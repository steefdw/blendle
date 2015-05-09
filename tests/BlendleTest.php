<?php

use Steefdw\Blendle\Blendle;

class BlendleTest extends PHPUnit_Framework_TestCase {

    public function testBlendleSearch()
    {
        $blendle = new Blendle;
        
        $this->assertObjectHasAttribute('_links', $blendle->search('blendle'));
    }

}
