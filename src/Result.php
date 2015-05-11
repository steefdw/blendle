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
        return isset($this->response->results) ? $this->response->results : 0;
    }

    public function next()
    {
        return isset($this->response->_links->next->href) ? $this->response->_links->next->href
                    : false;
    }

    public function prev()
    {
        return isset($this->response->_links->prev->href) ? $this->response->_links->prev->href
                    : false;
    }

    public function url_fetched()
    {
        return isset($this->response->_links->self->href) ? $this->response->_links->self->href
                    : false;
    }

    public function results()
    {
        return isset($this->response->_embedded) ? $this->response->_embedded : false;
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
                'snippet'  => $article->snippet,
                'link'     => $article->_embedded->item->_links->self->href,
                'date'     => $article->_embedded->item->_embedded->manifest->date,
                'provider' => $article->_embedded->item->_embedded->manifest->provider->id,
                'images'   => $article->_embedded->item->_embedded->manifest->images,
            );
        }

        return $snippets;
    }

}
