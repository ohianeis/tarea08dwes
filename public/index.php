<?php
session_start();

if (isset($_SESSION['usuario'])) {
  session_unset();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <title>Login NBA</title>
</head>

<body>


  <section class=" py-3 py-md-5" style="background-color: #003197;">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
          <div class="card border border-light-subtle rounded-3 shadow-sm">
            <div class="card-body p-3 p-md-4 p-xl-5">
              <div class="text-center mb-3">
                <a href="#!">
                  <img src="../assets/nba.jpg" alt="nba Logo" width="175" height="100">
                </a>
              </div>
              <h2 class="fs-6 fw-normal text-center text-secondary mb-4">Accede a tu cuenta</h2>
              <form action="buscador.php" method="POST" id="login">
                <div class="row gy-2 overflow-hidden">
                  <div class="col-12">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" name="nombre" id="nombre" placeholder="ohiane" required>
                      <label for="nombre" class="form-label">Nombre</label>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-floating mb-3">
                      <input type="password" class="form-control" name="password" id="password" value="" placeholder="ohianeis" required>
                      <label for="password" class="form-label">Password</label>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="d-grid my-3">
                      <button class="btn btn-lg text-white" style="background-color: #003197;" type="submit">Log in</button>
                    </div>
                  </div>
                  <div class="col-12">
                    <p class="m-0 text-secondary text-center">¿No tienes una cuenta? <a href="#!" class="link-danger text-decoration-none">Registrate</a></p>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div id="erroresLogin"></div>
</body>
<script>

  $(document).ready(function() {
    $('#login').submit(function(event) {
      event.preventDefault();
      console.log("Formulario interceptado por AJAX");

      $.ajax({
        url: 'validarLogin.php',
        type: 'POST',
        dataType: 'json',
        data: {
          nombre: $('input[name="nombre"]').val(),
          password: $('input[name="password"]').val()
        },
        success: function(data) {
          console.log("Respuesta del servidor:", data); 
          if (data.success) {
            $('#login').unbind('submit').submit();
          } else {
            let erroresLogin = '<p class="list-group-item">Errores:</p>';
            for (let error in data) {
              erroresLogin += '<li class="list-group-item list-group-item-danger">' + data[error] + '</li>';
            }
            $('#erroresLogin').html(erroresLogin); 
          }
        },
        error: function(xhr, status, error) {
          console.error("Error en la petición AJAX: " + error);
        }
      });
    });
  });
</script>

</html>