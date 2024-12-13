<?php

namespace Controller;

use Model\Motor;
use Model\Order;
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
        $supplierData = $supplierId > 0 ? Supplier::getById($supplierId) : Supplier::getAll();

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

    #[POST('/add_motor')]
    public function addMotor(): void
    {
        $type = (string)$_POST['motor_tipe'];
        $name = (string)$_POST['motor_name'];
        $price = (int)$_POST['motor_price'];
        $qty = (int)$_POST['motor_qty'];
        $supplierId = (int)$_POST['supplier_motor_id'];

        $supplier = Supplier::getById($supplierId);

        if ($supplier) {
            $motor = new Motor(null, $type, $name, $price, $qty, $supplier);
            $isAdded = $motor->insert();

            if ($isAdded) {
                http_response_code(201);
                echo json_encode(['message' => 'Motor added successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Failed to add motor']);
            }
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Supplier not found']);
        }
    }


    #[GET('/delete_motor')]
    public function deleteMotorDataById(): void
    {
        $supplierId = intval($_GET['id']);
        $motordata = Motor::deleteById($supplierId);

        if ($motordata) {
            http_response_code(200);
            echo json_encode(['message' => 'Delete successful']);
        } else {
            http_response_code(404);
            header('Content-Type: application/json');
            echo json_encode([]);
        }
    }

    #[GET('/get_motor')]
    public function getMotorData(): void
    {
        $motorId = intval($_GET['id']);
        $supplierData = $motorId > 0 ? Motor::getById($motorId) : Motor::getAll();

        if ($supplierData) {
            header('Content-Type: application/json');
            echo json_encode($supplierData);
        } else {
            http_response_code(404);
            header('Content-Type: application/json');
            echo json_encode([]);
        }
    }

    #[POST('/edit_motor')]
    public function editMotor(): void
    {
        $id = (int)$_POST['motor_id'];
        $type = (string)$_POST['motor_tipe'];
        $name = (string)$_POST['motor_name'];
        $price = (int)$_POST['motor_price'];
        $qty = (int)$_POST['motor_qty'];
        $supplierId = (int)$_POST['supplier_motor_id'];

        $supplier = Supplier::getById($supplierId);

        if ($supplier) {
            $motor = new Motor($id, $type, $name, $price, $qty, $supplier);
            $isAdded = $motor->update();

            if ($isAdded) {
                http_response_code(201);
                echo json_encode(['message' => 'Motor added successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Failed to add motor']);
            }
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Supplier not found']);
        }
    }

    #[POST('/add_order')]
    public function addOrder(): void
    {
        $orderName = (string)$_POST['order_name'];
        $orderMotorId = (int)$_POST['order_motor_id'];
        $orderJumlah = (int)$_POST['order_jumlah'];
        $orderDilayani = (int)$_POST['order_dilayani'];
        $orderSupplierId = (int)$_POST['supplier_order'];

        $motor = Motor::getById($orderMotorId);
        $supplier = Supplier::getById($orderSupplierId);

        if ($motor && $supplier) {
            $order = new Order(null, $orderName, $motor, $supplier, $orderJumlah, $orderDilayani);
            $isAdded = $order->insert();

            if ($isAdded) {
                http_response_code(201);
                echo json_encode(['message' => 'Order added successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Failed to add order']);
            }
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Motor or Supplier not found']);
        }
    }

    #[POST('/edit_order')]
    public function editOrder(): void
    {
        $orderName = (string)$_POST['order_name'];
        $orderMotorId = (int)$_POST['order_motor_id'];
        $orderJumlah = (int)$_POST['order_jumlah'];
        $orderDilayani = (int)$_POST['order_dilayani'];
        $orderSupplierId = (int)$_POST['supplier_order'];
        $orderId = (int)$_POST['order_id'];

        $motor = Motor::getById($orderMotorId);
        $supplier = Supplier::getById($orderSupplierId);

        if ($motor && $supplier) {
            $order = new Order($orderId, $orderName, $motor, $supplier, $orderJumlah, $orderDilayani);
            $isAdded = $order->update();

            if ($isAdded) {
                http_response_code(201);
                echo json_encode(['message' => 'Order added successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Failed to add order']);
            }
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Motor or Supplier not found']);
        }
    }

    #[GET('/get_order')]
    public function gerOrderById(): void
    {
        $orderId = intval($_GET['id']);
        $orderData = Order::getById($orderId);

        if ($orderData) {
            header('Content-Type: application/json');
            echo json_encode($orderData);
        } else {
            http_response_code(404);
            header('Content-Type: application/json');
            echo json_encode([]);
        }
    }

}