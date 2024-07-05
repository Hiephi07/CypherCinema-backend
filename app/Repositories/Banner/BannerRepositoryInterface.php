<?php 

namespace App\Repositories\Banner;

interface BannerRepositoryInterface {
    public function getAll();
    public function getByType($type);
}