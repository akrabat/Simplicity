<?php
/**
 * @package     Simplicity
 * @author      Rob Allen <rob@akrabat.com>
 * @copyright   2012 Rob Allen.
 * @license     MIT License - see LICENSE file
 * @link        http://phpfundamentals.com
 */
namespace Simplicity;

class View
{
    public $fileDirectory;

    public function __construct($fileDirectory)
    {
        $this->fileDirectory = $fileDirectory;
    }

    /**
     * Render a view script.
     */
    public function render($filename, $parameters = array())
    {
        // extract parameters into $this for the view script to use
        foreach ($parameters as $name=>$value) {
            if ($name != 'this' && $name != 'fileDirectory') {
                $this->$name = $value;
            }
        }
        
        // Render the view script using an ouptut buffer, so we can control
        // the response and send headers later
        ob_start();
        require $this->fileDirectory . '/' . $filename;
        $content = ob_get_clean();
        return $content;
    }
}