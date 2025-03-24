<?php

namespace Core\Http;

class Response
{
    public const HTTP_OK = 200;
    public const HTTP_CREATED = 201;
    public const HTTP_BAD_REQUEST = 400;
    public const HTTP_UNAUTHORIZED = 401;
    public const HTTP_FORBIDDEN = 403;
    public const HTTP_NOT_FOUND = 404;
    public const HTTP_METHOD_NOT_ALLOWED = 405;
    public const HTTP_UNPROCESSABLE_CONTENT = 422;
    public const HTTP_INTERNAL_SERVER_ERROR = 500;

    public const MESSAGES = [
        self::HTTP_OK => 'OK',
        self::HTTP_CREATED => 'Created',
        self::HTTP_BAD_REQUEST => 'Bad Request',
        self::HTTP_UNAUTHORIZED => 'Unauthorized',
        self::HTTP_FORBIDDEN => 'Forbidden',
        self::HTTP_NOT_FOUND => 'Not Found',
        self::HTTP_METHOD_NOT_ALLOWED => 'Method Not Allowed',
        self::HTTP_UNPROCESSABLE_CONTENT => 'Unprocessable Content',
        self::HTTP_INTERNAL_SERVER_ERROR => 'Internal Server Error'
    ];

    protected string $protocol;
    protected array $headers;
    protected int $statusCode;
    protected string $message;
    protected mixed $body = null;

    public function __construct()
    {
        $this->protocol = $_SERVER['SERVER_PROTOCOL'];
    }

    public function getProtocol()
    {
        return $this->protocol;
    }

    public function setStatusCode(int $code): self
    {
        $this->statusCode = $code;
        return $this;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setHeaders($key, $value): self
    {
        $this->headers[$key] = $value;
        return $this;
    }

    public function getHeaders(): array 
    {
        return $this->headers;
    }

    public function setBody(mixed $body): self 
    {
        $this->body = $body;
        return $this;
    }

    public function getBody(): mixed
    {
        return $this->body;
    }

    public function send(): void
    {
        //send https status
        header($this->protocol . " " . $this->statusCode . " " . $this->message);

        //send headers
        foreach($this->headers as $key => $value){
            header("$key: $value");
        }

        // Send body (JSON-encode if array/object)
        if ($this->body !== null) {
            echo is_array($this->body) || is_object($this->body) ? json_encode($this->body) : $this->body;
        }

        exit;
    }
}
