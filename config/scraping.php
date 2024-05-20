<?php

return [
    'organizations' => [
            "1" => [
                "name" => "detijd",
                "sector" => "source_newspaper",
            ],
            // "2" => [
            //     "name" => "demorgen",
            //     "sector" => "source_newspaper",
            // ],
    ],
    
    'processing' => [
        'prompt' => "Respond only in json format. Do not exclude data. If a field is not mentioned it is null. Everything in lowercase. Structure the json like:
            
            key: category
            value: choose most fitting (cannot be null): Politics, Business, Economy, Technology, Science & planet, Entertainment, Sports, Opinion,
           
            key: created_at
            value: date article was published in format yyyy-mm-dd-hh-mm

            key: occupations
            value: every occupation occupation mentioned
                with
                    name => name of the occupation, 
                    sector => general sector

            key: organizations
            value: every mentioned organizations and company 
                with 
                    name => organization name, 
                    sector => general sector

            key: entities
            value: every mention of an organization, company or entity
                with
                    name => name of mentioned entity / organization / company, 
                    occupation => occupation, 
                    organization => name of linked organization from organizations key.

            key: mentions
            value: all instances of an entity or organization being mentioned
                with
                    context => context of mention (15 words), 
                    sentiment => score from 1 - 16
                    entityName => name of mentioned entity (ensure entity is included in entities key),
                    organizationName => name of mentioned organization (ensure organization is included in organizations key), 
        ",
    ]
];
