<?php

namespace App\Interfaces;

use GuzzleHttp\Client;

interface WebCrawlerInterface
{
    public function setHttpClient(Client $client): void;

    public function crawlPage(string $url): string;

    public function crawlScreenshot(string $url): string;
}
