--TEST--
Resource
--SKIPIF--
<?php 
if (!extension_loaded("igbinary")) print "skip\n";
if (!function_exists('curl_init')
	&& !function_exists('sqlite_open')) print "skip\n";
?>
--FILE--
<?php 
if(!extension_loaded('igbinary')) {
	dl('igbinary.' . PHP_SHLIB_SUFFIX);
}

function test($type, $variable, $test) {
	$serialized = igbinary_serialize($variable);
	$unserialized = igbinary_unserialize($serialized);

	echo $type, "\n";
	echo substr(bin2hex($serialized), 8), "\n";
	echo $test || $unserialized === null ? 'OK' : 'FAIL';
	echo "\n";
}

if (function_exists('curl_init')) {
	$test = 'curl';
	$res = curl_init('http://opensource.dynamoid.com');
} else if (function_exists('sqlite_open')) {
	$test = 'sqlite';
	$res = sqlite_open('db.txt');
}

test('resource', $res, false);

switch ($test) {
	case 'curl':
		curl_close($res);
		break;
	case 'sqlite':
		sqlite_close($res);
		@unlink('db.txt');
		break;
}

/*
 * you can add regression tests for your extension here
 *
 * the output of your test code has to be equal to the
 * text in the --EXPECT-- section below for the tests
 * to pass, differences between the output and the
 * expected text are interpreted as failure
 *
 * see php5/README.TESTING for further information on
 * writing regression tests
 */
?>
--EXPECT--
resource
00
OK
