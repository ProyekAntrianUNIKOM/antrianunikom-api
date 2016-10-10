<?php
'default' => 's3',

'disks' => [
    's3' => [
        'driver' => 's3',
        'key'    => env('S3_KEY'),
        'secret' => env('S3_SECRET'),
        'region' => env('S3_REGION'),
        'bucket' => env('S3_BUCKET'),
    ],
]
?>
