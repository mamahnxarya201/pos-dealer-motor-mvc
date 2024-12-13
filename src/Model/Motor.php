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

    public static function getMotorById(int $id): ?Motor
    {
        $stmt = ConnectionPDO::connect()->prepare("select * from motor where id = ?");
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
}