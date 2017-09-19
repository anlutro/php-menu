<?php
require 'vendor/autoload.php';
if (!class_exists('PHPUnit_Framework_TestCase') && class_exists('PHPUnit\Framework\TestCase')) {
    // fix newer versions of phpunit.
    class PHPUnit_Framework_TestCase extends PHPUnit\Framework\TestCase
    {

    }
}
