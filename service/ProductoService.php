<?php
include_once __DIR__ . '/../Conexion/Conexion.php';
include_once __DIR__ . '/CategoriaProductoService.php';
include_once __DIR__ . '/ProveedorService.php';
include_once __DIR__ . '/UnidadMedidaService.php';

class ProductoService extends Conexion
{
    private $db;
    private $cate_prod_service;

    function __construct()
    {
        $this->db = new Conexion();
        $this->cate_prod_service = new CategoriaProductoService(true);
        $this->proveedor_service = new ProveedorService(true);
        $this->unidad_medida_service = new UnidadMedidaService(true);
    }

    function listar()
    {
        $query = "SELECT id_producto, nombre_producto, precio_unitario,
                id_categoria_producto, id_proveedor, id_unidad_medida,
                cantidad, estado
                FROM tb_producto
                WHERE estado = '1'";
        $resultado = $this->db->query($query);
        $datos = [];

        if (mysqli_num_rows($resultado) > 0) {
            while ($row = $resultado->fetch_assoc()) {

                $categora_producto = $this->cate_prod_service->porId($row['id_categoria_producto']);
                $proveedor = $this->proveedor_service->porId($row['id_proveedor']);
                $unidad_medida = $this->unidad_medida_service->porId($row['id_unidad_medida']);

                $datos[] = array(
                    "id_producto" => $row['id_producto'],
                    "nombre_producto" => $row['nombre_producto'],
                    "precio_unitario" => $row['precio_unitario'],
                    "categora_producto" => $categora_producto,
                    "proveedor" => $proveedor,
                    "unidad_medida" => $unidad_medida,
                    "cantidad" => $row['cantidad'],
                    "estado" => $row['estado'],
                );
            }
        }

        mysqli_close($this->db);
        return $datos;
    }

    function porId($id)
    {
        $query = "SELECT id_producto, nombre_producto, precio_unitario,
                    id_categoria_producto, id_proveedor, id_unidad_medida,
                    cantidad, estado
                    FROM tb_producto
                    WHERE id_producto = $id";

        $resultado = $this->db->query($query);
        $data = new ArrayObject();

        if (mysqli_num_rows($resultado) > 0) {
            $object = $resultado->fetch_assoc(); //obtenemos el 1ero             

            $categora_producto = $this->cate_prod_service->porId($object['id_categoria_producto']);
            $proveedor = $this->proveedor_service->porId($object['id_proveedor']);
            $unidad_medida = $this->unidad_medida_service->porId($object['id_unidad_medida']);
            $data = array(
                "id_producto" => $object['id_producto'],
                "nombre_producto" => $object['nombre_producto'],
                "precio_unitario" => $object['precio_unitario'],
                "categora_producto" => $categora_producto,
                "proveedor" => $proveedor,
                "unidad_medida" => $unidad_medida,
                "cantidad" => $object['cantidad'],
                "estado" => $object['estado'],
            );
        }

        mysqli_close($this->db);
        return $data;
    }

    function agregar($data)
    {
        $nombre_producto = $data['nombre_producto'];
        $precio_unitario = $data['precio_unitario'];
        
        $id_categoria_producto = $data['categora_producto']["id_categoria_producto"];
        $id_proveedor = $data['proveedor']["id_proveedor"];
        $id_unidad_medida = $data['unidad_medida']["id_unidad_medida"];

        $query = "INSERT INTO tb_producto (nombre_producto, precio_unitario, cantidad, 
                    id_categoria_producto, id_proveedor, id_unidad_medida, estado)                 
                    VALUES ('$nombre_producto', '$precio_unitario', 0,
                            '$id_categoria_producto', '$id_proveedor', '$id_unidad_medida' ,'1' )";

        // var_dump($query);
        $result = $this->db->query($query);
        mysqli_close($this->db);

        if ($result) return true;
        else return false;
    }

    function actualizar($data)
    {
        // var_dump($data);
        $id_producto = (int) $data['id_producto'];
        $nombre_producto = $data['nombre_producto'];
        $precio_unitario = (float) $data['precio_unitario'];

        $id_categoria_producto = $data['categora_producto']["id_categoria_producto"];
        $id_proveedor = $data['proveedor']["id_proveedor"];
        $id_unidad_medida = $data['unidad_medida']["id_unidad_medida"];

        $query = "UPDATE
                tb_producto 
                SET nombre_producto ='$nombre_producto', precio_unitario= $precio_unitario,
                id_categoria_producto = '$id_categoria_producto', id_proveedor = '$id_proveedor', 
                id_unidad_medida = '$id_unidad_medida'
                WHERE id_producto = $id_producto";

        // var_dump($query);

        $result = $this->db->query($query);
        mysqli_close($this->db);

        if ($result) return true;
        else return false;
    }

    function eliminar($id)
    {
        $query = "UPDATE
                tb_producto 
                SET estado = '0'
                WHERE id_producto = $id";

        $result = $this->db->query($query);
        mysqli_close($this->db);

        if ($result) return true;
        else return false;
    }

}
