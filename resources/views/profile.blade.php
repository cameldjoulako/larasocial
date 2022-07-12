@extends ("layouts.app")

@section ("main")

    <main id="main">
        @include ("layouts/page-title", [
            "page_title" => "Profile"
        ])

        <script>
            function selectCoverPhoto() {
                document.querySelector("#form-update-profile input[name=coverPhoto]").click();
            }

            function coverPhotoSelected() {
                var file = document.querySelector("#form-update-profile input[name=coverPhoto]").files;
                if (file.length > 0) {
                    var fileReader = new FileReader();
         
                    fileReader.onload = function (event) {
                        document.getElementById("cover-photo").setAttribute("src", event.target.result);
                    };
         
                    fileReader.readAsDataURL(file[0]);
                }
            }

            function selectProfilePhoto() {
                document.querySelector("#form-update-profile input[name=profileImage]").click();
            }

            function profileImageSelected() {
                var file = document.querySelector("#form-update-profile input[name=profileImage]").files;
                if (file.length > 0) {
                    var fileReader = new FileReader();
         
                    fileReader.onload = function (event) {
                        document.getElementById("profile-image").setAttribute("src", event.target.result);
                    };
         
                    fileReader.readAsDataURL(file[0]);
                }
            }

            function updateProfile(form) {
                // show a loading bar inside submit button
                form.submit.querySelector("i").style.display = "";

                // create AJAX instance
                var ajax = new XMLHttpRequest();
         
                // open the request
                ajax.open(form.getAttribute("method"), form.getAttribute("action"), true);
         
                // listen for response from server
                ajax.onreadystatechange = function () {
                    // when the request is successfull
                    if (this.readyState == 4) {

                        // hide loading bar
                        form.submit.querySelector("i").style.display = "none";

                        if (this.status == 200) {
                            console.log(this.responseText);
                            var response = JSON.parse(this.responseText);
                            console.log(response);
             
                            // show the response
                            swal(response.status, response.message, response.status);
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

        <form method="POST" action="{{ url('/profile') }}" id="form-update-profile" enctype="multipart/form-data" onsubmit="return updateProfile(this);" style="display: none;">
            {{ csrf_field() }}

            <input type="file" accept="image/*" name="coverPhoto" onchange="coverPhotoSelected();" />

            <input type="file" accept="image/*" name="profileImage" onchange="profileImageSelected();" />
        </form>

        <section style="padding-bottom: 0px;">
            <div class="feature-photo" style="position: relative;">
                <figure style="margin-bottom: 0px;">
                    <img class="cover-photo" id="cover-photo" style="width: 100%; height: 700px; object-fit: cover; cursor: pointer;" src="{{ auth()->user()->cover_photo }}" onclick="selectCoverPhoto();" />
                </figure>

                <div class="container-fluid" style="position: absolute; bottom: 0px;">
                    <div class="row merged">
                        <div class="col-md-2">
                            <div class="user-avatar">
                                <figure>
                                    <img class="profile-image" id="profile-image" style="height: 150px; object-fit: cover; cursor: pointer;" src="{{ auth()->user()->profile_image }}" onclick="selectProfilePhoto();" />
                                </figure>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="services contact section-bg">
            <div class="container">
                <div class="section-title pt-5" data-aos="fade-up">
                    <h2>{{ auth()->user()->name }}</h2>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="icon-box php-email-form" data-aos="fade-up">
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Your Name" value="{{ auth()->user()->name }}" required form="form-update-profile" />
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="Your Email" value="{{ auth()->user()->email }}" disabled />
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label>Date of Birth</label>
                                    <input type="text" class="form-control" name="dob" placeholder="Your date of birth" id="dob" value="{{ auth()->user()->dob }}" form="form-update-profile" autocomplete="off" />
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label>Country</label>
                                    <select name="country_id" onchange="getCities(this);" class="form-control" required form="form-update-profile">
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" {{ $country->id == auth()->user()->country->id ? "selected" : "" }}>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label>City</label>
                                    <select name="city_id" id="cities" class="form-control" required form="form-update-profile">
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" {{ $city->id == auth()->user()->city->id ? "selected" : "" }}>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label>About me</label>
                                    <textarea class="form-control" name="about_me" placeholder="Something about yourself" rows="7" form="form-update-profile">{{ auth()->user()->about_me }}</textarea>
                                </div>
                            </div>

                            <button type="submit" name="submit" form="form-update-profile">
                                Update Profile
                                <i class="fa fa-spinner fa-spin" style="display: none;"></i>
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="contact" style="padding-top: 50px;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12" data-aos="fade-up" style="background: none;">

                        <h2 class="text-center">My Posts</h2>
                  
                      <div class="row">
                          <div class="offset-md-3 col-md-6 php-email-form">
                                <div id="newsfeed">
                                    @foreach (auth()->user()->posts()->paginate() as $post)
                                        @include ("layouts/single-post")
                                    @endforeach

                                    {{ auth()->user()->posts()->paginate()->links() }}
                                </div>
                          </div>
                      </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <script>
        window.addEventListener("load", function () {
            $("#dob").datetimepicker({
                timepicker: false,
                format: "Y-m-d"
            });
        });
    </script>

@endsection