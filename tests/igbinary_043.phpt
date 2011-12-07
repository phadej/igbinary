--TEST--
Object serialization with compact strings
--SKIPIF--
<?php
	if (!extension_loaded("igbinary")) {
		print "skip";
	}
?>
--INI--
igbinary.compact_strings=Off
--FILE--
<?php
class Foo {
}

class Bar {
}


$expected_array = array();
for ($i = 0; $i < 10; $i++) {
	$expected_array['foo_' . $i] = new Foo;
	$expected_array['bar_' . $i] = new Bar;
}

$actual_array = igbinary_unserialize(igbinary_serialize($expected_array));

$error = 'OK';

foreach ($expected_array as $key => $object) {
	if (!isset($actual_array[$key])) {
		$error = 'ERROR';
		echo "Key $key is missing from result.\n";
		echo "Expected key/value:\n";
		var_dump($key, $object);
		var_dump($object);

		break;
	}

	if (!is_object($actual_array[$key]) ||
		get_class($object) !== get_class($actual_array[$key])) {
		$error = 'ERROR';
		echo "Array mismatch on $key\n";
		echo "Expected key/value:\n";
		var_dump($key, $object);
		echo "Actual key/value:\n";
		var_dump($key, $actual_array[$key]);

		break;
	}

}

echo $error, "\n";

--EXPECT--
OK
