@extends ("layouts.app")

@section ("breadcrumb")
    <ol>
      <li><a href="{{ url('/') }}">Home</a></li>
      <li>{{ $query }}</li>
    </ol>
@endsection

@section ("main")

    <main id="main">
        @include ("layouts/page-title", [
            "page_title" => $query
        ])

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs">
                      <li class="nav-item">
                        <a class="nav-link active" id="users-tab" data-toggle="tab" href="#users" role="tab" aria-controls="users" aria-selected="true">Users ({{ $user_count }})</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="pages-tab" data-toggle="tab" href="#pages" role="tab" aria-controls="pages" aria-selected="false">Pages ({{ $page_count }})</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="groups-tab" data-toggle="tab" href="#groups" role="tab" aria-controls="groups" aria-selected="false">Groups ({{ $group_count }})</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="posts-tab" data-toggle="tab" href="#posts" role="tab" aria-controls="posts" aria-selected="false">Posts ({{ $post_count }})</a>
                      </li>
                    </ul>
                    <div class="tab-content">

                      <div class="tab-pane fade show active" id="users" role="tabpanel" aria-labelledby="users-tab">
                        <table class="table" style="margin-top: 50px;">
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <img src="{{ $user->profile_image }}" style="width: 100px;" />
                                    
                                        <div style="transform: translateY(50%); margin-left: 10px;">{{ $user->name }}</div>
                                    </td>

                                    <td>
                                        @if (!auth()->user()->is_friend_request_sent_or_received($user->id))
                                            <form method="POST" action="{{ url('/friend-requests/send') }}" style="transform: translateY(50%);" class="offset-md-8" onsubmit="return sendFriendRequest(this);">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="user_id" value="{{ $user->id }}" required>

                                                <button type="submit" class="btn btn-success">Send Friend Request</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                        {{ $users->links() }}
                      </div>

                      <div class="tab-pane fade" id="pages" role="tabpanel" aria-labelledby="pages-tab">
                        
                      </div>

                      <div class="tab-pane fade" id="groups" role="tabpanel" aria-labelledby="groups-tab">
                        
                      </div>

                      <div class="tab-pane fade" id="posts" role="tabpanel" aria-labelledby="posts-tab">
                        <table class="table" style="margin-top: 50px;">
                            @foreach ($posts as $post)
                                <tr>

                                    <td>
                                        <img src="{{ $post->user->profile_image }}" style="width: 100px;" />
                                    
                                        <div style="transform: translateY(50%); margin-left: 10px;">{{ $post->user->name }}</div>
                                    </td>

                                    <td style="display: flex;">
                                        <div style="margin-left: 10px; margin-top: auto; margin-bottom: auto;">
                                            {{ $post->caption }} <br />

                                            {{ $post->likers->count() }} Likes
                                        </div>
                                    </td>

                                    <td style="position: relative;">
                                        <a href="{{ url('/posts/' . $post->id) }}"
                                            style="position: absolute;
                                                top: 50px;
                                                transform: translateY(-50%);">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                        {{ $posts->links() }}
                      </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        function sendFriendRequest(form) {
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

                        if (response.status == "error") {
                            // show the response
                            swal(response.status, response.message, response.status);
                        } else {
                            form.remove();
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
            var formData = new FormData(form);
     
            // send the request
            ajax.send(formData);

            return false;
        }
    </script>

@endsection