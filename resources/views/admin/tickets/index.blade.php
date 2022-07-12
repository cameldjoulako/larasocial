@extends ("admin.layouts.app")

@section ("main")
    <div class="container">
        <div class="page-title">
            <h3>All Tickets</h3>
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
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>User</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($tickets as $ticket)
                                        <tr>
                                            <td>
                                                <a href="{{ url('/admin/tickets/' . $ticket->id) }}" class="btn btn-link">
                                                    {{ $ticket->id }}
                                                </a>
                                            </td>

                                            <td>{{ $ticket->title }}</td>
                                            <td>{{ $ticket->status }}</td>

                                            <td>
                                                <a href="{{ url('user/' . $ticket->user->id) }}" class="btn btn-link">
                                                    {{ $ticket->user->name }}
                                                </a>
                                            </td>

                                            <td>
                                                <a href="{{ url('admin/tickets/' . $ticket->id) }}" class="btn btn-link">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer">
                        {{ $tickets->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection