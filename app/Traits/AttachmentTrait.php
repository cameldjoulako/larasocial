<?php

namespace App\Traits;

use App\Models\Post;
use App\Models\PostAttachment;

use Storage;

trait AttachmentTrait
{
    public function upload($validated, Post $post)
    {
        // Save images if selected
        if (isset($validated["images"]))
        {
            foreach ($validated["images"] as $image)
            {
                $post_attachment = new PostAttachment();
                $post_attachment->type = "image";
                $post_attachment->post_id = $post->id;
                $post_attachment->file_path = Storage::putFile("public/" . auth()->user()->email . "/posts/" . $post->id, $image);
                $post_attachment->save();
            }
        }

        // Save videos if selected
        if (isset($validated["videos"]))
        {
            foreach ($validated["videos"] as $video)
            {
                $post_attachment = new PostAttachment();
                $post_attachment->type = "video";
                $post_attachment->post_id = $post->id;
                $post_attachment->file_path = Storage::putFile("public/" . auth()->user()->email . "/posts/" . $post->id, $video);
                $post_attachment->save();
            }
        }
    }
}