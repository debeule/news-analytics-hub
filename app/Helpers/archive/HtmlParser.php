<?php

namespace App\Helpers;

class HtmlParser
{
    public static function HtmlToArray(string $html) : array
    {
        $html = self::CleanHtml(inputString: $html);
        $html = self::RemoveTabs(inputString: $html);

        $htmlArray = [];
        $htmlArray = self::ExplodeHtml(inputString: $html);
        $htmlArray = self::RemoveBrackets(inputArray: $htmlArray);
        $htmlArray = self::TrimArray(inputArray: $htmlArray);
        $htmlArray = self::RemoveEmptyKeys(inputArray: $htmlArray);
        $htmlArray = self::StructureArray(inputArray: $htmlArray);
        $htmlArray = self::MatchTags(inputArray: $htmlArray);       

        return $htmlArray;
    }

    public static function CleanHtml(string $inputString) : string
    {
        return str_replace(["\n", "\t"], '', $inputString);
    }

    public static function RemoveBrackets(array $inputArray): array
    {
        foreach ($inputArray as $i => $value)
        { 
            $inputArray[$i] = str_replace('<', "", $inputArray[$i]);
            $inputArray[$i] = str_replace('>', " content=", $inputArray[$i]);
        }

        return $inputArray;
    }

    public static function ExplodeHtml(string $inputString): array
    {
        $outputArray = explode(">", $inputString);
        $outputArray = explode("<", $inputString);

        foreach ($outputArray as $key => $value) 
        {
            $value = self::RemoveTabs($value);
        }

        return $outputArray;
    }

    public static function RemoveTabs(string $inputString): string
    {
        $inputString = preg_replace('/ {2,}/', ' ', $inputString);

        if (strpos($inputString, '  ') !== false) 
        {
            $inputString = self::RemoveTabs(inputString: $inputString);
        }

        $inputString = trim($inputString);

        return $inputString;
    }

    public static function TrimArray(array $inputArray) : array
    {
        foreach ($inputArray as $key => $value) 
        {
            $inputArray[$key] = trim($value);
        }
        return $inputArray;
    }

    public static function removeEmptyKeys(array $inputArray) : array
    {
        foreach ($inputArray as $key => $value) 
        {
            if ($value == '' || str_contains(strtoupper($value), 'DOCTYPE')) 
            {
                unset($inputArray[$key]);
            }
        }

        $inputArray = array_values($inputArray);
        return $inputArray;
    }

    public static function StructureArray(array $inputArray) : array
    {
        $outputArray = [];

        for ($i=0; $i < count($inputArray); $i++) 
        {
            $attributesArray = [];

            foreach (explode(' ', $inputArray[$i]) as $key => $value) 
            {
                $attributesArray[$key] = $value;
            }

            $outputArray[$i]["tag"] = array_shift($attributesArray);

            foreach ($attributesArray as $key => $value) 
            {
                unset($attributesArray[$key]);
                
                $attribute = explode('=', $value);

                if (isset(explode('=', $value)[1])) 
                {
                    $key = explode('=', $value)[0];
                    $value = explode('=', $value)[1];
                }
                if ($value !== '' && !is_numeric($key) ) 
                {
                    $attributesArray[$key] = $value;
                }
                if (is_numeric($key) && isset($attributesArray["content"])) 
                {
                    $attributesArray["content"] .= " " . $value;
                }
            }
            $outputArray[$i]['attributes'] = $attributesArray;            
        }
        
        return $outputArray;
    }

    
    public static function MatchTags(array $inputArray) : array
    {
        $unclosedTagsArray = [];
        $outputArray = [];

        for ($i = 0; $i < count($inputArray); $i++) 
        {
            $j = count($unclosedTagsArray);

            for ($j > 0; $j--;) 
            { 
                if (isset($unclosedTagsArray[$j]) && $inputArray[$i]["tag"] == "/" . $unclosedTagsArray[$j]["tag"]) 
                {
                    array_push($outputArray, $unclosedTagsArray[$j]);
                    //$outputArray[count($outputArray) - 1]["closingIndex"] = $i;

                    unset($unclosedTagsArray[$j]);
                    $unclosedTagsArray = array_values($unclosedTagsArray);

                    break;
                }
            }
            //$inputArray[$i]["openingIndex"] = $i;
            array_push($unclosedTagsArray, $inputArray[$i]);
        }

        return $outputArray;
    }

    public static function ExtractHtmlContent(array $htmlArray) : array
    {
        foreach ($htmlArray as $key => $value) 
        {
            if (!isset($value["attributes"]["content"]) || isset($value["attributes"]["href"])) 
            {
                unset($htmlArray[$key]);
            }
        }

        $htmlArray = array_values($htmlArray);

        $contentArray = [];

        foreach ($htmlArray as $value) 
        {
            array_push($contentArray, $value["attributes"]["content"]);
        }

        return $contentArray;
    }

    public static function HtmlContentToString(array $contentArray) : string
    {
        $outputString = "";

        foreach ($contentArray as $value) 
        {
            $outputString .= $value . "\n";
        }

        return $outputString;
    }
}