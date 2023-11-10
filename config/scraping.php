<?php

return [
    'sources' => [
        [
            'name' => "HLN",
            'domain' => "hln.be/",
            'articles_page' => 'net-binnen',
        ],
        [
            'name' => "De Tijd",
            'domain' => "tijd.be/",
            'articles_page' => 'meest-recent.html',
        ],
    ],
    
    'destination' => env('SCRAPER_PROJECT_DESTINATION'),
];
