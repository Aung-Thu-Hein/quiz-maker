<?php

namespace App\Traits;

use Core\Http\JsonResponse;
use Core\Http\Response;

trait ApiResponse
{
    public function response(int $status, ?string $message = null, array $data = [])
    {
        $responseData = [
            'status' => $status,
            'message' => $message ?? Response::MESSAGES[$status]
        ];

        if($data) {
            $responseData['data'] = $data;
        }

        (new JsonResponse($status, $responseData))->send();
    }
}
