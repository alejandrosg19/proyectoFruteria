<?php
$validacion = null;
if (isset($_GET["validacion"])) {
  $validacion = $_GET["validacion"];
}
?>

</style>
<div class="container-fluid" style="background-color: #FFE716;">
  <div class="container">
    <div class="row pt-4">
      <div class=" col-xl-2 col-lg-2 col-md-2 col-sm-12 order-xl-1 order-lg-1 order-md-1 d-lg-block d-md-block d-sm-none d-none">
        <div class="form-group">
          <img src="Vista/Img/logistica.png" alt="" style="width: 80px;">
        </div>
      </div>
      <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 text-center order-xl-2 order-lg-2 order-md-2 order-sm-1 order-xs-1 order-1">
        <h1 class="my-0 mx-auto" style="font-family: 'Yellowtail', cursive;"> Distribuidora de Frutas Doña Rosa</h1>
        <h5 class="my-0 font-weight-normal text-white">Frutas de la Mejor Calidad</h5>
      </div>
      <div class="pt-3 text-center col-xl-2 col-lg-2 col-md-2 col-sm-12 order-xl-3 order-lg-3 order-md-3 order-sm-3  order-xs-3 order-3">
        <a class="btn btn-outline-dark" data-toggle="modal" data-target="#modalIniciarSesion" href="#">Iniciar Sesion</a>
        <a class="nav-link text-white p-0" data-toggle="modal" data-target="#modalRegistrarse" href="#">
          <p>Registrarse</p>
        </a>
      </div>
    </div>
    <!-- Modal Iniciar Sesion-->
    <div class="modal fade" id="modalIniciarSesion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog ">
        <div class="modal-content ">
          <div class="modal-header text-center" style="background-color: #FFE716;">
            <h5 class="modal-title" id="exampleModalLabel">Iniciar Sesion</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="index.php?pid= <?php echo base64_encode("Vista/Auth/Autenticar.php") ?>" method="POST">
              <div class="form-group">
                <label for="exampleInputEmail1">Direccion de correo electrónico</label>
                <input type="email" id="Correo" name="Correo" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                <small id="emailHelp" class="form-text text-muted">No compartiremos su correo con nadie más.</small>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" id="Clave" name="Clave" class="form-control" id="exampleInputPassword1">
              </div>
              <div class="form-group text-center">
                <input name="Ingresar" type="submit" class="btn btn-outline-dark">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Registrarse-->
    <div class="modal fade" id="modalRegistrarse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog ">
        <div class="modal-content ">
          <div class="modal-header text-center" style="background-color: #FFE716;">
            <h5 class="modal-title" id="exampleModalLabel">Registrarse</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="index.php?pid= <?php echo base64_encode("Vista/Registrar.php") ?>" method="POST">
              <div class="form-group">
                <label for="Nombre">Nombres</label>
                <input type="text" class="form-control" name="Nombre" id="Nombre">
              </div>
              <div class="form-group">
                <label for="Correo">Direccion de correo electrónico</label>
                <input type="email" class="form-control" name="Correo" id="Correo" aria-describedby="emailHelp">
                <small id="emailHelp" class="form-text text-muted">No compartiremos su correo con nadie más.</small>
              </div>
              <div class="form-group">
                <label for="Rol">Rol</label>
                <select class="form-control" name="Rol" id="Rol">
                  <option>Comprador</option>
                  <option>Proveedor</option>
                </select>
              </div>
              <div class="form-group">
                <label for="Password">Password</label>
                <input type="password" class="form-control" name="Password" id="Password">
              </div>
              <div class="form-group text-center">
                <input name="Ingresar" type="submit" class="btn btn-outline-dark">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php if ($validacion != null) {
  echo "<div class='modal fade' id='mostrarmodal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
  echo "<div class='modal-dialog '>";
  echo "<div class='modal-content '>";
  if ($validacion == 1) {
    echo "<div class='alert alert-danger m-0 d-flex'>";
    echo "<h5 class='modal-title flex-grow-1' id='exampleModalLabel'>Ya existe una cuenta asociado a este email</h5>";
  } else if ($validacion == 2) {
    echo "<div class='alert alert-success m-0 text-center d-flex'>";
    echo "<h5 class='modal-title flex-grow-1' id='exampleModalLabel'>Registro exitoso</h5>";
  } else if ($validacion == 3) {
    echo "<div class='alert alert-danger m-0 text-center d-flex'>";
    echo "<h5 class='modal-title flex-grow-1' id='exampleModalLabel'>Error en el correo o clave</h5>";
  } else if($validacion == 4){
    echo "<div class='alert alert-danger m-0 text-center d-flex'>";
    echo "<h5 class='modal-title flex-grow-1' id='exampleModalLabel'>Usuario bloqueado, comuniquese con un administrador</h5>";
  } else if($validacion == 5){
    echo "<div class='alert alert-warning m-0 text-center d-flex'>";
    echo "<h5 class='modal-title flex-grow-1' id='exampleModalLabel'>Usuario deshabilitado, espere a que un administrador lo habilite</h5>";
  }
  echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
  echo "<span aria-hidden='true'>&times;</span>";
  echo "</button>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
} ?>