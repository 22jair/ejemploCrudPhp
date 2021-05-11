<?php
include_once __DIR__ . '/../Conexion/Conexion.php';

class CategoriaProductoService extends Conexion
{
    private $db;
    private $isInstantiated;

    function __construct($isInstantiated = false)
    {
        $this->db = new Conexion();
        $this->isInstantiated =  $isInstantiated;
    }

    function listar($estado = "")
    {
        
        $query = "SELECT id_categoria_producto, nombre_categoria, descripcion, estado 
                FROM tb_categoria_producto";

        switch($estado){
            case 'ACTIVO' : 
                $query = $query." WHERE estado = '1'"; 
                break;
            case 'NOACTIVO' : 
                $query = $query." WHERE estado = '0'"; 
                break;
            default: break;
        }
                
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
        $query = "SELECT id_categoria_producto, nombre_categoria, descripcion,  estado
                FROM tb_categoria_producto
                WHERE id_categoria_producto = $id";

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
        $nombre_categoria = $data['nombre_categoria'];
        $descripcion = $data['descripcion'];
       
        $query = "INSERT INTO tb_categoria_producto (nombre_categoria, descripcion, estado)                 
                    VALUES ('$nombre_categoria', '$descripcion', '1' )";

        // var_dump($query);
        $result = $this->db->query($query);
        mysqli_close($this->db);

        if ($result) return true;
        else return false;
    }

    function actualizar($data)
    {
        // var_dump($data);

        $id_categoria_producto =(int) $data['id_categoria_producto'];
        $nombre_categoria = $data['nombre_categoria'];
        $descripcion = $data['descripcion'];
     
        $query = "UPDATE
                tb_categoria_producto 
                SET nombre_categoria ='$nombre_categoria', descripcion='$descripcion'
                WHERE id_categoria_producto = $id_categoria_producto";                

        // var_dump($query);

        $result = $this->db->query($query);
        mysqli_close($this->db);

        if ($result) return true;
        else return false;
    }

    function eliminar($id)
    {
         
        $query = "UPDATE
                tb_categoria_producto 
                SET estado = '0'
                WHERE id_categoria_producto = $id";                

        // var_dump($query);

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
