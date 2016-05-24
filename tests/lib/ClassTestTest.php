<?php

namespace Worky\Test;

use PHPUnit_Framework_TestCase;

class ClassTestTest extends PHPUnit_Framework_TestCase {
    public function testCanWork() {
        $a = new ClassTest();
        $this->assertEquals("hello", $a->hello(), "Its ok !");
    }
}