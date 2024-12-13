<?php

namespace Controller;

use Model\Supplier;
use Router\Attributes\GET;
use Router\Attributes\POST;
use Router\Attributes\Prefix;

#[Prefix('/api')]
class ApiController
{
    #[GET('/get_supplier')]
    public function getSupplierDataById(): void
    {
        $supplierId = intval($_GET['id']);
        $supplierData = Supplier::getById($supplierId);

        if ($supplierData) {
            header('Content-Type: application/json');
            echo json_encode($supplierData);
        } else {
            http_response_code(404);
            header('Content-Type: application/json');
            echo json_encode([]);
        }
    }

    #[GET('/delete_supplier')]
    public function deleteSupplierDataById(): void
    {
        $supplierId = intval($_GET['id']);
        $supplierData = Supplier::deleteById($supplierId);

        if ($supplierData) {
            http_response_code(200);
            echo json_encode(['message' => 'Delete successful']);
        } else {
            http_response_code(404);
            header('Content-Type: application/json');
            echo json_encode([]);
        }
    }

    #[POST('/add_supplier')]
    public function addSupplier(): void
    {
        $nama = (string)$_POST['supplier_motor_nama'];
        $merk = (string)$_POST['supplier_motor_merk'];
        $kontak = (string)$_POST['supplier_motor_kontak'];

        $supplier = new Supplier(null, $nama, $merk, $kontak);
        $isAdded = $supplier->insert();

        if ($isAdded) {
            http_response_code(201);
            echo json_encode(['message' => 'Supplier added successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to add supplier']);
        }
    }

    #[POST('/edit_supplier')]
    public function editSupplier(): void
    {
        $id = (int)$_POST['supplier_motor_id'];
        $nama = (string)$_POST['supplier_motor_nama'];
        $merk = (string)$_POST['supplier_motor_merk'];
        $kontak = (string)$_POST['supplier_motor_kontak'];

        $supplier = new Supplier($id, $nama, $merk, $kontak);
        $isUpdated = $supplier->update();

        if ($isUpdated) {
            http_response_code(200);
            echo json_encode(['message' => 'Supplier updated successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to update supplier']);
        }
    }


}