<pre>
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once __DIR__ . '/../vendor/autoload.php';

use Steefdw\Blendle\Blendle;

//$search = Blendle::search('blendle');
$search = Blendle::query('blendle')->limit(10)->offset(10)->find();

var_dump($search->total());
var_dump($search->url_fetched());
var_dump($search->snippets());
var_dump($search->results());
var_dump($search->articles());
var_dump($search->next()->articles());
var_dump($search->prev()->articles());
