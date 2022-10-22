<?php
namespace FF\http;

class Response
{
    private string $body;

    /**
     * @param string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function send(): void
    {
        echo $this->body;
    }
}
