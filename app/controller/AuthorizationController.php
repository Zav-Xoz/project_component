<?php
namespace App\Controller;

use Delight\Auth\Auth;
use League\Plates\Engine;
use App\Components\QueryBuilder;
use Tamtamchik\SimpleFlash\Flash;

/**
 * Login and logout
 */
class AuthorizationController
{
    public function __construct(Auth $auth, QueryBuilder $db, Engine $engine, Flash $flash)
    {
        $this->db = $db;
        $this->auth = $auth;
        $this->flash = $flash;
        $this->engine = $engine;
    }

    public function login()
    {
        if ($_POST['rememberme'] == "on") {
            // keep logged in for one year
            $rememberDuration = (int) (60 * 60 * 24 * 365.25);
        } else {
            // do not keep logged in after session ends
            $rememberDuration = null;
        }

        try {
            $this->auth->login($_POST['email'], $_POST['password'], $rememberDuration);
            header('Location: /');
            exit;
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            $this->flash->error('Wrong email address.');
            header("Location: /login");
            exit;
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            $this->flash->error('Wrong password.');
            header("Location: /login");
            exit;
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            $this->flash->error('Email not verified.');
            header("Location: /login");
            exit;
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            $this->flash->error('Too many attempts. Try again later.');
            header("Location: /login");
            exit;
        }
    }

    public function logout()
    {
        $this->auth->logOut();
        echo $this->engine->render('page_login');
    }

    /**
     * Current logged in user gets Admin role
     * FOR TEST PUSPOSE ONLY
     */
    public function becameAdmin()
    {
        try {
            $username = $this->auth->getUsername();
            $this->auth->admin()->addRoleForUserById($this->auth->getUserId(), \Delight\Auth\Role::ADMIN);
            $this->flash->info("User '$username' is ADMIN now. I hope you know what you doing ;)");

            header('Location: /');
            exit;

        } catch (\Delight\Auth\UnknownIdException $e) {
            die('Unknown user ID');
        }
    }
}