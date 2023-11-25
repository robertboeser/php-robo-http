<?php
namespace Robo\RoboHttp;

class Request {
    protected $base;

    function __construct($base='') {
        $this->base = $base;
    }

    protected function req($path, $opts=[]) {
        if(!$opts) return file_get_contents($this->base.$path);
        return file_get_contents(
            $this->base.$path,
            false,
            stream_context_create($opts)
        );
    }

    protected function rex($path, $method, $headers=[], $body=null) {
        $head = '';
        foreach($headers as $k => $v) {
            $head .= "$k: $v\r\n";
        }

        $opts = [
            'method' => $method,
            'header' => $head,
            'content' => $body,
        ];
        return $this->req($path, ['http' => $opts]);
    }
/*
    function get_simple($path) {
        return $this->req($path);
    }
*/
    function get($path, $headers) {
        return $this->rex($path, 'GET', $headers);
    }

    function put($path, $headers, $body=null) {
        return $this->rex($path, 'PUT', $headers, $body);
    }

    function post($path, $headers, $body=null) {
        return $this->rex($path, 'POST', $headers, $body);
    }

    function delete($path, $headers, $body=null) {
        return $this->rex($path, 'DELETE', $headers, $body);
    }
}
