<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\EnvFile\EnvFile;

class EnvFileTest extends TestCase
{
    public function testPath()
    {
        $env = new EnvFile("foo");

        $this->assertEquals($env->path(), "foo");
    }

    public function testContents()
    {
        $env = new EnvFile("foo", ["# this is a comment", "line1" => "the quick", "line2" => "brown fox", "line3" => "jumps over", "line4" => "the lazy dog"]);

        $this->assertEquals($env->contents(), "LINE1=the quick\nLINE2=brown fox\nLINE3=jumps over\nLINE4=the lazy dog");
    }

    public function testWithContents()
    {
        $env = new EnvFile("foo");
        $dupe = $env->withContents(["# this is a comment", "line1" => "the quick", "line2" => "brown fox", "line3" => "jumps over", "line4" => "the lazy dog"]);

        $this->assertNotEquals($env, $dupe);
    }

    public function testHas()
    {
        $env = new EnvFile("foo", ["# this is a comment", "line1" => "the quick", "line2" => "brown fox", "line3" => "jumps over", "line4" => "the lazy dog"]);

        $this->assertFalse($env->has(0));
        $this->assertTrue($env->has("line1"));
        $this->assertTrue($env->has("\tline1\n"));
        $this->assertTrue($env->has("\tLiNe1\n"));
    }

    public function testSet()
    {
        $env = new EnvFile("foo", ["# this is a comment", "line1" => "the quick", "line2" => "brown fox", "line3" => "jumps over", "line4" => "the lazy dog"]);

        $env->set(0, "# change the comment");
        $env->set("line1", "foo");
        $env->set("\tline2\n", "bar");
        $env->set("\tLiNe3\n", "baz");

        $this->assertNull($env->get(0));
        $this->assertEquals($env->get("line1"), "foo");
        $this->assertEquals($env->get("line2"), "bar");
        $this->assertEquals($env->get("line3"), "baz");
    }

    public function testGet()
    {
        $env = new EnvFile("foo", ["# this is a comment", "line1" => "the quick", "line2" => "brown fox", "line3" => "jumps over", "line4" => "the lazy dog"]);

        $this->assertNull($env->get(0));
        $this->assertEquals($env->get("line1"), "the quick");
        $this->assertEquals($env->get("\tline1\n"), "the quick");
        $this->assertEquals($env->get("\tLiNe1\n"), "the quick");
    }

    public function testDelete()
    {
        $env = new EnvFile("foo", ["# this is a comment", "line1" => "the quick", "line2" => "brown fox", "line3" => "jumps over", "line4" => "the lazy dog"]);
        $dupe = new EnvFile("foo", ["# this is a comment", "line1" => "the quick", "line2" => "brown fox", "line3" => "jumps over", "line4" => "the lazy dog"]);

        $env->delete(0);
        $this->assertEquals($env, $dupe);

        $env->delete("line1");
        $this->assertNotEquals($env, $dupe);
    }

    public function testToArray()
    {
        $env = new EnvFile("foo", ["# this is a comment", "line1" => "the quick", "line2" => "brown fox", "line3" => "jumps over", "line4" => "the lazy dog"]);

        $array = $env->toArray();
        $dupe = new EnvFile("bar", $array);

        $this->assertEquals($array, $dupe->toArray());
    }
}
