<?php

function p($data)
{
    Symfony\Component\VarDumper\VarDumper::dump($data);
}

function clearCache()
{
    return isset($_REQUEST[CLEAR_CACHE_PARAM]) && $_REQUEST[CLEAR_CACHE_PARAM] == CLEAR_CACHE_VALUE;
}
