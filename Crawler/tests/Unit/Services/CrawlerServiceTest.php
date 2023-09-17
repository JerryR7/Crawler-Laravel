<?php

namespace Tests\Unit\Services;

use App\Interfaces\HtmlParserInterface;
use App\Interfaces\HtmlToXmlConverterInterface;
use App\Interfaces\WebCrawlerInterface;
use App\Models\CrawledResult;
use App\Services\CrawlerService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrawlerServiceTest extends TestCase
{
    use RefreshDatabase;

    private $webCrawler;
    private $htmlParser;
    private $htmlToXmlConverter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->webCrawler = $this->createMock(WebCrawlerInterface::class);
        $this->htmlParser = $this->createMock(HtmlParserInterface::class);
        $this->htmlToXmlConverter = $this->createMock(HtmlToXmlConverterInterface::class);
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function testCrawlMethodShouldReturnCrawledResultOnSuccess()
    {
        $this->webCrawler->expects($this->once())
            ->method('crawlPage')
            ->willReturn('<html><head><title>Test Title</title></head><body>Test Body</body></html>');

        $this->webCrawler->expects($this->once())
            ->method('crawlScreenshot')
            ->willReturn('screenshot.png');

        $this->htmlParser->expects($this->once())
            ->method('loadHtmlContent');

        $this->htmlParser->expects($this->any())
            ->method('getXPath')
            ->willReturn(new \DOMXPath(new \DOMDocument()));

        $htmlToXmlConverter = $this->createMock(HtmlToXmlConverterInterface::class);
        $crawlerService = new CrawlerService($this->webCrawler, $this->htmlParser, $htmlToXmlConverter);

        $result = $crawlerService->crawl('https://example.com');

        $this->assertInstanceOf(CrawledResult::class, $result);
    }

    public function testCrawlMethodShouldThrowExceptionOnFailure()
    {
        $this->webCrawler->expects($this->once())
            ->method('crawlPage')
            ->willThrowException(new \Exception('Crawl failed'));

        $crawlerService = new CrawlerService($this->webCrawler, $this->htmlParser, $this->htmlToXmlConverter);

        $this->expectException(\Exception::class);

        $crawlerService->crawl('https://example.com');
    }

    public function testGetRecordsMethodShouldReturnRecordsOrderedByUpdatedAt()
    {
        $record1 = CrawledResult::factory()->create(['updated_at' => now()]);
        sleep(1);
        $record2 = CrawledResult::factory()->create(['updated_at' => now()]);
        sleep(1);
        $record3 = CrawledResult::factory()->create(['updated_at' => now()]);

        $crawlerService = app(CrawlerService::class);
        $records = $crawlerService->getRecords();

        $expectedOrder = [$record3->id, $record2->id, $record1->id];
        $actualOrder = $records->pluck('id')->toArray();
        $this->assertEquals($expectedOrder, $actualOrder);
    }

    public function testQueryRecordMethodShouldReturnMatchingRecords()
    {
        $record1 = CrawledResult::factory()->create(['title' => 'Test Title 1']);
        $record2 = CrawledResult::factory()->create(['title' => 'Test Title 2']);
        $record3 = CrawledResult::factory()->create(['title' => 'Another Title']);

        $crawlerService = app(CrawlerService::class);
        $results = $crawlerService->queryRecord('Test Title');

        $this->assertCount(2, $results);
        $this->assertEquals([$record1->id, $record2->id], $results->pluck('id')->toArray());
    }
}
