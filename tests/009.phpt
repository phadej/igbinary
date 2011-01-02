--TEST--
Check for reference serialisation
--INI--
report_memleaks=0
--SKIPIF--
<?php
if(!extension_loaded('igbinary')) {
	echo "skip no igbinary";
}
--FILE--
<?php 

function test($type, $variable, $test = true) {
	$serialized = igbinary_serialize($variable);
	$unserialized = igbinary_unserialize($serialized);

	echo $type, "\n";
	echo substr(bin2hex($serialized), 8), "\n";
	echo !$test || $unserialized == $variable ? 'OK' : 'ERROR', "\n";

	$dump_exp = print_r($variable, true);
	$dump_act = print_r($unserialized, true);

	if ($dump_act !== $dump_exp) {
		echo "But var dump differs:\n", $dump_act, "\n", $dump_exp, "\n";
	}
}

$a = array('foo');

test('array($a, $a)', array($a, $a), true);
test('array(&$a, &$a)', array(&$a, &$a), true);

$a = array(null);
$b = array(&$a);
$a[0] = &$b;

test('cyclic $a = array(&array(&$a))', $a, false);

--EXPECT--
array($a, $a)
14020600140106001103666f6f06010101
OK
array(&$a, &$a)
1402060025140106001103666f6f0601250101
OK
cyclic $a = array(&array(&$a))
1401060025140106002514010600250101
OK
