<?php
/**
 * @package     Simplicity
 * @author      Rob Allen <rob@akrabat.com>
 * @copyright   2012 Rob Allen.
 * @license     MIT License - see LICENSE file
 * @link        http://phpfundamentals.com
 */
namespace Simplicity;

class Response
{
    protected $version = '1.1';
    protected $statusCode = 200;
    protected $headers = array();
    protected $content;


    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;
        return $this;
    }
    
    public function getHeader($name)
    {
        $value = '';
        if (array_key_exists($name, $this->headers)) {
            $value = $this->headers[$name];
        }
        return $value;
    }

    public function send()
    {
        $this->sendHeaders()
             ->sendContent();
        return $this;
    }

    public function sendHeaders()
    {
        return $this;   
    }

    public function sendContent()
    {
        echo $this->getContent();
    }

    public function getReasonPhrase($statusCode = null)
    {
        if (null === $statusCode) {
            $statusCode = $this->getStatusCode();
        }

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



    // ========================================================================
    // Getters and Setters for properties
    // ========================================================================

    public function getVersion()
    {
        return $this->version;
    }
    
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }
    
    public function getStatusCode()
    {
        return $this->statusCode;
    }
    
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }
    
    public function getHeaders()
    {
        return $this->headers;
    }
    
    public function setHeaders($headers)
    {
        $this->headers = $headers;
        return $this;
    }
    
    public function getContent()
    {
        return $this->content;
    }
    
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }
}