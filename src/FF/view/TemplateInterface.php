<?php

namespace FF\view;

interface TemplateInterface
{
    public function render(string $templatePath, array $data = []);
    public function setTemplatePath(string $templatePath);
}