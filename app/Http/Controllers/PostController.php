<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\AddPostRequest;
use App\Http\Requests\SharePostRequest;

use App\Traits\AttachmentTrait;

use App\Models\Post;
use App\Models\PostAttribute;
use App\Models\PostAttachment;
use App\Models\Share;
use App\Models\Liker;

use Storage;
use Validator;

class PostController extends Controller
{
    use AttachmentTrait;

    public function share(SharePostRequest $request)
    {
        $validated = $request->validated();

        // Create new post
        $post = new Post();

        // Save caption if written
        if (isset(request()->caption))
        {
            $post->caption = request()->caption;
        }

        // Authenticated user has created this post
        $post->user_id = auth()->user()->id;

        // Insert in posts table
        $post->save();

        $post->user;
        $post->post_attachments;

        $share = new Share();
        $share->shared_post_id = $validated["id"];
        $share->post_id = $post->id;
        $share->user_id = auth()->user()->id;
        $share->type = "timeline";
        $share->save();

        return response()->json([
            "status" => "success",
            "message" => "Post has been shared.",
            "post" => $post
        ]);
    }

    public function get_content()
    {
        $validator = Validator::make(request()->all(), [
            "id" => "required|numeric|exists:posts,id"
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

        $post = Post::find(request()->id);

        $post_html = view('layouts/single-post', [
            "post" => $post
        ])->render();

        return response()->json([
            "status" => "success",
            "message" => "Post UI has been fetched.",
            "post" => $post_html
        ]); 
    }

    public function update(AddPostRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $post = Post::find(request()->id);
        if ($post == null)
        {
            return response()->json([
                "status" => "error",
                "message" => "Post does not exists."
            ]);
        }

        if ($post->user_id != auth()->user()->id)
        {
            return response()->json([
                "status" => "error",
                "message" => "Sorry, you are not the creator of this post."
            ]);
        }

        $this->upload($validated, $post);

        // Save caption if written
        if (isset($validated["caption"]))
        {
            $post->caption = $validated["caption"];
        }
        $post->save();

        return response()->json([
            "status" => "success",
            "message" => "Post has been updated.",
            "post" => $post
        ]);
    }

    public function destroy_attachment()
    {
        $validator = Validator::make(request()->all(), [
            "id" => "required|numeric|exists:post_attachments,id"
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

        $post_attachment = PostAttachment::find(request()->id);
        if ($post_attachment->post->user_id != auth()->user()->id)
        {
            return response()->json([
                "status" => "error",
                "message" => "Sorry, you are not the creator of this post."
            ]);
        }

        $post = $post_attachment->post;

        Storage::delete($post_attachment->file_path);
        $post_attachment->delete();

        return response()->json([
            "status" => "success",
            "message" => "Attachment has been deleted.",
            "post" => $post
        ]);
    }

    public function edit(Post $post)
    {
        if ($post->user_id != auth()->user()->id)
        {
            abort(401);
        }

        return view("posts/edit", [
            "post" => $post
        ]);
    }

    public function destroy()
    {
        $validator = Validator::make(request()->all(), [
            "id" => "required|numeric|exists:posts,id"
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

        $post = Post::find(request()->id);
        $temp_post = $post;

        if ($post->user_id != auth()->user()->id)
        {
            return response()->json([
                "status" => "error",
                "message" => "Sorry, you are not the creator of this post."
            ]);
        }

        $path = "public/" . auth()->user()->email . "/posts/" . $post->id;
        if (Storage::exists($path))
        {
            Storage::deleteDirectory($path);
        }
        $post->delete();

        return response()->json([
            "status" => "success",
            "message" => "Post has been deleted.",
            "post" => $temp_post
        ]);
    }

    public function detail(Post $post)
    {
        return view("posts/detail", [
            "post" => $post
        ]);
    }

    public function like_unlike_post()
    {
        $validator = Validator::make(request()->all(), [
            "post_id" => "required|numeric|exists:posts,id"
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

        $liker = Liker::where("post_id", "=", request()->post_id)
            ->where("user_id", "=", auth()->user()->id)
            ->first();

        // user has not liked this post before
        if ($liker == null)
        {
            $liker = new Liker();
            $liker->post_id = request()->post_id;
            $liker->user_id = auth()->user()->id;
            $liker->save();

            $is_deleted = 0;
        }
        else
        {
            // user has already liked this post
            $liker->delete();

            $is_deleted = 1;
        }

        $post_likes_count = Liker::where("post_id", "=", request()->post_id)->count();

        return response()->json([
            "status" => "success",
            "message" => "Post has been liked/unliked.",
            "is_deleted" => $is_deleted,
            "post_likes_count" => $post_likes_count
        ]);
    }

    public function load_more_posts()
    {
        $validator = Validator::make(request()->all(), [
            "page" => "required|numeric"
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

        $friend_ids = [];
        foreach (auth()->user()->friends() as $friend)
        {
            array_push($friend_ids, $friend->other_user->id);
        }
        array_push($friend_ids, auth()->user()->id);

        $posts = Post::where(function ($query) use ($friend_ids) {
                $query->where("type", "=", "post")
                    ->whereIn("user_id", $friend_ids);
            })
            ->orderBy("id", "desc")
            ->paginate();

        $posts_html = "";
        foreach ($posts as $post)
        {
            $posts_html .= view("layouts/single-post", [
                "post" => $post
            ])->render();
        }

        return response()->json([
            "status" => "success",
            "message" => "Data has been fetched.",
            "posts_html" => $posts_html,
            "posts" => $posts
        ]);
    }

    public function store(AddPostRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        // Create new post
        $post = new Post();

        // Save caption if written
        if (isset($validated["caption"]))
        {
            $post->caption = $validated["caption"];
        }

        // Authenticated user has created this post
        $post->user_id = auth()->user()->id;

        $post->type = $validated["type"];

        // Insert in posts table
        $post->save();

        $this->upload($validated, $post);

        // These lines are written to send the relationships with the response (from where AJAX is called)
        $post->user;
        $post->post_attachments;

        return response()->json([
            "status" => "success",
            "message" => "Post has been added.",
            "post" => $post
        ]);
    }
}
