<?php

namespace Steefdw\Blendle;

use Steefdw\Blendle\Rest;

class Blendle {

    public function search($query)
    {
        return Rest::fetch('https://ws.blendle.nl/search?q=' . $query);
    }

}
