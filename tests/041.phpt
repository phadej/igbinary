--TEST--
Check for double NaN, Inf, -Inf, 0, and -0. IEEE 754 doubles
--FILE--
<?php 

function str2bin($bytestring) {
	$len = strlen($bytestring);
	$output = '';

	for ($i = 0; $i < $len; $i++) {
		$bin = decbin(ord($bytestring[$i]));
		$bin = str_pad($bin, 8, '0', STR_PAD_LEFT);
		$output .= $bin;
	}

	return $output;
}

function test($type, $variable) {
	$serialized = igbinary_serialize($variable);
	$unserialized = igbinary_unserialize($serialized);

	echo $type, ":\n";
	var_dump($variable);
	var_dump($unserialized);

	echo "   6         5         4         3         2         1          \n";
	echo "3210987654321098765432109876543210987654321098765432109876543210\n";
	echo str2bin(substr($serialized, 5, 8)), "\n";
	echo "\n";
}

// exponent all-1, non zero mantissa
test('double NaN', NAN);

// sign 0, exp all-1, zero mantissa
test('double Inf', INF);

// sign 1, exp all-1, zero mantissa
test('double -Inf', -INF);

// sign 0, all-0
test('double 0.0', 0.0);

// sign 1, all-0
test('double -0.0', -1 * 0.0);

--EXPECTREGEX--
double NaN:
float\(NAN\)
float\(NAN\)
   6         5         4         3         2         1          
3210987654321098765432109876543210987654321098765432109876543210
.111111111110*1.*

double Inf:
float\(INF\)
float\(INF\)
   6         5         4         3         2         1          
3210987654321098765432109876543210987654321098765432109876543210
0111111111110000000000000000000000000000000000000000000000000000

double -Inf:
float\(-INF\)
float\(-INF\)
   6         5         4         3         2         1          
3210987654321098765432109876543210987654321098765432109876543210
1111111111110000000000000000000000000000000000000000000000000000

double 0.0:
float\(0\)
float\(0\)
   6         5         4         3         2         1          
3210987654321098765432109876543210987654321098765432109876543210
0000000000000000000000000000000000000000000000000000000000000000

double -0.0:
float\(-0\)
float\(-0\)
   6         5         4         3         2         1          
3210987654321098765432109876543210987654321098765432109876543210
1000000000000000000000000000000000000000000000000000000000000000

