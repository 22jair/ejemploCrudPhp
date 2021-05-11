<?php
include_once __DIR__ . '/../Conexion/Conexion.php';

class UnidadMedidaService extends Conexion
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
        $query = "SELECT id_unidad_medida, unidad_medida, descripcion, estado
                FROM tb_unidad_medida
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
        $query = "SELECT id_unidad_medida, unidad_medida, descripcion,  estado FROM tb_unidad_medida
                    WHERE id_unidad_medida = $id";

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
        $unidad_medida = $data['unidad_medida'];
        $descripcion = $data['descripcion'];
       
        $query = "INSERT INTO tb_unidad_medida (unidad_medida, descripcion, estado)                 
                    VALUES ('$unidad_medida', '$descripcion', '1' )";

        // var_dump($query);
        $result = $this->db->query($query);
        mysqli_close($this->db);

        if ($result) return true;
        else return false;
    }

    function actualizar($data)
    {
        // var_dump($data);

        $id_unidad_medida =(int) $data['id_unidad_medida'];
        $unidad_medida = $data['unidad_medida'];
        $descripcion = $data['descripcion'];
     
        $query = "UPDATE
                tb_unidad_medida 
                SET unidad_medida ='$unidad_medida', descripcion='$descripcion'
                WHERE id_unidad_medida = $id_unidad_medida";                

        // var_dump($query);

        $result = $this->db->query($query);
        mysqli_close($this->db);

        if ($result) return true;
        else return false;
    }

    function eliminar($id)
    {
         
        $query = "UPDATE
                tb_unidad_medida 
                SET estado = '0'
                WHERE id_unidad_medida = $id";                

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
