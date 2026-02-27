<?php

namespace App\Traits;

trait ResultService
{
    use Response;

    private $result = null;
    private bool $isSuccess = false;
    private ?string $message = null;
    private int $code = 200;
    private $error = null;

    /**
     * Set the result data.
     *
     * @param mixed $result
     * @return $this
     */
    public function setResult($result): self
    {
        $this->result = $result;
        return $this;
    }

    /**
     * Get the result data.
     *
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set the success status.
     *
     * @param bool $isSuccess
     * @return $this
     */
    public function setSuccess(bool $isSuccess): self
    {
        $this->isSuccess = $isSuccess;
        return $this;
    }

    /**
     * Check if the operation was successful.
     *
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->isSuccess;
    }

    /**
     * Set the response message.
     *
     * @param string $message
     * @return $this
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Get the response message.
     *
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * Set the HTTP status code.
     *
     * @param int $code
     * @return $this
     */
    public function setCode(int $code): self
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Get the HTTP status code.
     *
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * Set the error data.
     *
     * @param mixed $error
     * @return $this
     */
    public function setError($error): self
    {
        $this->error = $error;
        return $this;
    }

    /**
     * Get the error data.
     *
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Return a standardized JSON response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function json()
    {
        return response()->json([
            'success' => $this->isSuccess,
            'code' => $this->code,
            'message' => $this->message,
            'error' => $this->error,
            'data' => $this->result,
        ], $this->code);
    }
}
