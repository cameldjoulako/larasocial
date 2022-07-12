@extends ("admin.layouts.app")

@section ("main")
    <div class="container">
        <div class="page-title">
            <h3>Ticket Detail</h3>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">

                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <td>{{ $ticket->id }}</td>
                                    </tr>

                                    <tr>
                                        <th>Title</th>
                                        <td>{{ $ticket->title }}</td>
                                    </tr>

                                    <tr>
                                        <th>Description</th>
                                        <td>{{ $ticket->description }}</td>
                                    </tr>

                                    <tr>
                                        <th>Status</th>
                                        <td>{{ $ticket->status }}</td>
                                    </tr>

                                    <tr>
                                        <th>User</th>
                                        <td>
                                            <a href="{{ url('user/' . $ticket->user->id) }}" class="btn btn-link">
                                                {{ $ticket->user->name }}
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        Change Status
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ url('/admin/tickets/change-status') }}">

                            {{ csrf_field() }}

                            <input type="hidden" name="id" value="{{ $ticket->id }}" required />

                            <div class="form-group">
                                <select name="status" class="form-control" required>
                                    <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                            </div>

                            <input type="submit" class="btn btn-primary" value="Change Status" /> 
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Responses</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Response</th>
                                        <th>Responded By</th>
                                        <th>Is Read</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @php
                                        $responses = $ticket->responses()->paginate();
                                    @endphp

                                    @foreach ($responses as $response)
                                        <tr>
                                            <td>
                                                {{ $response->id }}
                                            </td>

                                            <td>{!! $response->response !!}</td>
                                            <td>
                                                <a href="{{ url('user/' . $response->user->id) }}" class="btn btn-link">
                                                    {{ $response->user->name }}
                                                </a>
                                            </td>

                                            <td>
                                                {{ $response->is_read ? "Read" : "Unread" }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer">
                        {{ $responses->links() }}
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        Respond
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ url('/admin/tickets/respond') }}">

                            {{ csrf_field() }}

                            <input type="hidden" name="id" value="{{ $ticket->id }}" required />

                            <div class="form-group">
                                <textarea name="response" class="form-control"></textarea>
                            </div>

                            <input type="submit" class="btn btn-success" value="Respond" /> 
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        window.addEventListener("load", function () {
            $("textarea").richText();
        });
    </script>

@endsection