@extends ("layouts.app")

@section ("main")

    <style>
      #preview-post-attachments {
        display: flex;
        margin-top: 30px;
      }
      #preview-post-attachments img,
      #preview-post-attachments video {
        width: 200px;
        height: 200px;
        object-fit: contain;
        margin-right: 5px;
      }
    </style>

    <main id="main" style="margin-top: 170px;">
        <section class="contact">
            <div class="container">

              <div class="row">
                <div class="col-md-3">
                  <ul class="list-group">
                    <li class="list-group-item">
                      <a href="{{ url('/friend-requests') }}">Friend Requests {{ $unresponded_friend_requests > 0 ? '(' . $unresponded_friend_requests . ')' : '' }}</a>
                    </li>

                    <li class="list-group-item">
                      <a href="{{ url('/friends') }}">Friends</a>
                    </li>

                    <li class="list-group-item">
                      <a href="{{ url('/tickets') }}">Tickets {{ $unread_tickets > 0 ? '(' . $unread_tickets . ')' : '' }}</a>
                    </li>

                    <li class="list-group-item">
                      <a href="javascript:void(0);" onclick="premiumVersionPopup();">Chat</a>
                    </li>

                    <li class="list-group-item">
                      <a href="javascript:void(0);" onclick="premiumVersionPopup();">Pages</a>
                    </li>

                    <li class="list-group-item">
                      <a href="javascript:void(0);" onclick="premiumVersionPopup();">Groups</a>
                    </li>

                    <li class="list-group-item">
                      <a href="javascript:void(0);" onclick="premiumVersionPopup();">Notifications</a>
                    </li>
                  </ul>
                </div>

                <div class="col-md-6 php-email-form" data-aos="fade-up">
                  <div class="form-row">

                      <div class="col-md-3">
                        <img src="{{ auth()->user()->profile_image }}" style="width: 100px;" />
                      </div>

                      <div class="col-md-9 form-group">
                          <form method="POST" action="{{ url('/posts/add') }}" enctype="multipart/form-data" onsubmit="return addPost(this);" id="form-add-post">
                            
                            {{ csrf_field() }}

                            <input type="hidden" name="type" value="post" required />

                            <textarea class="form-control" name="caption" placeholder="What's in your mind ?"></textarea>
                            
                            <i class="fa fa-file-image-o theme-color" onclick="this.nextElementSibling.click();"></i>
                            <input type="file" accept="image/*" name="images[]" multiple onchange="previewImage(this, 'preview-post-attachments');" style="display: none;" />

                            <i class="fa fa-video-camera theme-color" onclick="this.nextElementSibling.click();"></i>
                            <input type="file" accept="video/*" name="videos[]" multiple onchange="previewVideo(this, 'preview-post-attachments');" style="display: none;" />

                            <button type="submit" name="submit" style="border-radius: 0px; padding: 5px 10px; margin-top: 10px; float: right;">
                              Post
                              <i class="fa fa-spinner fa-spin" style="display: none;"></i>
                            </button>
                          </form>

                          <div id="preview-post-attachments"></div>
                      </div>
                  </div>

                  <div id="newsfeed" style="margin-top: 50px;">
                    
                  </div>
                </div>

              </div>

            </div>
        </section>
    </main>

    <div class="modal" id="shareModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Share Post</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{ url('/posts/share') }}" id="form-share-post"
              onsubmit="return sharePost(this);">
              {{ csrf_field() }}

              <input type="hidden" name="id" required />

              <div class="form-group">
                <textarea name="caption" class="form-control" rows="7"></textarea>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="submit" form="form-share-post" class="btn theme-color-bg">Share</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal" id="postRespondersModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          
          <div class="modal-header">
            <h5 class="modal-title"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            
          </div>
          
        </div>
      </div>
    </div>

    <input type="hidden" id="pagination-current-page" value="0">

    <script>
      var loadMore = true;
      window.addEventListener("load", function () {
        loadMorePosts();
        $(window).bind('scroll', function() {
            if(!loadMore && $(window).scrollTop() >= $('#newsfeed').offset().top + $('#newsfeed').outerHeight() - window.innerHeight) {
              // console.log('end reached');
              loadMore = true;
              loadMorePosts();
            }
        });
      });
    </script>

@endsection