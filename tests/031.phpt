--TEST--
Object Serializable interface throws exceptions
--SKIPIF--
--FILE--
<?php 
if(!extension_loaded('igbinary')) {
	dl('igbinary.' . PHP_SHLIB_SUFFIX);
}

function test($variable) {
	$serialized = igbinary_serialize($variable);
	$unserialized = igbinary_unserialize($serialized);
}

class Obj implements Serializable {
	private static $count = 0;

	var $a;
	var $b;

	function __construct($a, $b) {
		$this->a = $a;
		$this->b = $b;
	}

	public function serialize() {
		$c = self::$count++;
		if ($this->a) {
			throw new Exception("exception in serialize $c");
		}
		return pack('NN', $this->a, $this->b);
	}

	public function unserialize($serialized) {
		$tmp = unpack('N*', $serialized);
		$this->__construct($tmp[1], $tmp[2]);
		$c = self::$count++;
		if ($this->b) {
			throw new Exception("exception in unserialize $c");
		}
	}
}

$a = new Obj(1, 0);
$b = new Obj(0, 1);
$c = new Obj(1, 0);
$d = new Obj(0, 1);

try {
	test(array($a, $a, $c));
} catch (Exception $e) {
	echo $e->getMessage(), "\n";
}

try {
	test(array($b, $b, $d));
} catch (Exception $e) {
	echo $e->getMessage(), "\n";
}

--EXPECT--
exception in serialize 0
exception in unserialize 3
