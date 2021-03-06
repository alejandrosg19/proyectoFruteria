<?php
$cliente = new Cliente();
$cantidad = 5;
if (isset($_GET["cantidad"])) {
    $cantidad = $_GET["cantidad"];
}
$pagina = 1;
if (isset($_GET["pagina"])) {
    $pagina = $_GET["pagina"];
}
$filtro = "";
if (isset($_GET["filtro"])) {
    $filtro = $_GET["filtro"];
}
#$cant = $cliente->cantidadPaginas();
$cant = $cliente->cantidadPaginasFiltro($filtro); /* se creo un nuevo metodo que trae la cantidad de paginas segun el filtro*/
$cantPagina = intval($cant[0] / $cantidad);
if (($cant[0] % $cantidad) != 0) {
    $cantPagina++;
}
#echo "cant " . $cant[0] . " cantidad " . $cantidad . " cantPagina " . $cantPagina . " pagina " . $pagina . " filtro" . $filtro;


$listaClientes = $cliente->listarFiltro($filtro, $cantidad, $pagina); /*Nuevo metodo que trae los datos entre cantidad y pagina pero que tengas el filtro*/
#$listaClientes = $cliente->listarClientes($cantidad, $pagina);
?>


<div class="container">
    <div class="card mt-3">
        <div class="card-header text-white bg-dark text-center">
            <h4>Lista Clientes</h4>
        </div>
        <div class="d-flex text-center m-2 shadow-sm p-3 e rounded">
            <div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 col-12">
                <input class="form-control mr-sm-2" id="search" type="search" placeholder="Search" aria-label="Search" data-cantidad="<?php echo $cantidad ?>" value="<?php echo ($filtro != null ? $filtro : "") ?>">
            </div>
        </div>

        <div class="card-body col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div id="contenido">
                <table class="table table-responsive-sm table-responsive-md table-hover table-striped">
                    <tr>
                        <th>idCliente</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Estado</th>
                        <th>Servicios</th>
                    </tr>
                    <tr>
                        <?php
                        foreach ($listaClientes  as $clienteActual) {
                            echo "<tr>";
                            echo "<td>" . $clienteActual->getidCliente() . "</td>";

                            /*PINTAR BUSQUEDA EDE NOMBRE EN TABLA*/
                            /*strtipos -> stripos ( string $haystack , string $needle [, int $offset = 0 ] ) Encuentra la posición numérica de la primera aparición de needle (aguja) en el string haystack (pajar).*/
                            $primeraPosicion = stripos($clienteActual->getNombre(), $filtro);
                            if ($primeraPosicion === false) {
                                echo "<td>" . $clienteActual->getNombre() . "</td>";
                            } else {
                                /*El siguiente codigo imprime primero la parte de la palabra hasta que encuentra el indice de $primeraPosicion, luego en negrila <mark> imprime desde el indice de primeraPosicion hasta el final de la palabra $filtro, y por ultimo imprime desde la primeraPosicion+la palabra del filtro, es decir el restante de la oracion*/
                                echo "<td>" . substr($clienteActual->getNombre(), 0, $primeraPosicion) . "<strong>" . substr($clienteActual->getNombre(), $primeraPosicion, strlen($filtro)) . "</strong>" . substr($clienteActual->getNombre(), $primeraPosicion + strlen($filtro)) . "</td>";
                            }

                            echo "<td>" . $clienteActual->getCorreo() . "</td>";
                            echo "<td>";
                            echo "<select class='custom-select estado' data-idcliente='" . $clienteActual->getidCliente() . "' style='width: 150px'>";
                            echo "<option value='-1'";
                            echo ($clienteActual->getEstado() == -1) ? 'selected' : '';
                            echo ">Bloqueado</option>";
                            echo "<option value='0'";
                            echo ($clienteActual->getEstado() == 0) ? 'selected' : '';
                            echo ">Deshabilitado</option>";
                            echo "<option value='1'";
                            echo ($clienteActual->getEstado() == 1) ? 'selected' : '';
                            echo ">Activo</option>";
                            echo "</select>";
                            echo "</td>";

                            echo "<td> <a href='#' class='detalle' data-idcliente='" . $clienteActual->getidCliente() . "' data-toggle='modal' data-target='#exampleModal'><span class='fas fa-info-circle' data-toggle=tooltip ' data-placement='top' title='Información Cliente'></span> </a>";
                            echo  "<a href='index.php?pid=" . base64_encode("Vista/Cliente/editarInfo.php") . "&idCliente=" . $clienteActual->getidCliente() . "' class=''><span class='fas fa-edit' data-toggle=tooltip' data-placement='top' title='Editar Cliente'></span> </a> </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tr>
                </table>
                <div class="d-flex justify-content-between mt-4">
                    <nav aria-label="...">
                        <ul class="pagination">
                            <?php if ($pagina > 1) {
                                echo '<li class="page-item"> <a class="page-link" href="index.php?pid=' . base64_encode("Vista/Cliente/listarClientes.php") . '&pagina=' . ($pagina - 1) . '&cantidad=' . $cantidad . '&filtro=' . $filtro . '" tabindex="0" aria-disabled="false">Previous</a></li>';
                            } ?>
                            <?php for ($i = 1; $i <= $cantPagina; $i++) {
                                if ($pagina == $i) {
                                    echo "<li class='page-item active'>" .
                                        "<a class='page-link'>$i</a>" .
                                        "</li>";
                                } else {
                                    echo "<li class='page-item'>" .
                                        "<a class='page-link' href='index.php?pid=" . base64_encode("Vista/Cliente/listarClientes.php") . "&pagina=" . $i . "&cantidad=" . $cantidad . "&filtro=" . $filtro . "'>" . $i . "</a>" .
                                        "</li>";
                                }
                            } ?>
                            <?php if ($pagina < $cantPagina) {
                                echo '<li class="page-item"> <a class="page-link" href="index.php?pid=' . base64_encode("Vista/Cliente/listarClientes.php") . '&pagina=' . ($pagina + 1) . '&cantidad=' . $cantidad . '&filtro=' . $filtro . '" tabindex="0" aria-disabled="false">Next</a></li>';
                            } ?>
                        </ul>
                    </nav>
                    <div class="text-center m-2">
                        <span><?php echo (($pagina - 1) * $cantidad) ?> al <?php echo ((($pagina - 1) * $cantidad) + count($listaClientes) - 1) ?> de <?php echo ($cant[0] - 1) ?> Registros Encontrados</span>
                        <select id="cantidad" class="custom-select" onchange="Selected();" style="width: 60px" data-filtro="<?php echo $filtro ?>">
                            <option value="5" <?php echo ($cantidad == 5) ? "selected" : "" ?>>5</option>
                            <option value="10" <?php echo ($cantidad == 10) ? "selected" : "" ?>>10</option>
                            <option value="15" <?php echo ($cantidad == 15) ? "selected" : "" ?>>15</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class='modal fade' id='vermodal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
    <div class='modal-dialog '>
        <div class='modal-content '>
            <div class='alert alert-success p-3 m-0 text-center d-flex'>
                <h5 class='modal-title flex-grow-1' id='exampleModalLabel'>Registro actualizado correctamente</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
        </div>
    </div>
</div>
<!--Modal-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="text-center bg-dark text-white p-3">
                <h5 class="modal-title" id="exampleModalLabel">Detalle</h5>
            </div>
            <div class="modal-body p-0">
                <div id="mostrar">
                    ...
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $("#cantidad").on("change", function() {
        url = "index.php?pid=<?php echo base64_encode("Vista/Cliente/listarClientes.php") ?>&cantidad=" + $(this).val() + "&filtro=" + $(this).data("filtro");
        location.replace(url);
    });
    /**Cambio Estado */
    $(".estado").change(function() {
        var objJSON = {
            idCliente: $(this).data("idcliente"),
            /*el this coge el elemento que activo el evento*/
            estado: $(this).val(),
        }

        url = "indexAjax.php?pid=<?php echo base64_encode("Vista/Cliente/Ajax/clientesAjax.php") ?>";
        $.post(url, objJSON, function(info) {
            $res = JSON.parse(info);
            $("#vermodal").modal("show");
        })

    });

    /*search filtro*/
    $(document).ready(function() {
        $("#search").keyup(function() {
            if ($(this).val().length >= 3 || $(this).val().length == 0) {
                var url = "indexAjax.php?pid=<?php echo base64_encode("Vista/Cliente/Ajax/buscarClienteAjax.php") ?>&filtro=" + $(this).val() + "&cantidad=" + $(this).data("cantidad");
                $("#contenido").load(url);
            }
        });
    });

    /**Mostrar Info */
    $(function() {
        $(".detalle").on("click", function() {
            var id = $(this).data("idcliente");
            var url = "indexAjax.php?pid=<?php echo base64_encode("Vista/Ajax/infoUsuarios.php") ?>&idCliente=" + id + "&actor=2";
            $("#mostrar").load(url);
        })
    })
</script>