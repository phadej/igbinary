--TEST--
https://github.com/igbinary/igbinary/issues/15
--SKIPIF--
<?php if (!extension_loaded("igbinary")) print "skip"; ?>
--FILE--
<?php
$o = new ArrayObject;
$o->append($o);

$serialized = igbinary_serialize($o);
$un = igbinary_unserialize($serialized);

echo ($un == $un[0]) ? "true" : "false";
?>
--EXPECT--
true
