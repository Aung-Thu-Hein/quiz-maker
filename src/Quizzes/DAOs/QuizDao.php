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

    public function all(): array
    {
        $query = 'SELECT * FROM quizzes';
        return $this->db->run($query)->all();
    }

    public function show(int $id): array
    {
        $query = 'SELECT 
            quizzes.id,
            quizzes.name,
            quizzes.is_used_same_score,
            quizzes.question_type,
            quizzes.created_at,
            quizzes.updated_at,
            questions.id AS question_id,
            questions.quiz_id,
            questions.body,
            questions.options,
            questions.solution,
            questions.score,
            questions.created_at AS question_created_at,
            questions.updated_at AS question_updated_at
            FROM quizzes 
            LEFT JOIN questions 
            ON quizzes.id = questions.quiz_id 
            WHERE quizzes.id = :id';
            
        return $this->db->run($query, ['id' => $id])->all();
    }

    public function create(array $data): DB
    {
        $query = 'INSERT INTO quizzes (name, is_used_same_score, question_type) VALUES (:name, :is_used_same_score, :question_type)';
        return $this->db->run($query, $data);
    }

    public function update(int $id, array $data): DB
    {
        $query = 'UPDATE quizzes SET name = :name, is_used_same_score = :is_used_same_score, question_type = :question_type WHERE id = :id';
        $data['id'] = $id;
        return $this->db->run($query, $data);
    }

    public function patch(int $id, array $data): DB
    {
        $fields = [];
        foreach($data as $key => $value) {
            $fields[] = "$key = :$key";
        }

        $query = 'UPDATE quizzes SET ' . implode(', ', $fields) . ' WHERE id = :id';
        $data['id'] = $id;

        return $this->db->run($query, $data);
    }

    public function delete(int $id): bool
    {
        $query = 'DELETE FROM quizzes WHERE id = :id';
        $result = $this->db->delete($query, ['id' => $id]);

        return $result > 0;
    }
}
