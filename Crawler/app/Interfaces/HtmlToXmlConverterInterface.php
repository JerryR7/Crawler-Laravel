<?php

namespace App\Interfaces;

interface HtmlToXmlConverterInterface
{
    public function convertAndSave(string $htmlContent, string $url): string;
}
