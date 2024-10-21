<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Post $post)
    {
        $comments=$post->comments()->get();
        return CommentResource::collection($comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request, Post $post)
    {
        $validated = $request->validated();
        // Create the comment associated with the post
        $comment = $post->comments()->create([
            'content' => $validated['content'],
            'user_id' => Auth::id(), // Make sure this is included
        ]);

        return response()->json(['comment' => $comment], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request,Post $post, Comment $comment)
    {
        if(!Gate::allows('update-comment',$comment)){
            return response(['message'=>'You do not have permission to update this comment.'],403);
        }
        $validated=$request->validated();
        $comment->update($validated);
        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, Comment $comment)
    {
        if(!Gate::allows('delete-comment',$comment)){
            return response(['message'=>'You do not have permission to delete this comment.'],403);
        }
        $comment->delete();
        return response(['Deleted Successfully'], 204);
    }
}
