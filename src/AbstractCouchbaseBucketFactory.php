<?php

namespace WebPT\ZendCouchbaseModule;

use Assert\Assertion;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AbstractCouchbaseBucketFactory implements AbstractFactoryInterface
{
    /**
     * Determine if we can create a service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName
     * @return bool
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return stripos($requestedName, 'couchbase.') === 0 && substr_count($requestedName, '.') === 2;
    }
    
    /**
     * Create service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param string $name
     * @param string $requestedName
     * @return \CouchbaseBucket
     * @throws \RuntimeException
     * @throws \Assert\AssertionFailedException
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $components = explode('.', $requestedName);
        Assertion::count($components, 3);
        
        $moduleConfig = $this->getModuleConfig($serviceLocator);
        
        $clusterOptions = $this->getClusterOptions($moduleConfig, $components[1]);
        
        $bucketOptions = $this->getBucketOptions($moduleConfig, $components[2]);
        
        $cluster = $this->createCouchbaseCluster($clusterOptions);
        
        return $this->createCouchbaseBucket($cluster, $bucketOptions);
    }
    
    /**
     * @param \CouchbaseCluster $cluster
     * @param BucketOptions $options
     * @return \CouchbaseBucket
     */
    public function createCouchbaseBucket(\CouchbaseCluster $cluster, BucketOptions $options)
    {
        return $cluster->openBucket($options->getBucket(), $options->getPassword());
    }
    
    /**
     * @param ClusterOptions $options
     * @return \CouchbaseCluster
     * @throws \RuntimeException
     */
    public function createCouchbaseCluster(ClusterOptions $options)
    {
        if (class_exists('\Couchbase\Cluster', true)) {
            $class = '\Couchbase\Cluster';
            return new $class($options->getDsn());
        }
        
        if (class_exists('\CouchbaseCluster', true)) {
            return new \CouchbaseCluster($options->getDsn(), $options->getUsername(), $options->getPassword());
        }
        
        throw new \RuntimeException('Extension couchbase is required.');
    }
    
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return array
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     * @throws \Assert\AssertionFailedException
     */
    public function getModuleConfig(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        Assertion::isArray($config);
    
        Assertion::keyExists($config, 'webpt/zend-couchbase-module');
        $moduleConfig = $config['webpt/zend-couchbase-module'];
        Assertion::isArray($moduleConfig);
        
        return $moduleConfig;
    }
    
    /**
     * @param array $moduleConfig
     * @param string $bucketConfigName
     * @return BucketOptions
     * @throws \Assert\AssertionFailedException
     */
    public function getBucketOptions(array $moduleConfig, $bucketConfigName)
    {
        Assertion::keyExists($moduleConfig, 'buckets');
        
        $bucketsConfig = $moduleConfig['buckets'];
        Assertion::isArray($bucketsConfig);
    
        Assertion::keyExists($bucketsConfig, $bucketConfigName);
        $bucketConfig = $bucketsConfig[$bucketConfigName];
        Assertion::isArray($bucketConfig);
        
        return new BucketOptions($bucketConfig);
    }
    
    /**
     * @param array $moduleConfig
     * @param string $clusterName
     * @return ClusterOptions
     * @throws \Assert\AssertionFailedException
     */
    public function getClusterOptions(array $moduleConfig, $clusterName)
    {
        Assertion::keyExists($moduleConfig, 'clusters');
        
        $clustersConfig = $moduleConfig['clusters'];
        Assertion::isArray($clustersConfig);
    
        Assertion::keyExists($clustersConfig, $clusterName);
        $clusterConfig = $clustersConfig[$clusterName];
        Assertion::isArray($clusterConfig);
        
        return new ClusterOptions($clusterConfig);
    }
}
