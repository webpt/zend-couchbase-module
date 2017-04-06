<?php

namespace WebPT\ZendCouchbaseModule;

use Assert\Assertion;
use Zend\Stdlib\AbstractOptions;

class BucketOptions extends AbstractOptions
{
    /** @var string */
    private $bucket = 'default';
    
    /** @var string */
    private $password = '';
    
    /**
     * @return string
     */
    public function getBucket()
    {
        return $this->bucket;
    }
    
    /**
     * @param string $bucket
     * @return void
     * @throws \Assert\AssertionFailedException
     */
    public function setBucket($bucket)
    {
        Assertion::string($bucket);
        
        $this->bucket = $bucket;
    }
    
    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * @param string $password
     * @return void
     * @throws \Assert\AssertionFailedException
     */
    public function setPassword($password)
    {
        Assertion::string($password);
        
        $this->password = $password;
    }
}
