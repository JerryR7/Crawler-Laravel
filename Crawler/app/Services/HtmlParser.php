<?php

namespace App\Services;

use App\Interfaces\HtmlParserInterface;
use DOMDocument;
use DOMXPath;

class HtmlParser implements HtmlParserInterface
{
    protected DOMDocument $dom;
    protected DOMXPath $xpath;

    public function __construct()
    {
        $this->dom = new DOMDocument();
        libxml_use_internal_errors(true);
    }

    public function loadHtmlContent($htmlContent): void
    {
        $this->dom->loadHTML($htmlContent);
        $this->xpath = new DOMXPath($this->dom);
    }

    public function getXPath(): DOMXPath
    {
        return $this->xpath;
    }
}
