<?php
/**
 * @package     Simplicity
 * @author      Rob Allen <rob@akrabat.com>
 * @copyright   2012 Rob Allen.
 * @license     MIT License - see LICENSE file
 * @link        http://phpfundamentals.com
 */
namespace Simplicity;

/**
 * The Response object represents all the information we need to send back 
 * to the browser. It holds three thing: status code, headers and content
 * 
 * The status code is the first header sent back and is a number along with
 * a reason phrase. As the phrase is quite hard to remember, there's a
 * helper method, getReasonPhrase(), which will provide them.
 * 
 * Each header has a name and a value, which are most easily set using the 
 * helper method setHeader().
 * 
 * Finally, the content is just a string, so can be set using the public
 * property, $content.
 */
class Response
{
    public $statusCode = 200;
    public $headers = array();
    public $content;

    /**
     * Set a header's name and its value
     */
    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;
        return $this;
    }

    /**
     * Send the response to the browser
     */
    public function send()
    {
        header('HTTP/1.1 ' . $this->statusCode . ' ' . $this->getReasonPhrase());
        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }
        echo $this->content;
    }

    public function getReasonPhrase($statusCode = null)
    {
        if (null === $statusCode) {
            $statusCode = $this->statusCode;
        }

        // List from Zend Framework 2
        $reasonPhrases = array(
            // INFORMATIONAL CODES
            100 => 'Continue',
            101 => 'Switching Protocols',
            102 => 'Processing',
            // SUCCESS CODES
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            207 => 'Multi-status',
            208 => 'Already Reported',
            // REDIRECTION CODES
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => 'Switch Proxy', // Deprecated
            307 => 'Temporary Redirect',
            // CLIENT ERROR
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Time-out',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Large',
            415 => 'Unsupported Media Type',
            416 => 'Requested range not satisfiable',
            417 => 'Expectation Failed',
            418 => 'I\'m a teapot',
            422 => 'Unprocessable Entity',
            423 => 'Locked',
            424 => 'Failed Dependency',
            425 => 'Unordered Collection',
            426 => 'Upgrade Required',
            428 => 'Precondition Required',
            429 => 'Too Many Requests',
            431 => 'Request Header Fields Too Large',
            // SERVER ERROR
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Time-out',
            505 => 'HTTP Version not supported',
            506 => 'Variant Also Negotiates',
            507 => 'Insufficient Storage',
            508 => 'Loop Detected',
            511 => 'Network Authentication Required',
        );

        if (isset($reasonPhrases[$statusCode])) {
            return $reasonPhrases[$statusCode];
        }

        return '';
    }
}
