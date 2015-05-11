<?php

namespace Steefdw\Blendle;

class Query {

    public function offset($query)
    {
        $this->parameters[] = 'offset=' .$query;
        
        return $this;
    }
        
    public function limit($query)
    {
        $this->parameters[] = 'limit=' .$query;
        
        return $this;
    }  
    
    public function max_age($query)
    {
        $this->parameters[] = 'max_age=' .$query;
        
        return $this;
    }      
    
    public function min_words($query)
    {
        $this->parameters[] = 'min_words=' .$query;
        
        return $this;
    }      
    
    public function max_words($query)
    {
        $this->parameters[] = 'max_words=' .$query;
        
        return $this;
    }   
    
    public function category($query)
    {
        $this->parameters[] = 'category=' .$query;
        
        return $this;
    }       
    
    public function provider_id($query)
    {
        $this->parameters[] = 'provider_id=' .$query;
        
        return $this;
    }       
    
    public function users($query)
    {
        $this->parameters[] = 'users=' .$query;
        
        return $this;
    } 

}
