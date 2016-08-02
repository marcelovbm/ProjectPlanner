//------------------------------ FUNCOES JAVA PARA INDEX ----------------------//
$(document).ready(function() {

  $("#inputPasswordConfirmed").keyup(function() {
    var valor = $("#inputPasswordConfirmed").val();
    var vazio = "";
    if (valor != vazio) {
      if ($("#inputPassword").val() == $("#inputPasswordConfirmed").val()) {
        $("#divInputPasswordConfirmed").removeClass("has-error");
        $("#divInputPasswordConfirmed").addClass("has-success");
        $("#mybox").removeClass("alert-danger").addClass("hide");
      } else {
        $("#divInputPasswordConfirmed").removeClass("has-success");
        $("#divInputPasswordConfirmed").addClass("has-error");
        $("#mybox").html("<p>These passwords don't match.!</p>").addClass("alert-danger").removeClass("hide");
      }
    }
    else{
      $("#divInputPasswordConfirmed").removeClass("has-success");
      $("#divInputPasswordConfirmed").removeClass("has-error");
      $("#mybox").removeClass("alert-danger").addClass("hide");
    }
  });

  $("#submitSignin").click(function() { //QUANDO O BOTAO COM ID 'submit' E CLICADO

    $("#mybox").removeClass("alert-success").removeClass("hide");
    $("#mybox").removeClass("alert-danger").removeClass("hide");
    $("#divInputUsername").removeClass("has-error");
    $("#divInputFullName").removeClass("has-error");
    $("#divInputEddress").removeClass("has-error");
    $("#divInputEmail").removeClass("has-error");
    $("#divInputPassword").removeClass("has-error");
    $("#divInputPasswordConfirmed").removeClass("has-error");

    var formData = $("#cadUsuario").serializeArray();

    $.ajax({
      url: "controller/signin.php",
      type: "POST",
      dataType: "html",
      data: formData
    }).done(function(msg) {
      if (msg == "<p><strong>User Name</strong> was not inserted!</p>") {
        $("#divInputUsername").addClass("has-error");
        $("#mybox").html(msg).addClass("alert-danger").removeClass("hide");
      } else {
        if (msg == "<p><strong>Email</strong> was not inserted!</p>") {
          $("#divInputEmail").addClass("has-error");
          $("#mybox").html(msg).addClass("alert-danger").removeClass("hide");

        } else {
          if (msg == "<p><strong>Password</strong> was not inserted!</p>") {
            $("#divInputPassword").addClass("has-error");
            $("#mybox").html(msg).addClass("alert-danger").removeClass("hide");
          } else {
            if (msg == "<p><strong>Confirm your password</strong> was not inserted!</p>") {
              $("#divInputPasswordConfirmed").addClass("has-error");
              $("#mybox").html(msg).addClass("alert-danger").removeClass("hide");

            } else {
              if (msg == "<p><strong>Email has already been used!</strong></p>") {
                $("#mybox").html(msg).addClass("alert-danger").removeClass("hide");
              } else {
                if (msg == "<p><strong>Password and Confirm your password are not the same!</strong></p>") {
                  $("#mybox").html(msg).addClass("alert-danger").removeClass("hide");
                } else {
                  if (msg == "<p><strong>User successfully registered!</strong></p>") {
                    $("#mybox").html(msg).addClass("alert-success").removeClass("hide");
                    $('#cadUsuario').each(function() {
                      this.reset();
                    });
                  }
                }
              }
            }
          }
        }
      }
    });
  });

  $("#submitLogin").click(function() {
    var formData = $('#logUsuario').serializeArray();
    $.ajax({
      url: "controller/login.php",
      type: "POST",
      dataType: "text",
      data: formData
    }).done(function(msg) {
      if (msg == "<p><strong>Email</strong> was not inserted!</p>") {
        alert("User name was not inserted");
      } else {
        if (msg == "<p><strong>Password</strong> was not inserted!</p>") {
          alert("Password was not inserted");
        } else {
          if (msg == "<p><strong>Email or password are wrong</strong></p>") {
            alert("Email or Password are wrong");
          } else {
            window.location = "main.html";
          }
        }
      }
    });
    request.fail(function(jqXHR, textStatus) {
      alert("Request failed: " + textStatus);
    });
  });
});

function removerClass() {
  //REMOVE AS CLASSES DE ALERT DA DIV E ESCONDE ELA NOVAMENTE
  $("#mybox").removeClass("alert-success").addClass("hide");
  $("#mybox").removeClass("alert-danger").addClass("hide");
  $("#divInputUsername").removeClass("has-error");
  $("#divInputFullName").removeClass("has-error");
  $("#divInputEddress").removeClass("has-error");
  $("#divInputEmail").removeClass("has-error");
  $("#divInputPassword").removeClass("has-error");
  $("#divInputPasswordConfirmed").removeClass("has-error");


  //RESETA OS CAMPOS DO FORMULARIO DE CADASTRO
  $('#cadUsuario').each(function() {
    this.reset();
  });

}
