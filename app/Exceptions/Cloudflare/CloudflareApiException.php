<?php

namespace App\Exceptions\Cloudflare;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\Pure;

class CloudflareApiException extends Exception
{
    private array $messages = [];
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null, array $messages = [])
    {
        $this->messages = $messages;
        parent::__construct($message, $code, $previous);
    }

    /**
     * Report the exception.
     */
    public function report(): void
    {
        //
    }

    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request $request): Response
    {
        return response([
            'message' => $this->message,
            'error_messages' => $this->messages
        ], $this->code);
    }

    public static function checkIfFails(Collection $result): void
    {
        if (!$result['success']) {
            throw new self($result['errors'][0]['message'], Response::HTTP_UNPROCESSABLE_ENTITY, messages: $result['messages']);
        }
    }
}
