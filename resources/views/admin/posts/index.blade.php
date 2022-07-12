@extends ("admin.layouts.app")

@section ("main")
    <div class="container">
        <div class="page-title">
            <h3>{{ request()->route()->getName() }} Posts</h3>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <!-- <div class="card-header">Basic Table</div> -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Caption</th>
                                        <th>Attachments</th>
                                        <th>User</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($posts as $post)
                                        <tr>
                                            <td>
                                                <a href="{{ url('/posts/' . $post->id) }}" class="btn btn-link">
                                                    {{ $post->id }}
                                                </a>
                                            </td>

                                            <td>{{ $post->caption }}</td>
                                            <td>
                                                @foreach ($post->post_attachments as $attachment)
                                                    @if ($attachment->type == "image")
                                                        <img src="{{ url('public/' . \Storage::url($attachment->file_path)) }}" style="width: 200px; height: 200px; object-fit: cover;" />
                                                    @elseif ($attachment->type == "video")
                                                        <video src="{{ url('public/' . \Storage::url($attachment->file_path)) }}" style="width: 200px; height: 200px;" controls></video>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                <a href="{{ url('user/' . $post->user->id) }}">
                                                    {{ $post->user->name }}
                                                </a>
                                            </td>
                                            <td>
                                                {{ $post->type }}
                                            </td>

                                            <td>
                                                {{ $post->status }}
                                            </td>

                                            <td>
                                                <form method="POST" action="{{ url('/admin/posts/ban') }}" onsubmit="return banPost(this);">

                                                    {{ csrf_field() }}

                                                    <input type="hidden" name="id" value="{{ $post->id }}" required />

                                                    <input type="hidden" name="reason" />

                                                    <input type="submit" class="btn btn-danger btn-sm" value="Ban" /> 
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer">
                        {{ $posts->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function banPost(form) {

            swal("Enter reason to ban:", {
                content: "input",
            })
            .then((value) => {
                premiumVersionPopup();
            });

            return false;
        }
    </script>
@endsection