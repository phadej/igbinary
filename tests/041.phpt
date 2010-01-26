--TEST--
Check for double NaN, Inf, -Inf, 0, and -0
--FILE--
<?php 
function test($type, $variable) {
	$serialized = igbinary_serialize($variable);
	$unserialized = igbinary_unserialize($serialized);

	echo $type, ":\n";
	var_dump($variable);
	var_dump($unserialized);

	echo substr(bin2hex($serialized), 8), "\n";
	echo "\n";
}

test('double NaN', NAN);
test('double Inf', INF);
test('double -Inf', -INF);
test('double 0.0', 0.0);
test('double -0.0', -0.0);

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

double 0.0:
float(0)
float(0)
0c0000000000000000

double -0.0:
float(0)
float(0)
0c0000000000000000

