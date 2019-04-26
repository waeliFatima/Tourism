<?php
class Router
{

    private static $_routes = [],
        $_defaultConfig = [
        'method' => 'GET'
    ];
    public static function route($url)
    {

        $checkedroute = self::checkRoute($url);
        if(is_callable($checkedroute['action'])){
            call_user_func_array($checkedroute['action'],$checkedroute['params']);


        }
       elseif ($checkedroute !== false) {
           $urlParts = explode('.', $checkedroute['action']);
           $controllerName = str_replace('Controller','',$urlParts[0] );
         //  dd($controllerName);
           //$actionName = (isset($urlpath[1]) ? $urlParts[1] : 'index') . 'Action';
           $actionName = $urlParts[1] . 'Action';
           $params = $checkedroute['params'];
           $controllerClassName = 'App\\Controllers\\'.ucfirst($controllerName).'Controller';
          // dd($controllerClassName);
           $ctrl = new $controllerClassName;
           if (method_exists($ctrl, $actionName)) {

               call_user_func_array(array($ctrl, $actionName), $params);
           } else
               echo "error : action" . $actionName . "does not exist";


       }else {
            echo '404';
        }
    }


    public static function register($route, $routeAction,$config=[])
    {
        $config =self::getConfigs($config);
        preg_match_all('/^([^{]+)\//', $route, $matches);
        $rParams = [];
        $rName = isset($matches[1][0]) ? $matches[1][0] : $route;
        if ($rName !== $route) {

            preg_match_all('/\/{([^}]+)}/U', $route, $matches);
            $rParams = $matches[1];
        }
        $config['name']=$rName;
        $config['action'] = $routeAction;
        $config['params'] = $rParams;
        self::$_routes[] = $config;
       //echo '<pre>';print_r(self::$_routes[$rName]);exit;
    }

    private static function checkRoute($url){
       foreach (self::$_routes as $conf) {
            $name = $conf['name'];
            $filterParams = self::removeArbitratyParams($conf['params']);
            $urlname = rtrim(substr($url, 0, strlen($name . '/')), '/') ;
            if ($name  === ($urlname !== ''? $urlname : '/') ) {
                if( $_SERVER['REQUEST_METHOD']== $conf['method']) {
                    $urlparts = explode('/',rtrim (substr($url,strlen($name)), '/'));
                    clearArray($urlparts);
                    if ($name =='/' ||  count($conf['params']) >= count($urlparts)) {
                        foreach ($urlparts as $index => $value) {
                            if ($urlparts[$index])
                                $filterParams[$index] = $urlparts[$index];
                        }

                        $conf['params'] = $filterParams;
                        return $conf;
                    }
                }
            }
        }
        return false;
    }
    private static function removeArbitratyParams($params){
        $params2 = [];
        foreach ($params as $key=>$value) {
            if ($value[0] === '?') {
                return $params2;
            }
            $params2[] = $value;
        }
        return [];
    }
private static function getConfigs($config){
        $ret = self::$_defaultConfig;
        foreach ($config as $cName => $cVal){
            $ret[$cName] = $cVal;
        }
        return $ret;
}
}