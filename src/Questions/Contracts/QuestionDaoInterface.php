<?php

namespace App\Questions\Contracts;

use Core\DB;

interface QuestionDaoInterface
{
    public function all(int $quiz_id): array;

    public function show(int $id): array;

    public function create(array $data): DB;

    public function createMultiple(int $quiz_id, array $data): DB;

    public function update(int $id, array $data): DB;

    public function patch(int $id, array $data): DB;

    public function delete(int $id): bool;
}
