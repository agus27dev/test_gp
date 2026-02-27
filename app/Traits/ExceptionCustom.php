<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Exception;

trait ExceptionCustom
{
    use ResultService;

    /**
     * Handle exception and return a standardized error response.
     *
     * @param Exception $exception
     * @param string $message
     * @return $this
     */
    public function exceptionResponse(Exception $exception, string $message = 'Terjadi suatu kesalahan!')
    {
        if ($exception instanceof QueryException) {
            if (isset($exception->errorInfo[1]) && $exception->errorInfo[1] == 1451) {
                return $this->setSuccess(false)
                            ->setMessage('Data masih terpakai di data lain!')
                            ->setCode(400);
            }
        }

        if ($exception instanceof ModelNotFoundException) {
            return $this->setSuccess(false)
                        ->setMessage('Data tidak ditemukan!')
                        ->setCode(404);
        }

        if (config('app.debug')) {
            $errorDetail = (object) [
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTrace(),
            ];

            return $this->setSuccess(false)
                        ->setMessage($exception->getMessage())
                        ->setError($errorDetail)
                        ->setCode(400);
        }

        Log::error($exception->getMessage(), [
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTrace(),
            'url' => request()->fullUrl(),
            'ip' => request()->ip(),
        ]);

        return $this->setSuccess(false)
                     ->setMessage($message)
                     ->setCode(400);
    }
}
