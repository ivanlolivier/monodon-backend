<?php

return [
    'modules_enabled' => [
        'inus' => env('INUS_ENABLED', true),
        'cda'  => env('CDA_ENABLED', true),
        'xds'  => env('XDS_ENABLED', false)
    ]
];

