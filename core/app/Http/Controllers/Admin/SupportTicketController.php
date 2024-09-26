<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use App\Traits\SupportTicketManager;
use Illuminate\Http\Request as Request;

class SupportTicketController extends Controller
{
    use SupportTicketManager;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->user = auth()->guard('admin')->user();
            return $next($request);
        });

        $this->userType = 'admin';
        $this->column = 'admin_id';
    }

    public function tickets(Request $request)
    {
        $pageTitle = 'Support Tickets';
        $perPage = $request->get('per_page', 25);
        $items = SupportTicket::orderBy('id','desc')->with('user')->whereHas('user')->paginate($perPage);
        return view('admin.support.tickets', compact('items', 'pageTitle'));
    }

    public function pendingTicket()
    {
        $pageTitle = 'Pending Tickets';
        $items = SupportTicket::whereIn('status', [Status::TICKET_OPEN,Status::TICKET_REPLY])->orderBy('id','desc')->with('user')->whereHas('user')->paginate(getPaginate());
        return view('admin.support.tickets', compact('items', 'pageTitle'));
    }

    public function closedTicket(Request $request)
    {
        $pageTitle = 'Closed Tickets';
        $perPage = $request->get('per_page', 25);
        $items = SupportTicket::where('status',Status::TICKET_CLOSE)->orderBy('id','desc')->with('user')->whereHas('user')->paginate($perPage);
        return view('admin.support.tickets', compact('items', 'pageTitle', 'perPage'));
    }

    public function answeredTicket()
    {
        $pageTitle = 'Answered Tickets';
        $items = SupportTicket::orderBy('id','desc')->with('user')->where('status',Status::TICKET_ANSWER)->whereHas('user')->paginate(getPaginate());
        return view('admin.support.tickets', compact('items', 'pageTitle'));
    }

    public function ticketReply($id)
    {
        $ticket = SupportTicket::with('user')->where('id', $id)->firstOrFail();
        $pageTitle = 'Reply Ticket';
        $messages = SupportMessage::with('ticket','admin','attachments')->where('support_ticket_id', $ticket->id)->orderBy('id','desc')->get();
        return view('admin.support.reply', compact('ticket', 'messages', 'pageTitle'));
    }

    public function ticketDelete($id)
    {
        $message = SupportMessage::findOrFail($id);
        $path = getFilePath('ticket');
        if ($message->attachments()->count() > 0) {
            foreach ($message->attachments as $attachment) {
                fileManager()->removeFile($path.'/'.$attachment->attachment);
                $attachment->delete();
            }
        }
        $message->delete();
        $notify[] = ['success', "Support ticket deleted successfully"];
        return back()->withNotify($notify);

    }

}
