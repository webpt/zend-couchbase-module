<?php

namespace WebPTTest\ZendCouchbaseModule;

use WebPT\ZendCouchbaseModule\BucketOptions;
use Klever\Tutor\AccessMethod\AbstractTestCase;

/**
 * @covers \WebPT\ZendCouchbaseModule\BucketOptions
 */
class BucketOptionsTest extends AbstractTestCase
{
    public function getClassAccessMethodTestConfiguration()
    {
        return [
            'accessors' => [
                'bucket' => [
                    'default_value' => 'default',
                    'injectable_value' => 'MyBucket',
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
        return new BucketOptions();
    }
}
