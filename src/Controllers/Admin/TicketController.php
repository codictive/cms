<?php

namespace Codictive\Cms\Controllers\Admin;

use Codictive\Cms\Models\Ticket;
use Codictive\Cms\Traits\RequiresUser;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Events\TicketCreatedEvent;
use Codictive\Cms\Controllers\Controller;

class TicketController extends Controller
{
    use RequiresUser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tickets = Ticket::with([]);
        if ($request->query('query')) {
            $tickets = $tickets->where('subject', 'LIKE', "%{$request->query('query')}%");
        }
        if ($request->query('Department')) {
            $tickets = $tickets->where('Department', "{$request->query('Department')}");
        }
        if ($request->query('priority')) {
            $tickets = $tickets->where('priority', "{$request->query('priority')}");
        }
        if ($request->query('status')) {
            $tickets = $tickets->where('status', "{$request->query('status')}");
        }

        $perPage  = (int) $request->query('per_page') ?? 30;
        $orderBy  = $request->query('order_by')       ?? 'tickets.id';
        $orderDir = $request->query('order_dir')      ?? 'DESC';
        $tickets  = $tickets->orderBy($orderBy, $orderDir)->paginate($perPage);

        return view('admin.tickets.index', ['tickets' => $tickets]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = [Ticket::DEPARTEMAN_MANAGEMENT, Ticket::DEPARTEMAN_SUPPORT, Ticket::DEPARTEMAN_FEEDBACK];
        $priority    = [Ticket::PRIORITY_LOW, Ticket::PRIORITY_NORMAL, Ticket::PRIORITY_HIGH];
        $status      = [Ticket::STATUS_PENDING, Ticket::STATUS_ANSWERED, Ticket::STATUS_CLOSED];
        $data        = ['departments' => $departments, 'priority' => $priority, 'status' => $status];

        return view('admin.tickets.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'    => 'required|exists:users,id',
            'subject'    => 'required',
            'department' => ['required', Rule::in([Ticket::DEPARTEMAN_MANAGEMENT, Ticket::DEPARTEMAN_SUPPORT, Ticket::DEPARTEMAN_FEEDBACK])],
            'priority'   => ['required', Rule::in([Ticket::PRIORITY_LOW, Ticket::PRIORITY_NORMAL, Ticket::PRIORITY_HIGH])],
            'status'     => ['required', Rule::in([Ticket::STATUS_PENDING, Ticket::STATUS_ANSWERED, Ticket::STATUS_CLOSED])],
        ]);
        $ticket = Ticket::create($request->all());


        return redirect()->route('admin.tickets.index')->with('success', "تیکت با موضوع '{$ticket->subject}' ایجاد شد.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        $departments = [Ticket::DEPARTEMAN_MANAGEMENT, Ticket::DEPARTEMAN_SUPPORT, Ticket::DEPARTEMAN_FEEDBACK];
        $priority    = [Ticket::PRIORITY_LOW, Ticket::PRIORITY_NORMAL, Ticket::PRIORITY_HIGH];
        $status      = [Ticket::STATUS_PENDING, Ticket::STATUS_ANSWERED, Ticket::STATUS_CLOSED];
        $data        = ['departments' => $departments, 'priority' => $priority, 'status' => $status, 'ticket' => $ticket];

        return view('admin.tickets.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'subject'    => 'required',
            'department' => 'required',
            'priority'   => ['required', Rule::in([Ticket::PRIORITY_LOW, Ticket::PRIORITY_NORMAL, Ticket::PRIORITY_HIGH])],
            'status'     => ['required', Rule::in([Ticket::STATUS_PENDING, Ticket::STATUS_ANSWERED, Ticket::STATUS_CLOSED])],
        ]);
        $ticket->update($request->all());

        return redirect()->route('admin.tickets.index')->with('info', "تغییرات تیکت با موضوع '{$ticket->subject}' اعمال شد.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return redirect()->route('admin.tickets.index')->with('warning', "تیکت با موضوع '{$ticket->subject}' حذف شد.");
    }
}
