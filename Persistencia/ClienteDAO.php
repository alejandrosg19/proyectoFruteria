<?php
    class ClienteDAO{
        private $idCliente;
        private $nombre;
        private $correo;
        private $clave;
        private $estado;

        public function ClienteDAO($idCliente = "", $nombre = "", $correo = "", $clave = "", $estado = ""){
            $this -> idCliente = $idCliente;
            $this -> nombre = $nombre;
            $this -> correo = $correo;
            $this -> clave = $clave;
            $this -> estado = $estado;
        }

        public function validarCorreo(){
            return "select idCliente
                    from cliente
                    where correo = '" . $this -> correo . "'";
        }

        public function registrarCliente($codigoAtivacion){
            return "insert into cliente values('','".$this -> nombre."','".$this -> correo."','".md5($this -> clave)."','0','".md5($codigoAtivacion)."')";
        }

        public function autenticar(){
            return "select idCliente 
                    from cliente
                    where correo = '" . $this -> correo ."' and clave = '" . md5($this -> clave) . "'";
        }

        public function traerInfo(){
            return "select idCliente, nombre, correo
                    from cliente
                    where idCliente = '". $this -> idCliente ."'";
        }

        public function actualizarInfo(){
            return "update cliente set nombre = '".$this -> nombre ."', correo = '". $this -> correo ."'
                    where idCliente = '". $this -> idCliente ."'";
        }

        public function listarTodosClientes(){
            return "select idCliente, nombre, correo, clave, estado
                    from cliente";
        }

        public function cantidadPaginas(){
            return "select count(idCliente) from cliente";
        }

        public function listarClientes($cantidad, $pagina){
            return "select idCliente, nombre, correo, clave, estado
                    from cliente
                    limit " . (($pagina-1) * $cantidad) . ", " . $cantidad;
        }

        public function actualizarEstado(){
            return "update cliente set estado = '". $this -> estado ."' where idCliente = '". $this -> idCliente. "'";
        }

        public function cantidadPaginasFiltro($filtro){
            return "select count(idCliente) 
                    from cliente
                    where idCliente like '%".$filtro."%' or nombre like '".$filtro."%' or correo like '".$filtro."%'";
        }

        public function listarFiltro($filtro,$cantidad,$pagina){
            return "select idCliente, nombre, correo, estado
                    from cliente
                    where idCliente like '%".$filtro."%' or nombre like '".$filtro."%' or correo like '".$filtro."%'
                    limit " . (($pagina-1) * $cantidad) . ", " . $cantidad;
        }
    }
?>