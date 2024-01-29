<?php

return [
    'organizations' => [
            "1" => [
                "name" => "detijd",
                "organization_type" => "news_paper",
            ],
            "2" => [
                "name" => "demorgen",
                "organization_type" => "news_paper",
            ],
    ],
    
    
    'destination' => env('SCRAPER_PROJECT_DESTINATION'),
    'enableVenvCommand' => env('APP_ENV') == 'local' ? ".\\venv\\Scripts\\activate" : "source .\\venv\\Scripts\\activate",
];
