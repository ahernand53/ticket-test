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
        $tickets = Ticket::all();

        return response()->json(['data' => $tickets], 200);
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
            'assignationDate' => $request->get('assignationDate'),
            'user_id' => $request->get('user')
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

        return response()->json(['data' => $ticket], 200);
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
        if ($request->has('issue')){
            $ticket->issue = $request->get('issue');
            $ticket->save();
        }

        if ($request->has('priority')){
            $ticket->priority = $request->get('priority');
            $ticket->save();
        }

        if ($request->has('assignationDate')){
            $ticket->assignationDate = $request->get('assignationDate');
            $ticket->save();
        }

        if ($request->has('user_id')){
            $ticket->user_id = $request->get('user');
            $ticket->save();
        }

        if ($request->has('task')) {
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
