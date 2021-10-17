<?php
namespace App\Controller;

if (!session_id()) {
    @session_start();
}


use Tamtamchik\SimpleFlash\Flash;
use Delight\Auth\Auth;
use App\Model\Register;
use App\Model\User;
use League\Plates\Engine;

/**
 * Operations with user registration
 * creating new user
 * deleting user
 */
class RegisterController
{   
    private $auth = null;
    private $user = null;
    private $flash = null;
    private $engine = null;
    private $register = null;

    public function __construct(
        Auth $auth,
        Flash $flash,
        Register $register,
        Engine $engine,
        User $user
    ) {
        $this->auth = $auth;
        $this->user = $user;
        $this->flash = $flash;
        $this->engine = $engine;
        $this->register = $register;
    }

    /**
     * User registration handler
     */
    public function registerUser()
    {
        if($this->register->newUser()) {
            $this->flash->success('User successfuly registered.');
            echo $this->engine->render('page_login', ['flash' => $this->flash]);
        } else {
            $this->flash->error('Register failed.');
            echo $this->engine->render('page_register', ['flash' => $this->flash]);
        }
    }

    /**
     * Delete user handler
     */
    public function deleteUser()
    {
       $this->checkPermissions();

       $id = $_GET['id'];
       
       if ($this->auth->getUserId() == $id) {
           if ($this->register->deleteById($id)) {
               echo $this->engine->render('page_login', ['flash' => $this->flash]);
               $this->auth->destroySession();
           } else {
               die('User delete failed.');
           }

       } else if ($this->auth->hasRole(\Delight\Auth\Role::ADMIN)) {
           if ($this->register->deleteById($id)) {
               $this->flash->info('User was deleted');
               header('Location: /');
               exit;
           } else {
               die('User delete failed.');
           }
       } 
    }

    /**
     * Form for create user profile
     */
    public function createUserForm()
    {
        $this->checkPermissions();

        echo $this->engine->render('create_user');
    }

    /**
     * Create user handler
     */
    public function createUser()
    {
        $id = $this->register->newUser();
        $ud_updated = $this->user->editUserData($id);
        $status_updated = $this->user->setStatus($id);
        $contacts_updated = $this->user->editContacts($id);
        $avatar_uploaded = $this->user->uploadAvatar($id);

        if ($id && $ud_updated && $status_updated && $contacts_updated && $avatar_uploaded) {
            $this->flash->success('New user created.');
        } else {
            $this->flash->error('Something went wrong');
        }

        header("Location: /");
        exit;
    }

    /**
     * Check is users allowed to this operation
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