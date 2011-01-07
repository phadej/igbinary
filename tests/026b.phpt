--TEST--
Cyclic array test 2
--INI--
report_memleaks=0
--SKIPIF--
<?php
if(!extension_loaded('igbinary')) {
	echo "skip no igbinary";
}

if (version_compare(PHP_VERSION, "5.2.16", "<")) {
	echo "skip only test on php version 5.2.16 and above
}

--FILE--
<?php

$a = array("foo" => &$b);
$b = array(1, 2, $a);
var_dump($a);

/* all three statements below should produce same output however PHP stock
 * unserialize/serialize produces different output (5.2.16). I consider this is
 * a PHP bug. - Oleg Grenrus
 */

//$k = $a;
//$k = unserialize(serialize($a));
$k = igbinary_unserialize(igbinary_serialize($a));
var_dump($k);

$k["foo"][1] = "b";
var_dump($k);

?>
--EXPECT--
array(1) {
  ["foo"]=>
  &array(3) {
    [0]=>
    int(1)
    [1]=>
    int(2)
    [2]=>
    *RECURSION*
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
    *RECURSION*
  }
}
array(1) {
  ["foo"]=>
  &array(3) {
    [0]=>
    int(1)
    [1]=>
    string(1) "b"
    [2]=>
    array(1) {
      ["foo"]=>
      *RECURSION*
    }
  }
}
