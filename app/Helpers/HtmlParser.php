<?php

namespace App\Helpers;

class HtmlParser
{
    public function __construct(protected string $html, protected array $outputArray = [])
    {
        $outputArray = $this->HtmlToArray();
    }
    
    public function HtmlToArray()
    {
        $this->html = $this->CleanHtml(inputString: $this->html);
        $this->html = $this->RemoveTabs(inputString: $this->html);

        $outputArray = [];
        $outputArray = $this->ExplodeHtml(inputString: $this->html);
        $outputArray = $this->RemoveBrackets(outputArray: $outputArray);
        $outputArray = $this->TrimArray(inputArray: $outputArray);
        $outputArray = $this->RemoveEmptyKeys(inputArray: $outputArray);
        $outputArray = $this->StructureArray(inputArray: $outputArray);
        $outputArray = $this->MatchTags(inputArray: $outputArray);       

        return $outputArray;
    }

    public function CleanHtml(string $inputString) : string
    {
        return str_replace(["\n", "\t"], '', $inputString);
    }

    public function RemoveBrackets(array $outputArray): array
    {
        for ($i=0; $i < count($outputArray); $i++) 
        { 
            $this->outputArray[$i] = str_replace('<', "", $outputArray[$i]);
            $this->outputArray[$i] = str_replace('>', " content=", $outputArray[$i]);
        }

        return $outputArray;
    }

    public function ExplodeHtml(string $inputString): array
    {
        $outputArray = explode(">", $inputString);
        $outputArray = explode("<", $inputString);

        foreach ($outputArray as $key => $value) 
        {
            $value = $this->RemoveTabs($value);
        }

        return $outputArray;
    }

    public function RemoveTabs(string $inputString): string
    {
        $inputString = preg_replace('/ {2,}/', ' ', $inputString);

        if (strpos($inputString, '  ') !== false) 
        {
            $inputString = self::RemoveTabs(inputString: $inputString);
        }

        $inputString = trim($inputString);

        return $inputString;
    }

    public function TrimArray(array $inputArray) : array
    {
        foreach ($inputArray as $key => $value) 
        {
            $inputArray[$key] = trim($value);
        }
        return $inputArray;
    }

    public function removeEmptyKeys(array $inputArray) : array
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

    public function StructureArray(array $inputArray) : array
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

            //foreach attribute in attributes array explode op = key value pair
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

    
    public function MatchTags(array $inputArray) : array
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
                    $outputArray[count($outputArray) - 1]["closingIndex"] = $i;

                    unset($unclosedTagsArray[$j]);
                    $unclosedTagsArray = array_values($unclosedTagsArray);

                    break;
                }
            }
            $inputArray[$i]["openingIndex"] = $i;
            array_push($unclosedTagsArray, $inputArray[$i]);
        }

        return $outputArray;
    }

    public function NestHtmlArray(array $inputArray) : array
    {
        $outputArray = [];

        foreach ($inputArray as $key => $value) 
        {
            for ($i = 0; $i < count($outputArray); $i++)
            {
                //if in between any other key's opening and closing index
                if ($value["openingIndex"] > $outputArray[$i]["openingIndex"] && $value["closingIndex"] < $outputArray[$i]["closingIndex"]) 
                {
                    array_push($outputArray[$i]["children"], $value);
                    break;
                }

                //if not in between any other key's opening and closing index && smaller
                if ($value["openingIndex"] < $outputArray[$i]["openingIndex"] && $value["closingIndex"] < $outputArray[$i]["closingIndex"]) 
                {
                    array_unshift($outputArray, $value);
                    break;
                }

                //if not in between any other key's opening and closing index && smaller
                if ($value["openingIndex"] > $outputArray[$i]["openingIndex"] && $value["closingIndex"] > $outputArray[$i]["closingIndex"]) 
                {
                    array_push($outputArray, $value);
                    break;
                }
            }

            if (!isset($outputArray[0])) 
            {
                array_push($outputArray, $value);
            }
        }

        return $outputArray;
    }
}



// public function MatchTags(array $inputArray) : array
// {

//     $i = 0;
//     $arrayLength = count($inputArray);

//     while ($i < $arrayLength) 
//     {
//         if (isset($inputArray[$i + 1]) && "/" . $inputArray[$i]["tag"] == $inputArray[$i + 1]["tag"]) 
//         {
//             unset($inputArray[$i + 1]);
//             $inputArray = array_values($inputArray);
//             $arrayLength--;
//         }

//         $i++;
//     }

//     return $inputArray;
// }