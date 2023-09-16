<?php

namespace App\Http\Controllers;

use App\Models\Http\Request\crawlerRequest;
use App\Models\Http\Request\searchRequest;
use App\Services\CrawlerService;
use Exception;

class CrawlerController extends Controller
{
    protected CrawlerService $crawlerService;

    public function __construct(CrawlerService $crawlerService)
    {
        $this->crawlerService = $crawlerService;
    }

    public function index()
    {
        return view('crawler.crawler');
    }

    public function crawl(CrawlerRequest $request)
    {
        try {
            $url = $request->input('url');

            $crawledResult = $this->crawlerService->crawl($url);

            return view('crawler.crawler', ['crawledResult' => $crawledResult]);
        } catch (Exception $e) {
            return view('crawler.crawler')->with('exception', $e->getMessage());
        }
    }

    public function crawledRecords()
    {
        $crawledRecords = $this->crawlerService->getRecords();

        return view('crawler.crawledRecords', ['crawledRecords' => $crawledRecords]);
    }

    public function searchRecords(SearchRequest $request)
    {
        $query = $request->input('query');

        $results = $this->crawlerService->queryRecord($query);

        return view('crawler.crawledRecords', ['crawledRecords' => $results]);
    }
}
