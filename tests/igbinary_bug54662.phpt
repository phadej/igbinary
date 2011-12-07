--TEST--
Nested objects cause segfault, php bug #54662
--SKIPIF--
<?php if (!extension_loaded("igbinary")) print "skip"; ?>
--FILE--
<?php
/**
 * Proof of concept, segmentation fault (spl_array.c/igbinary.c)
 * when using nested objects.
 *
 * PHP 5.3.6, Igbinary 1.x
 *
 * @author Aleksey Korzun
 */

class Storage {
    public $storage = "a string";
}

$collection = new ArrayObject;
$collection->append(new Storage);

$ser = igbinary_serialize($collection);
$new_collection = igbinary_unserialize($ser);

var_dump($new_collection[0]->storage);
--EXPECT--
string(8) "a string"
