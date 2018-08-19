<?php
namespace core;

interface TemplateInterface
{
    public function render(string $templatePath, array $data = []);
}