<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Address;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    /**
     * List all addresses for the authenticated user.
     */
    public function index(Request $request): JsonResponse
    {
        $addresses = $request->user()
            ->addresses()
            ->orderByDesc('is_default')
            ->orderBy('created_at')
            ->get();

        return response()->json(['data' => $addresses]);
    }

    /**
     * Create a new address for the authenticated user.
     */
    public function store(StoreAddressRequest $request): JsonResponse
    {
        $user = $request->user();
        $data = $request->validated();

        DB::transaction(function () use ($user, &$data) {
            if (! empty($data['is_default'])) {
                $user->addresses()->update(['is_default' => false]);
            } elseif ($user->addresses()->count() === 0) {
                // First address is always the default.
                $data['is_default'] = true;
            }
        });

        $address = $user->addresses()->create($data);

        return response()->json($address, 201);
    }

    /**
     * Update an existing address.
     */
    public function update(UpdateAddressRequest $request, Address $address): JsonResponse
    {
        $this->authorize('update', $address);

        $data = $request->validated();

        DB::transaction(function () use ($request, $address, &$data) {
            if (! empty($data['is_default'])) {
                $request->user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
            }

            $address->update($data);
        });

        return response()->json($address->fresh());
    }

    /**
     * Delete an address.
     */
    public function destroy(Request $request, Address $address): JsonResponse
    {
        $this->authorize('delete', $address);

        $address->delete();

        if ($address->is_default) {
            // Promote the next address to default.
            $request->user()->addresses()->oldest()->first()?->update(['is_default' => true]);
        }

        return response()->json(null, 204);
    }

    /**
     * Mark an address as the user's default.
     */
    public function setDefault(Request $request, Address $address): JsonResponse
    {
        $this->authorize('update', $address);

        DB::transaction(function () use ($request, $address) {
            $request->user()->addresses()->update(['is_default' => false]);
            $address->update(['is_default' => true]);
        });

        return response()->json($address->fresh());
    }
}
