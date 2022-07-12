@extends ("layouts.app")

@section ("breadcrumb")
    <ol>
      <li><a href="{{ url('/') }}">Home</a></li>
      <li>Login</li>
    </ol>
@endsection

@section ("main")

    <main id="main">
        @include ("layouts/page-title", [
            "page_title" => "Login"
        ])

        <section class="contact">
            <div class="container">
                <div class="row">
                    <div class="offset-md-3 col-md-6" data-aos="fade-left">
                        <form action="{{ url('/login') }}" method="POST" class="php-email-form" onsubmit="return doLogin(this);">

                            {{ csrf_field() }}

                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <input type="email" class="form-control" name="email" placeholder="Your Email" required autocomplete="on" />
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <input type="password" class="form-control" name="password" placeholder="Enter Password" required autocomplete="on" />
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" name="submit">
                                    Login
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

        function doLogin(form) {

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

                        if (response.status == "error") {
                            // show the response
                            swal(response.status, response.message, response.status);
                        } else {
                            window.location.href = baseUrl;
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