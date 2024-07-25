<?php

namespace App\Repositories\User;

use App\Repositories\User\UserRepositoryInterface;
use App\Models\User;
use Exception;

class UserRepository implements UserRepositoryInterface
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAll()
    {
        try {
            return $this->user->all();
        } catch (Exception $e) {
            throw new Exception('Lỗi tìm nạp tất cả users: ' . $e->getMessage());
        }
    }

    public function findById($id)
    {
        try {
            return $this->user->find($id);
        } catch (Exception $e) {
            throw new Exception('Không tìm thấy user: ' . $e->getMessage());
        }
    }

    public function create(array $data)
    {
        try {
            return $this->user->create($data);
        } catch (Exception $e) {
            throw new Exception('Có lỗi khi tạo mới user: ' . $e->getMessage());
        }
    }

    public function update($id, array $data)
    {
        try {
            $user = $this->findById($id);
            if ($user) {
                $user->update($data);
                return $user;
            }
            return null;
        } catch (Exception $e) {
            throw new Exception('Lỗi khi cập nhật user: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $user = $this->findById($id);
            if ($user) {
                $user->delete();
                return true;
            }
            return false;
        } catch (Exception $e) {
            throw new Exception('Lỗi khi xoá user: ' . $e->getMessage());
        }
    }
}
