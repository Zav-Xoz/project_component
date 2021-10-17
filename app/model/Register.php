<?php
namespace App\Model;

use \PDO;
use \Delight\Auth\Auth;
use \App\Components\QueryBuilder;

/**
 * Register and delete user
 */
class Register
{
    public function __construct(Auth $auth, QueryBuilder $db)
    {
        $this->auth = $auth;
        $this->db = $db;
    }

    /**
     * Register new user
     * @return int|bool - user ID if success OR false 
     */
    public function newUser()
    {
        try {
            $userId = $this->auth->register($_POST['email'], $_POST['password']);

            // If user registered, fill the 'users_data' table
            if ($userId) {
                $this->db->insert(['id' => $userId, 'email' => $_POST['email']], 'users_data');

                return $userId;
            }

            return false;
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            $this->flash->error('Invalid email address.');
            header('Location: /registration');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            $this->flash->error('Invalid password.');
            header('Location: /registration');
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            $this->flash->error('User already exists.');
            header('Location: /registration');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }

    /**
     * Delete user by id
     * @param int $id - User ID
     * @return bool - Success of delete
     */
    public function deleteById($id)
    {
        $ud_deleted = $this->db->delete('users_data', $id);
        $u_deleted = $this->db->delete('users', $id);
        $ur_deleted = $this->db->deleteByField('users_remembered', 'user', $id);

        return ($ud_deleted && $u_deleted && $ur_deleted);
    }
}