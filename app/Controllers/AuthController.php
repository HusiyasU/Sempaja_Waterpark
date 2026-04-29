<?php

namespace App\Controllers;

use App\Core\Response;
use App\Core\Middleware;
use App\Models\UserModel;
use Firebase\JWT\JWT;

class AuthController
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // =====================
    // POST /api/auth/login
    // =====================
    public function login(): void
    {
        $body = json_decode(file_get_contents('php://input'), true);

        $login    = trim($body['login']    ?? '');
        $password = trim($body['password'] ?? '');

        if (!$login || !$password) {
            Response::error('Username/email dan password wajib diisi', 422);
        }

        $user = $this->userModel->findByUsernameOrEmail($login);

        if (!$user || !password_verify($password, $user['password'])) {
            Response::error('Username/email atau password salah', 401);
        }

        $payload = [
            'iss'  => $_ENV['APP_URL'],
            'iat'  => time(),
            'exp'  => time() + (int)($_ENV['JWT_EXPIRE'] ?? 86400),
            'id'   => $user['id'],
            'role' => $user['role'],
        ];

        $token = JWT::encode($payload, $_ENV['JWT_SECRET'], 'HS256');

        unset($user['password']);

        Response::success([
            'token' => $token,
            'user'  => $user,
        ], 'Login berhasil');
    }

    // =====================
    // POST /api/auth/register
    // =====================
    public function register(): void
    {
        $body = json_decode(file_get_contents('php://input'), true);

        $namaDepan   = trim($body['nama_depan']            ?? '');
        $namaBelakang= trim($body['nama_belakang']         ?? '');
        $username    = trim($body['username']              ?? '');
        $email       = trim($body['email']                 ?? '');
        $telepon     = trim($body['telepon']               ?? '');
        $password    = $body['password']                   ?? '';
        $konfirmasi  = $body['password_confirmation']      ?? '';

        // Validasi
        $errors = [];
        if (!$namaDepan)  $errors['nama_depan'] = 'Nama depan wajib diisi';
        if (!$username)   $errors['username']   = 'Username wajib diisi';
        if (!$email)      $errors['email']      = 'Email wajib diisi';
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Format email tidak valid';
        if (!$password)   $errors['password']   = 'Password wajib diisi';
        elseif (strlen($password) < 8) $errors['password'] = 'Password minimal 8 karakter';
        if ($password !== $konfirmasi) $errors['password_confirmation'] = 'Konfirmasi password tidak cocok';

        if (!empty($errors)) {
            Response::error('Validasi gagal', 422, $errors);
        }

        if ($this->userModel->findByUsername($username)) {
            Response::error('Username sudah digunakan', 409);
        }

        if ($this->userModel->findByEmail($email)) {
            Response::error('Email sudah terdaftar', 409);
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $userId = $this->userModel->create([
            'nama_depan'    => $namaDepan,
            'nama_belakang' => $namaBelakang,
            'username'      => $username,
            'email'         => $email,
            'telepon'       => $telepon,
            'password'      => $hashedPassword,
            'role'          => 'user',
        ]);

        if (!$userId) {
            Response::error('Registrasi gagal, coba lagi', 500);
        }

        Response::success(['id' => $userId], 'Registrasi berhasil', 201);
    }

    // =====================
    // POST /api/auth/logout
    // =====================
    public function logout(): void
    {

        Response::success(null, 'Logout berhasil');
    }

    // =====================
    // GET /api/auth/me
    // =====================
    public function me(): void
    {
        $payload = Middleware::auth();

        $user = $this->userModel->findById($payload->id);

        if (!$user) {
            Response::notFound('User tidak ditemukan');
        }

        unset($user['password']);

        Response::success($user, 'Data user berhasil diambil');
    }
}