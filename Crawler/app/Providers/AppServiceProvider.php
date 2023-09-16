<?php

namespace App\Providers;

use App\Interfaces\DataStorageInterface;
use App\Interfaces\HtmlParserInterface;
use App\Interfaces\HtmlToXmlConverterInterface;
use App\Interfaces\WebCrawlerInterface;
use App\Services\HtmlParser;
use App\Services\HtmlToXmlConverter;
use App\Services\WebCrawler;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(WebCrawlerInterface::class, WebCrawler::class);
        $this->app->bind(HtmlParserInterface::class, HtmlParser::class);
        $this->app->bind(HtmlToXmlConverterInterface::class, HtmlToXmlConverter::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
    }
}
