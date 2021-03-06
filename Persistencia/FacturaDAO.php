<?php
class FacturaDAO{
    private $idFactura;
    private $fecha;
    private $idCliente;
    private $valor;


    public function FacturaDAO($idFactura = "", $fecha = "", $idCliente = "", $valor = 0)
    {
        $this->idFactura = $idFactura;
        $this->fecha = $fecha;
        $this->idCliente = $idCliente;
        $this->valor = $valor;
    }

    public function setIdFactura($idFactura)
    {
        $this->idFactura = $idFactura;
    }
    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    public function traerInfo(){
        return "select idFactura, fecha, idCliente, valor
                from factura
                where idFactura = '".$this -> idFactura."'";
    }

    public function crearFactura(){
        return "insert into factura (fecha,idCliente,valor) values('".$this -> fecha."','".$this -> idCliente."','".$this -> valor."')";
    }

    public function facturas(){
        return "select * from factura";
    }

    public function actualizarValor(){
        return "update factura set valor = '".$this -> valor."' where idFactura = '".$this -> idFactura."'";
    }

    public function cantidadPaginasFiltro($filtro){
        return "select count(idFactura) 
                from factura
                where idFactura like '%".$filtro."%' or fecha like '%".$filtro."%' or idCliente like '".$filtro."%' or valor like '".$filtro."%'";
    }

    public function listarFiltro($filtro,$cantidad,$pagina){
        return "select idFactura, fecha, idCliente, valor
                from factura
                where idFactura like '%".$filtro."%' or fecha like '%".$filtro."%' or idCliente like '".$filtro."%' or valor like '".$filtro."%'
                order by idFactura DESC
                limit " . (($pagina-1) * $cantidad) . ", " . $cantidad;
    }

    public function cantidadPaginasFiltroCliente($filtro){
        return "select count(idFactura) 
                from factura
                where (idFactura like '%".$filtro."%' or fecha like '%".$filtro."%' or valor like '".$filtro."%')
                and idCliente = '".$this -> idCliente."'";
    }

    public function listarFiltroCliente($filtro,$cantidad,$pagina){
        return "select idFactura, fecha, idCliente, valor
                from factura
                where (idFactura like '%".$filtro."%' or fecha like '%".$filtro."%' or valor like '".$filtro."%')
                and idCliente = '".$this -> idCliente."'
                order by idFactura DESC
                limit " . (($pagina-1) * $cantidad) . ", " . $cantidad;
    }
}
