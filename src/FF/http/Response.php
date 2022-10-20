<?php
namespace FF\http;

class Response
{
    private string $body;

    public function __toString(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }
}
