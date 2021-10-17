<?php
namespace App\Controller;

if (!session_id()) {
    session_start();
}

use Delight\Auth\Auth;
use App\Components\QueryBuilder;
use App\Model\User;
use League\Plates\Engine;
use Tamtamchik\SimpleFlash\Flash;

/**
 * Forms and handlers for editing user information
 */
class UserController
{
    public function __construct(
        Auth $auth,
        QueryBuilder $db,
        Engine $engine, 
        User $userOps, 
        Flash $flash
        ) {
        $this->db = $db;
        $this->auth = $auth;
        $this->engine = $engine;
        $this->userOps = $userOps;
        $this->flash = $flash;
    }

    /**
     * User profile
     */
    public function profile()
    {
        $user = $this->db->getOne('users_data', $_GET['id']);
        echo $this->engine->render('page_profile', ['user' => $user]);
    }

    /**
     * Form with user contacts
     */
    public function contactsForm()
    {
        $this->checkPermissions();

        $id = $_GET['id'];

        $user = $this->db->getOne('users_data', $id);
        echo $this->engine->render('edit_contacts', ['user' => $user]);
    }

    /**
     * Edit contacts handler
     */
    public function editContacts()
    {
        $this->checkPermissions();

        $id = $_POST['id'];

        if ($this->userOps->editContacts($id)) {
            $this->flash->success('Contacts updated.');
        } else {
            $this->flash->error('Unable to update contacts.');
        }

        header('Location: /');
        exit;
    }

    /**
     * Form with user info
     * username, job, phone, address
     */
    public function userInfo()
    {
        $this->checkPermissions();

        $id = $_GET['id'];
        $user = $this->db->getOne('users_data', $id);

        echo $this->engine->render('edit', ['user' => $user]);
    }

    /**
     * Edit user info handler
     */
    public function editUserInfo()
    {
        $this->checkPermissions();

        $id = $_POST['id'];
        if ($this->userOps->editUserData($id)) {
            $this->flash->success('User info updated.');
        } else {
            $this->flash->error('Failed to update user info.');
        }

        header('Location: /');
        exit;
    }

    /**
     * Form with user status
     */
    public function statusForm()
    {
        $this->checkPermissions();

        $id = $_GET['id'];
        $currentStatus = $this->db->getFieldById('users_data', 'status', $id);

        $statusToDescription = [
            'online' => 'Онлайн',
            'afk' => 'Отошел',
            'busy' => 'Не беспокоить'
        ];

        echo $this->engine->render('status', [
            'currentStatus' => $currentStatus,
            'statusToDescription' => $statusToDescription
        ]);
    }

    /**
     * Set user status handler
     */
    public function setStatus()
    {
        $this->checkPermissions();

        $id = $_GET['id'];

        if ($this->userOps->setStatus($id)) {
            $this->flash->success('Status changed');
        } else {
            $this->flash->error('Unable to change status.');
        }

        header('Location: /');
        exit;
    }

    /**
     * Form for upload avatar
     */
    public function mediaForm()
    {
        $this->checkPermissions();

        $id = $_GET['id'];
        $user = $this->db->getOne('users_data', $id);

        echo $this->engine->render('media', ['user' => $user]);
    }

    /**
     * Upload avatar handler
     */
    public function uploadAvatar()
    {
        $this->checkPermissions();

        $id = $_GET['id'];

        if ($this->userOps->uploadAvatar($id)) {
            header("Location: /mediapage?id={$id}");
            exit;

        } else {
            $this->flash->error('Unable to upload avatar.');
            header('Location: /');
            exit;
        }
    }

    /**
     * Form where user can change email and password
     */
    public function securityForm()
    {
        $this->checkPermissions();

        $id = $_GET['id'];
        $user = $this->db->getOne('users_data', $id);

        echo $this->engine->render('security', ['user' => $user]);
    }

    /**
     * Email and password update handler
     */
    public function updateCredentials()
    {
        $this->checkPermissions();

        $id = $_GET['id'];

        if ($this->userOps->updateSecurity($id)) {
            $this->flash->success('Email and password updated');
        } else {
            $this->flash->error('Unable to update email and password');
        }

        header('Location: /');
        exit;
    }

    /**
     * Check if user has permissions to this form or action
     */
    private function checkPermissions()
    {
        $userId = $_GET['id'] ?? $_POST['id'];

        $permissions = ($this->auth->isLoggedIn()) &&
        ($this->auth->getUserId() == $userId || $this->auth->hasRole(\Delight\Auth\Role::ADMIN));

        if (!$permissions) {
            $this->flash->warning("Access denied.");
            header('Location: /');
            exit;
        }
    }
}