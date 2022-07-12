@extends ("layouts.app")

@section ("breadcrumb")
    <ol>
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ url('/tickets') }}">Tickets</a></li>
        <li>Detail</li>
    </ol>
@endsection

@section ("main")

    <main id="main">
        @include ("layouts/page-title", [
            "page_title" => "Ticket Detail"
        ])

        <section class="contact">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">

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
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card" style="margin-top: 20px;">
                            <div class="card-header">Responses</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Response</th>
                                                <th>Responded By</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @php
                                                $responses = $ticket->responses()->paginate();
                                            @endphp

                                            @foreach ($responses as $response)
                                                <tr>
                                                    <td>{!! $response->response !!}</td>
                                                    <td>
                                                        <a href="{{ url('user/' . $response->user->id) }}" class="btn btn-link">
                                                            {{ $response->user->name }}
                                                        </a>
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

                        <div class="card" style="margin-top: 20px;">
                            <div class="card-header">
                                Respond
                            </div>

                            <div class="card-body">
                                <form method="POST" action="{{ url('/tickets/respond') }}">

                                    {{ csrf_field() }}

                                    <input type="hidden" name="id" value="{{ $ticket->id }}" required />

                                    <div class="form-group">
                                        <textarea name="response" class="form-control"></textarea>
                                    </div>

                                    <input type="submit" class="btn theme-color-bg" value="Respond" /> 
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

    </main>

    <script>
        window.addEventListener("load", function () {
            $("textarea").richText();
        });
    </script>

@endsection