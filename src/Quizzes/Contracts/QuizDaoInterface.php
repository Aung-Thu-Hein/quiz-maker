<?php

namespace App\Quizzes\Contracts;

use Core\DB;

interface QuizDaoInterface
{
    public function all(): array;

    public function show(int $id): array;

    public function create(array $data): DB;

    public function update(int $id, array $data): DB;

    public function patch(int $id, array $data): DB;

    public function delete(int $id): bool;
}
