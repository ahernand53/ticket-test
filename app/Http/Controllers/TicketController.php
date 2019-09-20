<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\TicketDetails;
use Illuminate\Http\Request;

class TicketController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Ticket::orderBy('id', 'DESC')->get();

        return response()->json(['data' => $tickets], 200);
    }

    /**
     * @param Ticket $ticket
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Ticket $ticket) {

        return response()->json($ticket, 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, Ticket::rules());

        $ticket = new Ticket([
            'issue' => $request->get('issue'),
            'priority' => $request->get('priority'),
            'assignation_date' => $request->get('assignation_date'),
            'user_id' => $request->get('user'),
            'user_assigned' => $request->get('userAssigned')
        ]);

        $ticket->save();

        $ticket->details()->create([
            'task' => $request->get('task'),
            'state' => $ticket->state
        ]);

        return response()->json(['data' => $ticket], 200);
    }

    public function close(Request $request, Ticket $ticket) {
        $concludingRemarks = $request->get('concluding_remarks');

        $ticket->state = false;
        $ticket->save();

        $ticket->details()->update([
            'state' => false,
            'concluding_remarks' => $concludingRemarks
        ]);

        $ticket = Ticket::find($ticket);

        return response()->json($ticket, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        if ($request->has('issue') &&
            $request->has('issue') !== $ticket->issue){
            $ticket->issue = $request->get('issue');
            $ticket->save();
        }

        if ($request->has('priority') &&
            $request->has('priority') !== $ticket->priority){
            $ticket->priority = $request->get('priority');
            $ticket->save();
        }

        if ($request->has('assignation_date') &&
            $request->has('assignation_date') !== $ticket->assignation_date){
            $ticket->assignation_date = $request->get('assignation_date');
            $ticket->save();
        }

        if ($request->has('user_assigned') &&
            $request->has('user_assigned') !== $ticket->user_assigned){
            if ( $request->get('user_assigned')['id'] ) {
                $ticket->user_assigned = $request->get('user_assigned')['id'];
            } else {
                $ticket->user_assigned = $request->get('user_assigned');
            }
            $ticket->save();
        }

        if ($request->has('task') &&
            $request->has('task') !== $ticket->details->task) {
            $ticket->details()->update(['task' => $request->get('task')]);
        }

        $ticket = Ticket::find($ticket);

        return response()->json(['data' => $ticket], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return response()->json('Se ha eliminado Correctamente', 200);
    }
}
