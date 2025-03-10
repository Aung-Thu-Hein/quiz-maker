<?php

namespace App\Questions\DAOs;

use App\Questions\Contracts\QuestionDaoInterface;
use Core\DB;

class QuestionDao implements QuestionDaoInterface
{

    public function __construct(private DB $db)
    {
        //
    }

    public function create(array $data): DB
    {
        $query = 'INSERT INTO questions (quiz_id, body, options, solution, score) VALUES (:quiz_id, :body, :options, :solution, :score)';
        return $this->db->run($query, $data);
    }
}
