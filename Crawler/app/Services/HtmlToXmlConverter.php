<?php

namespace App\Services;

use App\Interfaces\HtmlToXmlConverterInterface;

class HtmlToXmlConverter implements HtmlToXmlConverterInterface
{
    public function convertAndSave(string $htmlContent, string $url): string
    {
        $uniqueXmlFileName = 'xml/' . base64_encode($url) . '.xml';
        $xmlFilePath = public_path($uniqueXmlFileName);

        $xmlRootElement = '<root>' . $htmlContent . '</root>';
        file_put_contents($xmlFilePath, $xmlRootElement);
        return $uniqueXmlFileName;
    }
}
