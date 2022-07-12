<div class="card single-post" style="margin-top: 20px !important;" id="post-{{ $post->id }}">
  <div class="">
     <section class="card-header">
          <div class="row">
              <div class="col-md-11">
                  <div class="media">
                    <div class="media-left">
                      
                      <a href="{{ url('/user/' . $post->user->id) }}">
                        <img class="media-object photo-profile" src="{{ $post->user->profile_image }}" width="40" height="40" />
                      </a>

                    </div>
                    <div class="media-body">
                      <div style="float: left;">
                        <a href="{{ url('/posts/' . $post->id) }}" target="_blank" class="anchor-username">
                          <h4 class="media-heading">{{ $post->user->name }}</h4>
                        </a>

                        <a href="javascript:void(0);" class="anchor-time">{{ $post->created_at }}</a>
                      </div>

                      @if ($post->user_id == auth()->user()->id)
                        <div style="float: right;">

                          @if ($post->user_id == auth()->user()->id)
                            <a href="{{ url('/posts/edit/' . $post->id) }}" class="btn btn-warning btn-sm">
                              <i class="fa fa-pencil"></i>
                            </a>
                          @endif

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
                      @endif

                    </div>
                  </div>
              </div>
          </div>             
     </section>
     <section class="card-body">
         <p>{{ $post->caption }}</p>

         @foreach ($post->post_attachments as $attachment)
            @if ($attachment->type == "image")
              <img src="{{ url('public/' . \Storage::url($attachment->file_path)) }}" style="width: 200px; height: 200px; object-fit: cover;" />
            @elseif ($attachment->type == "video")
              <video src="{{ url('public/' . \Storage::url($attachment->file_path)) }}" style="width: 200px; height: 200px;" controls></video>
            @endif
         @endforeach

         @if ($post->shared_post != null)
          <div class="shared-post">

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

     </section>
     <section class="card-footer" style="padding: 10px;">
         <div class="post-footer-option container" style="padding-left: 0px;">
              <ul class="list-unstyled" style="display: flex; margin-bottom: 0px;">
                  <li>
                      <span class="responders" onclick="showPostResponders(this.getAttribute('data-type'), this.getAttribute('data-id'));" data-type="likes" data-id="{{ $post->id }}">({{ $post->likers->count() }})</span>

                      <button type="button" class="{{ $post->has_liked() ? '' : 'unlike' }}" onclick="doLike(this);" data-post-id="{{ $post->id }}">
                          Like
                          <i class="fa fa-thumbs-up"></i>
                      </button>
                  </li>

                  <li>
                      (<span class="responders" onclick="showPostResponders(this.getAttribute('data-type'), this.getAttribute('data-id'));" data-type="comments" data-id="{{ $post->id }}">{{ $post->comments->count() }}</span>)
                      
                      <button onclick="window.open('{{ url("posts/" . $post->id) }}', '_blank');" type="button" class="comment">
                          Comment
                          <i class="fa fa-comment"></i>
                      </button>
                  </li>

                  <li>
                      (<span class="responders" onclick="showPostResponders(this.getAttribute('data-type'), this.getAttribute('data-id'));" data-type="shares" data-id="{{ $post->id }}">{{ $post->shares->count() }}</span>)

                      <button type="button" class="share" onclick="showShareModal(this);" data-id="{{ $post->id }}">
                          Share
                          <i class="fa fa-share-alt"></i>
                      </button>
                  </li>
              </ul>
         </div>
     </section>
  </div>
</div>