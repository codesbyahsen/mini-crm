<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait AjaxResponse
{
    /**
     * Sends the success response
     */
    public function success(string $message, mixed $data = [], int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return new JsonResponse(['success' => true, 'message' => $message, 'data' => $data], $statusCode);
    }

    /**
     * Sends the error response
     */
    public function error(string $messageKey, int $statusCode = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return new JsonResponse(['success' => false, 'message' => self::errorMessages()[$messageKey]], $statusCode);
    }

    /**
     * return error messages
     */
    public static function errorMessages()
    {
        return [
            'not_found' => 'The data you are requesting, not found',
            'not_found_update' => 'The data you are requesting to update, not found',
            'not_found_delete' => 'The data you are requesting to delete, not found',
            'failed_query' => 'The database not responed, failed to create employee, try again!'
        ];
    }
}
