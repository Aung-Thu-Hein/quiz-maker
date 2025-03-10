<?php

namespace App\Quizzes\DAOs;

use App\Quizzes\Contracts\QuizDaoInterface;
use Core\DB;

class QuizDao implements QuizDaoInterface
{

    public function __construct(private DB $db)
    {
        //
    }

    public function create(array $data): DB
    {
        $query = 'INSERT INTO quizzes (name, is_used_same_score, question_type) VALUES (:name, :is_used_same_score, :question_type)';
        return $this->db->run($query, $data);
    }
}
