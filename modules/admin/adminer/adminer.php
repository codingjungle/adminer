<?php


namespace IPS\adminer\modules\admin\adminer;

/* To prevent PHP errors (extending class does not exist) revealing path */

use Exception;
use IPS\adminer\Application;
use IPS\Http\Url;
use IPS\Output;
use IPS\Theme;

use function gzdecode;
use function libxml_use_internal_errors;
use function ob_end_clean;
use function ob_get_clean;
use function ob_start;
use function pq;
use function str_replace;

use function header;
use function mb_strpos;
use function preg_replace;
use const TRUE;


if ( !\defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
	header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
	exit;
}

/**
 * adminer
 */
class _adminer extends \IPS\Dispatcher\Controller
{
    /**
 * @brief    Has been CSRF-protected
 */
    public static $csrfProtected = true;
	/**
	 * Execute
	 *
	 * @return	void
	 */
	public function execute()
	{
		\IPS\Dispatcher::i()->checkAcpPermission( 'adminer_manage' );
		parent::execute();
	}

	/**
	 * ...
	 *
	 * @return	void
	 */
	protected function manage()
	{
        Application::addJs(['admin_click'], 'admin');
        Application::addCss(['adminer'], 'admin');

        ob_start();
        require Application::getRootPath(
                'toolbox'
            ) . '/applications/adminer/sources/Adminer/db.php';
        $content = ob_get_clean();
        try {
            ob_end_clean();
        } catch (Exception $e) {
        }
        /* Swap out certain tags that confuse phpQuery */
        $content = preg_replace( '/<(\/)?(html|head|body)(>| (.+?))/', '<$1temp$2$3', $content );
        $content = str_replace( '<!DOCTYPE html>', '<tempdoctype></tempdoctype>', $content );

        /* Load phpQuery  */
        require_once Application::getRootPath('core') . '/system/3rd_party/phpQuery/phpQuery.php';
        libxml_use_internal_errors(TRUE);
        $phpQuery = \phpQuery::newDocumentHTML( $content );
        $url = (string) Url::internal('app=adminer&module=adminer&controller=adminer&do=adminer');
        /** @var \DOMElement $link */
        foreach($phpQuery->find('link') as $link){
            $l = $link->getAttribute('href');
            if( $l ) {
                pq($link)->remove();
            }
        }
        $foo = [];
        /** @var \DOMElement $script */
        foreach($phpQuery->find('script') as $script){
            $l = $script->getAttribute('src');
            if($l) {
                pq($script)->attr('src',$url.str_replace('?','&',$l));
            }
            else{
                $d = pq($script)->html();
                $d = str_replace('?server', $url.'&server',$d);
                pq($script)->html($d);
            }
        }
        $url2 = (string) Url::internal('app=adminer&module=adminer&controller=adminer');

        foreach($phpQuery->find('a') as $a ){
            $a = pq($a);
            $ref = $a->attr('href');
            if(mb_strpos($ref,'?server=') !== false){
                $ref = str_replace('?server',$url2.'&server',$ref);
            }
            $a->attr('href',$ref);
        }
        $return = $phpQuery->htmlOuter();
        $return = preg_replace( '/<(\/)?temp(html|head|body)(.*?)>/', '<$1$2$3>', $return );
        $return = str_replace( '<tempdoctype></tempdoctype>', '<!DOCTYPE html>', $return );

        Output::i()->output = Theme::i()->getTemplate('adminer', 'adminer', 'admin')->adminer($return);
	}

    protected function adminer(){
        ob_start();
        require Application::getRootPath(
                'toolbox'
            ) . '/applications/adminer/sources/Adminer/adminer.php';
        $content = ob_get_clean();
        try {
            ob_end_clean();
        } catch (Exception $e) {
        }
        Output::i()->sendOutput($content);
    }
	// Create new methods with the same name as the 'do' parameter which should execute it
}