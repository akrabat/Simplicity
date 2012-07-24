<?php
/**
 * @package     Simplicity
 * @author      Rob Allen <rob@akrabat.com>
 * @copyright   2012 Rob Allen.
 * @license     MIT License - see LICENSE file
 * @link        http://phpfundamentals.com
 */
namespace Simplicity;

use Exception;

/**
 * PSR-0 compliant namespace autoloader
 * 
 * This autoloader will load any PSR-0 class that is within a predefinied
 * list of available namespaces. The namespace map is an array of namespace
 * to the parent directory of files for that namespace are stored.
 * 
 * Example:
 *      $map = array(
 *          'Application' => __DIR__ . '/../application',
 *          'Simplicity'  => __DIR__ . '/../library',
 *      );
 * 
 * Note that this class does not automatically register the Simplicity library.
 * 
 */
class Autoloader
{
    protected $map;

    /**
     * Sets the namespace map and registers this autoloader with then SPL.
     * 
     * @param array $map hash of namespace to directory
     */
    public function __construct($map)
    {
        $this->setMap($map);

        // register with the SPL autoloader
        spl_autoload_register(array($this, 'autoload'));
    }

    /**
     * Autoload a namespaced class name that uses the PSR-0 standard naming convention
     * @see https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md
     * 
     * @param string $className name of the class to load
     */
    function autoload($className)
    {
        $className = ltrim($className, '\\');
        $fileName  = '';
        $namespace = '';
        $lastNsPos = strripos($className, '\\');
        if ($lastNsPos) {
            // convert the classname to a filename
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
            $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        
            // Find the top level namespace
            $topLevelNamespace = $namespace;
            $firstNsPos = strpos($namespace, '\\');
            if ($firstNsPos) {
                $topLevelNamespace = substr($topLevelNamespace, 0, $firstNsPos);
            }
            
            // load from the map
            $map = $this->getMap();
            if (isset($map[$topLevelNamespace])) {
                $fileName = $map[$topLevelNamespace] . '/' . $fileName;

                if (!is_readable($fileName)) {
                    throw new Exception("Cannot load class $className. Looked for file $fileName");
                }
                require $fileName;
            }
        }

        return false;
    }

    /**
     * Retrieve the map array
     */
    public function getMap()
    {
        return $this->map;
    }
    
    /**
     * Set the map array
     * 
     * @param array $map hash of namespace to directory
     */
    public function setMap($map)
    {
        $this->map = $map;
        return $this;
    }
}