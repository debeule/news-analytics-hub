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
    
    'processing' => [
        'prompt' => "Respond only in json format. Do not exclude data. If a field is not mentioned it is null. Everything in lowercase. Structure the json like:
            
            key: category
            value: choose most fitting: Politics, Business, Economy, Technology, Science & planet, Entertainment, Sports, Opinion,
           
            key: created_at
            value: date article was published in format yyyy-mm-dd-hh-mm

            key: occupations
            value: every occupation of an entity mentioned

            key: organizations
            value: every mentioned organizations and company 
                with 
                    name => organization name, 
                    sector => general sector

            key: entities
            value: every person mentioned 
                with
                    name, 
                    occupation, 
                    name of linked organization from organizations key.

            key: mentions
            value: all instances of an entity or organization being mentioned
                with
                    mentioned entity,
                    mentioned organization, 
                    context of mention (15 words), 
                    positivity score from 1 - 16
        ",
    ]
];
