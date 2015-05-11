<?php namespace Steefdw\Blendle;

use Steefdw\Blendle\Rest;

class Blendle extends Query {

    private $url        = 'https://ws.blendle.nl/search';
    protected $parameters = array();
    
    //https://ws.blendle.nl/search{?q,offset,limit,max_age,min_words,max_words,category,provider_id,users}
    public static function search($query)
    {
        $blendle = new Blendle();
        
        return Rest::fetch($blendle->url. '?q=' .$query);
    }
    
    public static function query($query)
    {
        $blendle = new Blendle();
        $blendle->parameters[] = 'q=' .$query;
        
        return $blendle;
    }          
    
    public function find()
    {
        $url = $this->url. '?' .implode($this->parameters, '&');
        
        return new Result($url);
    }
    
}
