<?php
/**
 * @brief		Adminer Application Class
 * @author		<a href=''></a>
 * @copyright	(c) 2022 
 * @package		Invision Community
 * @subpackage	Adminer
 * @since		20 Jun 2022
 * @version		
 */
 
namespace IPS\adminer;

use IPS\Output;
use IPS\Theme;

use function array_merge;

use function is_array;


/**
 * Adminer Application Class
 */
class _Application extends \IPS\Application
{
    public static function addJs($js, $location = 'front', $app = 'adminer'): void
    {
        if (!is_array($js)) {
            $js = [$js];
        }
        $jsFiles[] = Output::i()->jsFiles;
        foreach ($js as $file) {
            $file .= '.js';
            $jsFiles[] = Output::i()->js($file, $app, $location);
        }
        Output::i()->jsFiles = array_merge(...$jsFiles);
    }

    public static function addCss($css, $location = 'front', $app = 'adminer'): void
    {
        if (!is_array($css)) {
            $css = [$css];
        }

        $cssFiles[] = Output::i()->cssFiles;
        foreach ($css as $file) {
            $file .= '.css';
            $cssFiles[] = Theme::i()->css($file, $app, $location);
        }
        Output::i()->cssFiles = array_merge(...$cssFiles);
    }
}