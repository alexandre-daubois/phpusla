<?php

class Foo {

}

class Bar extends Foo {
    public function __construct()
    {
        new class extends Bar {

        };
    }
}
