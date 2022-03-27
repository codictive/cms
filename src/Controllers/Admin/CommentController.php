<?php

namespace Codictive\Cms\Controllers\Admin;

use Codictive\Cms\Models\Comment;
use Codictive\Cms\Traits\RequiresUser;
use Illuminate\Http\Request;
use Codictive\Cms\Controllers\Controller;

class CommentController extends Controller
{
    use RequiresUser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::orderBy('id', 'DESC')->paginate(30);

        return view('admin.comments.index', ['comments' => $comments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        return view('admin.comments.edit', ['comment' => $comment]);
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
