<?php

namespace App\Models;

class UserModel extends BaseModel
{
    protected string $table = 'users';

    public function findByUsername(string $username): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE username = ? LIMIT 1"
        );
        $stmt->execute([$username]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE email = ? LIMIT 1"
        );
        $stmt->execute([$email]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function findByUsernameOrEmail(string $login): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table}
             WHERE username = ? OR email = ?
             LIMIT 1"
        );
        $stmt->execute([$login, $login]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function getAllUsers(): array
    {
        $stmt = $this->db->query(
            "SELECT id, nama_depan, nama_belakang, username, email,
                    telepon, role, created_at
             FROM {$this->table}
             ORDER BY created_at DESC"
        );
        return $stmt->fetchAll();
    }
}