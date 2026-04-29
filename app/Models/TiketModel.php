<?php

namespace App\Models;

class TiketModel extends BaseModel
{
    protected string $table = 'tiket';

    public function getByUserId(int $userId): array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table}
             WHERE user_id = ?
             ORDER BY created_at DESC"
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function getAllWithUser(): array
    {
        $stmt = $this->db->query(
            "SELECT t.*,
                    CONCAT(u.nama_depan, ' ', u.nama_belakang) AS nama_pengunjung,
                    u.email
             FROM {$this->table} t
             LEFT JOIN users u ON t.user_id = u.id
             ORDER BY t.created_at DESC"
        );
        return $stmt->fetchAll();
    }

    public function getJenisTiket(): array
    {
        return [
            ['jenis' => 'anak',     'harga' => 35000,  'label' => 'Tiket Anak',     'deskripsi' => 'Usia di bawah 12 tahun'],
            ['jenis' => 'dewasa',   'harga' => 55000,  'label' => 'Tiket Dewasa',   'deskripsi' => 'Usia 12 tahun ke atas'],
            ['jenis' => 'keluarga', 'harga' => 150000, 'label' => 'Paket Keluarga', 'deskripsi' => 'Maks. 2 dewasa + 2 anak'],
        ];
    }
}