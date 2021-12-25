<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Post;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentRequest $request, Post $post)
    {
        $validated = $request->validated();
        $comment = new Comment();
        $comment->text = strip_tags($validated['text']);
        $comment->user()->associate(auth()->user());
        $comment->post()->associate($post);
        try {
            $comment->saveOrFail();
        } catch (\Throwable $ex) {
            if ($comment->id) {
                $comment->delete();
            }           
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        return json_encode(['result' => $comment->delete() ? 'true' : 'false']);
    }
}
