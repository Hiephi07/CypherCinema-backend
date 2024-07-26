<?php

namespace App\Repositories\Theater;

interface TheaterRepositoryInterface {
    public function getAll();
    public function findById($id);
    public function create($data);
    public function update($data, $id);
    public function delete($id);
}