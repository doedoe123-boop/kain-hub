<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupportTicketRequest;
use App\Models\Store;
use App\Models\SupportTicket;
use App\TicketStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SupportTicketController extends Controller
{
    /**
     * Display a listing of the user's support tickets.
     */
    public function index(Request $request): JsonResponse
    {
        $tickets = SupportTicket::query()
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate($request->integer('per_page', 15));

        return response()->json($tickets);
    }

    /**
     * Store a newly created support ticket.
     */
    public function store(StoreSupportTicketRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if (! isset($validated['sector']) && isset($validated['store_id'])) {
            $validated['sector'] = Store::query()
                ->whereKey($validated['store_id'])
                ->value('sector');
        }

        $ticket = SupportTicket::create([
            ...$validated,
            'user_id' => $request->user()->id,
            'status' => TicketStatus::Open,
        ]);

        return response()->json([
            'message' => 'Support ticket submitted successfully.',
            'data' => $ticket,
        ], 201);
    }

    /**
     * Display the specified support ticket.
     */
    public function show(Request $request, string $id): JsonResponse
    {
        $ticket = SupportTicket::query()
            ->where('user_id', $request->user()->id)
            ->findOrFail($id);

        return response()->json($ticket);
    }
}
