<?php

class Router{
    private array $routes;
    private $directories;
    public function __construct($WorkspaceFolder)
    {
        $this->directories = dir_recursive($WorkspaceFolder);
        $this->register_autoload();
        foreach(HttpMethod::cases() as $method){
            $this->routes[$method->value]=[];
        }
    }

    public function Get(string $uri, Closure|array|string $action){
        $route = new Route($uri,$action);
        $this->routes[HttpMethod::GET->value][]=$route;
    }

    public function Post(string $uri, Closure|array|string $action){
        $route = new Route($uri,$action);
        $this->routes[HttpMethod::POST->value][]=$route;
    }

    public function Put(string $uri, Closure|array|string $action){
        $route = new Route($uri,$action);
        $this->routes[HttpMethod::PUT->value][]=$route;
    }

    public function Delete(string $uri, Closure|array|string $action){
        $route = new Route($uri,$action);
        $this->routes[HttpMethod::DELETE->value][]=$route;
    }

    public function Resolve(){

        $method = $_SERVER["REQUEST_METHOD"];
        $uri = strtolower($this->GetURI());
        $route = $this->ComparePathWihtDictonary($this->routes[$method],$uri);
        if(!is_null($route)){
            $args = $this->GetArguments($method,$uri,$route);
            $this->ExecMethod($route,$args);
        }
    }

    private function GetURI():string{
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode('/', $path);
        return implode('/',$uri);
    }

    private function ComparePathWihtDictonary(array $items, string $path):?Route{
        foreach($items as $item)
        {
            $exist = $item->matches($path);
            if($exist)
            {
                return $item;
            }
        }
        return null;
    }

    private function GetArguments(string $method, string $path,Route $route)
    {
        if (in_array($method, ["POST", "PUT"])) {
            $buffer =  file_get_contents("php://input");
            return json_decode(urldecode($buffer));
        }
        //$path = explode('/',$path);
        //if(count($path)>2){
        //    $path = array_splice($path, 3);
        //}
        $args= $route->parseParameters($path);
        return $args;
    }

    private function ExecMethod(Route $route, object|array|string $args){
        $fn = $route->action;
        if(is_array($route->action))
        {
            $className =  $route->action[0];
            $methodName =  $route->action[1];
            $controller = new $className(); 
            $fn= array($controller, $methodName);
            //$controller->$methodName($args);
            //die;
        }
        if(is_array($args)){
            call_user_func_array($fn, $args);    
        }else{
            call_user_func($fn, $args); 
        }
        die;
    }

    private function register_autoload()
    {
        spl_autoload_register(function ($className) {
            // Buscar en diferentes directorios
            foreach ($this->directories as $directory) {
                $filename = $directory . $className . '.php';
                if (file_exists($filename)) {
                    include $filename;
                    return;
                }
            }
            throw new Exception("No se pudo cargar la clase $className");
        });
    }
}
?>