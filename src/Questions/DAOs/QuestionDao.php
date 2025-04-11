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

    public function all(int $quiz_id): array
    {
        $query = 'SELECT * FROM questions WHERE quiz_id = :quiz_id';
        return $this->db->run($query, ['quiz_id' => $quiz_id])->all();
    }

    public function show(int $id, int $quiz_id): false|array
    {
        $query = 'SELECT * FROM questions WHERE id = :id AND quiz_id = :quiz_id';
        return $this->db->run($query, [
            'id' => $id, 'quiz_id' => $quiz_id
        ])->find();
    }

    public function create(array $data): DB
    {
        $query = 'INSERT INTO questions (quiz_id, body, options, solution, score) VALUES (:quiz_id, :body, :options, :solution, :score)';
        return $this->db->run($query, $data);
    }

    public function createMultiple(int $quiz_id, array $data): DB
    {
        $query = 'INSERT INTO questions (quiz_id, body, options, solution, score) VALUES ';

        $placeholders = [];
        $values = [];

        foreach($data as $question){
            $placeholders[] = "(?, ?, ?, ?, ?)";

            //store in sequential order
            $values[] = $quiz_id;
            $values[] = $question['body'];
            $values[] = json_encode($question['options']);
            $values[] = json_encode($question['solution']);
            $values[] = $question['score'];
        }

        $query .= implode(', ', $placeholders);
        return $this->db->run($query, $values);
    }

    public function update(int $id, int $quiz_id, array $data): DB
    {
        $query = 'UPDATE questions SET quiz_id = :quiz_id, body = :body, options = :options, solution = :solution, score = :score WHERE id = :id';
        $data['id'] = $id;
        $data['quiz_id'] = $quiz_id;
        return $this->db->run($query, $data);
    }

    public function patch(int $id, array $data): DB
    {
        $fields = [];
        foreach($data as $key => $value) {
            $fields[] = "$key = :$key";
        }

        $query = 'UPDATE questions SET ' . implode(', ', $fields) . ' WHERE id = :id';
        $data['id'] = $id;
        return $this->db->run($query, $data);
    }

    public function delete(int $id): bool
    {
        $query = 'DELETE FROM questions WHERE id = :id';
        $result = $this->db->delete($query, ['id' => $id]);

        return $result > 0;
    }
}
