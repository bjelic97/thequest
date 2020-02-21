$(document).ready(function() {
  // prevented socail links to indicate somewhere cuz i don't need it but they look cool :D

  $("body").on("click", ".socials", function(e) {
    e.preventDefault();
  });

  //

  // REG MODAL CLEAR ERRORS

  $("body").on("click", "#reg-modal", function(e) {
    $("#register-form")[0].reset();
    $("#errors").addClass("elementDissapear");
    $("#success").addClass("elementDissapear");
  });

  // REG MODAL CLEAR ERRORS END

  // LOG MODAL CLEAR ERRORS

  $("body").on("click", "#login-modal", function(e) {
    $("#login-form")[0].reset();
    $("#errors").addClass("elementDissapear");
    $("#success").addClass("elementDissapear");
  });

  // LOG MODAL CLEAR ERRORS END
  // LOGIN JS

  $("body").on("click", "#login", function(e) {
    e.preventDefault();
    let username = document.querySelector("#log-username").value;
    let password = document.querySelector("#log-password").value;

    let errors = [];

    let regPassword = /^[\w\d]{5,15}$/;

    if (!regPassword.test(username)) {
      errors.push(
        "<strong>Username :</strong> Letters and numbers allowed, length 15."
      );
      console.log(errors);
    }

    if (!regPassword.test(password)) {
      errors.push(
        "<strong>Password :</strong> Letters and numbers allowed, length 15."
      );
      console.log(errors);
    }

    // // AJAX CALL

    if (errors.length != 0) {
      let errorElement = $("#errors");
      $("#container-login").before(errorElement);
      printErrors(errors);
    } else {
      $("#errors").addClass("elementDissapear");

      $.ajax({
        method: "POST",
        url: "index.php?page=login",
        data: {
          logUser: "log",
          username: username,
          password: password
        },
        dataType: "json",
        success: function(data, status, request) {
          console.info(data);
          console.info(status);
          console.info(request);
          console.info(request.responseJSON);
          let successElement = $("#success");
          $("#container-login").before(successElement);
          printSuccess("Success!", "You have successfully logged in.");
          setTimeout(window.location.replace("index.php"), 3000);
        },
        error: showErrors
      });
    }
  });

  // END LOGIN JS

  // REGISTER JS

  $("body").on("click", "#register", function(e) {
    e.preventDefault();
    var firstname = document.querySelector("#firstname").value;
    var lastname = document.querySelector("#lastname").value;
    var email = document.querySelector("#email").value;

    let username = document.querySelector("#username").value;
    let password = document.querySelector("#password").value;

    let errors = [];

    let regFirstName = /^[A-ZŽŠĐĆČ][a-zžšđčć]{3,12}$/;
    let regLastName = /^([A-ZŽŠĐĆČ][a-zžšđčć]{3,12})+$/;
    let regEmail = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    let regPassword = /^[\w\d]{5,15}$/;

    if (!regFirstName.test(firstname)) {
      errors.push(
        "<strong>Firstname :</strong> Letters only, length &lt12, first letter capitalised."
      );
      console.log(errors);
    }

    if (!regLastName.test(lastname)) {
      errors.push(
        "<strong>Lastname :</strong>  Letters only, length &lt12, first letter capitalised."
      );
      console.log(errors);
    }

    if (!regEmail.test(email)) {
      errors.push("<strong>Invalid email format.</strong>");
      console.log(errors);
    }

    if (!regPassword.test(username)) {
      errors.push(
        "<strong>Username :</strong> Letters and numbers allowed, length 15."
      );
      console.log(errors);
    }

    if (!regPassword.test(password)) {
      errors.push(
        "<strong>Password :</strong> Letters and numbers allowed, length 15."
      );
      console.log(errors);
    }

    // // AJAX CALL

    if (errors.length != 0) {
      let errorElement = $("#errors");
      $("#container-register").before(errorElement);
      printErrors(errors);
    } else {
      $("#errors").addClass("elementDissapear");

      $.ajax({
        method: "POST",
        url: "index.php?page=register",
        data: {
          regUser: "nestopametnije",
          firstname: firstname,
          lastname: lastname,
          email: email,
          password: password,
          username: username
        },
        dataType: "json",
        success: function(data, status, request) {
          switch (request.status) {
            case 201:
              console.info(`${request.status}: ${request.statusText}`);
              break;
            case 200:
              console.info(`${request.status}: ${request.statusText}`);
              break;
            case 204:
              console.info(`${request.status}: ${request.statusText}`);
              break;
          }
          console.info(data);
          console.info(status);
          console.info(request);
          console.info(request.responseJSON);
          let successElement = $("#success");
          $("#container-register").before(successElement);
          printSuccess("Success!", "You have successfully registered.");
        },
        error: showErrors
      });
    }
  });

  // END OF REGISTER JS

  $("body").on("click", ".posts-pagination", function() {
    let limit = $(this).data("limit");
    console.log(limit);

    $.ajax({
      url: `index.php?page=posts&limit=${limit}`,
      method: "POST",
      //   data: {
      //     limit: limit
      //   },
      success: function(data) {
        console.log(data);
        printPosts(data.posts);
        printPagination(data.totalCount);
      },
      error: function(error) {
        console.log(error);
      }
    });
  });

  $("body").on("click", ".filter-cat", function(e) {
    e.preventDefault();
    let id = $(this).data("id");

    $.ajax({
      url: `index.php?page=posts&category=${id}`,
      method: "POST",
      data: {
        id_category: id
      },
      dataType: "json",
      success: function(data, status, requet) {
        console.info(data);
        console.info(status);
        console.info(requet);
        if (requet.status === 200) {
          console.info(`${requet.status} : ${requet.statusText}`);
          printPosts(data.posts);
          printPagination(data.totalCount);
        }
      },
      error: showErrors
    });
  });

  $("#filter").keyup(function() {
    let filter = $(this).val();

    if (filter == "") {
      $.ajax({
        url: `index.php?page=posts&limit=0`,
        method: "POST",
        success: function(data) {
          printPosts(data.posts);
          printPagination(data.totalCount);
        },
        error: function(error) {
          console.log(error);
        }
      });
    } else {
      $.ajax({
        url: `index.php?page=posts&filter=${filter}`,
        method: "POST",
        dataType: "json",
        success: function(data) {
          printPosts(data.posts);
          printPagination(data.totalCount);
        },
        error: function(error) {
          console.log(error);
        }
      });
    }
  });

  $("#sort").change(function() {
    let sort = $(this).val();

    $.ajax({
      url: `index.php?page=posts&sort=${sort}`,
      method: "POST",
      dataType: "json",
      success: function(data) {
        printPosts(data.posts);
        printPagination(data.totalCount);
      },
      error: function(error) {
        console.log(error);
      }
    });
  });

  $("body").on("click", "#saveComment", function() {
    let content = $("#comment").val();
    let loggedUserId = $("#loggedUserId").val();
    let postId = $("#postId").val();
    let errors = [];

    if (!isNullOrWhitespace(content)) {
      $("#errors").addClass("elementDissapear");
      $.ajax({
        url: `index.php?page=comments&create=comment`,
        method: "POST",
        data: {
          content: content,
          loggedUserId: loggedUserId,
          postId: postId
        },
        // dataType: "json",
        success: function(data, status, requet) {
          console.warn("Successfuly created comment");

          if (requet.status == 201) {
            console.log("Message" + data.success);
          }
          if (typeof Storage !== "undefined") {
            console.log("supports");
          } else {
            console.log("doesnt");
          }
          clearForm();
          getComments(postId);
        },
        error: showErrors
      });
    } else {
      errors.push(
        "<strong>Content field cannot be empty or contain only space.</strong>"
      );
      let errorElement = $("#errors");
      $("#comment").after(errorElement);
      printErrors(errors);
    }
  });

  // post section crud and stuff

  // delete post

  $(document).on("click", ".delete-mod", function(e) {
    e.preventDefault();

    let id = $(this).data("id");
    let check = $(this).data("update");

    $(".delete-post").data("id", id);
    $(".delete-post").data("update", check);
  });

  $(document).on("click", ".delete-post", function(e) {
    e.preventDefault();

    $(".delete-post").attr("data-dismiss", null);
    $("#spinner").removeClass("elementDissapear");
    $(".delete-post").addClass("elementDissapear");
    $(".cancel-mod").addClass("elementDissapear");

    let id = $(this).data("id");
    let check = $(this).data("update");

    $.ajax({
      url: "index.php?page=posts&remove",
      method: "POST",
      data: {
        id: id
      },
      // dataType: "json",
      success: function(data, status, request) {
        console.warn("Succesfully deleted post.");
        if (check == "from-posts") {
          setTimeout(getPosts, 1000);
        } else {
          window.location.replace("http://localhost/thequest/index.php");
        }
      },
      error: showErrors
    });
  });

  $(document).on("click", ".save-content", function() {
    let id = $(this).data("id");
    let content = $("#content").val();

    errors = [];

    if (!isNullOrWhitespace(content)) {
      // patch ( post-content )
      $.ajax({
        url: "index.php?page=posts&edit=content",
        method: "POST",
        data: {
          id: id,
          content: content
        },
        // dataType: "json",
        success: function(data) {
          console.log("update content suceeded");
          let modified = $("#modified-at");
          let origTitle = $("#original-content");
          var current_datetime = new Date();
          const months = [
            "January",
            "February",
            "March",
            "April",
            "May",
            "Jun",
            "July",
            "August",
            "September",
            "October",
            "November",
            "Dec"
          ];

          var time =
            appendLeadingZeroes(current_datetime.getHours()) +
            ":" +
            appendLeadingZeroes(current_datetime.getMinutes());
          let formatted_date = `${
            months[current_datetime.getMonth()]
          } ${current_datetime.getDate()}, ${current_datetime.getFullYear()}. ${time}`;

          modified.html(`Latest modify : ${formatted_date}`);
          origTitle.html(content);
        },
        error: function(error, status, statusText) {
          console.error("error");

          console.log(error.parseJSON);
        }
      });
    } else {
      errors.push(
        "<strong>Content field cannot be empty or contain only space.</strong>"
      );
      let errorElement = $("#errors");
      $("#content").after(errorElement);
      printErrors(errors);
    }
  });

  $(document).on("click", ".save-img", function() {
    let id = $(this).data("id");

    $.ajax({
      url: "index.php?page=posts&edit=img",
      method: "POST",
      data: {
        id: id
      },
      // dataType: "json",
      success: function(data) {
        console.log(data);
        console.log("update img suceeded");
        let modified = $("#modified-at");
        // let origTitle = $("#original-content");
        var current_datetime = new Date();
        const months = [
          "January",
          "February",
          "March",
          "April",
          "May",
          "Jun",
          "July",
          "August",
          "September",
          "October",
          "November",
          "Dec"
        ];

        var time =
          appendLeadingZeroes(current_datetime.getHours()) +
          ":" +
          appendLeadingZeroes(current_datetime.getMinutes());
        let formatted_date = `${
          months[current_datetime.getMonth()]
        } ${current_datetime.getDate()}, ${current_datetime.getFullYear()}. ${time}`;

        modified.html(`Latest modify : ${formatted_date}`);
        // origTitle.html(content);
      },
      error: function(error, status, statusText) {
        console.error("error");
        console.error(error);
        console.log(error.parseJSON);
      }
    });
  });

  $(document).on("click", ".save-title", function() {
    // patch ( post-title )
    let id = $(this).data("id");
    let title = $("#field-title").val();

    errors = [];

    if (!isNullOrWhitespace(title)) {
      $("#errors").addClass("elementDissapear");
      $.ajax({
        url: "index.php?page=posts&edit=title", //change into patch !
        method: "POST",
        data: {
          id: id,
          title: title
        },
        // dataType: "json",
        success: function(data) {
          console.log("update title suceeded");

          // better then calling server

          let modified = $("#modified-at");
          let origTitle = $("#show-title");
          var current_datetime = new Date();
          const months = [
            "January",
            "February",
            "March",
            "April",
            "May",
            "Jun",
            "July",
            "August",
            "September",
            "October",
            "November",
            "Dec"
          ];

          var time =
            appendLeadingZeroes(current_datetime.getHours()) +
            ":" +
            appendLeadingZeroes(current_datetime.getMinutes());
          let formatted_date = `${
            months[current_datetime.getMonth()]
          } ${current_datetime.getDate()}, ${current_datetime.getFullYear()}. ${time}`;

          modified.html(`Latest modify : ${formatted_date}`);
          origTitle.html(title);
        },
        error: function(error, status, statusText) {
          console.error("error");

          console.log(error.parseJSON);
        }
      });
    } else {
      errors.push(
        "<strong>Title field cannot be empty or contain only space.</strong>"
      );
      let errorElement = $("#errors");
      $("#field-title").after(errorElement);
      printErrors(errors);
    }
  });

  $(document).on("click", ".save-user", function() {
    let id = $(this).data("id");

    let selectedHtml = $("#ddl-users")
      .children("option:selected")
      .text();

    let selectedVal = $("#ddl-users").val();
    errors = [];
    // get username
    init = selectedHtml.indexOf("(");
    fin = selectedHtml.indexOf(")");
    let username = selectedHtml.substr(init + 1, fin - init - 1).trim();

    if (selectedVal != 0) {
      // patch ( post-user )
      $.ajax({
        url: "index.php?page=posts&edit=user",
        method: "POST",
        data: {
          id: id,
          user: selectedVal
        },
        // dataType: "json",
        success: function(data) {
          console.log("update user suceeded");
          let modified = $("#modified-at");
          let origUser = $("#users-original");
          var current_datetime = new Date();
          const months = [
            "January",
            "February",
            "March",
            "April",
            "May",
            "Jun",
            "July",
            "August",
            "September",
            "October",
            "November",
            "Dec"
          ];

          var time =
            appendLeadingZeroes(current_datetime.getHours()) +
            ":" +
            appendLeadingZeroes(current_datetime.getMinutes());
          let formatted_date = `${
            months[current_datetime.getMonth()]
          } ${current_datetime.getDate()}, ${current_datetime.getFullYear()}. ${time}`;

          modified.html(`Latest modify : ${formatted_date}`);
          origUser.html(`By ${username}`);
        },
        error: function(error, status, statusText) {
          console.error("error");

          console.log(error.parseJSON);
        }
      });
    } else {
      errors.push("<strong>Please, select a valid user.</strong>");
      let errorElement = $("#errors");
      $("#ddl-users").after(errorElement);
      printErrors(errors);
    }
  });

  $(document).on("click", ".save-category", function() {
    let id = $(this).data("id");

    errors = [];

    let selectedHtml = $("#ddl-categories")
      .children("option:selected")
      .text();

    let selectedVal = $("#ddl-categories").val();

    if (selectedVal != 0) {
      // get categoryhtml
      let cathtml = selectedHtml.toUpperCase();

      // patch ( post-category )

      $("#errors").addClass("elementDissapear");
      $.ajax({
        url: "index.php?page=posts&edit=category",
        method: "POST",
        data: {
          id: id,
          category: selectedVal
        },
        // dataType: "json",
        success: function(data) {
          console.log("update user suceeded");
          let modified = $("#modified-at");
          let origCat = $("#categories-original");
          var current_datetime = new Date();
          const months = [
            "January",
            "February",
            "March",
            "April",
            "May",
            "Jun",
            "July",
            "August",
            "September",
            "October",
            "November",
            "Dec"
          ];

          var time =
            appendLeadingZeroes(current_datetime.getHours()) +
            ":" +
            appendLeadingZeroes(current_datetime.getMinutes());
          let formatted_date = `${
            months[current_datetime.getMonth()]
          } ${current_datetime.getDate()}, ${current_datetime.getFullYear()}. ${time}`;

          modified.html(`Latest modify : ${formatted_date}`);
          origCat.html(`in <a href="#">${cathtml}</a>`);
        },
        error: function(error, status, statusText) {
          console.error("error");

          console.log(error.parseJSON);
        }
      });
    } else {
      errors.push("<strong>Please, select a valid category.</strong>");
      let errorElement = $("#errors");
      $("#ddl-categories").after(errorElement);
      printErrors(errors);
    }
  });

  $(document).on("click", ".edit-comment", function() {
    // fields

    let id = $(this).data("id");
    let p = $(`#comment-${id}`);
    let edit = $(`#field-${id}`);
    let close = $(`#close-${id}`);
    let save = $(`#save-${id}`);

    if (edit.hasClass("elementDissapear")) {
      edit.val(p.html());
      edit.removeClass("elementDissapear");
      close.removeClass("elementDissapear");
      save.removeClass("elementDissapear");
      p.addClass("elementDissapear");
    } else {
      edit.val("");
      p.removeClass("elementDissapear");
      edit.addClass("elementDissapear");
      close.addClass("elementDissapear");
      save.addClass("elementDissapear");
    }
    $("#errors").addClass("elementDissapear");
  });

  $(document).on("click", ".title-post", function() {
    // fields

    let save = $(`#save-title`);
    let edit = $("#field-title");
    let origTitle = $("#show-title");

    if (edit.hasClass("elementDissapear")) {
      save.removeClass("elementDissapear");
      edit.removeClass("elementDissapear");
      origTitle.addClass("elementDissapear");
      edit.val(origTitle.html());
    } else {
      save.addClass("elementDissapear");
      edit.addClass("elementDissapear");
      origTitle.removeClass("elementDissapear");
    }
    $("#errors").addClass("elementDissapear");
  });

  $(document).on("click", ".users-post", function() {
    // fields

    let id = $(this).data("id");

    let save = $(`#save-users`);
    let edit = $("#ddl-users");
    let origTitle = $("#users-original");

    if (edit.hasClass("elementDissapear")) {
      save.removeClass("elementDissapear");
      edit.removeClass("elementDissapear");
      origTitle.addClass("elementDissapear");
    } else {
      save.addClass("elementDissapear");
      edit.addClass("elementDissapear");
      origTitle.removeClass("elementDissapear");
    }
    $("#errors").addClass("elementDissapear");
  });

  $(document).on("click", ".categories-post", function() {
    // fields

    let id = $(this).data("id");

    let save = $(`#save-categories`);
    let edit = $("#ddl-categories");
    let origTitle = $("#categtories-original");

    if (edit.hasClass("elementDissapear")) {
      save.removeClass("elementDissapear");
      edit.removeClass("elementDissapear");
      origTitle.addClass("elementDissapear");
    } else {
      save.addClass("elementDissapear");
      edit.addClass("elementDissapear");
      origTitle.removeClass("elementDissapear");
    }
    $("#errors").addClass("elementDissapear");
  });

  $(document).on("click", ".content-post", function() {
    // fields

    let id = $(this).data("id");

    let save = $(`#save-content`);
    let edit = $("#content");
    let origTitle = $("#original-content");

    if (edit.hasClass("elementDissapear")) {
      save.removeClass("elementDissapear");
      edit.removeClass("elementDissapear");
      origTitle.addClass("elementDissapear");
      edit.val(origTitle.html());
    } else {
      save.addClass("elementDissapear");
      edit.addClass("elementDissapear");
      origTitle.removeClass("elementDissapear");
    }
    $("#errors").addClass("elementDissapear");
  });

  $(document).on("click", ".upload-img-post", function() {
    // fields

    let id = $(this).data("id");

    let save = $(`#save-upload-img`);
    let edit = $("#post-img");
    let origTitle = $("#original-img");

    if (edit.hasClass("elementDissapear")) {
      save.removeClass("elementDissapear");
      edit.removeClass("elementDissapear");
      origTitle.addClass("elementDissapear");
    } else {
      save.addClass("elementDissapear");
      edit.addClass("elementDissapear");
      origTitle.removeClass("elementDissapear");
    }
  });

  $(document).on("click", ".remove-comment", function() {
    // fields

    let id = $(this).data("id");
    let postId = $("#postId").val();
    console.log(id);

    $.ajax({
      url: "index.php?page=comments&remove",
      method: "POST",
      data: {
        id: id
      },
      // dataType: "json",
      success: function(data) {
        console.log(data);
        console.log("remove suceeded, " + id);
        getComments(postId);
      },
      error: function(error, status, statusText) {
        console.error("error");

        console.log(error.parseJSON);
      }
    });
  });
});

$(document).on("click", ".close-edit", function() {
  let id = $(this).data("id");
  console.log(id);
  let p = $(`#comment-${id}`);
  let edit = $(`#field-${id}`);
  let close = $(`#close-${id}`);
  let save = $(`#save-${id}`);

  p.removeClass("elementDissapear");
  edit.addClass("elementDissapear");
  close.addClass("elementDissapear");
  save.addClass("elementDissapear");
});

$(document).on("click", ".save-edit", function() {
  let id = $(this).data("id");
  console.log(id);
  let p = $(`#comment-${id}`);
  let edit = $(`#field-${id}`);
  let close = $(`#close-${id}`);
  let save = $(`#save-${id}`);
  let errors = [];
  p.removeClass("elementDissapear");
  edit.addClass("elementDissapear");
  close.addClass("elementDissapear");
  save.addClass("elementDissapear");

  if (!isNullOrWhitespace(edit.val())) {
    // p.html(edit.val());
    $.ajax({
      url: "index.php?page=comments&edit",
      method: "POST",
      data: {
        id: id,
        content: edit.val()
      },
      // dataType: "json",
      success: function(data) {
        console.log("updated suceeded, " + id);
        getComment(id);
      },
      error: function(error, status, statusText) {
        console.error("error");

        console.log(error.parseJSON);
      }
    });
  } else {
    errors.push(
      "<strong>Content field cannot be empty or contain only space.</strong>"
    );
    let errorElement = $("#errors");
    $(`#field-${id}`).after(errorElement);
    printErrors(errors);
  }
});

function printPosts(posts) {
  let html = "";
  let crudBtns = "";

  let loggedUserRole = $("#loggedUserRole").val();

  for (let post of posts) {
    if (loggedUserRole == 1) {
      crudBtns = `<a href="index.php?page=posts&id=${post.id}" class="btn btn-secondary btnComm"><i class="fa fa-wrench" aria-hidden="true"></i></a>
      <a href="#delete-modal" style="float:right;" class="trigger-btn btn btn-danger btnComm delete-mod" data-id="${post.id}" data-toggle="modal"><i class="fa fa-times" aria-hidden="true"></i></a>`;
    }

    if (post.content.length > 300) {
      post.content = post.content.substr(0, 300) + " ...";
    }

    html += `<div class="col-md-6"> 
   ${crudBtns}
    ${printDeleteModal()}
<div class="blog-post">
    <img src="${post.src_small}" alt="${post.alt}">
    <div class="post-date">${post.created_at}</div>
    <h4>${post.title}</h4>
    <div class="post-metas">
        <div class="post-meta">By <i class="fa fa-user-secret" aria-hidden="true"></i> <a>${post.firstname +
          " " +
          post.lastname}</a></div>
        <div class="post-meta"><i class="fa fa-gamepad" aria-hidden="true"></i> in <a> ${post.category.toUpperCase()}</a></div>
        <div class="post-meta"><i class="fa fa-comments" aria-hidden="true"></i> ${
          post.commNum
        } Comments</div>
    </div>
    <p class="word-wrap">${post.content}</p>
    <a href="index.php?page=posts&id=${post.id}" class="read-more">Read More</a>
</div>
</div>`;
  }

  $("#posts").html(html);
}

function printPagination(totalCount) {
  let html = "";
  for (let i = 0; i < totalCount; i++) {
    html += `<li class="posts-pagination ml-2 btn btn-secondary" data-limit="${i}">          
                      ${i + 1}
              </li>`;
  }
  $("#pag").html(html);
}

function printDeleteModal() {
  let html = `<div id="delete-modal" class="modal fade">
  <div class="modal-dialog modal-confirm">
      <div class="modal-content">
          <div class="modal-header">
              <div class="row">
                  <div class="col-sm-1 btnComm">
                      <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                  </div>
                  <div class="col-sm-10">
                      <h4 class="modal-title">Confirm action</h4>
                  </div>
              </div>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
              <p>Do you really want to delete this post? This process cannot be undone.</p>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-info cancel-mod" data-dismiss="modal">Cancel</button>
              <a href="#" class="trigger-btn btn btn-danger delete-post" data-dismiss="modal" data-id="<?= $post->id ?>">Delete</a>
              <div id="spinner" class="spinner-border elementDissapear" role="status">
                  <span class="sr-only">Loading...</span>
              </div>
          </div>
      </div>
  </div>
</div>`;
  return html;
}

function printComments(comments) {
  let loggedUserId = $("#loggedUserId").val();
  let loggedUserUsername = $("#loggedUserUsername").val();

  let html = "";
  let isOwnerHtml = "";
  for (let comment of comments) {
    if (comment.created_by == loggedUserId) {
      isOwnerHtml = `
      <input type="button" value="&#xf0ad" id="edit" class="btn btn-secondary btnComm fa fa-input edit-comment" data-id="${comment.id}" />
      <input type="button" value="&#xf00d" id="remove" class="btn btn-danger btnComm fa fa-input remove-comment" data-id="${comment.id}" />
      `;
    }

    html += `
    <div class="lc-item">
        <img src="app/assets/img/author-thumbs/1.jpg" alt="">
        <div class="lc-text">
            <h6>${comment.username}<span> In </span><a href="">${comment.title}</a></h6>
            <input type="button" value="&#xf2d3 Close" id="close-${comment.id}" class=" btn btn-warning btnComm fa fa-input close-edit elementDissapear" data-id="${comment.id}" />
                    <input type="button" value="&#xf0c7 Save" id="save-${comment.id}" class="btn btn-primary btnComm fa fa-input save-edit elementDissapear" data-id="${comment.id}" />        
            <p id="comment-${comment.id}">${comment.content}</p>
            <textarea id="field-${comment.id}" class="form-control textarea elementDissapear" name="editComment" rows="4" cols="2">${comment.content}</textarea>
            <div class="lc-date">Created : ${comment.created_at}</div>
            <div class="lc-date">Modified : ${comment.modified_at}</div>
            ${isOwnerHtml}
        </div>
    </div>`;
  }

  html += ` <div class="lc-item">
        <img src="app/assets/img/author-thumbs/1.jpg" alt="">
            <div class="lc-text">
                <h6>${loggedUserUsername}<span> In </span><a href="">${comments[0].title}</a></h6>
                  <form class="comment-form">
                      <input type="hidden" id="hdnId" />
                      <div class="row">
                            <div class="col-md-6">
                                <textarea class="form-control textarea" name="comment" id="comment" rows="4" cols="2" placeholder="Add comment..."></textarea>
                            </div>
                            <div class="col-md-1">
                            <input type="button" value="&#xf067" id="saveComment" class="btn btn-primary btnComm fa fa-input" />
                            </div>
                            <div class="col-md-5">

                            </div>
                        </div>
                  </form>
      </div>
  </div>
`;

  $("#comments").html(html);
}

function getComments(postId) {
  $.ajax({
    url: `index.php?page=comments&idAjax=${postId}`,
    method: "GET",
    success: function(data, status, request) {
      if (request.status == 200) {
        console.log("Message" + data.success);
      }
      console.log(data);
      printComments(data.comments);
    },
    error: showErrors
  });
}

function getComment(id) {
  console.log(id);
  $.ajax({
    url: `index.php?page=comments&idAjaxSingle=${id}`,
    method: "GET",
    success: function(data, status, request) {
      if (request.status == 200) {
        console.log("Message" + data.success);
      }

      let modified = $(`#modified-at-comm-${id}`);
      var current_datetime = new Date();
      const months = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "Jun",
        "July",
        "August",
        "September",
        "October",
        "November",
        "Dec"
      ];

      var time =
        appendLeadingZeroes(current_datetime.getHours()) +
        ":" +
        appendLeadingZeroes(current_datetime.getMinutes());
      let formatted_date = `${
        months[current_datetime.getMonth()]
      } ${current_datetime.getDate()}, ${current_datetime.getFullYear()}. ${time}`;

      modified.html(`Modified : ${formatted_date}`);

      let p = $(`#comment-${id}`);
      p.html(data.comment.content);
    },
    error: function(error) {
      console.log(error);
    }
  });
}

function getPosts() {
  $.ajax({
    url: `index.php?page=posts&limit=0`,
    method: "GET",
    success: function(data, status, request) {
      if (request.status == 200) {
        console.log("Message" + data.success);
      }

      $(".delete-post").attr("data-dismiss", "modal");

      $("#spinner").addClass("elementDissapear");
      $(".delete-post").removeClass("elementDissapear");
      $(".cancel-mod").removeClass("elementDissapear");
      console.log(data.posts);
      printPosts(data.posts);
      printPagination(data.totalCount);
    },
    error: showErrors
  });
}

function clearForm() {
  $("#hdnId").val("");
  $("#comment").val("");
  // $("#forma-naslov").html("Add category");
}

function showErrors(error, status, statusText) {
  console.error(status);
  console.error(error.responseText);
  console.error(error.responseJSON);

  printErrors(error.responseJSON);

  switch (error.status) {
    case 400:
      console.error(`${error.status}: ${statusText}`);
      break;
    case 403:
      console.error(`${error.status}: ${statusText}`);
      break;
    case 404:
      console.error(`${error.status}: ${statusText}`);
      break;
    case 405:
      console.error(`${error.status}: ${statusText}`);
      break;
    case 409:
      console.error(`${error.status}: ${statusText}`);
      break;
    case 415:
      console.error(`${error.status}: ${statusText}`);
      break;
    case 422:
      console.error(`${error.status}: ${statusText}`);
      break;
    case 500:
      console.error(`${error.status}: ${statusText}`);

      break;
  }
}

function printErrors(errors) {
  let errorElement = $("#errors");
  errorElement.removeClass("elementDissapear");
  let html = `<div class="text-center"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></div>`;
  for (let error of errors) {
    html += `
      <div class="text-center">
      ${error}
      </div>
    `;
  }
  $("#errors").html(html);
}

function printSuccess(heading, description) {
  $(".alert-success").removeClass("elementDissapear");
  let html = `<h4 class="alert-heading text-center">${heading} <i class="fa fa-check" aria-hidden="true"></i></h4>
  <p></p>
  <hr>
  <p class="mb-0 text-center">${description}</p>`;

  $(".alert-success").html(html);
}

function appendLeadingZeroes(n) {
  if (n <= 9) {
    return "0" + n;
  }
  return n;
}

function isNullOrWhitespace(input) {
  if (typeof input === "undefined" || input == null) return true;

  return input.replace(/\s/g, "").length < 1;
}
