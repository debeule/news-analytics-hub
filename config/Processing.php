<?php

return [
    'openai_api_key' => env('OPENAI_API_KEY'),
    'prompt' =>
        "Respond only in JSON format. Fields cannot be null unless specified. Ensure all data is lowercase. Structure the JSON as follows:

        key: category
        value: choose the most fitting category: politics, business, economy, technology, science & planet, entertainment, sports, opinion, media.
    
        key: created_at
        value: date article was published in the format yyyy-mm-dd hh:ii.
    
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
        value: list of all mentioned entities. Do NOT include organizations and companies, each with:
            - name: name of mentioned entity
            - occupation: occupation (nullable)
            - organization: name of the organization this entity is part of. from 'organizations' key (nullable)
    
        key: entity-mentions
        value: list of every instance of an entity being discussed. Ensure every entity listed in the 'entities' key has corresponding entries in the 'entity-mentions' key. each with:
            - context: write a descriptive sentence giving context to what the mention is about (+- 15 words)
            - sentiment: score from 1 to 16
            - entity_name: name of person mentioned (NO organizations and companies) (ensure entity is included in 'entities' key)
            
        key: organization-mentions
        value: list of every instance of an organization or company being mentioned. If multiple organizations or companies are mentioned in an instance make multiple records. Ensure every organization listed in the 'organizations' key has corresponding entries in the 'organization-mentions' key. each with:
            - context: write a descriptive sentence giving context to what the mention is about (+- 15 words)
            - sentiment: score from 1 to 16
            - organization_name: name of organization or company mentioned (NO entities) (ensure organization is included in 'organizations' key)"
            
];