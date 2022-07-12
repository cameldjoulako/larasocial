<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\CreateTicketRequest;

use App\Models\Ticket;
use App\Models\TicketResponse;
use App\Models\User;

use App\Events\NotifyUser;

use Storage;

class TicketController extends Controller
{

    public function respond()
    {
        request()->validate([
            "id" => "required|numeric|exists:tickets,id",
            "response" => "required"
        ]);

        $ticket = Ticket::find(request()->id);
        if ($ticket->user_id != auth()->user()->id)
        {
            abort(401);
        }

        $ticket_response = new TicketResponse();
        $ticket_response->ticket_id = $ticket->id;
        $ticket_response->response = request()->response;
        $ticket_response->response_by = auth()->user()->id;
        $ticket_response->is_read = 0;
        $ticket_response->save();

        return redirect()->back();
    }

    public function detail(Ticket $ticket)
    {
        $ticket->unread_responses()
            ->where("response_by", "!=", auth()->user()->id)
            ->update([
            "is_read" => 1
        ]);

        return view("tickets/detail", [
            "ticket" => $ticket
        ]);
    }

    public function store(CreateTicketRequest $request)
    {
        $validated = $request->validated();

        $ticket = new Ticket();
        $ticket->user_id = auth()->user()->id;
        $ticket->title = $validated["title"];
        $ticket->description = $validated["description"];

        // Save attachment if selected
        if (isset(request()->attachment))
        {
            $ticket->attachment = Storage::putFile("public/" . auth()->user()->email . "/tickets/" . $validated["title"], request()->attachment);
        }

        $ticket->status = "open";
        $ticket->save();

        $admin = User::where("role", "=", "admin")->first();
        if ($admin != null)
        {
            $content = "New <a href='" .url('/admin/tickets/' . $ticket->id) . "'>Ticket</a> has been opened.";
            event(new NotifyUser("New Ticket", $content, $admin->id));
        }

        return redirect("/tickets");
    }

    public function create()
    {
        return view("tickets/create");
    }

    public function index()
    {
        $tickets = auth()->user()->tickets()->paginate();

        return view("tickets/index", [
            "tickets" => $tickets
        ]);
    }
}
