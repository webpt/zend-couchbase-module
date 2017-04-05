<?php

namespace WebPT\ZendCouchbaseModule;

use Assert\Assertion;
use Zend\Stdlib\AbstractOptions;

class ClusterOptions extends AbstractOptions
{
    /** @var string */
    private $dsn = 'couchbase://localhost';
    
    /** @var string */
    private $username = '';
    
    /** @var string */
    private $password = '';
    
    /**
     * @return string
     */
    public function getDsn()
    {
        return $this->dsn;
    }
    
    /**
     * @param string $dsn
     * @return void
     * @throws \Assert\AssertionFailedException
     */
    public function setDsn($dsn)
    {
        Assertion::string($dsn);
        
        $this->dsn = $dsn;
    }
    
    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
    
    /**
     * @param string $username
     * @return void
     * @throws \Assert\AssertionFailedException
     */
    public function setUsername($username)
    {
        Assertion::string($username);
        
        $this->username = $username;
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
