<?php

namespace App\Helpers;

use App\Helpers\Helpers;

class Helpers
{

    public function NestHtmlArray()
    {
        return $this->NestHtmlArray(inputArray: $outputArray); 
    }

    public function extractHtmlContent()
    {
        $outputArray = HtmlParser::HtmlToArray();
        return HtmlParser::extractHtmlContent(inputArray: $outputArray);
    }
}