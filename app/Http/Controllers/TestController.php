<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Helpers\Helpers;

class TestController extends Controller
{
    public function __invoke(Request $request)
    {
        $client = new Client();

        $url = "";
        
        $headers = [
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/117.0.0.0 Safari/537.36',
        ];

        $response = $client->get($url);
        
        
        if ($response->getStatusCode() == 200)
        {
            $html = $response->getBody()->getContents();
            
            $htmlArray = Helpers::ExtractHtmlContent(html: $html);

            ray($htmlArray)->die();
        }
        
        if ($response->getStatusCode() != 200) 
        {
            ray("something went wrong");
            ray($response->getStatusCode())->die();
        }
    }
}
