<?php

namespace Steefdw\Blendle;

class Result {

    private $response;

    public function __construct($url)
    {
        $this->response = !is_null($url) 
                        ? (object) Rest::fetch($url) 
                        : null;

        return $this;
    }

    /**
     * Show the total results
     * 
     * @return int
     */
    public function total()
    {
        return $this->object_get($this->response, 'results', 0);
    }

    /**
     * Fetch the next result set
     * 
     * @return \Steefdw\Blendle\Result
     */
    public function next()
    {
        $next_url = $this->object_get($this->response, '_links.next.href');
        
        return new Result($next_url);
    }

    /**
     * Fetch the previous result set
     * 
     * @return \Steefdw\Blendle\Result
     */
    public function prev()
    {
        $prev_url = $this->object_get($this->response, '_links.prev.href');
        
        return new Result($prev_url);        
    }

    /**
     * Mainly for debugging: what URL did we just fetch?
     * 
     * @return string
     */
    public function url_fetched()
    {
        return $this->object_get($this->response, '_links.self.href');
    }

    /**
     * Show the whole result set from the Blendle API
     * 
     * @return object
     */
    public function results()
    {
        return $this->object_get($this->response, '_embedded', false);
    }

    /**
     * Show the search snippets for displaying what was found
     * 
     * Note/todo: it would be nice if we could show the healine, URL and snippet,
     * so we can make a google-like search result page
     * 
     * @return array
     */
    public function snippets()
    {
        $snippets = [];

        foreach($this->object_get($this->response, '_embedded.results', []) as $article)
        {
            $snippets[] = $this->object_get($article, 'snippet');
        }

        return $snippets;
    }

    /**
     * Get the basic data from the articles
     * 
     * Note: too bad there isn't a "headline" in the result set, so we should
     * guess that $this->object_get($article, '_embedded.item._embedded.manifest.body')
     * has a type=hl1 somewhere?
     * 
     * @return array
     */
    public function articles()
    {
        $articles = [];

        foreach($this->object_get($this->response, '_embedded.results', []) as $article)
        {
            $articles[] = array(
                'id'        => $this->object_get($article, '_embedded.item._embedded.manifest.id'),
                'links'     => array(
                    'self'     => $this->object_get($article, '_embedded.item._links.self.href'),
                    'content'  => $this->object_get($article, '_embedded.item._links.item_content.href'),                    
                    'manifest' => $this->object_get($article, '_embedded.item._embedded.manifest._links.self.href'),                    
                ),
                'snippet'   => $this->object_get($article, 'snippet'),
                'item'      => $this->object_get($article, '_embedded.item._embedded.manifest'),
            );
        }

        return $articles;
    }
    

    /**
     * The object_get method will retrieve a given value from a deeply nested object using "dot" notation.
     * See also: http://laravel.com/docs/5.0/helpers
     *
     * Example: 
     * $articles = (object)['articles' => (object)['item1' => (object)['headline' => 'Man bites dog']]];
     * 
     * $this->object_get($articles, 'articles.item1.headline');
     * // 'Man bites dog'
     * $this->object_get($articles, 'articles.item404.headline');
     * // null
     * $this->object_get($articles, 'articles.item404.headline', 'headline not found');
     * // 'headline not found'
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
