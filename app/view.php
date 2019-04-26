<?php namespace App;
use Couchbase\Exception;
class View{
   public static function render($viewpath, $data)
    {
        $viewpath = str_replace('.', DIRSEP, $viewpath).VIEWEXTENTION;
        $loader = new \Twig_Loader_Filesystem(VIEWPATH);
        $twig = new \Twig_Environment($loader);
        echo $twig->render($viewpath,$data);

    }
}