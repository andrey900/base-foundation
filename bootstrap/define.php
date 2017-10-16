<?php

define("DS", DIRECTORY_SEPARATOR);
define("BASE_PATH", realpath('..').DS);
define("APP_DIR", "app");
define("APP_PATH", BASE_PATH.APP_DIR.DS);
define("VAR_DIR", "var");
define("VAR_PATH", BASE_PATH.VAR_DIR.DS);
define("CACHE_DIR", "cache");
define("CACHE_PATH", VAR_PATH.CACHE_DIR.DS);
define("LOG_DIR", "logs");
define("LOG_PATH", VAR_PATH.LOG_DIR.DS);
define("PUBLIC_DIR", "public");
define("PUBLIC_PATH", BASE_PATH.PUBLIC_DIR.DS);
define("CONFIG_DIR", "config");
define("CONFIG_PATH", BASE_PATH.CONFIG_DIR.DS);
define("TEMPLATES_DIR", "templates");
define("TEMPLATES_PATH", BASE_PATH.TEMPLATES_DIR.DS);

define('CLEAR_CACHE_PARAM', 'clear_cache');
define('CLEAR_CACHE_VALUE', '1');