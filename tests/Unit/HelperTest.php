<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HelperTest extends TestCase
{
    public function testNormalizeKeyValueArray()
    {
        $input = [
            ["key" => "line1", "value" => "the quick"],
            ["key" => "line2", "value" => "brown fox"],
            ["key" => "line3", "value" => "jumps over"],
            ["key" => "line4", "value" => "the lazy dog"],
        ];

        $output = normalize_key_value_array($input);
        $expected = ["line1" => "the quick", "line2" => "brown fox", "line3" => "jumps over", "line4" => "the lazy dog"];

        $this->assertEquals($output, $expected);
    }

    public function testNormalizeKeyValueArrayWithInvalidKey()
    {
        $input = [
            ["invalid-index" => "line1", "value" => "the quick"],
            ["key" => "line2", "value" => "brown fox"],
            ["key" => "line3", "value" => "jumps over"],
            ["key" => "line4", "value" => "the lazy dog"],
        ];

        $output = normalize_key_value_array($input);
        $expected = ["line2" => "brown fox", "line3" => "jumps over", "line4" => "the lazy dog"];

        $this->assertEquals($output, $expected);
    }

    public function testNormalizeKeyValueArrayWithEmptyValue()
    {
        $input = [
            ["key" => "line1", "value" => null],
            ["key" => "line2", "value" => "brown fox"],
            ["key" => "line3", "value" => "jumps over"],
            ["key" => "line4", "value" => "the lazy dog"],
        ];

        $output = normalize_key_value_array($input);
        $expected = ["line1" => null, "line2" => "brown fox", "line3" => "jumps over", "line4" => "the lazy dog"];

        $this->assertEquals($output, $expected);
    }
}
