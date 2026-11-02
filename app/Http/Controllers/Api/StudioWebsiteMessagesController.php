<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class StudioWebsiteMessagesController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        if ($denied = $this->authorizeStudioSuperadmin($request)) {
            return $denied;
        }

        $query = Lead::query()->select([
            'id', 'name', 'phone', 'email', 'service', 'details', 'status', 'created_at',
        ]);

        $status = $request->query('status');
        if (is_string($status) && array_key_exists($status, Lead::STATUSES)) {
            $query->where('status', $status);
        }

        $service = $request->query('service');
        if (is_string($service) && array_key_exists($service, Lead::SERVICES)) {
            $query->where('service', $service);
        }

        $search = trim((string) $request->query('search', ''));
        if ($search !== '') {
            $query->where(function ($builder) use ($search): void {
                $builder->where('name', 'like', '%'.$search.'%')
                    ->orWhere('phone', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%')
                    ->orWhere('details', 'like', '%'.$search.'%');
            });
        }

        $perPage = min(max((int) $request->query('per_page', 20), 1), 50);
        $paginator = $query->latest('created_at')->paginate($perPage);

        return response()->json([
            'data' => $paginator->items(),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
            ],
            'counts' => Lead::query()
                ->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->pluck('total', 'status'),
            'statuses' => Lead::STATUSES,
            'services' => Lead::SERVICES,
        ])->header('Cache-Control', 'private, no-store');
    }

    public function updateStatus(Request $request, Lead $lead): JsonResponse
    {
        if ($denied = $this->authorizeStudioSuperadmin($request)) {
            return $denied;
        }

        $data = $request->validate([
            'status' => ['required', 'string', 'in:'.implode(',', array_keys(Lead::STATUSES))],
        ]);
        $lead->update(['status' => $data['status']]);

        return response()->json(['message' => 'وضعیت پیام به‌روزرسانی شد.', 'id' => $lead->id, 'status' => $lead->status]);
    }

    public function bulkUpdateStatus(Request $request): JsonResponse
    {
        if ($denied = $this->authorizeStudioSuperadmin($request)) {
            return $denied;
        }

        $data = $request->validate([
            'ids' => ['required', 'array', 'min:1', 'max:50'],
            'ids.*' => ['required', 'integer', 'distinct', 'exists:leads,id'],
            'status' => ['required', 'string', 'in:'.implode(',', array_keys(Lead::STATUSES))],
        ]);
        $updated = Lead::query()->whereIn('id', $data['ids'])->update(['status' => $data['status']]);

        return response()->json(['message' => 'وضعیت پیام‌ها به‌روزرسانی شد.', 'updated' => $updated]);
    }

    private function authorizeStudioSuperadmin(Request $request): ?JsonResponse
    {
        $token = $request->bearerToken();
        if (! $token) {
            return response()->json(['message' => 'Studio sign-in required.'], 401);
        }

        // Verify the current Studio session server-side; never trust client-supplied roles.
        try {
            $identityResponse = Http::connectTimeout(3)
                ->timeout(6)
                ->acceptJson()
                ->withToken($token)
                ->get($this->studioSessionUrl());
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json(['message' => 'Could not verify Studio session.'], 503);
        }

        if ($identityResponse->status() === 401 || $identityResponse->status() === 403) {
            return response()->json(['message' => 'Studio session expired or invalid.'], 401);
        }

        if (! $identityResponse->successful()) {
            return response()->json(['message' => 'Could not verify Studio session.'], 503);
        }

        $identity = $identityResponse->json();
        if (! is_array($identity)) {
            return response()->json(['message' => 'Studio identity is invalid.'], 403);
        }

        $role = $identity['role'] ?? null;
        $email = is_string($identity['email'] ?? null) ? $identity['email'] : '';
        $modules = is_array($identity['module_access'] ?? null) ? $identity['module_access'] : [];

        $isSuperadmin = $role === 'superadmin' || ($email && mb_strtolower($email) === mb_strtolower((string) config('studio.admin_email')));
        $isAdmin = $role === 'admin';
        $hasModuleAccess = in_array('website-messages', $modules);

        if (! $isSuperadmin && ! $isAdmin && ! $hasModuleAccess) {
            return response()->json(['message' => 'Studio authorized access required.'], 403);
        }

        return null;
    }

    private function studioSessionUrl(): string
    {
        return rtrim((string) config('studio.base_url'), '/')
            .'/api/apps/flowsee-preview/entities/User/me';
    }
}
