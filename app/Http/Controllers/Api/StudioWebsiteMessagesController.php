<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudioWebsiteMessagesController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $claims = $this->verifiedClaims($request->bearerToken());
        if (! $claims || ($claims['scope'] ?? null) !== 'website-messages:read'
            || (int) ($claims['exp'] ?? 0) <= now()->timestamp) {
            return response()->json(['message' => 'Studio access expired or invalid.'], 401);
        }

        // Re-check the issuing account on every request so removing admin access
        // immediately revokes access, even while the short-lived token exists.
        $user = User::find($claims['sub'] ?? null);
        if (! $user?->is_admin) {
            return response()->json(['message' => 'Admin access required.'], 403);
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

    /** @return array<string, mixed>|null */
    private function verifiedClaims(?string $token): ?array
    {
        if (! $token || ! str_contains($token, '.')) {
            return null;
        }

        [$payload, $signature] = explode('.', $token, 2);
        $expected = hash_hmac('sha256', $payload, (string) config('app.key'));
        if (! hash_equals($expected, $signature)) {
            return null;
        }

        $decoded = base64_decode(strtr($payload, '-_', '+/'), true);
        if ($decoded === false) {
            return null;
        }

        $claims = json_decode($decoded, true);

        return is_array($claims) ? $claims : null;
    }
}
