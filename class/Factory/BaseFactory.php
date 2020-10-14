<?php

/**
 * @license http://opensource.org/licenses/lgpl-3.0.html
 * @author Justyn Crook <hannajg at appstate dot edu>
 */

namespace gpa\Factory;

abstract class BaseFactory extends \phpws2\ResourceFactory
{
    protected $header;

    abstract public function build();

    public function load(int $id)
    {
        if (empty($id)) {
            throw new ResourceNotFound;
        }
        $resource = $this->build();
        $resource->setId($id);
        if (!parent::loadByID($resource)) {
            throw new ResourceNotFound($id);
        }
        return $resource;
    }

    protected function walkingCase($name)
    {
        if (stripos($name, '_')) {
            return preg_replace_callback('/^(\w)(\w*)_(\w)(\w*)/',
                    function($letter) {
                $str = strtoupper($letter[1]) . $letter[2] . strtoupper($letter[3]) . $letter[4];
                return $str;
            }, $name);
        } else {
            return ucfirst($name);
        }
    }

    protected function sendCurl($url, $headerOnly = false)
    {
        $this->headers = null;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        if ($headerOnly) {
            curl_setopt($ch, CURLOPT_HEADERFUNCTION, [$this, 'curlHeader']);
        }

        if (STORIES_DISABLE_CURL_SSL) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        }
        $result = curl_exec($ch);
        curl_close($ch);
        if ($headerOnly) {
            return $this->header;
        }
        return $result;
    }

    public function curlHeader($curl, $header)
    {
        $this->header = $header;
    }

    protected function formatUrl(string $url, bool $endSlash = false)
    {
        if (!preg_match('@^(https?:)?//@', $url)) {
            $url = 'http://' . $url;
        } elseif (!preg_match('@^https?:@', $url)) {
            $url = 'http:' . $url;
        }
        if ($endSlash && !preg_match('@/$@', $url)) {
            $url = $url . '/';
        }
        return $url;
    }

    protected function successfulHeader(string $header)
    {
        return (bool) preg_match('@^HTTP/1.\d (301|200)@', $header);
    }

    public function testUrl(string $url)
    {
        $url = $this->formatUrl($url, true);
        $url = $url . 'gpa/Share/test';
        $header = $this->sendCurl($url, true);
        if (empty($header)) {
            return false;
        }
        return $this->successfulHeader($header);
    }
}

?>
