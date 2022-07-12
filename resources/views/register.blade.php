@extends ("layouts.app")

@section ("breadcrumb")
    <ol>
      <li><a href="{{ url('/') }}">Home</a></li>
      <li>Register</li>
    </ol>
@endsection

@section ("main")

    <main id="main">
        @include ("layouts/page-title", [
            "page_title" => "Register"
        ])

        <section class="contact">
            <div class="container">
                <div class="row">
                    <div class="offset-md-3 col-md-6" data-aos="fade-left">
                        <form action="{{ url('/register') }}" method="POST" class="php-email-form" onsubmit="return doRegister(this);">
                            {{ csrf_field() }}
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <input type="text" name="name" class="form-control" placeholder="Your Name" required />
                                </div>
                                <div class="col-md-6 form-group">
                                    <input type="text" class="form-control" name="username" placeholder="Your Username" required />
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <input type="email" class="form-control" name="email" placeholder="Your Email" required />
                                </div>
                                <div class="col-md-6 form-group">
                                    <select name="gender" class="form-control" required
                                        style="border-radius: 0px; height: 44px;">
                                        <option value="">Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <select name="country_id" class="form-control" 
                                        style="border-radius: 0px; height: 44px;"
                                        onchange="getCities(this);">
                                        <option value="">Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 form-group">
                                    <select name="city_id" id="cities" class="form-control" 
                                        style="border-radius: 0px; height: 44px;">
                                        <option value="">City</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="password" class="form-control" name="password" placeholder="Enter Password" required />
                            </div>

                            <div class="text-center">
                                <button type="submit" name="submit">
                                    Register
                                    <i class="fa fa-spinner fa-spin" style="display: none;"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>

        function doRegister(form) {
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

@endsection