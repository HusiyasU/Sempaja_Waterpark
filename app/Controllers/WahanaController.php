<?php

namespace App\Controllers;

use App\Core\Response;
use App\Models\WahanaModel;

class WahanaController
{
    private WahanaModel $wahanaModel;

    public function __construct()
    {
        $this->wahanaModel = new WahanaModel();
    }

    // =====================
    // GET /api/wahana
    // =====================
    public function index(): void
    {
        $kategori = $_GET['kategori'] ?? null;

        $wahana = $kategori
            ? $this->wahanaModel->getByKategori($kategori)
            : $this->wahanaModel->getAll();

        Response::success($wahana, 'Data wahana berhasil diambil');
    }

    // =====================
    // GET /api/wahana/{id}
    // =====================
    public function show(string $id): void
    {
        $wahana = $this->wahanaModel->findById((int)$id);

        if (!$wahana) {
            Response::notFound('Wahana tidak ditemukan');
        }

        Response::success($wahana, 'Detail wahana berhasil diambil');
    }
}