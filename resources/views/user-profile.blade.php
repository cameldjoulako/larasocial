@extends ("layouts.app")

@section ("main")

    <main id="main">
        <section style="padding-bottom: 0px;">
            <div class="feature-photo" style="position: relative;">
                <figure class="margin-bottom-0">
                    <img class="cover-photo" style="width: 100%; height: 700px; object-fit: cover;" src="{{ $user->cover_photo }}" />
                </figure>

                <div class="container-fluid" style="position: absolute; bottom: 0px;">
                    <div class="row merged">
                        <div class="col-md-2">
                            <div class="user-avatar">
                                <figure>
                                    <img class="profile-image" style="height: 150px; object-fit: cover;" src="{{ $user->profile_image }}" />
                                </figure>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="contact section-bg">
            <div class="container" style="margin-top: 50px;">

              <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header theme-color-bg">
                            <h3 class="margin-bottom-0">Personal Info</h3>
                        </div>

                        <div class="card-body">
                            <p>Name: {{ $user->name }}</p>
                            @if (auth()->user()->is_friend($user->id))
                                <p>Email: {{ $user->email }}</p>
                                <p>Date of Birth: {{ $user->dob }}</p>
                            @endif
                            <p>Lives in: {{ $user->country->name . " " . $user->city->name }}</p>
                            <p>About: {{ $user->about_me }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 php-email-form" data-aos="fade-up" style="background: none;">
                  
                  <div id="newsfeed">

                    @php
                        $posts = $user->posts();
                    @endphp

                    @if ($posts->count() == 0)
                        <h3 class="text-center">No posts yet.</h3>
                    @endif

                    @foreach ($posts->paginate() as $post)
                        @include ("layouts/single-post")
                    @endforeach

                    {{ $posts->paginate()->links() }}
                  </div>
                </div>
              </div>

            </div>
        </section>
    </main>

    <style>
        .card.single-post {
            margin-top: 0px !important;
        }
    </style>

@endsection