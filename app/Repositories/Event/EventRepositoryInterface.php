<?php 

namespace App\Repositories\Event;

interface EventRepositoryInterface {
    public function getAll($limit);
    public function getEventById($id);
    public function create($data);
    public function update($data, $id);
    public function delete($id);
}