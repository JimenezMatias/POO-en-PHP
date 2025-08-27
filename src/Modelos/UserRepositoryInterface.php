<?php
namespace App\Modelos;

interface UserRepositoryInterface
{
    public function findByNombre(string $nombre): ?array;

    public function findById(int $id): ?array;
}
