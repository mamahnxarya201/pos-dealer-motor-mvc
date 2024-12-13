<?php
declare(strict_types=1);

namespace Model;

use Database\ConnectionPDO;
use PDO;

class Order
{
    public function __construct(
        public ?int $order_id,
        public string $order_name,
        public Motor $order_motor,
        public Supplier $order_supplier,
        public string $order_jumlah,
        public int $order_dilayani
    ) {}

    public static function getById(int $id): ?Order
    {
        $stmt = ConnectionPDO::connect()->prepare("SELECT * FROM `order` WHERE order_id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!empty($row)) {
            $motor = Motor::getById($row['order_motor_id']);
            $supplier = Supplier::getById($row['order_supplier']);
            if (!is_null($motor) && !is_null($supplier)) {
                return new Order(
                    $row['order_id'],
                    $row['order_name'],
                    $motor,
                    $supplier,
                    $row['order_jumlah'],
                    $row['order_dilayani']
                );
            }
        }

        return null;
    }

    public static function getAll(): array
    {
        $stmt = ConnectionPDO::connect()->prepare("SELECT * FROM `order`");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $listOrder = [];
        if (!empty($data)) {
            foreach ($data as $row) {
                $motor = Motor::getById($row['order_motor_id']);
                $supplier = Supplier::getById($row['order_supplier']);
                if (!is_null($motor) && !is_null($supplier)) {
                    $listOrder[] = new Order(
                        $row['order_id'],
                        $row['order_name'],
                        $motor,
                        $supplier,
                        $row['order_jumlah'],
                        $row['order_dilayani']
                    );
                }
            }
        }

        return $listOrder;
    }

    public static function deleteById(int $id): bool
    {
        $stmt = ConnectionPDO::connect()->prepare("DELETE FROM `order` WHERE order_id = ?");
        $result = $stmt->execute([$id]);
        return $result && $stmt->rowCount() > 0;
    }

    public function insert(): bool
    {
        $stmt = ConnectionPDO::connect()->prepare(
            "INSERT INTO `order` (order_name, order_motor_id, order_supplier, order_jumlah, order_dilayani) 
             VALUES (:name, :motor_id, :supplier_id, :jumlah, :dilayani)"
        );
        $result = $stmt->execute([
            'name' => $this->order_name,
            'motor_id' => $this->order_motor->id,
            'supplier_id' => $this->order_supplier->id,
            'jumlah' => $this->order_jumlah,
            'dilayani' => $this->order_dilayani
        ]);

        return $result;
    }

    public function update(): bool
    {
        $stmt = ConnectionPDO::connect()->prepare(
            "UPDATE `order`
             SET order_name = :name, order_motor_id = :motor_id, order_supplier = :supplier_id, order_jumlah = :jumlah, order_dilayani = :dilayani 
             WHERE order_id = :id"
        );
        $result = $stmt->execute([
            'name' => $this->order_name,
            'motor_id' => $this->order_motor->id,
            'supplier_id' => $this->order_supplier->id,
            'jumlah' => $this->order_jumlah,
            'dilayani' => $this->order_dilayani,
            'id' => $this->order_id
        ]);

        return $result;
    }
}
