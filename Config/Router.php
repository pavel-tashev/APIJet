<?php 

use APIJet\Router AS R;

return [
    'globalPattern' => [
        '{id}' => '([0-9]+)',
    ],
    'routes' => [
        'jobs' => [R::POST, 'jobs\index'],
        'jobs/list' => [R::GET, 'jobs\list'],
        'jobs/{id}' => [R::GET_PUT_DELETE, 'jobs\index'],
        
        'candidates/list' => [R::GET, 'candidates\list'],
        'candidates/review/{id}' => [R::GET, 'candidates\review'],
        'candidates/search/{id}' => [R::GET, 'candidates\search'],
    ]
];

