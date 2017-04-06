<?php

return [
    'service_manager' => [
        'abstract_factories' => [
            \WebPT\ZendCouchbaseModule\AbstractCouchbaseBucketFactory::class,
        ],
    ],
    'webpt/zend-couchbase-module' => [
        'clusters' => [
            'localhost' => [
                'dsn' => getenv('COUCHBASE_LOCALHOST_CLUSTER_DSN') ?: 'couchbase://localhost',
                'username' => getenv('COUCHBASE_LOCALHOST_CLUSTER_USERNAME') ?: '',
                'password' => getenv('COUCHBASE_LOCALHOST_CLUSTER_PASSWORD') ?: '',
            ],
        ],
        'buckets' => [
            'default' => [
                'bucket' => getenv('COUCHBASE_DEFAULT_BUCKET_NAME') ?: 'default',
                'password' => getenv('COUCHBASE_DEFAULT_BUCKET_PASSWORD') ?: '',
            ],
        ],
    ],
];
