<?php

namespace WebPTTest\ZendCouchbaseModule;

use WebPT\ZendCouchbaseModule\Module;

/**
 * @covers \WebPT\ZendCouchbaseModule\Module
 */
class ModuleTest extends \PHPUnit_Framework_TestCase
{
    public function testGetConfig()
    {
        $config = (new Module())->getConfig();
        
        self::assertSame($config, unserialize(serialize($config)));
    }
}
