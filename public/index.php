<pre>
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once __DIR__ . '/../vendor/autoload.php';

use Steefdw\Blendle\Blendle;

//$search = Blendle::search('blendle');
$search = Blendle::query('blendle')
        ->limit(10)
        ->offset(10)
        ->min_words(10)
        ->max_words(100)
        ->provider_id('economist') // doesn't work
        ->max_age(1)               // how does this work?
        //->category('new')
        ->find();

?>
Fetched: <a href="<?php echo $search->url_fetched() ?>"><?php echo $search->url_fetched() ?></a>
Total results: <strong><?php echo $search->total() ?></strong>

Result snippets:
<?php
foreach($search->snippets() as $snippet)
{ 
    echo "  - ".$snippet.PHP_EOL;
}
?>

Methods:
  - Get the next set of articles:     <strong>$search->next()->articles()</strong>
  - Get the previous set of articles: <strong>$search->prev()->articles())</strong>
  - Show the whole result set:        <strong>$search->results()</strong>

The result for <strong>$search->articles()</strong>

<?php var_dump($search->articles()); ?>
