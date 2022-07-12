@extends ("layouts.app")

@section ("breadcrumb")
    <ol>
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ url('/tickets') }}">Tickets</a></li>
        <li>Create</li>
    </ol>
@endsection

@section ("main")

    <main id="main">
        @include ("layouts/page-title", [
            "page_title" => "Create Ticket"
        ])

        <section class="contact">
            <div class="container">
                <div class="row">
                    <div class="offset-md-3 col-md-6 php-email-form">
                        <form method="post" action="{{ url('/tickets/create') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control" required autocomplete="off" />
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control" required></textarea>
                            </div>

                            <div class="form-group">
                                <label>Attachment</label>
                                <input type="file" name="attachment" />
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Create Ticket
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection