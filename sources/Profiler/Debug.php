<?php

/**
* @brief      Debug Class
* @author     -storm_author-
* @copyright  -storm_copyright-
* @package    IPS Social Suite
* @subpackage adminer
* @since      1.0.0 Beta 2
* @version    -storm_version-
*/

namespace IPS\adminer\Profiler;

use IPS\adminer\Profiler\Debug;

if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) ) {
    header( ( $_SERVER[ 'SERVER_PROTOCOL' ] ?? 'HTTP/1.0' ) . ' 403 Forbidden' );
    exit;
}

/**
* Debug Class
* @mixin Debug
*/
class _Debug
{

    /**
    * _Debug constructor
    *
    */
    public function __construct(){

        
    }

    public static function __callStatic( $method, $args ){

        if( defined('DTPROFILER') && DTPROFILER && class_exists( \IPS\toolbox\Profiler\Debug::class) ){
            $class =  \IPS\toolbox\Profiler\Debug::class;
            if( method_exists($class, $method ) ){
                $class::{$method}(...$args);
            }
        }
        else if( $method === 'add' ){
            list( $message, $key, ) = $args;
            \IPS\Log::debug($message, $key);
        }
    }
}