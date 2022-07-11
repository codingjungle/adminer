<?php

use IPS\Settings;

$path = \str_replace('/applications/adminer/sources/Adminer/db.php', '',
        \str_replace('\\', '/', __FILE__)) . '/';
$path2 = \str_replace('Adminer/db.php', '',
        \str_replace('\\', '/', __FILE__)) . '/';
require_once $path . 'init.php';

    function adminer_object()
    {
        // required to run any plugin
        include_once 'Plugin.php';

        $plugins = array();

        // It is possible to combine customization and plugins:
        class AdminerCustomizationAdminer extends AdminerPlugin
        {
            function name() {
                // custom name in title and heading
                return Settings::i()->getFromConfGlobal('sql_database');
            }

            public function database()
            {
                return Settings::i()->getFromConfGlobal('sql_database');
            }

            function databasesPrint($missing)
            {
                return [];
            }
        }

        return new AdminerCustomizationAdminer($plugins);
    }
 
require_once($path2."Custom/adminer.php");
