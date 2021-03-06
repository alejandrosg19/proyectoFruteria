<?php
$filtro = $_GET["filtro"];
$producto = new Producto();

$cantidad = 6;
if (isset($_GET["cantidad"])) {
    $cantidad = $_GET["cantidad"];
}
$pagina = 1;
if (isset($_GET["pagina"])) {
    $pagina = $_GET["pagina"];
}
$cant = $producto->cantidadPaginasProve($filtro);
$cantPagina = intval($cant[0] / $cantidad);

if (($cant[0] % $cantidad) != 0) {
    $cantPagina++;
}

$listaProductos = $producto->listarFiltroProve($filtro, $cantidad, $pagina);
?>

<div>
    <table class="table table-responsive-sm table-responsive-md table-hover table-striped">
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Cantidad en Stock</th>
            <th>Precio Libra</th>
            <th>Estado en Bodega</th>
            <th>Servicios</th>
        </tr>
        <?php
        $i = ($pagina - 1) * $cantidad;
        foreach ($listaProductos  as $productoActual) {
            echo "<tr>";
            echo "<td>" . $i . "</td>";

            /*PINTAR BUSQUEDA DE NOMBRE EN TABLA*/
            /*strtipos -> stripos ( string $haystack , string $needle [, int $offset = 0 ] ) Encuentra la posición numérica de la primera aparición de needle (aguja) en el string haystack (pajar).*/
            $primeraPosicion = stripos($productoActual->getNombre(), $filtro);
            if ($primeraPosicion === false) {
                echo "<td>" . $productoActual->getNombre() . "</td>";
            } else {
                /*El siguiente codigo imprime primero la parte de la palabra hasta que encuentra el indice de $primeraPosicion, luego en negrila <mark> imprime desde el indice de primeraPosicion hasta el final de la palabra $filtro, y por ultimo imprime desde la primeraPosicion+la palabra del filtro, es decir el restante de la oracion*/
                echo "<td>" . substr($productoActual->getNombre(), 0, $primeraPosicion) . "<strong>" . substr($productoActual->getNombre(), $primeraPosicion, strlen($filtro)) . "</strong>" . substr($productoActual->getNombre(), $primeraPosicion + strlen($filtro)) . "</td>";
            }
            echo "<td>" . $productoActual->getCantidad() . "</td>";
            echo "<td>" . $productoActual->getPrecio() . "</td>";
            echo "<td>" . $productoActual->getEstado() . "</td>";
            echo "<td> <a href='index.php?pid=" . base64_encode("Vista/Producto/listarProductoProve.php") . "&idProducto=" . $productoActual->getIdProducto() . "&filtro=" . $filtro . "&cantidad=" . $cantidad . "&pagina=" . $pagina . "'><span class='fas fa-info-circle' data-toggle=tooltip' data-placement='top' title='Información Producto'></span> </a>";
            echo "</tr>";
            $i++;
        }
        ?>
    </table>
    <div class="d-flex justify-content-between mt-4">
        <nav aria-label="...">
            <ul class="pagination">
                <?php if ($pagina > 1) {
                    echo '<li class="page-item"> <a class="page-link" href="index.php?pid=' . base64_encode("Vista/Producto/listarProductoProve.php") . '&pagina=' . ($pagina - 1) . '&cantidad=' . $cantidad . '&filtro=' . $filtro . '" tabindex="0" aria-disabled="false">Previous</a></li>';
                } ?>
                <?php for ($i = 1; $i <= $cantPagina; $i++) {
                    if ($pagina == $i) {
                        echo "<li class='page-item active'>" .
                            "<a class='page-link'>$i</a>" .
                            "</li>";
                    } else {
                        echo "<li class='page-item'>" .
                            "<a class='page-link' href='index.php?pid=" . base64_encode("Vista/Producto/listarProductoProve.php") . "&pagina=" . $i . "&cantidad=" . $cantidad . "&filtro=" . $filtro . "'>" . $i . "</a>" .
                            "</li>";
                    }
                } ?>
                <?php if ($pagina < $cantPagina) {
                    echo '<li class="page-item"> <a class="page-link" href="index.php?pid=' . base64_encode("Vista/Producto/listarProductoProve.php") . '&pagina=' . ($pagina + 1) . '&cantidad=' . $cantidad . '&filtro=' . $filtro . '" tabindex="0" aria-disabled="false">Next</a></li>';
                } ?>
            </ul>
        </nav>
        <div class="text-center m-2">
            <span><?php echo (($pagina - 1) * $cantidad) ?> al <?php echo ((($pagina - 1) * $cantidad) + count($listaProductos) - 1) ?> de <?php echo ($cant[0] - 1) ?> Registros Encontrados</span>
            <select id="cantidad" class="custom-select" onchange="Selected();" style="width: 60px" data-filtro="<?php echo $filtro ?>">
                <option value="6" <?php echo ($cantidad == 6) ? "selected" : "" ?>>6</option>
                <option value="9" <?php echo ($cantidad == 9) ? "selected" : "" ?>>9</option>
                <option value="12" <?php echo ($cantidad == 12) ? "selected" : "" ?>>12</option>
            </select>
        </div>
    </div>
</div>

<script>
    $("#cantidad").on("change", function() {
        url = "index.php?pid=<?php echo base64_encode("Vista/Producto/listarProductoProve.php") ?>&cantidad=" + $(this).val() + "&filtro=" + $(this).data("filtro");
        location.replace(url);
    });
</script>