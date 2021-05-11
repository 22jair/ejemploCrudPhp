<?php

include_once __DIR__ . '/../service/ProveedorService.php';

class ProveedorController
{

    private $service;

    function __construct()
    {
        $this->service = new ProveedorService();
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
            echo json_encode(["message" =>"Proveedor no encontrado.", "data" =>$data]);       
        }
    }

    function agregar($data)
    {
        $errors = [];

        if (!isset($data["nombre_proveedor"]) || strlen($data["nombre_proveedor"]) <= 0) $errors["nombre_proveedor"] = "Ingrese nombre Proveedor";
        if (!isset($data["ruc"]) || strlen($data["ruc"]) <= 0) $errors["ruc"] = "Ingrese Ruc";
        if (strlen($data["ruc"]) != 11) $errors["ruc"] = "Ruc debe contener 11 caracteres.";        

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
        if (!isset($data["id_proveedor"]) || strlen($data["id_proveedor"]) <= 0) $errors["id_unidad_medida"] = "Ingrese el ID.";
        if (!isset($data["nombre_proveedor"]) || strlen($data["nombre_proveedor"]) <= 0) $errors["nombre_proveedor"] = "Ingrese nombre Proveedor";
        if (!isset($data["ruc"]) || strlen($data["ruc"]) != 11) $errors["ruc"] = "Ingrese Ruc, debe contener 11 Caracteres.";
        // if (strlen($data["ruc"]) != 11) $errors["ruc"] = "Ruc debe contener 11 caracteres";        


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
