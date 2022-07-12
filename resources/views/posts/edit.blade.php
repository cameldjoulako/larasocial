@extends ("layouts.app")

@section ("breadcrumb")
    <ol>
        <li><a href="{{ url('/') }}">Home</a></li>
        <li>Edit Post</li>
    </ol>
@endsection

@section ("main")

    <main id="main">
        @include ("layouts/page-title", [
            "page_title" => "Edit Post"
        ])

        <section class="contact">
            <div class="container">
                <div class="row">
                    <div class="offset-md-3 col-md-6 php-email-form">
                        <form method="post" action="{{ url('/posts/update') }}" onsubmit="return updatePost(this);" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <input type="hidden" name="id" value="{{ $post->id }}" required />

                            <input type="hidden" name="type" value="{{ $post->type }}" required />

                            <div class="form-group">
                                <label>Caption</label>
                                <input type="text" name="caption" value="{{ $post->caption }}" class="form-control" required />
                            </div>

                            <h3>Attachments</h3>
                            @foreach ($post->post_attachments as $attachment)
                                <p>
                                    @if ($attachment->type == "image")
                                        <img src="{{ url('public/' . \Storage::url($attachment->file_path)) }}" style="width: 100%;" />
                                    @elseif ($attachment->type == "video")
                                        <video src="{{ url('public/' . \Storage::url($attachment->file_path)) }}" controls style="width: 100%;"></video>
                                    @endif

                                    <button style="margin-top: 10px;" type="button" data-id="{{ $attachment->id }}" onclick="deleteAttachment(this);">Delete</button>

                                    <hr />
                                </p>
                            @endforeach

                            <div class="form-group">
                                <label>Upload Attachment</label>
                                <i class="fa fa-file-image-o theme-color" onclick="this.nextElementSibling.click();"></i>
                                <input type="file" accept="image/*" name="images[]" multiple onchange="previewImage(this, 'preview-post-attachments');" style="display: none;" />

                                <i class="fa fa-video-camera theme-color" onclick="this.nextElementSibling.click();"></i>
                                <input type="file" accept="video/*" name="videos[]" multiple onchange="previewVideo(this, 'preview-post-attachments');" style="display: none;" />
                            </div>

                            <div id="preview-post-attachments"></div>

                            <button type="submit" class="btn btn-primary">
                                Update
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>

        function updatePost(form) {
            // create AJAX instance
            var ajax = new XMLHttpRequest();
     
            // open the request
            ajax.open(form.getAttribute("method"), form.getAttribute("action"), true);
     
            // listen for response from server
            ajax.onreadystatechange = function () {
                // when the request is successfull
                if (this.readyState == 4) {

                    if (this.status == 200) {
                        console.log(this.responseText);
                        var response = JSON.parse(this.responseText);
                        console.log(response);

                        swal(response.status, response.message, response.status);

                        io.emit("post_updated", response.post);
                    }

                    // if the request fails
                    if (this.status == 500) {
                        console.log(this.responseText);
                        // swal("Error", this.responseText, "error");
                    }

                    if (this.status == 422) {
                        onValidationFails(this.responseText);
                    }
                }
            };
     
            // create form data object
            var formData = new FormData(form);
     
            // send the request
            ajax.send(formData);

            return false;
        }

        function deleteAttachment(self) {
            var id = self.getAttribute("data-id");

            // create AJAX instance
            var ajax = new XMLHttpRequest();
     
            // open the request
            ajax.open("POST", baseUrl + "/posts/attachments/delete", true);
     
            // listen for response from server
            ajax.onreadystatechange = function () {
                // when the request is successfull
                if (this.readyState == 4) {

                    if (this.status == 200) {
                        console.log(this.responseText);
                        var response = JSON.parse(this.responseText);
                        console.log(response);

                        if (response.status == "error") {
                            // show the response
                            swal(response.status, response.message, response.status);
                        } else {
                            self.parentElement.remove();

                            io.emit("post_updated", response.post);
                        }
                    }

                    // if the request fails
                    if (this.status == 500) {
                        console.log(this.responseText);
                        // swal("Error", this.responseText, "error");
                    }

                    if (this.status == 422) {
                        onValidationFails(this.responseText);
                    }
                }
            };
     
            // create form data object
            var formData = new FormData();
            formData.append("_token", document.querySelector("meta[name=_token]").content);
            formData.append("id", id);
     
            // send the request
            ajax.send(formData);
        }
    </script>

@endsection