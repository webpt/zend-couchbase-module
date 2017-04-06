<?php

namespace WebPTTest\ZendCouchbaseModule;

use WebPT\ZendCouchbaseModule\ClusterOptions;
use Klever\Tutor\AccessMethod\AbstractTestCase;

/**
 * @covers \WebPT\ZendCouchbaseModule\ClusterOptions
 */
class ClusterOptionsTest extends AbstractTestCase
{
    public function getClassAccessMethodTestConfiguration()
    {
        return [
            'accessors' => [
                'dsn' => [
                    'default_value' => 'couchbase://localhost',
                    'injectable_value' => 'couchbase://127.0.0.1',
                ],
                'username' => [
                    'default_value' => '',
                    'injectable_value' => 'MyUsername',
                ],
                'password' => [
                    'default_value' => '',
                    'injectable_value' => 'MyPassword',
                ],
            ],
        ];
    }
    
    public function getSubjectUnderTest()
    {
        return new ClusterOptions();
    }
}
