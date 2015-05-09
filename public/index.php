<pre>
<?php
require_once __DIR__ . '/../src/Blendle.php';
require_once __DIR__ . '/../src/Rest.php';

use Steefdw\Blendle\Blendle;

$search = Blendle::search('blendle');

var_export($search);
