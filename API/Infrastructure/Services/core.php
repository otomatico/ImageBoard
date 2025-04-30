<?php
include_once("./Infrastructure/Services/functions.php");
include_once("./Infrastructure/Services/config.php");

//Obsolete
class Core
{
    private $directories;
    public function __construct($WorkspaceFolder)
    {
        $this->directories = dir_recursive($WorkspaceFolder);
        $this->register_autoload();
    }

    public function Start()
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $path_split = explode('/', $path);
        array_shift($path_split);
        $method = $_SERVER["REQUEST_METHOD"];
        $countArg = count($path_split);
        if ($countArg < 2 || $path_split[1] == '') {
            var_dump($path_split);
            throw new Exception("No fue declado Controlado y Metodo solo hay $countArg parametros");
        }
        $controller = $path_split[0];
        $action = $path_split[1];
        $args =  $this->GetArguments($method, $path_split);
        $this->Action($controller, $action, $args);
    }

    private function Action($controller, $action, $args)
    {
        $controller = ucwords($controller);
        $class =  $controller . 'Controller';
        $ctrl = new $class(); //por injencion de spl_autoload_register
        
        $found = $this->GetAction($class,$action);
        if($found == false){
            throw new Exception("Metodo $action de la clase $class no encontrado");
        }
        if (method_exists($ctrl, $found)) {
            call_user_func_array(array($ctrl, $found), $args);
        }
    }

    private function GetAction ($class, $find){
        $array = get_class_methods($class);
        foreach($array as $item)
        {
            if(strcasecmp($item, $find)==0)
            {
                return $item;
            }
        }
        return false;
    }

    private function GetArguments($method, $path)
    {
        if (in_array($method, ["POST", "PUT"])) {
            return json_decode(urldecode(file_get_contents("php://input")));
        }
        array_splice($path, 0, 2);
        return $path;
    }

    private function register_autoload()
    {
        spl_autoload_register(function ($className) {
            // Buscar en diferentes directorios
            $directories = $this->directories;
            foreach ($directories as $directory) {
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