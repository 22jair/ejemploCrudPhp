<?php

include_once __DIR__ . '/../service/ProductoService.php';

class ProductoController
{

    private $service;

    function __construct()
    {
        $this->service = new ProductoService();
    }

    function listar()
    {
        $data = $this->service->listar();
        echo json_encode(["data" => $data]);
    }

    function porId($id)
    {
        $data = $this->service->porId($id);

        if (count($data) > 0) {
            http_response_code(200);
            echo json_encode($data);
        } else {
            http_response_code(404);
            echo json_encode(["message" =>"Producto no encontrado.", $data]);       
        }
    }

    function agregar($data)
    {
        $errors = [];


        if (!isset($data["nombre_producto"]) || strlen($data["nombre_producto"]) <= 0) $errors["nombre_producto"] = "Ingrese nombre del Producto";
        if (!isset($data["precio_unitario"]) || strlen($data["precio_unitario"]) <= 0) $errors["precio_unitario"] = "Ingrese un precio unitario";
       
        if (!isset($data["categora_producto"]) || !isset($data["categora_producto"]["id_categoria_producto"]) || 
            strlen($data["categora_producto"]["id_categoria_producto"]) <= 0) $errors["categora_producto"] = "Ingrese Producto";
        
        if (!isset($data["proveedor"]) || !isset($data["proveedor"]["id_proveedor"]) ||
            strlen($data["proveedor"]["id_proveedor"]) <= 0) $errors["proveedor"] = "Ingrese Proveedor";
        
        if (!isset($data["unidad_medida"]) || !isset($data["unidad_medida"]["id_unidad_medida"]) ||
        strlen($data["unidad_medida"]["id_unidad_medida"]) <= 0) $errors["unidad_medida"] = "Ingrese Unidad de Medida";
                
        if (count($errors) > 0){
            http_response_code(404);
            echo json_encode(["message" =>"Corregir los errores.", "errors"=>$errors]);            
            die();
        } 
        
        if ($this->service->agregar($data)) {
            http_response_code(201);
            echo json_encode(["message" => "Registrado correctamente."]);
        } else {
            http_response_code(404);
            echo json_encode(["message" =>"Error en el servicio, Contacte a Sistemas."]);
        }        
    }

    function actualizar($data)
    {
        $errors = [];
        if (!isset($data["id_producto"]) || strlen($data["id_producto"]) <= 0) $errors["id_producto"] = "Ingrese el ID.";
        
        if (!isset($data["nombre_producto"]) || strlen($data["nombre_producto"]) <= 0) $errors["nombre_producto"] = "Ingrese nombre del Producto";
        if (!isset($data["precio_unitario"]) || strlen($data["precio_unitario"]) <= 0) $errors["precio_unitario"] = "Ingrese un precio unitario";
       
        if (!isset($data["categora_producto"]) || !isset($data["categora_producto"]["id_categoria_producto"]) || 
            strlen($data["categora_producto"]["id_categoria_producto"]) <= 0) $errors["categora_producto"] = "Ingrese Producto";
        
        if (!isset($data["proveedor"]) || !isset($data["proveedor"]["id_proveedor"]) ||
            strlen($data["proveedor"]["id_proveedor"]) <= 0) $errors["proveedor"] = "Ingrese Proveedor";
        
        if (!isset($data["unidad_medida"]) || !isset($data["unidad_medida"]["id_unidad_medida"]) ||
        strlen($data["unidad_medida"]["id_unidad_medida"]) <= 0) $errors["unidad_medida"] = "Ingrese Unidad de Medida";
                

        if (count($errors) > 0){
            http_response_code(404);
            echo json_encode(["message" =>"Corregir los errores.", "errors"=>$errors]);            
            die();
        } 

        if ($this->service->actualizar($data)) {
            http_response_code(200);
            echo json_encode(["message" => "Actualizado correctamente."]);
        } else {
            http_response_code(404);
            echo json_encode(["message" =>"Error en el servicio, Contacte a Sistemas."]);
        }
    }

    function eliminar($id)
    {
        $errors = [];
        if (strlen($id) <= 0) $errors["id_proveedor"] = "Ingrese id del proveedor";        

        if (count($errors) > 0){
            http_response_code(404);
            echo json_encode(["message" =>"Corregir los errores.", "errors"=>$errors]);            
            die();
        } 

        if ($this->service->eliminar($id)) {
            http_response_code(200);
            echo json_encode(["message" => "Eliminado correctamente."]);
        } else {
            http_response_code(404);
            echo json_encode(["message" =>"Error en el servicio, Contacte a Sistemas."]);
        }
    }
}
