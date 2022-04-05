<?php

namespace Codictive\Cms\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Codictive\Cms\Models\Ticket;
use Codictive\Cms\Traits\RequiresUser;
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
        if ($request->query('id')) {
            $tickets = $tickets->where('id', $request->query('id'));
        }
        if ($request->query('user_id')) {
            $tickets = $tickets->where('user_id', $request->query('user_id'));
        }
        if ($request->query('subject')) {
            $tickets = $tickets->where('subject', 'LIKE', "%{$request->query('subject')}%");
        }
        if ($request->query('department')) {
            $tickets = $tickets->where('department', "{$request->query('department')}");
        }
        if ($request->query('priority')) {
            $tickets = $tickets->where('priority', "{$request->query('priority')}");
        }
        if ($request->query('status')) {
            $tickets = $tickets->where('status', "{$request->query('status')}");
        }

        $perPage     = (int) $request->query('per_page') ?? 30;
        $orderBy     = $request->query('order_by')       ?? 'id';
        $orderDir    = $request->query('order_dir')      ?? 'DESC';
        $tickets     = $tickets->orderBy($orderBy, $orderDir)->paginate($perPage);
        $departments = Ticket::DEPARTMENT;
        $priority    = Ticket::PRIORITY;
        $status      = Ticket::STATUS;

        return view('cms::admin.tickets.index', ['tickets' => $tickets, 'departments' => $departments, 'priority' => $priority, 'status' => $status]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Ticket::DEPARTMENT;
        $priority    = Ticket::PRIORITY;
        $status      = Ticket::STATUS;
        $data        = ['departments' => $departments, 'priority' => $priority, 'status' => $status];

        return view('cms::admin.tickets.create', $data);
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
            'department' => ['required', Rule::in(Ticket::DEPARTMENT)],
            'priority'   => ['required', Rule::in(Ticket::PRIORITY)],
            'status'     => ['required', Rule::in(Ticket::STATUS)],
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
        $departments = Ticket::DEPARTMENT;
        $priority    = Ticket::PRIORITY;
        $status      = Ticket::STATUS;
        $data        = ['departments' => $departments, 'priority' => $priority, 'status' => $status, 'ticket' => $ticket];

        return view('cms::admin.tickets.edit', $data);
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
            'department' => ['required', Rule::in(Ticket::DEPARTMENT)],
            'priority'   => ['required', Rule::in(Ticket::PRIORITY)],
            'status'     => ['required', Rule::in(Ticket::STATUS)],
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

    public function batch(Request $request)
    {
        $ticketIds    = $request->batch;
        $status       = Ticket::STATUS;
        if (! $ticketIds) {
            return redirect()->route('admin.tickets.index')->withErrors('تیکت مورد نظر را انتخاب کنید.');
        }

        switch ($request->input('action')) {
            case 'status':
                return view('cms::admin.tickets.batch', ['action' => 'status', 'status' => $status, 'ticketIds' => $ticketIds]);

                break;

            //proccess batch update

            case 'store_status':
                Ticket::whereIn('id', $ticketIds)->update(['status' => $request->input('status')]);

                break;

            case 'delete':
                Ticket::whereIn('id', $ticketIds)->delete();

                break;
        }

        return redirect()->route('admin.tickets.index')->with('info', 'عملیات انجام شد.');
    }
}
