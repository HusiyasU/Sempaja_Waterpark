<?php

namespace App\Controllers;

use App\Core\Response;
use App\Core\Middleware;

class UploadController
{
    public function image(): void
    {
        Middleware::admin();

        if (empty($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            $errCode = $_FILES['image']['error'] ?? -1;
            $errMsg  = match($errCode) {
                UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'File terlalu besar',
                UPLOAD_ERR_NO_FILE => 'Tidak ada file yang dipilih',
                default            => 'Error upload: ' . $errCode,
            };
            Response::error($errMsg, 422);
        }

        $file    = $_FILES['image'];
        $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        $maxSize = 3 * 1024 * 1024;

        $finfo    = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $allowed)) {
            Response::error('Format file tidak didukung. Gunakan JPG, PNG, atau WEBP', 422);
        }

        if ($file['size'] > $maxSize) {
            Response::error('Ukuran file maksimal 3MB', 422);
        }

        $uploadDir = __DIR__ . '/../../public/dist/img/wahana/';
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                Response::error('Gagal membuat folder upload', 500);
            }
        }

        $ext      = match($mimeType) {
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp',
            'image/gif'  => 'gif',
            default      => 'jpg',
        };
        $filename = 'wahana_' . uniqid() . '_' . time() . '.' . $ext;
        $dest     = $uploadDir . $filename;

        if (!move_uploaded_file($file['tmp_name'], $dest)) {
            Response::error('Gagal menyimpan file', 500);
        }

        $url = '/Sempaja_Waterpark/public/dist/img/wahana/' . $filename;

        Response::success(['url' => $url], 'Gambar berhasil diupload');
    }
}