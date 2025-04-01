<?php

namespace App\Users\Services;

use App\Users\Contracts\UserDaoInterface;
use App\Users\Contracts\UserServiceInterface;
use App\Users\Models\User;
use Core\Http\Request;

class UserService implements UserServiceInterface
{
    public function __construct(
        protected UserDaoInterface $userDao,
        protected User $user
    ){}

    public function buildUser(Request $request): void
    {
        $attributes = $request->getAttributes();

        $this->user->setFirstName($attributes['firstName']);
        $this->user->setLastName($attributes['lastName'] ?? null);
        $this->user->setEmail($attributes['email']);
        $this->user->setPassword($attributes['password']);
    }

    public function createUser(): User
    {
        $createdUser = $this->userDao->create([
            'first_name' => $this->user->getFirstName(),
            'last_name' => $this->user->getLastName(),
            'email' => $this->user->getEmail(),
            'password' => password_hash($this->user->getPassword(), PASSWORD_BCRYPT)
        ]);

        $this->user->setId($createdUser->lastInsertId());
        return $this->user;
    }

    public function getUserByEmail(string $email): array|false
    {
        $user = $this->userDao->getByEmail($email);

        if(!$user) {
            return false;
        }

        return $this->map($user);
    }

    public function map(array $user): array
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
