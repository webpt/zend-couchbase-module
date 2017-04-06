<?php

namespace WebPTTest\ZendCouchbaseModule;

use WebPT\ZendCouchbaseModule\AbstractCouchbaseBucketFactory;
use WebPT\ZendCouchbaseModule\BucketOptions;
use WebPT\ZendCouchbaseModule\ClusterOptions;
use WebPT\ZendCouchbaseModule\Module;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;

/**
 * @covers \WebPT\ZendCouchbaseModule\AbstractCouchbaseBucketFactory
 */
class AbstractCouchbaseBucketFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var ServiceLocatorInterface */
    private $serviceLocator;
    
    protected function setUp()
    {
        $config = (new Module())->getConfig();
    
        $serviceManager = new ServiceManager();
        
        (new ServiceManagerConfig(\igorw\get_in($config, ['service_manager'], [])))
            ->configureServiceManager($serviceManager);
        
        $serviceManager->setService('config', $config);
        
        $this->serviceLocator = $serviceManager;
    }
    
    /**
     * @group integration
     */
    public function testCreateService()
    {
        $bucket = $this->serviceLocator->get('couchbase.localhost.default');

        self::assertInstanceOf(\CouchbaseBucket::class, $bucket);
    }
    
    public function testCanCreateFromRequestedName()
    {
        $name = 'FooBar';
        $requestedName = 'couchbase.localhost.default';
    
        $canCreate = (new AbstractCouchbaseBucketFactory())->canCreateServiceWithName(
            new ServiceManager(),
            $name,
            $requestedName
        );
    
        self::assertTrue($canCreate);
    }
    
    /**
     * @return array
     */
    public function testGetModuleConfig()
    {
        $moduleConfig = (new AbstractCouchbaseBucketFactory())->getModuleConfig($this->serviceLocator);
        self::assertInternalType('array', $moduleConfig);
        
        return $moduleConfig;
    }
    
    /**
     * @return BucketOptions
     */
    public function testGetBucketOptions()
    {
        $moduleConfig = $this->testGetModuleConfig();
        
        $bucketOptions = (new AbstractCouchbaseBucketFactory())->getBucketOptions($moduleConfig, 'default');
        self::assertInstanceOf(BucketOptions::class, $bucketOptions);
        
        return $bucketOptions;
    }
    
    /**
     * @return ClusterOptions
     */
    public function testGetClusterOptions()
    {
        $moduleConfig = $this->testGetModuleConfig();
        
        $clusterOptions = (new AbstractCouchbaseBucketFactory())->getClusterOptions($moduleConfig, 'localhost');
        
        self::assertInstanceOf(ClusterOptions::class, $clusterOptions);
        
        return $clusterOptions;
    }
    
    /**
     * @group integration
     */
    public function testCreateCouchbaseCluster()
    {
        $clusterOptions = $this->testGetClusterOptions();
        
        $cluster = (new AbstractCouchbaseBucketFactory())->createCouchbaseCluster($clusterOptions);
        
        self::assertInstanceOf(\CouchbaseCluster::class, $cluster);
        
        return $cluster;
    }
    
    /**
     * @group integration
     */
    public function testCreateCouchbaseBucket()
    {
        $cluster = $this->testCreateCouchbaseCluster();
    
        $bucketOptions = $this->testGetBucketOptions();
        
        $bucket = (new AbstractCouchbaseBucketFactory())->createCouchbaseBucket($cluster, $bucketOptions);
        
        self::assertInstanceOf(\CouchbaseBucket::class, $bucket);
    }
}
