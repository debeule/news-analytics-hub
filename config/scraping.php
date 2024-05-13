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
        'prompt' => "Respond only with an array. Do not exclude data. Everything in lowercase. Structure the array like: 

            key: 'categories' value: category of news discussed.
            key: 'entities-occupations' value: array containing all entities mentioned with: [entity, occupation of entity, location (if not mentioned => null), organization of entity (not applicable = null)].
            key: 'entity-mentions' value: array containing all instances of an entity being mentioned with: [mentioned entity, context of mention, location(not mentioned = null), positivity score from 1 - 16]",
    ]
];
