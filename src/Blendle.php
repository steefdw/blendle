<?php namespace Steefdw\Blendle;

use Steefdw\Blendle\Rest;

class Blendle extends Query {

    private $url        = 'https://ws.blendle.nl/search';
    protected $parameters = array();

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
