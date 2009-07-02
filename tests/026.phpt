--TEST--
Cyclic array test
--INI--
report_memleaks=0
--SKIPIF--
<?php
if(!extension_loaded('igbinary')) {
	echo "skip no igbinary";
}
--FILE--
<?php 

function test($type, $variable, $test) {
	$serialized = igbinary_serialize($variable);
	$unserialized = igbinary_unserialize($serialized);

	echo $type, "\n";
	echo substr(bin2hex($serialized), 8), "\n";
	echo $test || $unserialized == $variable ? 'OK' : 'ERROR';
	echo "\n";
}

$a = array(
	'a' => array(
		'b' => 'c',
		'd' => 'e'
	),
);

$a['f'] = &$a;

test('array', $a, true);

$a = array("foo" => &$b);
$b = array(1, 2, $a);
var_dump(unserialize(serialize($a)));
var_dump(igbinary_unserialize(igbinary_serialize($a)));



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
array
1402110161140211016211016311016411016511016614020e0014020e010e020e030e040e050102
OK
array(1) {
  ["foo"]=>
  &array(3) {
    [0]=>
    int(1)
    [1]=>
    int(2)
    [2]=>
    array(1) {
      ["foo"]=>
      &array(3) {
        [0]=>
        int(1)
        [1]=>
        int(2)
        [2]=>
        array(1) {
          ["foo"]=>
          *RECURSION*
        }
      }
    }
  }
}
array(1) {
  ["foo"]=>
  &array(3) {
    [0]=>
    int(1)
    [1]=>
    int(2)
    [2]=>
    array(1) {
      ["foo"]=>
      &array(3) {
        [0]=>
        int(1)
        [1]=>
        int(2)
        [2]=>
        array(1) {
          ["foo"]=>
          *RECURSION*
        }
      }
    }
  }
}
