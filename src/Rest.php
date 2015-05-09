<?php namespace Steefdw\Blendle;

class Rest {

    public static function fetch($url)
    {
        $rest = new Rest();

        return $rest->file_get($url); // if we don't need more functions like ->charset('latin1')
    }

    private function file_get($url)
    {
        ini_set('default_charset', 'UTF-8');

        $context  = stream_context_create($this->get_options());
        $response = file_get_contents($url, false, $context);

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
