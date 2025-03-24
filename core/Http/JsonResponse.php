<?

namespace Core\Http;

class JsonResponse extends Response
{
    public function __construct(int $statusCode, array $data = [])
    {
        parent::__construct();
        $this->setHeaders('Content-Type', 'application/json');
        $this->setStatusCode($statusCode);
        $this->setMessage(self::MESSAGES[$statusCode]);
        $this->setBody($data);
    }

    public function setBody(mixed $body): self
    {
        if (!is_array($body) && !is_object($body)) {
            throw new \InvalidArgumentException('JSON response body must be an array or object.');
        }
        $this->body = json_encode($body, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        return $this;
    }

    public function send(): void
    {
        parent::send();
    }
}
