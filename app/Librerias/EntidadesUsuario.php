<?php

/**
 * 
 Clase para generar los get y set de los campos de usuario
 */
 class EntidadesUsuario
 {

    private $idUsuario;
    private $usuario;
    private $password;
    private $correo;
    private $estatus;
    private $tipo;
    private $Empleado_idRfc;
    private $nombreEmpleado;
    private $tiempoPapelera;
    private $tamBandeja;
    private $tamArchivo;
    
    
    public function getIdUsuario(){
        return $this->idUsuario;
    }

    public function setIdUsuario($idUsuario){
        $this->idUsuario = $idUsuario;
    }

    public function getUsuario(){
        return $this->usuario;
    }

    public function setUsuario($usuario){
        $this->usuario = $usuario;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function getCorreo(){
        return $this->correo;
    }

    public function setCorreo($correo){
        $this->correo = $correo;
    }

    public function getEstatus(){
        return $this->estatus;
    }

    public function setEstatus($estatus){
        $this->estatus = $estatus;
    }

    public function getTipo(){
        return $this->tipo;
    }

    public function setTipo($tipo){
        $this->tipo = $tipo;
    }


    public function getEmpleado_idRfc(){
        return $this->Empleado_idRfc;
    }

    public function setEmpleado_idRfc($Empleado_idRfc){
        $this->Empleado_idRfc = $Empleado_idRfc;
    }


    public function GetnombreEmpleado(){
        return $this->nombreEmpleado;
    }

    public function SetnombreEmpleado($nombreEmpleado){
        $this->nombreEmpleado = $nombreEmpleado;
    }

    public function getTiempoPapelera(){
        return $this->tiempoPapelera;
    }

    public function setTiempoPapelera($tiempoPapelera){
        $this->tiempoPapelera = $tiempoPapelera;
    }

    public function getTamBandeja(){
        return $this->tamBandeja;
    }

    public function setTamBandeja($tamBandeja){
        $this->tamBandeja = $tamBandeja;
    }

    public function getTamArchivo(){
        return $this->tamArchivo;
    }

    public function setTamArchivo($tamArchivo){
        $this->tamArchivo = $tamArchivo;
    }


}
?>