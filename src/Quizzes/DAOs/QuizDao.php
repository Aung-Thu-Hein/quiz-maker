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

    public function all()
    {
        $query = 'SELECT * FROM products';
        $stmt = $this->db->query($query);
        return $stmt->fetchAll();
    }
}
