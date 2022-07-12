@extends ("layouts.app")

@section ("breadcrumb")
    <ol>
      <li><a href="{{ url('/') }}">Home</a></li>
      <li>{{ $post->caption }}</li>
    </ol>
@endsection

@section ("main")

    <main id="main">
        @include ("layouts/page-title", [
            "page_title" => $post->caption
        ])

        <!-- ======= Blog Section ======= -->
        <section id="blog" class="blog">
          <div class="container">

            @if ($post->user_id == auth()->user()->id)
              <div class="row" style="margin-bottom: 10px;">
                <div class="col-md-12">
                  <a href="{{ url('/posts/edit/' . $post->id) }}" class="btn btn-warning btn-sm">
                    <i class="fa fa-pencil"></i>
                  </a>

                  <form method="POST" action="{{ url('/posts/delete') }}"
                    onsubmit="return confirmDeletePost(this);"
                    style="display: contents;">
                    {{ csrf_field() }}

                    <input type="hidden" name="id" value="{{ $post->id }}" required />

                    <button type="submit" class="btn btn-danger btn-sm"
                      style="background-color: red; border-radius: .2rem; padding: .25rem .5rem;">
                      <i class="fa fa-trash"></i>
                    </button>
                  </form>
                </div>
              </div>
            @endif

            <div class="row">

              <div class="col-lg-12 entries">

                <article class="entry entry-single">

                  <div class="entry-img">
                    @foreach ($post->post_attachments as $post_attachment)
                        @if ($post_attachment->type == "image")
                            <img src="{{ url('/public/' . \Storage::url($post_attachment->file_path)) }}" class="img-fluid" />
                        @elseif ($post_attachment->type == "video")
                            <video src="{{ url('/public/' . \Storage::url($post_attachment->file_path)) }}" style="width: 100%; height: 500px;" controls></video>
                        @endif
                    @endforeach
                  </div>

                  <h2 class="entry-title">
                    {{ $post->caption }}
                  </h2>

                  @if ($post->shared_post != null)
                    <div class="shared-post" style="margin-bottom: 30px;">

                      <div style="display: flex;">
                        <a href="{{ url('/user/' . $post->shared_post->shared_post->user->id) }}">
                          <img class="media-object photo-profile" src="{{ $post->shared_post->shared_post->user->profile_image }}" width="40" height="40" style="object-fit: contain; margin-right: 10px;" />
                        </a>

                        <p>{{ $post->shared_post->shared_post->caption }}</p>
                      </div>

                      @foreach ($post->shared_post->shared_post->post_attachments as $attachment)
                        @if ($attachment->type == "image")
                          <img src="{{ url('public/' . \Storage::url($attachment->file_path)) }}" style="width: 200px; height: 200px; object-fit: cover;" />
                        @elseif ($attachment->type == "video")
                          <video src="{{ url('public/' . \Storage::url($attachment->file_path)) }}" style="width: 200px; height: 200px;" controls></video>
                        @endif
                     @endforeach
                      
                    </div>
                   @endif

                  <div class="entry-meta">
                    <ul>
                      <li class="d-flex align-items-center"><i class="icofont-user"></i> <a href="{{ url('/user/' . $post->user->id) }}">{{ $post->user->name }}</a></li>
                      <li class="d-flex align-items-center"><i class="icofont-wall-clock"></i> <time datetime="{{ explode(' ', $post->created_at)[0] }}">{{ date_format(date_create($post->created_at), "F d, Y") }}</time></li>
                      <li class="d-flex align-items-center"><i class="icofont-comment"></i> {{ $post->comments->count() }} Comments</li>
                    </ul>
                  </div>

                </article><!-- End blog entry -->

                <div class="blog-author clearfix">
                  <img src="{{ $post->user->profile_image }}" class="rounded-circle float-left" alt="">
                  <h4>{{ $post->user->name }}</h4>
                  <p>
                    {{ $post->user->about_me }}
                  </p>
                </div><!-- End blog author bio -->

                <div class="blog-comments">

                  <h4 class="comments-count">{{ $post->comments->count() }} Comments</h4>

                  <div id="comments">
                      @foreach ($post->comments as $comment)
                        @include ("layouts/comment", [
                            "comment" => $comment
                        ])
                      @endforeach
                  </div>

                  <div class="reply-form">
                    <h4>Your comment</h4>
                    <form method="POST" action="{{ url('/add-comment') }}" onsubmit="return addComment(this);">
                      
                      {{ csrf_field() }}
                      <input type="hidden" name="post_id" value="{{ $post->id }}" required= />

                      <div class="row">
                        <div class="col form-group">
                          <textarea name="comment" class="form-control" placeholder="Your Comment*"></textarea>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary">Post</button>

                    </form>

                  </div>

                </div><!-- End blog comments -->

              </div><!-- End blog entries list -->

            </div>

          </div>
        </section><!-- End Blog Section -->
    </main>

    <div class="modal" id="replyModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Reply</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{ url('/add-reply') }}" onsubmit="return addReply(this);">
              {{ csrf_field() }}

              <input type="hidden" name="comment_id" required>

              <div class="row">
                <div class="col form-group">
                  <textarea name="reply" class="form-control" placeholder="Your Reply*"></textarea>
                </div>
              </div>

              <button type="submit" class="btn btn-primary">Post</button>

            </form>
          </div>
        </div>
      </div>
    </div>

    <script>

        function addReply(form) {
            var commentId = form.comment_id.value;

            var ajax = new XMLHttpRequest();
            ajax.open(form.getAttribute("method"), form.getAttribute("action"), true);

            ajax.onreadystatechange = function () {
                if (this.readyState == 4) {

                    $("#replyModal").modal("hide");

                    if (this.status == 200) {
                        // console.log(this.responseText);
                        var response = JSON.parse(this.responseText);
                        // console.log(response);

                        document.querySelector("#comment-" + commentId + " .replies").innerHTML = response.reply + document.querySelector("#comment-" + commentId + " .replies").innerHTML;
                    }

                    if (this.status == 500) {
                        console.log(this.responseText);
                    }

                    if (this.status == 422) {
                        onValidationFails(this.responseText);
                    }
                }
            };

            var formData = new FormData(form);
            ajax.send(formData);

            return false;
        }

        function showReplyModal(self) {
          var commentId = self.getAttribute("data-comment-id");
          $("#replyModal form input[name=comment_id]").val(commentId);
          $("#replyModal").modal("show");
        }

        function addComment(form) {
            var ajax = new XMLHttpRequest();
            ajax.open(form.getAttribute("method"), form.getAttribute("action"), true);

            ajax.onreadystatechange = function () {
                if (this.readyState == 4) {
                    if (this.status == 200) {
                        // console.log(this.responseText);
                        var response = JSON.parse(this.responseText);
                        // console.log(response);

                        document.getElementById("comments").innerHTML = response.comment + document.getElementById("comments").innerHTML;
                    }

                    if (this.status == 500) {
                        console.log(this.responseText);
                    }

                    if (this.status == 422) {
                        onValidationFails(this.responseText);
                    }
                }
            };

            var formData = new FormData(form);
            ajax.send(formData);

            return false;
        }
    </script>

@endsection