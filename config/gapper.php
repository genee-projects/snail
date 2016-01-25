<?php

return [
    'rpc' => [
        'client_id'=> env('GAPPER_RPC_CLIENT_ID'),
        'client_secret'=> env('GAPPER_RPC_CLIENT_SECRET'),
        'url'=> 'http://gapper.in/api',
    ],
    'url'=> 'http://gaper.in',
    'group_id'=> (int) env('GAPPER_GROUP_ID'),
];
