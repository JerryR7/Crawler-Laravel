<?php

namespace App\Services;

use App\Interfaces\WebCrawlerInterface;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Spatie\Browsershot\Browsershot;

class WebCrawler implements WebCrawlerInterface
{
    protected Client $client;
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function crawlPage($url): string
    {
        try {
            $response = $this->client->request('GET', $url);

            if ($response->getStatusCode() !== 200) {
                throw new Exception('HTTP Error: ' . $response->getStatusCode());
            }

            return $response->getBody()->getContents();
        } catch (Exception $e) {
            throw new Exception('Request Error: ' . $e->getMessage());
        }
    }

    public function crawlScreenshot($url): string
    {
        $screenshotPath = 'screenshots/' . base64_encode($url) . '.png';
        $screenshotStorePath = public_path($screenshotPath);

        if (!is_dir(public_path('screenshots'))) {
            mkdir(public_path('screenshots'));
        }

        try {
            Browsershot::url($url)
                ->noSandbox()
                ->ignoreHttpsErrors()
                ->setOption('landscape', true)
                ->newHeadless()
                ->windowSize(1024, 768)
                ->waitUntilNetworkIdle()
                ->timeout(60)
                ->save($screenshotStorePath);

            return $screenshotPath;
        } catch (Exception $e) {

            Log::error('截圖失敗: ' . $e->getMessage());
            return 'screenshot_not_found.png';
        }
    }

    public function setHttpClient(Client $client): void
    {
        $this->client = $client;
    }
}
