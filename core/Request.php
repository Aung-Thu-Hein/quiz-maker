<?php

namespace Core;

class Request
{
    protected string $uri;
    protected string $path;
    protected string $method;
    protected array $attributes;

    public function __construct()
    {
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->path = parse_url($this->uri)['path'];
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        $this->attributes = json_decode(file_get_contents('php://input'), true) ?? [];
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function addAttribute(mixed $value): void
    {
        $this->attributes[] = $value;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
