<?php

namespace App\Interfaces;

use DOMDocument;
use DOMXPath;

interface HtmlParserInterface
{
    public function loadHtmlContent(string $htmlContent): void;

    public function getXPath(): DOMXPath;
}
