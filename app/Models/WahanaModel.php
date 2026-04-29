<?php

namespace App\Models;

class WahanaModel extends BaseModel
{
    protected string $table = 'wahana';

    public function getAll(): array
    {
        $stmt = $this->db->query(
            "SELECT * FROM {$this->table}
             WHERE status = 'aktif'
             ORDER BY created_at DESC"
        );
        return $stmt->fetchAll();
    }

    public function getAllAdmin(): array
    {
        $stmt = $this->db->query(
            "SELECT * FROM {$this->table}
             ORDER BY created_at DESC"
        );
        return $stmt->fetchAll();
    }

    public function getByKategori(string $kategori): array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table}
             WHERE kategori = ? AND status = 'aktif'
             ORDER BY created_at DESC"
        );
        $stmt->execute([$kategori]);
        return $stmt->fetchAll();
    }
}