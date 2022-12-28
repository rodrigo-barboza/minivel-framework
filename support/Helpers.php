<?php

function createEnv()
{
    $env_path = "./.env";

    if (file_exists($env_path)) {
        $env_variables = file(
            $env_path, 
            FILE_IGNORE_NEW_LINES | 
            FILE_SKIP_EMPTY_LINES
        );

        foreach($env_variables as $line) {
            list($var_name, $value) = explode('=', $line);
            
            $var_name = trim($var_name);
            $value = trim($value);
            
            if (!array_key_exists($var_name, getenv())) {
                putenv("$var_name=$value");
            }
        }
    }
}

function env(string $var_name, string $default=null)
{
    $var_env = getenv($var_name);

    if ($var_env) {
        return $var_env;
    }

    return $default;
}
