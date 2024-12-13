<?php
declare(strict_types=1);

namespace Model;

use Database\ConnectionPDO;
use PDO;

class Motor
{
    public function __construct(
        public ?int     $id,
        public string   $type,
        public string   $name,
        public int      $price,
        public int      $qty,
        public Supplier $supplier
    )
    {
    }

    public static function getById(int $id): ?Motor
    {
        $stmt = ConnectionPDO::connect()->prepare("select * from motor where motor_id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!empty($row)) {
            $supplier = Supplier::getById($row['supplier_motor_id']);
            if (!is_null($supplier)) {
                return new Motor(
                    $row['motor_id'],
                    $row['motor_tipe'],
                    $row['motor_name'],
                    $row['motor_price'],
                    $row['motor_qty'],
                    $supplier
                );
            }
        }

        return null;
    }

    public static function getAll(): array
    {
        $stmt = ConnectionPDO::connect()->prepare("select * from motor");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $listMotor = [];
        if (!empty($data)) {
            foreach ($data as $row) {
                $supplier = Supplier::getById($row['supplier_motor_id']);
                if (!is_null($supplier)) {
                    $listMotor[] = new Motor(
                        $row['motor_id'],
                        $row['motor_tipe'],
                        $row['motor_name'],
                        $row['motor_price'],
                        $row['motor_qty'],
                        $supplier
                    );
                }
            }
        }

        return $listMotor;
    }

    public static function deleteById(int $id)
    {
        $stmt = ConnectionPDO::connect()->prepare("DELETE FROM motor WHERE motor_id = ?");
        $result = $stmt->execute([$id]);
        if ($result && $stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }


    public function insert(): bool
    {
        $stmt = ConnectionPDO::connect()->prepare(
            "INSERT INTO motor (motor_tipe, motor_name, motor_price, motor_qty, supplier_motor_id) 
         VALUES (:type, :name, :price, :qty, :supplierId)"
        );
        $result = $stmt->execute([
            'type' => $this->type,
            'name' => $this->name,
            'price' => $this->price,
            'qty' => $this->qty,
            'supplierId' => $this->supplier->id
        ]);

        return $result;
    }

    public function update(): bool
    {
        $stmt = ConnectionPDO::connect()->prepare(
            "UPDATE motor 
         SET motor_tipe = :type, motor_name = :name, motor_price = :price, motor_qty = :qty, supplier_motor_id = :supplierId 
         WHERE motor_id = :id"
        );
        $result = $stmt->execute([
            'type' => $this->type,
            'name' => $this->name,
            'price' => $this->price,
            'qty' => $this->qty,
            'supplierId' => $this->supplier->id,
            'id' => $this->id
        ]);

        return $result;
    }


}