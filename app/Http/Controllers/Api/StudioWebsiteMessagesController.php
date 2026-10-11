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
    private const PRIMARY_STUDIO_ADMIN_EMAIL = 'ceo@flowsee.local';

    public function index(Request $request): JsonResponse
    {
        $token = $request->bearerToken();
        if (! $token) {
            return response()->json(['message' => 'Studio sign-in required.'], 401);
        }

        // Verify the current Studio session server-side; never trust client-supplied roles.
        // Only the primary Studio superadmin identity is allowed. A separate
        // Flowsee account would force the user to sign in twice.
        try {
            $identityResponse = Http::connectTimeout(3)
                ->timeout(6)
                ->acceptJson()
                ->withToken($token)
                ->get('https://studio.flowsee.ir/api/apps/flowsee-preview/entities/User/me');
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
        if (! is_array($identity) || ($identity['role'] ?? null) !== 'superadmin'
            || ! is_string($identity['email'] ?? null)
            || mb_strtolower($identity['email']) !== self::PRIMARY_STUDIO_ADMIN_EMAIL) {
            return response()->json(['message' => 'Studio superadmin access required.'], 403);
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
}
