<?php
$infoLog = "";
$clienteAux;
$cliAux = new Cliente($_GET["idCliente"]);
$cliAux->traerInfo();
$band = 0;
if (isset($_POST["Editar"])) {
    if ($_FILES["imagen"]["name"] != "") {
        if ($_FILES["imagen"]["type"] == "image/png" or $_FILES["imagen"]["type"] == "image/jpeg") {
            $rutaLocal = $_FILES["imagen"]["tmp_name"];
            $tipo = $_FILES["imagen"]["type"];
            $tiempo = new DateTime();
            $rutaRemota = "Vista/Img/Users/" . $tiempo->getTimestamp() . (($tipo == "image/png") ? ".png" : ".jpeg");
            copy($rutaLocal, $rutaRemota);
            $clienteAux = new Cliente($_GET["idCliente"]);
            $clienteAux->traerInfo();

            if ($clienteAux->getFoto() != "") {
                unlink($clienteAux->getFoto());
            }
            $cliente = new Cliente($_GET["idCliente"], $_POST["Nombre"], $_POST["Correo"], "", "", $rutaRemota);
            $cliente->actualizarInfo();
            $band = 1;
        }
    } else if ($cliAux->getNombre() != $_POST["Nombre"] or $cliAux->getCorreo() != $_POST["Correo"]) { /*Se valida que haya cambiado algun campo*/
        $clienteAux = new Cliente($_GET["idCliente"]);
        $clienteAux->traerInfo();
        $cliente = new Cliente($_GET["idCliente"], $_POST["Nombre"], $_POST["Correo"], "", "", $clienteAux->getFoto());
        $cliente->actualizarInfo();
        $band = 1;
    }else{
        $band=2;
    }
    if ($band == 1) {
        $infoLog = "Actor:Cliente-Nombre:" . $clienteAux->getNombre() . "-Correo:" . $clienteAux->getCorreo() . "-id:" . $clienteAux->getidCliente();
        date_default_timezone_set('America/Bogota');
        $date = date('Y-m-d');
        $hora = date('H:i:s');
        $log = new Log("", 'Editar Cliente', $infoLog, $date, $hora, "Administrador", $_SESSION["id"]);
        $log->insertarLog();
    } else {
        $cliente = new Cliente($_GET["idCliente"]);
        $cliente->traerInfo();
    }
} else {
    $cliente = new Cliente($_GET["idCliente"]);
    $cliente->traerInfo();
}
?>

<div class="container">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card text-center">
                <div class="card-header bg-light text-dark">
                    Editar Información Cliente
                </div>
                <div class="card-body">
                    <div class="row p-3">
                        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                            <img src="<?php echo ($cliente->getFoto() != "" ? $cliente->getFoto() : "https://upload.wikimedia.org/wikipedia/commons/e/e4/Elliot_Grieveson.png") ?>" width="100%" class="img-thumbnail">
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                            <form action="index.php?pid= <?php echo base64_encode("Vista/Cliente/editarInfo.php") ?>&idCliente=<?php echo $_GET["idCliente"] ?>" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="Nombre">Nombres</label>
                                    <input type="text" class="form-control" name="Nombre" id="Nombre" value="<?php echo $cliente->getNombre() ?>">
                                </div>
                                <div class="form-group">
                                    <label for="Correo">Direccion de correo electrónico</label>
                                    <input type="email" class="form-control" name="Correo" id="Correo" value="<?php echo $cliente->getCorreo() ?>" aria-describedby="emailHelp">
                                    <small id="emailHelp" class="form-text text-muted">No compartiremos su correo con nadie más.</small>
                                </div>
                                <div class="form-group border-0">
                                    <label for="foto">Cargar Foto</label>
                                    <div class="row">
                                        <div class="col-3"></div>
                                        <div class="col-9 border-0">
                                            <input type="file" class="form-control border-0" name="imagen">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <input name="Editar" type="submit" class="btn btn-outline-dark" value="Editar">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($band == 1) {
    echo "<div class='modal fade' id='mostrarmodal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
    echo "<div class='modal-dialog '>";
    echo "<div class='modal-content '>";
    echo "<div class='alert alert-success m-0 d-flex justify-content-between'>";
    echo "<div></div>";
    echo "<h5 class='modal-title' id='exampleModalLabel'>La información se ha actualizado correctamente</h5>";
    echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
    echo "<span aria-hidden='true'>&times;</span>";
    echo "</button>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
} else if (isset($_POST["Editar"]) and $band == 0) {
    echo "<div class='modal fade' id='mostrarmodal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
    echo "<div class='modal-dialog '>";
    echo "<div class='modal-content '>";
    echo "<div class='alert alert-danger m-0 d-flex justify-content-between'>";
    echo "<div></div>";
    echo "<h5 class='modal-title' id='exampleModalLabel'>Error en el tipo de archivo</h5>";
    echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
    echo "<span aria-hidden='true'>&times;</span>";
    echo "</button>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
} else if ($band == 2) {
    echo "<div class='modal fade' id='mostrarmodal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
    echo "<div class='modal-dialog '>";
    echo "<div class='modal-content '>";
    echo "<div class='alert alert-warning m-0 d-flex justify-content-between'>";
    echo "<div></div>";
    echo "<h5 class='modal-title' id='exampleModalLabel'>No se ha cambiado ningun dato</h5>";
    echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
    echo "<span aria-hidden='true'>&times;</span>";
    echo "</button>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
} ?>