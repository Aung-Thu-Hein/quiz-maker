<?php

namespace App\Questions\Contracts;

use Core\DB;

interface QuestionDaoInterface
{
    public function create(array $data): DB;
}
