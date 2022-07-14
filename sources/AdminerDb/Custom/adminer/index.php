<?php
/** Adminer - Compact database management
* @link https://www.adminer.org/
* @author Jakub Vrana, https://www.vrana.cz/
* @copyright 2007 Jakub Vrana
* @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
*/

use IPS\Settings;
use IPS\toolbox\Profiler\Debug;
use IPS\Dispatcher\Build;
use IPS\Session\Front;

$ipsPath = \str_replace('/applications/adminer/sources/AdminerDb/Custom/adminer.php', '',
        \str_replace('\\', '/', __FILE__)) . '/';
require_once $ipsPath . 'init.php';

Build::i();
Front::i();
$auth = [
    'driver' => 'server',
    'server' => Settings::i()->getFromConfGlobal('sql_host'),
    'username' => Settings::i()->getFromConfGlobal('sql_user'),
    'password' => Settings::i()->getFromConfGlobal('sql_pass'),
    'db' => Settings::i()->getFromConfGlobal('sql_database'),
    'permanent' => true,
];
//seems to be cause the adminer devs are stupid?
$sql='mysql';
function ipsDebug($message){
    Debug::log($message);
};
function ipsUrl(){
    $url = (string) '&app=adminer&module=adminer&controller=adminer';
    if(isset($_GET['dbApp'])){
        $url .= '&dbApp='.$_GET['dbApp'];
    }
    return $url;
}

include "./include/bootstrap.inc.php";
include "./include/tmpfile.inc.php";

$enum_length = "'(?:''|[^'\\\\]|\\\\.)*'";
$inout = "IN|OUT|INOUT";

if (isset($_GET["select"]) && ($_POST["edit"] || $_POST["clone"]) && !$_POST["save"]) {
	$_GET["edit"] = $_GET["select"];
}
if (isset($_GET["callf"])) {
	$_GET["call"] = $_GET["callf"];
}
if (isset($_GET["function"])) {
	$_GET["procedure"] = $_GET["function"];
}

if (isset($_GET["download"])) {
	include "./download.inc.php";
} elseif (isset($_GET["table"])) {
	include "./table.inc.php";
} elseif (isset($_GET["schema"])) {
	include "./schema.inc.php";
} elseif (isset($_GET["dump"])) {
	include "./dump.inc.php";
} elseif (isset($_GET["privileges"])) {
	include "./privileges.inc.php";
} elseif (isset($_GET["sql"])) {
	include "./sql.inc.php";
} elseif (isset($_GET["edit"])) {
	include "./edit.inc.php";
} elseif (isset($_GET["create"])) {
	include "./create.inc.php";
} elseif (isset($_GET["indexes"])) {
	include "./indexes.inc.php";
} elseif (isset($_GET["database"])) {
	include "./database.inc.php";
} elseif (isset($_GET["scheme"])) {
	include "./scheme.inc.php";
} elseif (isset($_GET["call"])) {
	include "./call.inc.php";
} elseif (isset($_GET["foreign"])) {
	include "./foreign.inc.php";
} elseif (isset($_GET["view"])) {
	include "./view.inc.php";
} elseif (isset($_GET["event"])) {
	include "./event.inc.php";
} elseif (isset($_GET["procedure"])) {
	include "./procedure.inc.php";
} elseif (isset($_GET["sequence"])) {
	include "./sequence.inc.php";
} elseif (isset($_GET["type"])) {
	include "./type.inc.php";
} elseif (isset($_GET["trigger"])) {
	include "./trigger.inc.php";
} elseif (isset($_GET["user"])) {
	include "./user.inc.php";
} elseif (isset($_GET["processlist"])) {
	include "./processlist.inc.php";
} elseif (isset($_GET["select"])) {
	include "./select.inc.php";
} elseif (isset($_GET["variables"])) {
	include "./variables.inc.php";
} elseif (isset($_GET["script"])) {
	include "./script.inc.php";
} else {
	include "./db.inc.php";
}

// each page calls its own page_header(), if the footer should not be called then the page exits
page_footer();
