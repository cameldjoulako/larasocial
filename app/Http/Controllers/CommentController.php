<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\Http\Requests\AddCommentRequest;

use App\Models\Comment;
use App\Models\Reply;

class CommentController extends Controller
{
    public function add_reply()
    {
        $validator = Validator::make(request()->all(), [
            "comment_id" => "required|numeric|exists:comments,id",
            "reply" => "required"
        ]);

        if (!$validator->passes())
        {
            $error_html = "<ol>";
            foreach ($validator->errors()->all() as $error)
            {
                $error_html .= "<li>" . $error . "</li>";
            }
            $error_html .= "</ol>";

            return response()->json([
                "status" => "error",
                "message" => $error_html
            ]);
        }

        $reply = new Reply();
        $reply->comment_id = request()->comment_id;
        $reply->user_id = auth()->user()->id;
        $reply->reply = request()->reply;
        $reply->save();

        $reply_html = view("layouts/reply", [
            "reply" => $reply
        ])->render();

        return response()->json([
            "status" => "success",
            "message" => "Reply has been added.",
            "reply" => $reply_html
        ]);
    }

    public function store(AddCommentRequest $request)
    {
        $validated = $request->validated();

        $comment = new Comment();
        $comment->user_id = auth()->user()->id;
        $comment->post_id = $validated["post_id"];
        $comment->comment = $validated["comment"];
        $comment->save();

        $comment_html = view("layouts/comment", [
            "comment" => $comment
        ])->render();

        return response()->json([
            "status" => "success",
            "message" => "Comment has been added.",
            "comment" => $comment_html
        ]);
    }
}
