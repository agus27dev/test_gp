<?php

namespace App\Traits;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

trait Response
{
    /**
     * Return a JSON response.
     *
     * @param mixed $data
     * @param string $message
     * @param bool $status
     * @param int|null $code
     * @return JsonResponse
     */
    public function responseJson($data = [], string $message = 'Sukses', bool $status = true, ?int $code = null): JsonResponse
    {
        $httpCode = $code ?? ($status ? 200 : 400);

        return response()->json([
            'status' => $status,
            'code' => $httpCode,
            'message' => $message,
            'data' => $data,
        ], $httpCode);
    }

    /**
     * Return a view response.
     *
     * @param string $view
     * @param array $data
     * @return View
     */
    public function responseView(string $view, array $data = []): View
    {
        return view($view, $data);
    }
}
