<?php 

namespace App\Repositories\Event;

interface EventRepositoryInterface {
    public function getAll($limit);
}