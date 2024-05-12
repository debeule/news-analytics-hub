<?php

return [
    'organizations' => [
            "1" => [
                "name" => "detijd",
                "organization_type" => "newspaper",
            ],
            "2" => [
                "name" => "demorgen",
                "organization_type" => "newspaper",
            ],
    ],
    
    
    'destination' => env('SCRAPER_PROJECT_DESTINATION'),
    'enableVenvCommand' => env('APP_ENV') == 'local' ? ".\\venv\\Scripts\\activate" : "source .\\venv\\Scripts\\activate",
];
