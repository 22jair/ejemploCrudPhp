<?php
include_once __DIR__ . '/../Conexion/Conexion.php';

class ProveedorService extends Conexion
{
    private $db;
    private $isInstantiated;

    function __construct($isInstantiated = false)
    {
        $this->db = new Conexion();
        $this->isInstantiated =  $isInstantiated;
    }

    function listar()
    {
        $query = "SELECT id_proveedor, nombre_proveedor, ruc, estado
                FROM tb_proveedor
                WHERE estado = '1'";
        $resultado = $this->db->query($query);
        $datos = [];

        if (mysqli_num_rows($resultado) > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $datos[] = $row;
            }
        }

        mysqli_close($this->db);
        return $datos;
    }

    function porId($id)
    {
        $query = "SELECT id_proveedor, nombre_proveedor, ruc, estado
                    FROM tb_proveedor
                    WHERE id_proveedor = $id";

        $resultado = $this->db->query($query);
        $data = new ArrayObject();
    
        if (mysqli_num_rows($resultado) > 0) {
            $data = $resultado->fetch_assoc(); //obtenemos el 1ero             
        }


        $this->closeConnection();
        return $data;
    }

    function agregar($data)
    {
        $nombre_proveedor = $data['nombre_proveedor'];
        $ruc = $data['ruc'];
       
        $query = "INSERT INTO tb_proveedor (nombre_proveedor, ruc, estado)                 
                    VALUES ('$nombre_proveedor', '$ruc', '1' )";

        // var_dump($query);
        $result = $this->db->query($query);
        mysqli_close($this->db);

        if ($result) return true;
        else return false;
    }

    function actualizar($data)
    {
        // var_dump($data);
        $id_proveedor =(int) $data['id_proveedor'];
        $nombre_proveedor = $data['nombre_proveedor'];
        $ruc = $data['ruc'];
     
        $query = "UPDATE
                tb_proveedor 
                SET nombre_proveedor ='$nombre_proveedor', ruc='$ruc'
                WHERE id_proveedor = $id_proveedor";                

        // var_dump($query);

        $result = $this->db->query($query);
        mysqli_close($this->db);

        if ($result) return true;
        else return false;
    }

    function eliminar($id)
    {         
        $query = "UPDATE
                tb_proveedor 
                SET estado = '0'
                WHERE id_proveedor = $id";                

        $result = $this->db->query($query);
        mysqli_close($this->db);

        if ($result) return true;
        else return false;
    }

    private function closeConnection(){            
        if(!$this->isInstantiated){
            mysqli_close($this->db);
        }
    }
}

