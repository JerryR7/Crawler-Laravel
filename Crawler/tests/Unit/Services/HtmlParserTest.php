<?php

namespace Tests\Unit\Services;

use App\Services\HtmlParser;
use DOMDocument;
use DOMXPath;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HtmlParserTest extends TestCase
{
    use RefreshDatabase;

    private string $htmlContent;

    protected function setUp(): void
    {
        parent::setUp();

        $this->htmlContent = '<html><body><h1>Hello, World!</h1></body></html>';
    }

    public function testInitDOMDocumentMethodShouldReturnDOMDocumentInstance()
    {
        $htmlParser = new HtmlParser();
        $result = $htmlParser->loadHtmlContent($this->htmlContent);

        $this->assertInstanceOf(DOMDocument::class, $result);
    }

    public function testGetXPathMethodShouldReturnDOMXPathInstance()
    {
        $htmlParser = new HtmlParser();
        $htmlParser->loadHtmlContent($this->htmlContent);
        $result = $htmlParser->getXPath();

        $this->assertInstanceOf(DOMXPath::class, $result);
    }
}
