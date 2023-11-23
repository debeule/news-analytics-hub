<?php

namespace App\Helpers;

use App\Helpers\Helpers;
use App\Helpers\HtmlParser;

class Helpers
{
    public static function ExtractHtmlContent(string $html)
    {
        $htmlArray = HtmlParser::HtmlToArray(html: $html);

        $contentArray = HtmlParser::ExtractHtmlContent(htmlArray: $htmlArray);

        $contentString = HtmlParser::HtmlContentToString(contentArray: $contentArray);

        return $contentString;
    }
}