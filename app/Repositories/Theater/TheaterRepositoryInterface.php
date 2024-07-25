<?php

namespace App\Repositories\Theater;

interface TheaterRepositoryInterface {
    public function getAll();
    public function findById($id);
}