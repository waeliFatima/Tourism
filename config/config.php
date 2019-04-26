<?php
// instead of writing '/' will write DIRECTORY_SEPARATOR . in windows is '/' and another thing in linux so we
// use it to solve the problem
define('DIRSEP',DIRECTORY_SEPARATOR);
define('ROOTPATH',dirname(dirname(__FILE__)).'\\');
define('VIEWPATH',ROOTPATH.'views'.DIRSEP);
define('VIEWEXTENTION','.twig');
define('MASTERPAGE',VIEWPATH.'masterpage'.VIEWEXTENTION);
