<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * Success response
     */
    public static function success(string $message = 'Success', $data = null, int $statusCode = 200): JsonResponse
    {
        $response = [
            'status' => true,
            'message' => $message,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Error response
     */
    public static function error(string $message = 'Error', $errors = null, int $statusCode = 400): JsonResponse
    {
        $response = [
            'status' => false,
            'message' => $message,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Validation error response
     */
    public static function validationError($errors, string $message = 'Validation failed'): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'errors' => $errors,
        ], 422);
    }

    /**
     * Not found response
     */
    public static function notFound(string $message = 'Resource not found'): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
        ], 404);
    }

    /**
     * Unauthorized response
     */
    public static function unauthorized(string $message = 'Unauthorized'): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
        ], 401);
    }

    /**
     * Forbidden response
     */
    public static function forbidden(string $message = 'Forbidden'): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
        ], 403);
    }

    /**
     * Server error response
     */
    public static function serverError(string $message = 'Internal server error'): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
        ], 500);
    }

    /**
     * Created response
     */
    public static function created(string $message = 'Created successfully', $data = null): JsonResponse
    {
        $response = [
            'status' => true,
            'message' => $message,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, 201);
    }

    /**
     * Paginated response
     */
    public static function paginated($data, string $message = 'Data retrieved successfully'): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data->items(),
            'pagination' => [
                'current_page' => $data->currentPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total(),
                'last_page' => $data->lastPage(),
                'from' => $data->firstItem(),
                'to' => $data->lastItem(),
            ],
        ]);
    }
}
