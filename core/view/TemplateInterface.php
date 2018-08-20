<?php

namespace core\view;

interface TemplateInterface
{
    public function render(string $templatePath, array $data = []);
}