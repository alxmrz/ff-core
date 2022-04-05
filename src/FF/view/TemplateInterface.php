<?php

namespace FF\view;

interface TemplateInterface
{
    public function render(string $templatePath, array $data = []): string;
    public function setTemplatePath(string $templatePath): void;
}