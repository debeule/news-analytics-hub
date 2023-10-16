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

        $url = 'quotes.toscrape.com';
        
        $response = $client->get($url);
        
        
        if ($response->getStatusCode() == 200)
        {
            $html = $response->getBody()->getContents();
            
            $helper = new Helpers();
            $htmlArray = $helper->HtmlToArray(html: $html);

            ray($htmlArray)->die();
        }
        
        if ($response->getStatusCode() != 200) 
        {
            ray("something went wrong");
            ray($response->getStatusCode())->die();
        }
    }
}
