<?php
declare(strict_types=1);


namespace Model;

use Database\ConnectionPDO;
use PDO;

class Supplier
{
    public function __construct(
        public ?int    $id,
        public string $nama,
        public string $merk,
        public string $kontak,
    )
    {
    }

    public static function getAll(): array
    {
        $stmt = ConnectionPDO::connect()->prepare("SELECT * FROM supplier_motor");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $supplierArray = [];
        if (!empty($data)) {
            foreach ($data as $row) {
                $supplierArray[] = new Supplier(
                    $row['supplier_motor_id'],
                    $row['supplier_motor_nama'],
                    $row['supplier_motor_merk'],
                    $row['supplier_motor_kontak'],
                );
            }
        }
        return $supplierArray;
    }

    public static function getById(int $id): ?Supplier
    {
        $stmt = ConnectionPDO::connect()->prepare("SELECT * FROM supplier_motor WHERE supplier_motor_id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!empty($data)) {
            return new Supplier(
                $data['supplier_motor_id'],
                $data['supplier_motor_nama'],
                $data['supplier_motor_merk'],
                $data['supplier_motor_kontak'],
            );
        }

        return null;
    }

    public static function deleteById(int $id): bool
    {
        $stmt = ConnectionPDO::connect()->prepare("DELETE FROM supplier_motor WHERE supplier_motor_id = ?");
        $result = $stmt->execute([$id]);
        if ($result && $stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }

    public function insert(): bool
    {
        $stmt = ConnectionPDO::connect()->prepare("INSERT INTO supplier_motor (supplier_motor_nama, supplier_motor_merk, supplier_motor_kontak) VALUES (:nama, :merk, :kontak)");
        $result = $stmt->execute([
            'nama' => $this->nama,
            'merk' => $this->merk,
            'kontak' => $this->kontak
        ]);
        return $result;
    }

    public function update(): bool
    {
        $stmt = ConnectionPDO::connect()->prepare(
            "UPDATE supplier_motor 
         SET supplier_motor_nama = :nama, 
             supplier_motor_merk = :merk, 
             supplier_motor_kontak = :kontak 
         WHERE supplier_motor_id = :id"
        );
        $result = $stmt->execute([
            'nama' => $this->nama,
            'merk' => $this->merk,
            'kontak' => $this->kontak,
            'id' => $this->id
        ]);

        return $result;
    }

}