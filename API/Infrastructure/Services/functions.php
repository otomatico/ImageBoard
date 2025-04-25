<?php
function JSON($obj)
{
    header("Content-type:application/json");
    echo json_encode($obj, JSON_INVALID_UTF8_SUBSTITUTE + JSON_UNESCAPED_UNICODE, 5);
}

function Ok($obj = null, $typeMine = null)
{
    if (is_null($obj)) {
        header('HTTP/1.1 200 OK');
    } else {
        if (is_null($typeMine)) {
            header("Content-type:application/json");
            echo json_encode($obj, JSON_INVALID_UTF8_SUBSTITUTE + JSON_UNESCAPED_UNICODE, 5);
        } else {
            header("Content-type:$typeMine");
            echo $obj;
        }
    }
    die();
}

function NotAuthorize($msg = null)
{
    header('HTTP/1.1 401 Not Authorize');
    if (!is_null($msg)) {
        die($msg);
    }
    die();
}

function NotFound($msg = null)
{
    header('HTTP/1.1 404 Not Found');
    if (!is_null($msg)) {
        die($msg);
    }
    die();
}

function BadRequest()
{
    header('HTTP/1.1 400 Bad Request');
    die;
}

function NotAllowed()
{
    header('HTTP/1.1 405 Method not allowed');
    header('Allow: GET, POST, PUT, DELETE');
    die;
}

function dir_recursive($ruta)
{
    $ruta = rtrim($ruta, '/') . '/';
    $queue = array($ruta);
    $results = array();

    while (!empty($queue)) {
        $currentDir = array_shift($queue);

        if (is_dir($currentDir) && $dh = opendir($currentDir)) {
            while (($file = readdir($dh)) !== false) {
                if ($file == "." || $file == "..") continue;

                $fullPath = $currentDir . $file;

                if (is_dir($fullPath)) {
                    $fullPath .= '/';
                    $results[] = $fullPath;
                    $queue[] = $fullPath;
                }
            }
            closedir($dh);
        }
    }
    return $results;
}

function str_template($str, $arr)
{
    $properties = array_keys($arr);
    foreach ($properties  as $property) {
        $value = $arr["$property"];
        $str = str_replace($property, $value, $str);
    }
    return $str;
}

function file_get_json($filename)
{
    if (!file_exists($filename)) {
        throw new Exception("No existe $filename");
    }
    $strJson = file_get_contents($filename, true);
    return json_decode($strJson, true);
}
/*
function GetHeaderExtension($ext)
{
    switch ($ext) {
        case "css":
            return "text/css;charset=UTF-8";
        case "js":
            return "text/javascript;charset=UTF-8";
        case "json":
            return "application/json;charset=UTF-8";
        case "png":
            return "image/png";
        case "jpg":
            return "image/jpg";
        case "gif":
            return "image/gif";
        case "html":
            return "text/html;charset=UTF-8";
        default:
            return "'application/octet-stream'";
    }
}*/
?>