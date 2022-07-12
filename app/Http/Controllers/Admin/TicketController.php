<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Ticket;
use App\Models\TicketResponse;

class TicketController extends Controller
{

    public function respond()
    {
        request()->validate([
            "id" => "required|numeric|exists:tickets,id",
            "response" => "required"
        ]);

        $ticket_response = new TicketResponse();
        $ticket_response->ticket_id = request()->id;
        $ticket_response->response = request()->response;
        $ticket_response->response_by = auth()->user()->id;
        $ticket_response->is_read = 0;
        $ticket_response->save();

        return redirect()->back();
    }

    public function change_status()
    {
        request()->validate([
            "id" => "required|numeric|exists:tickets,id",
            "status" => "required|in:open,closed"
        ]);

        $ticket = Ticket::find(request()->id);
        $ticket->status = request()->status;
        $ticket->save();

        return redirect()->back();
    }

    public function detail(Ticket $ticket)
    {

        $ticket->unread_responses()
            ->where("response_by", "!=", auth()->user()->id)
            ->update([
            "is_read" => 1
        ]);
        
        return view("admin/tickets/detail", [
            "ticket" => $ticket
        ]);
    }

    public function index()
    {
        $tickets = Ticket::orderBy("id", "desc")
            ->paginate();
        
        return view("admin/tickets/index", [
            "tickets" => $tickets
        ]);
    }
}
