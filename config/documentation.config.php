<?php
return [
    'CRM\\V1\\Rest\\Auth_db\\Controller' => [
        'entity' => [
            'GET' => [
                'response' => '{
   "_links": {
       "self": {
           "href": "/auth_db[/:auth_db_id]"
       }
   }
   "usuario": "",
   "password": ""
}',
            ],
        ],
    ],
    'CRM\\V1\\Rest\\AuthDB\\Controller' => [
        'collection' => [
            'GET' => [
                'response' => '{
   "_links": {
       "self": {
           "href": "/auth-db"
       },
       "first": {
           "href": "/auth-db?page={page}"
       },
       "prev": {
           "href": "/auth-db?page={page}"
       },
       "next": {
           "href": "/auth-db?page={page}"
       },
       "last": {
           "href": "/auth-db?page={page}"
       }
   }
   "_embedded": {
       "auth_db": [
           {
               "_links": {
                   "self": {
                       "href": "/auth-db[/:auth_db_id]"
                   }
               }

           }
       ]
   }
}',
            ],
            'POST' => [
                'request' => '{

}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/auth-db[/:auth_db_id]"
       }
   }

}',
            ],
        ],
        'entity' => [
            'GET' => [
                'response' => '{
   "_links": {
       "self": {
           "href": "/auth-db[/:auth_db_id]"
       }
   }

}',
            ],
        ],
    ],
];
