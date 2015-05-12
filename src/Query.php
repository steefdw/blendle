<?php

namespace Steefdw\Blendle;

class Query {

    public function __call($method, $query)
    {
        $this->parameters[] = $method. '=' .urlencode(implode(',', $query));
        
        return $this;
    }

}
