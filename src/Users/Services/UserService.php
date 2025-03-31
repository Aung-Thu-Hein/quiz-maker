<?php

namespace App\Users\Services;

use App\Users\Contracts\UserDaoInterface;
use App\Users\Contracts\UserServiceInterface;
use App\Users\Models\User;
use Core\Http\Request;

class UserService implements UserServiceInterface
{
    protected User $user;

    public function __construct(
        protected UserDaoInterface $userDao
    ){}

    public function buildUser(Request $request)
    {
        $attributes = $request->getAttributes();

        $this->user->setFirstName($attributes['first_name']);
        $this->user->setLastName($attributes['last_name'] ?? null);
        $this->user->setEmail($attributes['email']);
        $this->user->setPassword($attributes['password']);
    }

    public function createUser()
    {
        $createdUser = $this->userDao->create([
            'first_name' => $this->user->getFirstName(),
            'last_name' => $this->user->getLastName(),
            'email' => $this->user->getLastName(),
            'password' => password_hash($this->user->getPassword(), PASSWORD_BCRYPT)
        ]);

        $this->user->setId($createdUser->lastInsertId());
        return $this->user;
    }

    public function getUserByEmail(string $email)
    {
        $user = $this->userDao->getByEmail($email);

        if(!$user) {
            return false;
        }

        return $this->map($user);
    }

    public function map(array $user)
    {
        return [
            'id' => $user['id'],
            'firstName' => $user['first_name'],
            'lastName' => $user['last_name'],
            'email' => $user['email'],
            'createdAt' => $user['created_at'],
            'updatedAt' => $user['updated_at']
        ];
    }
}
