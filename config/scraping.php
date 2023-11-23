<?php

return [
    'organizations' => [
            "0" => [
                "name" => "hln",
                "organization_type" => "news_paper",
            ],
    ],
    
    'destination' => env('SCRAPER_PROJECT_DESTINATION'),
    'enableVenvCommand' => env('APP_ENV') == 'local' ? ".\\venv\\Scripts\\activate" : "source .\\venv\\Scripts\\activate",
];
