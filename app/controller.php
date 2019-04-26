<?php namespace App;
use App\View;
class Controller
{
    function __construct()
    {

    }

    protected function render($viewPath,$data=[])
    {
        View::render($viewPath,$data);
    }
}