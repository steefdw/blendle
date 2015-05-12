<?php

namespace Steefdw\Blendle;

class Query {

    private $allowed_methods = array(
        'offset',
        'limit',
        'max_age',
        'min_words',
        'max_words',
        'category',
        'provider_id',
        'users',        
    );

    public function __call($method, $query)
    {
        if(in_array($method, $this->allowed_methods))
        {
            $this->parameters[] = $method. '=' .urlencode(implode(',', $query));
        }

        return $this;
    }

}
