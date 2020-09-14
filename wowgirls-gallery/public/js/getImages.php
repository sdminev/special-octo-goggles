<?php
 
    $dir = "https://staging.wowtea.eu/img";
    if(is_dir($dir)){
        if($dd = opendir($dir)){
            while (($f = scandir($dd)) !== false)
                if($f != "." && $f != "..")
                    $files[] = $f;
            closedir($dd);
        } 
     
 
    $n = $_GET["n"];
    $response = "";
        for($i = $n; $i<$n+9; $i++){
            $response = $response.$files[$i%count($files)].';';
        }
        echo $response;
    }
?>
