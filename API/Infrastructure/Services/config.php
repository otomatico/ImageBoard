<?php
include_once("functions.php");
function LoadSettings($WorkspaceFolder)
{
    $appsetting = file_get_json($WorkspaceFolder . "/appsettings.json");
    $GLOBALS["AppSettings"] = $appsetting;
    //foreach (array_keys($appsetting) as $property) {
    //    DEFINE($property, str_template($appsetting[$property], array('%WorkspaceFolder%' => $WorkspaceFolder)));
    //}
    
}
