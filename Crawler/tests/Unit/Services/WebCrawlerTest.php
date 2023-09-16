<?php

namespace Tests\Unit\Services;

use App\Services\WebCrawler;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Browsershot\Browsershot;
use Tests\TestCase;

class WebCrawlerTest extends TestCase
{
    use RefreshDatabase;

    public function tearDown(): void
    {
        parent::tearDown();

//        Storage::disk('public')->deleteDirectory('screenshots');
    }

    public function testCrawlPageMethodShouldReturnContent()
    {
        $crawler = new WebCrawler();

        $url = 'https://example.com';

        $mockClient = $this->createMock(Client::class);
        $mockClient->expects($this->once())
            ->method('request')
            ->with('GET', $url)
            ->willReturn(new Response(200, [], 'Mocked HTML Content'));

        $crawler->setHttpClient($mockClient);

        $content = $crawler->crawlPage($url);

        $this->assertEquals('Mocked HTML Content', $content);
    }

    public function testCrawlPageThrowsExceptionOnHttpError()
    {
        $crawler = new WebCrawler();

        $url = 'https://example.com';

        $mockClient = $this->createMock(Client::class);
        $mockClient->expects($this->once())
            ->method('request')
            ->with('GET', $url)
            ->willReturn(new Response(404, [], 'Not Found'));

        $crawler->setHttpClient($mockClient);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('HTTP Error: 404');

        $content = $crawler->crawlPage($url);
        $this->assertEquals('Not Found', $content);
    }

    public function testCrawlPageThrowsExceptionOnRequestError()
    {
        $crawler = new WebCrawler();

        $url = 'https://example.com';

        $mockClient = $this->createMock(Client::class);
        $mockClient->expects($this->once())
            ->method('request')
            ->with('GET', $url)
            ->willThrowException(new Exception('Request Failed'));

        // 將 Mocked Client 注入到 WebCrawler 實例中
        $crawler->setHttpClient($mockClient);

        // 預期應該拋出 Exception
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Request Error: Request Failed');

        // 呼叫 crawlPage 方法
        $crawler->crawlPage($url);
    }

    public function testCrawlScreenshotMethodShouldReturnScreenshotPath()
    {
        $browsershotMock = $this->createMock(Browsershot::class);

        $browsershotMock->willReturnCallback(function ($url) {
                return 'screenshots/' . base64_encode($url) . '.png';
            });

        $this->app->instance(Browsershot::class, $browsershotMock);

        $crawler = app(WebCrawler::class);

        $url = 'https://example.com';
        $screenshotPath = $crawler->crawlScreenshot($url);

        $this->assertEquals('screenshots/' . base64_encode($url) . '.png', $screenshotPath);
    }
}
