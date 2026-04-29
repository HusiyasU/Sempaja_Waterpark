<?php

namespace App\Core;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class Middleware
{
    /**
     * Verifikasi JWT token dari header Authorization
     * Kembalikan payload jika valid, null jika tidak
     */
    public static function auth(): ?object
    {
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';

        if (!str_starts_with($authHeader, 'Bearer ')) {
            Response::unauthorized('Token tidak ditemukan');
        }

        $token = substr($authHeader, 7);

        try {
            $payload = JWT::decode($token, new Key($_ENV['JWT_SECRET'], 'HS256'));
            return $payload;
        } catch (Exception $e) {
            Response::unauthorized('Token tidak valid atau sudah expired');
        }

        return null;
    }

    /**
     * Cek apakah user adalah admin
     */
    public static function admin(): object
    {
        $payload = self::auth();

        if (!$payload || $payload->role !== 'admin') {
            Response::forbidden('Akses hanya untuk admin');
        }

        return $payload;
    }
}