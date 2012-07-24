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

    // $encoding and $htmlSpecialCharsFlags are for escape methods
    public $encoding = 'utf-8';
    public $htmlSpecialCharsFlags = ENT_QUOTES;

    public function __construct($fileDirectory)
    {
        $this->fileDirectory = $fileDirectory;
        
        if (version_compare(PHP_VERSION, '5.4') >= 0) {
            $this->htmlSpecialCharsFlags = ENT_QUOTES | ENT_SUBSTITUTE;
        }
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

    /**
     * Escape a string for the HTML Body context where there are very few characters
     * of special meaning. Internally this will use htmlspecialchars().
     * 
     * @see Zend Framework 2's Escaper component
     * 
     * @param string $string
     * @return string
     */
    public function escapeHtml($string)
    {
        $result = htmlspecialchars($string, $this->htmlSpecialCharsFlags, $this->encoding);
        return $result;
    }

    /**
     * Escape a string for the HTML Attribute context. We use an extended set of characters
     * to escape that are not covered by htmlspecialchars() to cover cases where an attribute
     * might be unquoted or quoted illegally (e.g. backticks are valid quotes for IE).
     * 
     * @see Zend Framework 2's Escaper component
     * 
     * @param string $string
     * @return string
     */
    public function escapeHtmlAttr($string)
    {
        $string = $this->toUtf8($string);
        if (strlen($string) == 0 || ctype_digit($string)) {
            return $string;
        }
        $result = preg_replace_callback(
            '/[^a-zA-Z0-9,\.\-_]/Su',
            array($this, 'htmlAttrMatcher'),
            $string
        );
        return $this->fromUtf8($result);
    }
}
