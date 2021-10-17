<?php
namespace App\Model;

use \App\Components\QueryBuilder;
use Delight\Auth\Auth;
use \Tamtamchik\SimpleFlash\Flash;


class User
{   
    /**
     * Database
     * @var QueryBuilder
     */
    private $db = null;

    /**
     * For changing user status
     * @var array
     */
    private $descriptionToStatus = [
        'Онлайн' => 'online',
        'Отошел' => 'afk',
        'Не беспокоить' => 'busy'
    ];

    public function __construct(QueryBuilder $db, Auth $auth, Flash $flash)
    {
        $this->db = $db;
        $this->auth = $auth;
        $this->flash = $flash;
    }

    /**
     * Updating user data
     * @param int $userId = 0
     * @return bool - Is update successful
     */
    public function editUserData($userId = 0)
    {
        $id = $_POST['id'] ?? $userId;
        $ud_updated = $this->db->update([
            'job' => $_POST['job'],
            'phone' => $_POST['phone'],
            'address' => $_POST['address'],
            'username' => $_POST['username']

        ], $id, 'users_data');

        $u_updated = $this->db->update(['username' => $_POST['username']], $id, 'users');

        return $ud_updated && $u_updated;
    }

    /**
     * Set user status by ID
     * @param int $id - User ID
     * @return bool - Is status updated
     */
    public function setStatus($id)
    {
        $status = $this->descriptionToStatus[$_POST['status']];
        $data_updated = $this->db->update(['status' => $status], $id, 'users_data');

        return $data_updated;
    }

    /**
     * Update user contacts by ID
     * @param int $id - User ID
     * @return bool - Is update successful
     */
    public function editContacts($userId = 0)
    {
        $id = $_POST['id'] ?? $userId;
        $vk = $_POST['vk'] ?? '';
        $telegram = $_POST['telegram'] ?? '';
        $instagram = $_POST['instagram'] ?? '';

        $data_updated = $this->db->update([
            'vk' => $vk,
            'telegram' => $telegram,
            'instagram' => $instagram
        ], $id, 'users_data');

        return $data_updated;
    }

    /**
     * Upload new user avatar
     * @param int $id - User ID
     * @return bool - Is uploaded
     */
    public function uploadAvatar($id)
    {
        $relativeDir = 'upload/avatars';
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/' . $relativeDir;
        $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);


        $newFileName = uniqid();
        $uploadPath = $uploadDir . '/' . $newFileName . '.' . $extension;

        $result = move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadPath);
        
        $updated = $this->db->update(['avatar' => $relativeDir . '/' . $newFileName . '.' . $extension], $id, 'users_data');

        return $updated;
    }

    /**
     * Update user credentials
     * uses data from POST array
     * @param int $id - User ID
     * @return bool - Is update successful
     */
    public function updateSecurity($id)
    {
        $email = $_POST['email'];
        $currentPassword = $_POST['old_password'];
        $newPassword = $_POST['new_password'];

        if (!$email) {
            $this->flash->error('Email field cannot be empty.');
            header("Location: /security?id={$id}");
            exit;
        }

        $u_updated = $this->db->update(['email' => $email], $id, 'users');
        $ud_updated = $this->db->update(['email' => $email], $id, 'users_data');

        if (($currentPassword && $newPassword)) {
            if ($this->auth->getUserId() == $id) {
                $this->auth->changePassword($currentPassword, $newPassword);
            } else if ($this->auth->hasRole(\Delight\Auth\Role::ADMIN)) {
                $this->auth->admin()->changePasswordForUserById($id, $newPassword);
            }
        }

        return $u_updated && $ud_updated;
    }
}