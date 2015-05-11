<?php

namespace Steefdw\Blendle;

class Result {

    private $response;

    public function __construct($url)
    {
        $this->response = (object) Rest::fetch($url);

        return $this;
    }

    public function total()
    {
        return $this->object_get($this->response, 'results', 0);
    }

    public function next()
    {
        return $this->object_get($this->response, '_links.next.href');
    }

    public function prev()
    {
        return $this->object_get($this->response, '_links.prev.href');
    }

    public function url_fetched()
    {
        return $this->object_get($this->response, '_links.self.href');
    }

    public function results()
    {
        return $this->object_get($this->response, '_embedded', false);
    }

    public function snippets()
    {
        $snippets = [];

        foreach($this->response->_embedded as $article)
        {
            $snippets[] = $article->snippet;
        }

        return $snippets;
    }

    public function articles()
    {
        $snippets = [];

        foreach($this->response->_embedded->results as $article)
        {
            $snippets[] = array(
                'snippet'  => $this->object_get($article, 'snippet'),
                'link'     => $this->object_get($article, '_embedded.item._links.self.href'),
                'date'     => $this->object_get($article, '_embedded.item._embedded.manifest.date'),
                'provider' => $this->object_get($article, '_embedded.item._embedded.manifest.provider.id'),
                'images'   => $this->object_get($article, '_embedded.item._embedded.manifest.images'),
            );
        }

        return $snippets;
    }
    

    /**
     * Get an item from an object using "dot" notation.
     *
     * @param  object  $object
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function object_get($object, $key, $default = null)
    {
        if(is_null($key) || trim($key) == '')
        {
            return $object;
        }
            
        foreach(explode('.', $key) as $segment)
        {
            if(!is_object($object) || !isset($object->{$segment}))
            {
                return $default;
            }

            $object = $object->{$segment};
        }

        return $object;
    }

}
