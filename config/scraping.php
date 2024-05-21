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
        'prompt' => "Respond only in JSON format. Fields cannot be null unless specified. Ensure all data is lowercase. Structure the JSON as follows:

            key: category
            value: choose the most fitting category: Politics, Business, Economy, Technology, Science & Planet, Entertainment, Sports, Opinion.
        
            key: created_at
            value: date article was published in the format yyyy-mm-dd-hh-mm.
        
            key: author
            value: name of the author (nullable)

            key: occupations
            value: list of all mentioned occupations, each with:
                - name: name of the occupation
                - sector: general sector
        
            key: organizations
            value: list of all mentioned organizations and companies, each with:
                - name: organization name
                - sector: general sector
        
            key: entities
            value: list of all mentioned entities and organizations, each with:
                - name: name of mentioned entity/organization/company
                - occupation: occupation (nullable)
                - organization: name of linked organization from 'organizations' key (nullable)
        
            key: mentions
            value: all instances of entities or organizations being mentioned, each with:
                - context: context of mention (up to 15 words)
                - sentiment: score from 1 to 16
                - entity_name: name of mentioned entity (ensure entity is included in 'entities' key) (nullable if organization is mentioned)
                - organization_name: name of mentioned organization (ensure organization is included in 'organizations' key) (nullable if entity is mentioned)",
    ]
];
