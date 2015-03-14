<?php

/**
 * MaestroTest 
 * 
 * @uses PHPUnit
 * @uses _Framework_TestCase
 * @author Colin Campbell <colin@elusivelabs.com> 
 */
class MaestroTest extends PHPUnit_Framework_TestCase
{
    protected $maestro;

    public function setUp()
    {
        // will just use maestros own composer.json as a mock
        $this->maestro = new Maestro(__DIR__ . DIRECTORY_SEPARATOR . '..');
    }
    
    /**
     * config path should be projectroot/composer.json
     * 
     */
    public function testGetConfigPath()
    {
        $this->assertEquals(
            $this->maestro->getConfigPath(), 
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'composer.json'
        );
    }

    /**
     * Composer config should be an array and should have a name key from our
     * mock composer config.
     *
     */
    public function testGetConfig()
    {
        $this->assertInternalType('array', $this->maestro->getConfig());
        $this->assertArrayHasKey('name', $this->maestro->getConfig());
    }

    /**
     * We should get an exception if we cant open the config file
     *
     */
    public function testConfigException()
    {
        $this->setExpectedException('MaestroException');
        $this->maestro->setConfigFile('phonyfile');
        $this->maestro->getConfig();
    }

    /**
     * Sshould be able to retreive composer config values by key 
     * 
     * @return void
     */
    public function testGetConfigValue()
    {
        $this->assertEquals($this->maestro->getConfigValue('name'), 'maestro');
    }

    /**
     * Get name should return composer config name
     * 
     */
    public function testGetName()
    {
        $this->assertEquals($this->maestro->getName(), 'maestro');
    }

    /**
     * Authors should be an array of authors names an eemails 
     * 
     * @return void
     */
    public function testGetAuthors()
    {
        $authors = $this->maestro->getAuthors();
        $this->assertInternalType('array', $authors); 
        $this->assertArrayHasKey('name', $authors[0]);
        $this->assertArrayHasKey('email', $authors[0]);
    }
}
