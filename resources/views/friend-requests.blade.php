@extends ("layouts.app")

@section ("breadcrumb")
    <ol>
      <li><a href="{{ url('/') }}">Home</a></li>
      <li>Friend Requests</li>
    </ol>
@endsection

@section ("main")

    <main id="main">
        @include ("layouts/page-title", [
            "page_title" => "Friend Requests"
        ])

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <tr>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>

                        @foreach (auth()->user()->friend_requests_received as $friend_request)

                            @if ($friend_request->is_declined() || $friend_request->is_accepted())
                                @php continue; @endphp
                            @endif

                            <tr>
                                <td>{{ $friend_request->user->name }}</td>

                                <td style="display: flex;">
                                    
                                    <form method="POST" action="{{ url('/friend-requests/decline') }}" onsubmit="return friendRequestAction(this);">
                                        {{ csrf_field() }}

                                        <input type="hidden" name="id" value="{{ $friend_request->id }}" required />

                                        <button type="submit" class="btn btn-danger">Decline</button>
                                    </form>

                                    <form method="POST" action="{{ url('/friend-requests/accept') }}" style="margin-left: 10px;" onsubmit="return friendRequestAction(this);">
                                        {{ csrf_field() }}

                                        <input type="hidden" name="id" value="{{ $friend_request->id }}" required />

                                        <button type="submit" class="btn btn-success">Accept</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script>
        function friendRequestAction(form) {
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
                            form.parentElement.parentElement.remove();
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

            // prevent the form from submitting
            return false;
        }
    </script>

@endsection