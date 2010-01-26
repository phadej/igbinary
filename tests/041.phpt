--TEST--
Check for double NaN, Inf, and -Inf
--FILE--
<?php 
function test($type, $variable) {
	$serialized = igbinary_serialize($variable);
	$unserialized = igbinary_unserialize($serialized);

	echo $type, ": \n";
	var_dump($variable);
	var_dump($unserialized);

	echo substr(bin2hex($serialized), 8), "\n";
	echo "\n";
}

test('double NaN', NAN);
test('double Inf', INF);
test('double -Inf', -INF);

--EXPECT--
double NaN: 
float(NAN)
float(NAN)
0c7ff8000000000000

double Inf: 
float(INF)
float(INF)
0c7ff0000000000000

double -Inf: 
float(-INF)
float(-INF)
0cfff0000000000000
