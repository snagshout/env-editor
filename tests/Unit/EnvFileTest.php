<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\EnvFile\EnvFile;

class EnvFileTest extends TestCase
{
    protected function createEnvFile($name)
    {
        return new EnvFile($name, [
            "# this is a comment",
            "line1" => "the quick",
            "line2" => "brown fox",
            "line3" => "jumps over",
            "line4" => "the lazy dog"
        ]);
    }

    public function testPath()
    {
        $env = $this->createEnvFile("foo");

        $this->assertEquals($env->path(), "foo");
    }

    public function testContents()
    {
        $env = $this->createEnvFile("foo");

        $this->assertEquals($env->contents(), "LINE1=the quick\nLINE2=brown fox\nLINE3=jumps over\nLINE4=the lazy dog");
    }

    public function testWithContents()
    {
        $env = new EnvFile("foo");
        $dupe = $env->withContents([
            "# this is a comment",
            "line1" => "the quick",
            "line2" => "brown fox",
            "line3" => "jumps over",
            "line4" => "the lazy dog"
        ]);

        $this->assertNotEquals($env, $dupe);
    }

    public function testHas()
    {
        $env = $this->createEnvFile("foo");

        $this->assertFalse($env->has("0"));
        $this->assertTrue($env->has("line1"));
        $this->assertTrue($env->has("\tline1\n"));
        $this->assertTrue($env->has("\tLiNe1\n"));
    }

    public function testSet()
    {
        $env = $this->createEnvFile("foo");

        $env->set("0", "# change the comment");
        $env->set("line1", "foo");
        $env->set("\tline2\n", "bar");
        $env->set("\tLiNe3\n", "baz");

        $this->assertNull($env->get("0"));
        $this->assertEquals($env->get("line1"), "foo");
        $this->assertEquals($env->get("line2"), "bar");
        $this->assertEquals($env->get("line3"), "baz");
    }

    public function testGet()
    {
        $env = $this->createEnvFile("foo");

        $this->assertNull($env->get("0"));
        $this->assertEquals($env->get("line1"), "the quick");
        $this->assertEquals($env->get("\tline1\n"), "the quick");
        $this->assertEquals($env->get("\tLiNe1\n"), "the quick");
    }

    public function testDelete()
    {
        $env = $this->createEnvFile("foo");
        $dupe = $this->createEnvFile("foo");

        $env->delete("0");
        $this->assertEquals($env, $dupe);

        $env->delete("line1");
        $this->assertNotEquals($env, $dupe);
    }

    public function testToArray()
    {
        $env = $this->createEnvFile("foo");

        $array = $env->toArray();
        $dupe = new EnvFile("bar", $array);

        $this->assertEquals($array, $dupe->toArray());
    }
}
