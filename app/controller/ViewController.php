<?php
namespace App\Controller;

if (!session_id()) {
    @session_start();
}

use Delight\Auth\Auth;
use League\Plates\Engine;
use JasonGrimes\Paginator;
use App\Components\QueryBuilder;
use Tamtamchik\SimpleFlash\Flash;

/**
 * Registration form and main page with pagination
 * Also errors 404 and 405
 */
class ViewController
{
    public function __construct(Engine $engine, QueryBuilder $db, Auth $auth, Flash $flash)
    {
        $this->db = $db;
        $this->auth = $auth;
        $this->engine = $engine;
        $this->flash = $flash;
    }

    /**
     * Registration form
     */
    public function registerForm()
    {
        echo $this->engine->render('page_register');
    }

    /**
     * Login form
     */
    public function loginForm()
    {
        echo $this->engine->render('page_login');
    }

    /**
     * Main page with pagination
     */
    public function users($page = '1')
    {
        $recordsPerPage = 6;
        $totalUsers = $this->db->rowsCount('users_data');

        $statusToClass = [
            'afk' => 'warning',
            'busy' => 'danger',
            'online' => 'success'
        ];

        // only authorized admin can see "Create user" button
        $isUserAdmin = ($this->auth->isLoggedIn()) && 
            ($this->auth->admin()->doesUserHaveRole($this->auth->getUserId(), \Delight\Auth\Role::ADMIN));

        // To determine the visibility of profile options
        $currentUserId = $this->auth->isLoggedIn() ? $this->auth->getUserId() : null;

        $usersForPage = $this->db->selectPage('users_data', $recordsPerPage, $page);

        $this->paginator = new Paginator($totalUsers, $recordsPerPage, $page, '(:num)');

        echo $this->engine->render('users', [
            'usersForPage' => $usersForPage,
            'statusToClass' => $statusToClass,
            'isUserAdmin' => $isUserAdmin,
            'currentUserId' => $currentUserId,
            'paginator' => $this->paginator,
            'flash' => $this->flash
        ]);
    }

    public function error404()
    {
        echo $this->engine->render('404');
    }

    public function error405()
    {
        echo $this->engine->render('405');
    }
}