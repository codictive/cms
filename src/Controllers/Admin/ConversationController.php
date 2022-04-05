<?php

namespace Codictive\Cms\Controllers\Admin;

use Illuminate\Http\Request;
use Codictive\Cms\Models\File;
use Illuminate\Validation\Rule;
use Codictive\Cms\Models\Ticket;
use Codictive\Cms\Models\Conversation;
use Codictive\Cms\Traits\RequiresUser;
use Codictive\Cms\Controllers\Controller;

class ConversationController extends Controller
{
    use RequiresUser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Ticket $ticket)
    {
        $conversation       = $ticket->conversations()->latest()->paginate(30);
        $ticket->conversations()->latest()->limit(30)->update(['seen' => true]);

        return view('cms::admin.tickets.conversations.index', ['ticket' => $ticket, 'conversation' => $conversation]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Ticket $ticket)
    {
        $request->validate([
            'file' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->input('body') == null;
                }),
                'file',
            ],
            'body' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->hasFile('file') == false;
                }),
            ],
        ]);

        if ($request->input('body')) {
            $c = $ticket->conversations()->create([
                'sender_id'   => $this->user->id,
                'receiver_id' => $ticket->user_id,
                'body'        => $request->input('body'),
            ]);
        }
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $c = $ticket->conversations()->create([
                'sender_id'   => $this->user->id,
                'receiver_id' => $ticket->user_id,
                'type'        => 'file',
            ]);
            File::storeHttp($c->file(), $request->file('file'), 'ticket', $ticket->subject);
        }

        $ticket->update(['status' => Ticket::STATUS_ANSWERED]);

        return redirect()->route('admin.tickets.index')->with('info', "تیکت با موضوع '{$ticket->subject}' پاسخ داده شد.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket, Conversation $conversation)
    {
        return view('cms::admin.tickets.conversations.edit', ['ticket' => $ticket, 'conversation' => $conversation]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket, Conversation $conversation)
    {
        $request->validate([
            'body' => 'required',
        ]);
        $ticket->conversations()->update([
            'body' => $request->input('body'),
        ]);

        return redirect()->route('admin.tickets.conversations.index', $ticket->id)->with('info', "تیکت با موضوع '{$ticket->subject}' تغییر داده شد.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket, Conversation $conversation)
    {
        if ('file' == $conversation->type && $conversation->file) {
            $conversation->file->purge();
        }
        $conversation->delete();

        return redirect()->route('admin.tickets.conversations.index', $ticket->id)->with('info', "تیکت با موضوع '{$ticket->subject}' حذف شد.");
    }
}
