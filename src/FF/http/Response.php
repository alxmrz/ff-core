<?php

declare(strict_types=1);

namespace FF\http;

use Exception;

class Response implements ResponseInterface
{
    private array $headers = [];
    private string $body = '';

    /**
     * @throws Exception
     */
    public function send(): void
    {
        if (headers_sent()) {
            throw new Exception('Headers are already sent');
        }

        foreach ($this->headers as $header => $value) {
            header("{$header}: {$value}");
        }

        echo $this->body;
    }

    /**
     * @param string $body
     * @return Response
     */
    public function withBody(string $body): static
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @param mixed $body
     * @return $this
     * @throws Exception
     */
    public function withJsonBody(mixed $body): static
    {
        $this->withBody(json_encode($body, JSON_UNESCAPED_UNICODE))
            ->withHeader('Content-type', 'application/json');

        return $this;
    }

    /**
     * @throws Exception
     */
    public function withHeader(string $header, string $value): static
    {
        if (isset($this->headers[$header])) {
            throw new Exception("Header <{$header}> is already defined!");
        }

        $this->headers[$header] = $value;

        return $this;
    }

    /**
     * @param int $statusCode
     * @return Response
     */
    public function withStatusCode(int $statusCode): static
    {
        http_response_code($statusCode);

        return $this;
    }
}
