@extends ("admin.layouts.app")

@section ("main")
    <div class="container">
        <div class="page-title">
            <h3>{{ request()->route()->getName() }} Users</h3>
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
                                        <th>Name</th>
                                        <th>Picture</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>
                                                <a href="{{ url('/user/' . $user->id) }}" class="btn btn-link">
                                                    {{ $user->id }}
                                                </a>
                                            </td>

                                            <td>{{ $user->name }}</td>
                                            
                                            <td>
                                                <img src="{{ $user->profile_image }}" style="width: 200px;" />
                                            </td>

                                            <td>
                                                {{ $user->status }}
                                            </td>

                                            <td>
                                                <form method="POST" action="{{ url('/admin/users/ban') }}" onsubmit="return banUser(this);">

                                                    {{ csrf_field() }}

                                                    <input type="hidden" name="id" value="{{ $user->id }}" required />

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
                        {{ $users->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function banUser(form) {

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