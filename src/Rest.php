<?php namespace Steefdw\Blendle;

class Rest {

    public static function fetch($url)
    {
        $rest = new Rest();

        return $rest->file_get($url);
    }

    private function file_get($url)
    {
        ini_set('default_charset', 'UTF-8');
        
        set_error_handler(
            create_function(
                '$severity, $message, $file, $line', 
                'throw new ErrorException($message, $severity, $severity, $file, $line);'
            )
        );

        try
        {
            $context  = stream_context_create($this->get_options());
            $response = file_get_contents($url, false, $context);
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }

        restore_error_handler();

        return json_decode($response);
    }

    private function get_options()
    {
        return array(
            'http' => array(
                'method' => "GET",
            )
        );
    }

}
