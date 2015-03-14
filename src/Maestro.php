<?php

class MaestroException extends Exception {}

/**
 * Maestro Composer reflection 
 * 
 * @author Colin Campbell <colin@elusivelabs.com> 
 */
class Maestro
{
    /**
     * Project root folder 
     * 
     * @var string
     */
    protected $projectRoot;

    /**
     * Composer config file.  Defaults to composer.json 
     * 
     * @var string
     */
    protected $configFile = 'composer.json';

    /**
     * Composer config  
     * 
     * @var array 
     */
    protected $config = [];
    
    /**
     * __construct 
     * 
     * @param string $projectRoot composer project root folder
     */
    public function __construct($projectRoot)
    {
        $this->projectRoot = $projectRoot; 
    }

    /**
     * Set composer config file 
     * 
     * @param string $configFile composer config file 
     */
    public function setConfigFile($configFile)
    {
        $this->configFile = $configFile;
    }

    /**
     * Get composer config 
     * 
     * @return array composer config 
     */
    public function getConfig()
    {
        if (!$this->config) {
            $config = @file_get_contents($this->getConfigPath()); 
            if (!$config) {
                throw new MaestroException(
                    'Could not read composer config file: '
                    . $this->getConfigPath()
                );
            }
            $this->config = json_decode($config, true);
        }
        return $this->config;
    }

    /**
     * get full path to composer config file
     * 
     */
    public function getConfigPath()
    {
        return $this->projectRoot . DIRECTORY_SEPARATOR . $this->configFile;
    }

    /**
     * getConfigValue 
     * 
     * @param string $key composer config key 
     * 
     * @return mixed composer config value 
     */
    public function getConfigValue($key)
    {
        $config = $this->getConfig();

        if (array_key_exists($key, $config)) {
            $value = $config[$key];
        }

        return $value;
    }

    /**
     * Get project name 
     * 
     * @return string project name 
     */
    public function getName()
    {
        return $this->getConfigValue('name');
    }

    /**
     * Get authors 
     * 
     * @return array authors 
     */
    public function getAuthors()
    {
        return $this->getConfigValue('authors');
    }
}
