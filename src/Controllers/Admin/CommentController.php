<?php

namespace Codictive\Cms\Controllers\Admin;

use Illuminate\Http\Request;
use Codictive\Cms\Models\Comment;
use Codictive\Cms\Traits\RequiresUser;
use Codictive\Cms\Controllers\Controller;

class CommentController extends Controller
{
    use RequiresUser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $comments = Comment::with(['user']);
        if ($request->query('id')) {
            $comments->where('id', $request->query('id'));
        }
        if ($request->query('user_id')) {
            $comments->where('user_id', $request->query('user_id'));
        }
        if ($request->query('related_type')) {
            $comments->where('related_type', "{$request->query('related_type')}");
        }
        if ($request->query('related_id')) {
            $comments->where('related_id', $request->query('related_id'));
        }
        if ($request->query('is_approved') == 'true') {
            $comments->where('is_approved', true);
        }
        if ($request->query('is_approved') == 'false') {
            $comments->where('is_approved', false);
        }
        $perPage      = (int) $request->query('per_page') ?? 30;
        $orderBy      = $request->query('order_by')       ?? 'id';
        $orderDir     = $request->query('order_dir')      ?? 'DESC';
        $comments     = $comments->orderBy($orderBy, $orderDir)->paginate($perPage);

        return view('cms::admin.comments.index', ['comments' => $comments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        return view('cms::admin.comments.edit', ['comment' => $comment]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'body'    => 'required',
        ]);
        $comment->body        = $request->input('body');
        $comment->is_approved = $request->has('is_approved');
        $comment->save();

        return redirect()->route('admin.comments.index')->with('info', " تغییرات بر روی کامنت با شماره '{$comment->id}' اعمال شد.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->route('admin.comments.index')->with('warning', " کامنت با شماره'{$comment->id}' حذف شد.");
    }
}
