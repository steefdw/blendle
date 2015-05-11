<pre>
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

use Steefdw\Blendle\Blendle;

//$search = Blendle::search('blendle');
$search = Blendle::query('blendle')->limit(10)->find();

var_dump($search);
