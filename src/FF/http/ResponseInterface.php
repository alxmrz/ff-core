<?php

namespace FF\http;

interface ResponseInterface
{
    public function send(): void;
    public function withBody(string $body): static;
    public function withJsonBody(mixed $body): static;
    public function withHeader(string $header, string $value): static;
    public function withStatusCode(int $statusCode): static;
}