<?php
/**
 * Created by JetBrains PhpStorm.
 * User: once
 * Date: 9/12/14
 * Time: 8:02 PM
 * To change this template use File | Settings | File Templates.
 */
require_once __DIR__ . '/../src/autoload.php';

use Runkit\RunkitFunction;

function alert() {
	$t = 1;


	return $t;
}

$t = new RunkitFunction('alert');
echo $t->getCode()."\n";

$t->setCode('$t = 123;return $t;');
$t->redefine();
echo alert(). "\n\n";
echo $t->getCode() . "\n\n";

$newAlert = $t->copy('newAlert');
echo newAlert();

$runkitTestFunction = new RunkitFunction('test');
$runkitTestFunction->setCode('return rand(1,20);');
$runkitTestFunction->add();

echo "Test invoke\n";
echo "Result: " . $runkitTestFunction() . "\n\n";


$runkitTestFunction->setArguments(array(
	'$a',
	'$b'
));
$runkitTestFunction->setCode('echo $a + $b; echo "\n";');
$runkitTestFunction->redefine();

test(1, 2);
test(1, 3);
test(2, 3);

