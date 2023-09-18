<?php

namespace Tests\Unit\Services;

use App\Services\WebCrawler;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Browsershot\Browsershot;
use Tests\TestCase;

class WebCrawlerTest extends TestCase
{
    use RefreshDatabase;

    private $crawler;
    private $mockClient;
    private $url;
    private $expectedPath;

    public function setUp(): void
    {
        parent::setUp();

        $this->crawler = new WebCrawler();
        $this->url = 'https://example.com';
        $this->expectedPath = 'screenshots/' . base64_encode($this->url) . '.png';

        $this->mockClient = $this->createMock(Client::class);
        $this->crawler->setHttpClient($this->mockClient);
    }

    public function tearDown(): void
    {
        parent::tearDown();

//        Storage::disk('public')->deleteDirectory('screenshots');
    }

    public function testCrawlPageMethodShouldReturnContent()
    {
        $this->mockClient->expects($this->once())
            ->method('request')
            ->with('GET', $this->url)
            ->willReturn(new Response(200, [], 'Mocked HTML Content'));

        $content = $this->crawler->crawlPage($this->url);

        $this->assertEquals('Mocked HTML Content', $content);
    }

    public function testCrawlPageThrowsExceptionOnHttpError()
    {
        $this->mockClient->expects($this->once())
            ->method('request')
            ->with('GET', $this->url)
            ->willReturn(new Response(404, [], 'Not Found'));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('HTTP Error: 404');

        $content = $this->crawler->crawlPage($this->url);

        $this->assertEquals('HTTP Error: 404', $content);
    }

    public function testCrawlPageThrowsExceptionOnRequestError()
    {
        $this->mockClient->expects($this->once())
            ->method('request')
            ->with('GET', $this->url)
            ->willThrowException(new \Exception('Request Failed'));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Request Error: Request Failed');

        $content = $this->crawler->crawlPage($this->url);

        $this->assertEquals('Request Error: Request Failed', $content);
    }

    public function testCrawlScreenshotMethodShouldReturnScreenshotPath()
    {
        $this->instance(Browsershot::class, function () {
            $browsershotMock = $this->createMock(Browsershot::class);
            $browsershotMock->expects($this->once())
                ->method('save')
                ->willReturn($this->expectedPath);
            return $browsershotMock;
        });

        $screenshotPath = $this->crawler->crawlScreenshot($this->url);

        $this->assertEquals($this->expectedPath, $screenshotPath);
    }
}
