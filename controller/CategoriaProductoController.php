<?php

include_once __DIR__ . '/../service/CategoriaProductoService.php';

class CategoriaProductoController
{

    private $service;

    function __construct()
    {
        $this->service = new CategoriaProductoService();
    }

    function listar($data)
    {   
        $data = isset($data["estado"]) ?  $this->service->listar($data["estado"]) :  $this->service->listar();
        // para paginación
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
            echo json_encode(["message" =>"Categoria no encontrado.", "data" =>$data]);       
        }
    }

    function agregar($data)
    {
        $errors = [];
        
        if (!isset($data["nombre_categoria"]) || strlen($data["nombre_categoria"]) <= 0) $errors["nombre_categoria"] = "Ingrese nombre de categoria.";
        if (!isset($data["descripcion"]) || strlen($data["descripcion"]) <= 0) $errors["descripcion"] = "Ingrese unidad de medida";

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
        if (!isset($data["id_categoria_producto"]) || strlen($data["id_categoria_producto"]) <= 0) $errors["id_categoria_producto"] = "Ingrese el ID.";
        if (!isset($data["nombre_categoria"]) || strlen($data["nombre_categoria"]) <= 0) $errors["nombre_categoria"] = "Ingrese nombre categoria";
        if (!isset($data["descripcion"]) || strlen($data["descripcion"]) <= 0) $errors["descripcion"] = "Ingrese unidad de medida";

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
        if (strlen($id) <= 0) $errors["id_categoria_producto"] = "Ingrese id categoria producto";        

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
