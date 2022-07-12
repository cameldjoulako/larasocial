function premiumVersionPopup() {
  swal("This feature is available in premium version.", "To buy full version, WhatsApp: +92-310-5461304", "warning");
}

// creating io instance
var io = io("http://localhost:3000");
io.emit("user_connected", myId);

io.on("post_updated", function (data) {
  // console.log(data);
  getPostUI(data, function (postUI) {
    if (document.getElementById("post-" + data.id) != null) {
      document.getElementById("post-" + data.id).innerHTML = postUI;
    }
  });
});

io.on("post_deleted", function (data) {
  // console.log(data);
  if (document.getElementById("post-" + data.id) != null) {
    document.getElementById("post-" + data.id).remove();
  }
});

// io.on("post_added", function (data) {
  // console.log(data);
//   getPostUI(data, function (postUI) {
//     if (document.getElementById("newsfeed") != null) {
//       document.getElementById("newsfeed").innerHTML = postUI + document.getElementById("newsfeed").innerHTML;
//     }
//   });
// });

String.prototype.ucwords = function() {
  str = this.toLowerCase();
  return str.replace(/(^([a-zA-Z\p{M}]))|([ -][a-zA-Z\p{M}])/g,
    function(s){
      return s.toUpperCase();
  });
};

function showPostResponders(type, id) {
  // console.log(type, id);

  document.querySelector("#postRespondersModal .modal-title").innerHTML = type.ucwords();
  $("#postRespondersModal").modal("show");

  var url = baseUrl + "/posts/get-responders";
  
  var formData = new FormData();
  formData.append("_token", document.querySelector("meta[name=_token]").content);
  formData.append("type", type);
  formData.append("id", id);

  callAjax(url, formData, function (response) {
    // console.log(response);

    document.querySelector("#postRespondersModal .modal-body").innerHTML = response.html;
  });
}

function showShareModal(self) {
  var id = self.getAttribute("data-id");
  document.getElementById("form-share-post").id.value = id;

  $("#shareModal").modal("show");
}

function callAjax(url, formData, callBack) {
  // create AJAX instance
  var ajax = new XMLHttpRequest();

  // open the request
  ajax.open("POST", url, true);

  // listen for response from server
  ajax.onreadystatechange = function () {
      // when the request is successfull
      if (this.readyState == 4) {

          if (this.status == 200) {
              // console.log(this.responseText);
              var response = JSON.parse(this.responseText);
              // console.log(response);

              if (callBack != null) {
                callBack(response);
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

  // send the request
  ajax.send(formData);
}

function sharePost(form) {
  // create form data object
  var formData = new FormData(form);

  callAjax(form.getAttribute("action"), formData, function (response) {
    // show the response
    swal(response.status, response.message, response.status);
    $("#shareModal").modal("hide");

    getPostUI(response.post, function (postUI) {
      if (document.getElementById("newsfeed") != null) {
        document.getElementById("newsfeed").innerHTML = postUI + document.getElementById("newsfeed").innerHTML;
      }
    });
  });

  return false;
}

function getPostUI(post, callBack) {
  // create AJAX instance
  var ajax = new XMLHttpRequest();

  // open the request
  ajax.open("POST", baseUrl + "/posts/get-content", true);

  // listen for response from server
  ajax.onreadystatechange = function () {
      // when the request is successfull
      if (this.readyState == 4) {

          if (this.status == 200) {
              // console.log(this.responseText);
              var response = JSON.parse(this.responseText);
              // console.log(response);

              if (callBack != null) {
                callBack(response.post);
              }
          }

          // if the request fails
          if (this.status == 500) {
              console.log(this.responseText);
              // swal("Error", this.responseText, "error");
          }
      }
  };

  // create form data object
  var formData = new FormData();
  formData.append("_token", document.querySelector("meta[name=_token]").content);
  formData.append("id", post.id);

  // send the request
  ajax.send(formData);
}

function confirmDeletePost(form) {
  swal({
    title: "Delete Post",
    text: "Are you sure you want to delete this post ?",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      // create AJAX instance
      var ajax = new XMLHttpRequest();

      // open the request
      ajax.open(form.getAttribute("method"), form.getAttribute("action"), true);

      // listen for response from server
      ajax.onreadystatechange = function () {
          // when the request is successfull
          if (this.readyState == 4) {

              if (this.status == 200) {
                  // console.log(this.responseText);
                  var response = JSON.parse(this.responseText);
                  // console.log(response);

                  if (document.getElementById("post-" + form.id.value) != null) {
                    document.getElementById("post-" + form.id.value).remove();
                  }

                  io.emit("post_deleted", response.post);
                  swal("Deleted", response.message, "info");
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
    }
  });
  return false;
}

function doLike(self) {
  var button = self;
  var postId = button.getAttribute("data-post-id");

  // create AJAX instance
  var ajax = new XMLHttpRequest();

  // open the request
  ajax.open("POST", baseUrl + "/posts/like-unlike", true);

  // listen for response from server
  ajax.onreadystatechange = function () {
      // when the request is successfull
      if (this.readyState == 4) {

          if (this.status == 200) {
              // console.log(this.responseText);
              var response = JSON.parse(this.responseText);
              // console.log(response);

              if (response.status == "success") {
                // change button style
                if (response.is_deleted) {
                  button.className = "unlike";
                } else {
                  button.className = "";
                }

                button.previousElementSibling.innerHTML = "(" + response.post_likes_count + ")";
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
  var formData = new FormData();
  formData.append("_token", document.querySelector("meta[name=_token]").content);
  formData.append("post_id", postId);

  // send the request
  ajax.send(formData);
}

function loadMorePosts() {
  var page = document.getElementById("pagination-current-page").value;

  // create AJAX instance
  var ajax = new XMLHttpRequest();

  // open the request
  ajax.open("POST", baseUrl + "/posts/load-more", true);

  // listen for response from server
  ajax.onreadystatechange = function () {
      // when the request is successfull
      if (this.readyState == 4) {

          if (this.status == 200) {
              // console.log(this.responseText);
              var response = JSON.parse(this.responseText);
              // console.log(response);

              document.getElementById("pagination-current-page").value++;
              document.getElementById("newsfeed").innerHTML += response.posts_html;

              if (response.posts.data.length > 0) {
                loadMore = false;
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

  page++;

  // create form data object
  var formData = new FormData();
  formData.append("_token", document.querySelector("meta[name=_token]").content);
  formData.append("page", page);

  // send the request
  ajax.send(formData);
}

function addPost(form) {

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
              // console.log(this.responseText);
              var response = JSON.parse(this.responseText);
              // console.log(response);

              // show the response
              swal(response.status, response.message, response.status);

              if (response.status == "success") {
                document.getElementById("form-add-post").reset();
                document.getElementById("preview-post-attachments").innerHTML = "";

                getPostUI(response.post, function (postUI) {
                  if (document.getElementById("newsfeed") != null) {
                    document.getElementById("newsfeed").innerHTML = postUI + document.getElementById("newsfeed").innerHTML;
                  }
                });

                // io.emit("post_added", response.post);
              }

          }

          // if the request fails
          if (this.status == 500) {
              console.log(this.responseText);
              // swal("Error", this.responseText, "error");
          }

          // if the request fails
          if (this.status == 451) {
              console.log(this.responseText);
              swal("Error", this.responseText, "error");
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

function previewImage(self, preview) {
  for (var a = 0; a < self.files.length; a++) {
      var file = self.files[a];
      var fileReader = new FileReader();

      fileReader.onload = function (event) {
          document.getElementById(preview).innerHTML += "<img src= '" + event.target.result + "' style='width: 100%;' />";
      };

      fileReader.readAsDataURL(file);
    }
}

function previewVideo(self, preview) {
  for (var a = 0; a < self.files.length; a++) {
      var file = self.files[a];
      var fileReader = new FileReader();

      fileReader.onload = function (event) {
          document.getElementById(preview).innerHTML += "<video src= '" + event.target.result + "' controls style='width: 100%;'></video>";
      };

      fileReader.readAsDataURL(file);
    }
}

function getCities(self) {
    // create AJAX instance
    var ajax = new XMLHttpRequest();

    // open the request
    ajax.open("POST", baseUrl + "/api/get-cities", true);

    // listen for response from server
    ajax.onreadystatechange = function () {
        // when the request is successfull
        if (this.readyState == 4) {

            if (this.status == 200) {
                // console.log(this.responseText);
                var response = JSON.parse(this.responseText);
                // console.log(response);

                var html = "";
                for (var a = 0; a < response.cities.length; a++) {
                    html += "<option value='" + response.cities[a].id + "'>";
                        html += response.cities[a].name;
                    html += "</option>";
                }
                document.getElementById("cities").innerHTML = html;
            }

            // if the request fails
            if (this.status == 500) {
                console.log(this.responseText);
                // swal("Error", this.responseText, "error");
            }
        }
    };

    // create form data object
    var formData = new FormData();
    formData.append("country_id", self.value);

    // send the request
    ajax.send(formData);
}

function onValidationFails(response) {
    // console.log(response);
    var response = JSON.parse(response);
    // console.log(response);

    var html = "";
    for (var a = 0; a < response.length; a++) {
        html += "<p>" + response[a] + "</p>";
    }
    // swal("Error", html, "error");
    // this is a Node object    
    var span = document.createElement("span");
    span.innerHTML = html;

    swal({
        title: "Error", 
        content: span,
        confirmButtonText: "", 
        allowOutsideClick: "true" 
    });
}