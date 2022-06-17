<?php

return [
    'type' => [
        1 => 'super-admin',
        2 => 'user',
    ],

    'activation' => [
        1 => 'Active',
        2 => 'Non-Active',
    ],

    'balance' => [
        0 => 'Pending',
        1 => 'Success',
        99 => 'Reject',
        999 => 'Failed'
    ],
    'group' => [
        0 => 'Non Active',
        1 => 'Active',
    ],
    'session' => [
        0 => 'Non Active',
        1 => 'Active',
    ],
    'message' => [
        -10 => 'PENDING',
        -7 => 'MD_DOWNGRADE',
        -6 => 'INACTIVE',
        -5 => 'CONTENT_UNUPLOADABLE',
        -4 => 'CONTENT_TOO_BIG',
        -3 => 'CONTENT_GONE',
        -2 => 'EXPIRED',
        -1 => 'FAILED',
        0 => 'CLOCK',
        1 => 'SENT',
        2 => 'RECEIVED',
        3 => 'READ',
        4 => 'PLAYED'
    ],
    'message_max' => env('MESSAGE_MAX', 300),

];
