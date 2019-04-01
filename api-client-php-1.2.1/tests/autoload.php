<?php
spl_autoload_register(function ($classe)
{
    $classe = str_replace('\\',DIRECTORY_SEPARATOR,$classe);
    $classe = "$classe.php";
    if(file_exists($classe))
    {
        require $classe;
    }else{
        echo "ARQUIVO NÃO ENCONTRADO: ".$classe;
    }
});
?>