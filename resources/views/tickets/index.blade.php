@extends ("layouts.app")

@section ("breadcrumb")
    <ol>
      <li><a href="{{ url('/') }}">Home</a></li>
      <li>Tickets</li>
    </ol>
@endsection

@section ("main")

    <main id="main">
        @include ("layouts/page-title", [
            "page_title" => "Tickets"
        ])

        <div class="container">

            <div class="row" style="margin-bottom: 10px;">
                <div class="col-md-12 text-right">
                    <a href="{{ url('/tickets/create') }}" class="btn theme-color-bg">
                        Create Ticket
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($tickets as $ticket)
                                <tr>
                                    <td>{{ $ticket->title }}</td>
                                    <td>{{ $ticket->status }}</td>
                                    <td>
                                        <a href="{{ url('/tickets/detail/' . $ticket->id) }}">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $tickets->links() }}
                </div>
            </div>
        </div>
    </main>

@endsection