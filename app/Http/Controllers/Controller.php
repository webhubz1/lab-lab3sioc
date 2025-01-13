<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    // Shared properties
    protected $defaultPageSize = 10; // Example: default pagination size

    // Shared methods

    /**
     * Return a paginated response for a given query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|null $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected function paginate($query, $perPage = null)
    {
        $perPage = $perPage ?? $this->defaultPageSize; // Use default if no size provided
        return $query->paginate($perPage);
    }

    /**
     * Handle success responses.
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($message)
    {
        return response()->json(['message' => $message], 200);
    }

    /**
     * Handle error responses.
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($message, $statusCode = 400)
    {
        return response()->json(['error' => $message], $statusCode);
    }
}
