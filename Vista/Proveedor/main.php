<?php
$proveedor = new Proveedor($_SESSION["id"]);
$proveedor->traerInfo();
?>

<div class="container-fluid" style="background-color: #FFE716;">
    <div class="container">
        <div class="row pt-4 pb-3">
            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 order-xl-1 order-lg-1 order-md-1 d-lg-block d-md-block d-sm-none d-none">
                <div class="form-group">
                    <img src="Vista/Img/logistica.png" alt="" style="width: 80px;">
                </div>
            </div>
            <div class="text-center col-xl-7 col-lg-7 col-md-7 col-sm-12 order-xl-2 order-lg-2 order-md-2 order-sm-1 order-xs-1 order-1">
                <h1 class="my-0 mx-auto" style="font-family: 'Yellowtail', cursive;"> Distribuidora de Frutas Doña Rosa</h1>
                <h5 class="my-0 font-weight-normal text-white">Frutas de la Mejor Calidad</h5>
            </div>
            <div class="pt-3 text-center col-xl-3 col-lg-3 col-md-3 col-sm-12 order-xl-3 order-lg-3 order-md-3 order-sm-3  order-xs-3 order-3">
                <h5 class="my-0 font-weight-normal text-dark"><strong>Proveedor:</strong> <?php echo $proveedor->getNombre() ?> </h5>
            </div>
        </div>
        <div class="row">
            <div class="col-8 p-0">
                <nav class="navbar navbar-expand-lg navbar-light pb-0">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <a class="nav-link btn btn-outline-light border-0 text-dark" href="index.php?pid= <?php echo base64_encode("Vista/Proveedor/sesionProveedor.php") ?>"><i class="fas fa-home"></i></a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link btn btn-outline-light border-0" href="index.php?pid=<?php echo base64_encode("Vista/Producto/listarProductoProve.php")?>">Productos</a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link btn btn-outline-light border-0" href="index.php?pid=<?php echo base64_encode("Vista/Ordenes/listaOrdenesProve.php")?>">Ordenes</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="col-4 d-flex flex-row-reverse text-dark">
                <nav class="navbar navbar-expand-lg navbar-light pb-0 ">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item dropdown active">
                                <a class="nav-link btn btn-outline-light border-0 dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true"><i class="fas fa-user"></i></a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="index.php?pid= <?php echo base64_encode("Vista/Proveedor/actualizarInfo.php") ?>">Actualizar Información</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="index.php?cerrarsesion">Cerrar Sesion</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>