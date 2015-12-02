<?php

class BaseDeDatos
{
 protected static $instancia;
 private $host;
 private $usuario;
 private $contrasena;
 private $bd;
 private $mysqli;
 
private $campos=null;
private $donde=null;
private $agrupacion="";
private $ordenacion="";
private $valores=null;

  public function __construct($host = null, $usuario = null, $contrasena = null, $bd = null)
    {
        $this->host = $host;
        $this->usuario = $usuario;
        $this->contrasena = $contrasena;
        $this->bd = $bd;

        $this->conexion();
        self::$instancia = $this;

    }

public function conexion()
    {
        if (empty($this->host)) {
            throw new Exception('Defina un host primero');
        }

        $this->mysqli = new mysqli($this->host, $this->usuario, $this->contrasena, $this->bd);

        if ($this->mysqli->connect_error) {
            throw new Exception('Error en conexion ' . $this->_mysqli->connect_errno . ': ' . $this->_mysqli->connect_error);
        }
    }

    
    public function mysqli()
    {
        if (!$this->mysqli) {
            $this->conexion();
        }
        return $this->mysqli;
    }

    public static function getInstancia()
    {
        return self::$instancia;
    }


public function definir_donde($campo, $contenido, $operador="="){
    if($this->donde==""){
        $this->donde=$campo.$operador.$contenido;
    }else{
        $this->donde=$this->donde." AND".$campo.$operador.$contenido;
    }
    return $this;
}

public function agrupar_por($campo){
    if($this->agrupacion==""){
        $this->agrupacion=" GROUP BY ".$campo;
    }else{
        $this->agrupacion=$this->agrupacion.", ".$campo." ";
    }
    return $this;
}

public function ordenar_por($campo, $direccion=" ASC "){
    if($this->ordenacion==""){
        $this->ordenacion=" ORDER BY ".$campo." ".$direccion;
    }else{
        $this->ordenacion=$this->ordenacion.", ".$campo." ".$direccion;
    }
    return $this;
}

public function definir_campos($campo){
    if($this->campos==""){
        $this->campos=$campo;
    }else{
        $this->campos=$this->campos.", ".$campo;
    }

}



public function obtener($tabla, $limite=null){
    $sentencia="SELECT ".($this->campos!=null?$this->campos:'*').' FROM '.$tabla.($this->donde!=null?' WHERE '.$this->donde:'')
                    .$this->agrupacion
                    .$this->ordenacion
                    .';';
                    echo $sentencia;
    $this->donde="";
    $this->agrupacion="";
    $this->ordenacion="";
        return $this->mysqli->query($sentencia);
}

public function definir_valores($valor){
    if($this->valores==""){
        $this->valores=$valor;
    }else{
        $this->valores=$this->valores.", ".$valor;
    }

}
public function insertar($tabla){
    if ($this->valores) {
        $sentencia="INSERT INTO ".$tabla.($this->campos!=null?' ('.$this->campos.')':'').' VALUES ('.$this->valores.')';
        echo $sentencia;
        return $this->mysqli->query($sentencia);
    }else{
        echo "No hay valores para insertar en la tabla " .$tabla;
    }
}
public function borrar($tabla){
    if(is_string($tabla)){
        $sentencia="DELETE FROM ".$tabla.($this->donde!=null?' WHERE '.$this->donde:'');
        $this->donde="";
        return $this->mysqli->query($sentencia);
    }else{
        return false;
    }
}

}