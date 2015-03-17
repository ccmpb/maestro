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
     * Composer location 
     * 
     * @var string
     */
    protected $composer = 'vendor/composer';
    
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
     * Get path to composer folder
     * 
     * @return string composer folder 
     */
    public function getComposerPath()
    {
        return $this->projectRoot . DIRECTORY_SEPARATOR . $this->composer; 
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

    /**
     * Get composer autoload classmap 
     * 
     * @return array autoload classmap 
     */
    public function getAutoloadClassMap()
    {
        return $this->getComposerFile('autoload_classmap.php');
    }

    /**
     * Get composer autoload psr4 
     * 
     * @return array autoload psr4
     */
    public function getAutoloadPsr4()
    {
        return $this->getComposerFile('autoload_psr4.php');
    }

    /**
     * Get psr4 autoload from config 
     * 
     * 
     * @return array autoload psr4
     */
    public function getConfigAutoloadPsr4()
    {
        $autoload = $this->getConfigValue('autoload');

        if ($autoload && array_key_exists('psr-4', $autoload)) {
            return $autoload['psr-4'];
        }
    }

    /**
     * get the contets of a composer file 
     * 
     * @throws MaestroException
     * @param string $fileName composer file name 
     * @return mixed composer file contents 
     */
    public function getComposerFile($fileName)
    {
        $path = $this->getComposerPath();
        if (!is_file($path . DIRECTORY_SEPARATOR . $fileName)) {
            throw new MaestroException(
                'Could not read file: ' 
                . $path . DIRECTORY_SEPARATOR .  $fileName
            );
        }
        return include($path . DIRECTORY_SEPARATOR . $fileName);
    }

    /**
     * Get the basedir for a particular namespace 
     * 
     * @param string $namespace namespace 
     * 
     * @return string namespace base dir 
     */
    public function getBaseDir($namespace)
    {
        $namespaceBase = explode("\\", $namespace)[0];
        
        // check composer.json first (this way we only have to open the 1 file)
        $psr4 = $this->getConfigAutoloadPsr4();

        if ($psr4 && array_key_exists($namespaceBase . "\\", $psr4)) {
            // psr4 from composer.json is relative, so we need to add the root        
            return $this->projectRoot . DIRECTORY_SEPARATOR . $psr4[$namespaceBase . "\\"];
        }

        $psr4 = $this->getAutloadPsr4();

        if ($psr4 && array_key_exists($namespaceBase . "\\" , $psr4)) {
            return $psr4; 
        }
    }
}
