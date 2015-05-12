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
        $next_url = $this->object_get($this->response, '_links.next.href');
        
        return new Result($next_url);
    }

    public function prev()
    {
        $prev_url = $this->object_get($this->response, '_links.prev.href');
        
        return new Result($prev_url);        
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
     * The object_get method will retrieve a given value from a deeply nested object using "dot" notation.
     * See also: http://laravel.com/docs/5.0/helpers
     *
     * Example: $headline = object_get(
     *      $articles_response, 
     *      'articles.' .$article_id. '.headline', 
     *      'could not find headline'
     * );
     * 
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
