<?php

namespace Tests\Unit\Services;

use App\Interfaces\HtmlParserInterface;
use App\Interfaces\WebCrawlerInterface;
use App\Models\CrawledResult;
use App\Services\CrawlerService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrawlerServiceTest extends TestCase
{
    use RefreshDatabase;

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function testCrawlMethodShouldReturnCrawledResultOnSuccess()
    {
        $webCrawler = $this->createMock(WebCrawlerInterface::class);
        $htmlParser = $this->createMock(HtmlParserInterface::class);

        $webCrawler->expects($this->once())
            ->method('crawlPage')
            ->willReturn('<html><head><title>Test Title</title></head><body>Test Body</body></html>');

        $webCrawler->expects($this->once())
            ->method('crawlScreenshot')
            ->willReturn('screenshot.png');

        $htmlParser->expects($this->once())
            ->method('loadHtmlContent');

        $htmlParser->expects($this->any())
            ->method('getXPath')
            ->willReturn(new \DOMXPath(new \DOMDocument()));

        $crawlerService = new CrawlerService($webCrawler, $htmlParser);

        $result = $crawlerService->crawl('https://example.com');

        $this->assertInstanceOf(CrawledResult::class, $result);
    }

    public function testCrawlMethodShouldThrowExceptionOnFailure()
    {
        $webCrawler = $this->createMock(WebCrawlerInterface::class);
        $htmlParser = $this->createMock(HtmlParserInterface::class);

        $webCrawler->expects($this->once())
            ->method('crawlPage')
            ->willThrowException(new \Exception('Crawl failed'));

        $crawlerService = new CrawlerService($webCrawler, $htmlParser);

        $this->expectException(\Exception::class);

        $crawlerService->crawl('https://example.com');
    }

    public function testGetRecordsMethodShouldReturnRecordsOrderedByUpdatedAt()
    {
        $record1 = CrawledResult::factory()->create(['updated_at' => now()]);
        sleep(1); // 等待 1 秒，以確保時間不同
        $record2 = CrawledResult::factory()->create(['updated_at' => now()]);
        sleep(1);
        $record3 = CrawledResult::factory()->create(['updated_at' => now()]);

        $crawlerService = app(CrawlerService::class);
        $records = $crawlerService->getRecords();

        $expectedOrder = [$record3->id, $record2->id, $record1->id];
        $actualOrder = $records->pluck('id')->toArray();
        $this->assertEquals($expectedOrder, $actualOrder);
    }
}
