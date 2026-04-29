<?php

namespace App\Models;

class PesanModel extends BaseModel
{
    protected string $table = 'pesan';

    public function getAll(): array
    {
        $stmt = $this->db->query(
            "SELECT * FROM {$this->table}
             ORDER BY created_at DESC"
        );
        return $stmt->fetchAll();
    }

    public function countBelumDibaca(): int
    {
        $stmt = $this->db->query(
            "SELECT COUNT(*) FROM {$this->table}
             WHERE status = 'belum_dibaca'"
        );
        return (int)$stmt->fetchColumn();
    }

    public function tandaiBaca(int $id): bool
    {
        return $this->update($id, ['status' => 'sudah_dibaca']);
    }
}