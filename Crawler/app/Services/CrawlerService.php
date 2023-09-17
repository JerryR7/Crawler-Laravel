<?php

namespace App\Services;

use App\Interfaces\HtmlParserInterface;
use App\Interfaces\HtmlToXmlConverterInterface;
use App\Interfaces\WebCrawlerInterface;
use App\Models\CrawledResult;
use Exception;

class CrawlerService
{

    private WebCrawlerInterface $webCrawler;
    private HtmlParserInterface $htmlParser;
    private HtmlToXmlConverterInterface $htmlToXmlConverter;

    public function __construct(WebCrawlerInterface $webCrawler, HtmlParserInterface $htmlParser, HtmlToXmlConverterInterface $htmlToXmlConverter)
    {
        $this->webCrawler = $webCrawler;
        $this->htmlParser = $htmlParser;
        $this->htmlToXmlConverter = $htmlToXmlConverter;
    }

    /**
     * @throws Exception
     */
    public function crawl($url): CrawledResult
    {
        try {
            $conditions = ['url' => $url];

            $htmlContent = $this->webCrawler->crawlPage($url);
            $this->htmlParser->loadHtmlContent($htmlContent);

            $body = $this->htmlParser->getXPath()->evaluate('string(/html/body)');
            $xmlPath = $this->htmlToXmlConverter->convertAndSave($body, $url);

            $data = [
                'url' => $url,
                'screenshot' => $this->webCrawler->crawlScreenshot($url),
                'title' => $this->htmlParser->getXPath()->evaluate('string(//title)'),
                'body' => $xmlPath,
                'description' => $this->htmlParser->getXPath()->evaluate('string(//meta[@name="description"]/@content)'),
            ];

            return CrawledResult::updateOrCreate($conditions, $data);
        } catch (Exception $e) {
            throw new Exception('unexpected error：' . $e->getMessage());
        }
    }

    public function getRecords()
    {
        return CrawledResult::orderBy('created_at', 'desc')->paginate(10);
    }

    public function queryRecord(string $query)
    {
        try {
            return CrawledResult::where('title', 'LIKE', '%' . $query . '%')
                ->orWhere('description', 'LIKE', '%' . $query . '%')
                ->orWhere('body', 'LIKE', '%' . $query . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } catch (Exception $e) {
            throw new Exception('unexpected error：' . $e->getMessage());
        }
    }
}
