<?php

$cliente = new Cliente("", "", $_POST["Correo"], $_POST["Clave"]);
$proveedor = new Proveedor("", "", $_POST["Correo"], $_POST["Clave"]);
$administrador = new Administrador("", "", $_POST["Correo"], $_POST["Clave"]);
$log;
date_default_timezone_set('America/Bogota');
$date = date('Y-m-d');
$hora = date('H:i:s');

if ($cliente->autenticar()) { /*En autenticar se busca por correo, se trae la info y se le asigna el id*/
    $cliente->traerInfoCorreo();
    if ($cliente->getEstado() == -1) {
        header("Location: index.php?validacion=4");
    } else if ($cliente->getEstado() == 0) {
        header("Location: index.php?validacion=5");
    } else {
        $_SESSION["id"] = $cliente->getidCliente();
        $_SESSION["rol"] = "Cliente";
        $carrito = new Carrito();
        $_SESSION["carrito"] = serialize($carrito);
        $log = new Log("", 'Inicio de Sesion', "", $date, $hora, "Cliente", $cliente->getidCliente());
        $log->insertarLog();
        header("Location: index.php?pid=" . base64_encode("Vista/Cliente/sesionCliente.php"));
    }
} else if ($proveedor->autenticar()) {
    $proveedor->traerInfoCorreo();
    if ($proveedor->getEstado() == -1) {
        header("Location: index.php?validacion=4");
    } else if ($proveedor->getEstado() == 0) {
        header("Location: index.php?validacion=5");
    } else {
        $_SESSION["id"] = $proveedor->getIdProveedor();
        $_SESSION["rol"] = "Proveedor";
        $log = new Log("", 'Inicio de Sesion', "", $date, $hora, "Proveedor", $proveedor->getIdProveedor());
        $log->insertarLog();
        header("Location: index.php?pid=" . base64_encode("Vista/Proveedor/sesionProveedor.php"));
    }
} else if ($administrador->autenticar()) {
    $administrador->traerInfoCorreo();
    if ($administrador->getEstado() == -1) {
        header("Location: index.php?validacion=4");
    } else if ($administrador->getEstado() == 0) {
        header("Location: index.php?validacion=5");
    } else {
        $_SESSION["id"] = $administrador->getIdAdministrador();
        $_SESSION["rol"] = "Administrador";
        $log = new Log("", 'Inicio de Sesion', "", $date, $hora, "Administrador", $administrador->getIdAdministrador());
        $log->insertarLog();
        header("Location: index.php?pid=" . base64_encode("Vista/Administrador/sesionAdministrador.php"));
    }
} else {
    header("Location: index.php?validacion=3");
}
