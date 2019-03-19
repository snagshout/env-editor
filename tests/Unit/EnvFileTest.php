<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\EnvFile\EnvFile;

class EnvFileTest extends TestCase
{
    public function contentProvider()
    {
        return [
            [
                "# this is a comment",
                "line1" => "the quick",
                "line2" => "brown fox",
                "line3" => "jumps over",
                "line4" => "the lazy dog"
            ]
        ];
    }

    public function testPath()
    {
        $env = new EnvFile("foo");

        $this->assertEquals($env->path(), "foo");
    }

    /**
     * @dataProvider contentProvider
     */
    public function testContents($content)
    {
        $env = new EnvFile("foo", $content);

        $this->assertEquals($env->contents(), "LINE1=the quick\nLINE2=brown fox\nLINE3=jumps over\nLINE4=the lazy dog");
    }

    /**
     * @dataProvider contentProvider
     */
    public function testWithContents($content)
    {
        $env = new EnvFile("foo");
        $dupe = $env->withContents($content);

        $this->assertNotEquals($env, $dupe);
    }

    /**
     * @dataProvider contentProvider
     */
    public function testHas($content)
    {
        $env = new EnvFile("foo", $content);

        $this->assertFalse($env->has("0"));
        $this->assertTrue($env->has("line1"));
        $this->assertTrue($env->has("\tline1\n"));
        $this->assertTrue($env->has("\tLiNe1\n"));
    }

    /**
     * @dataProvider contentProvider
     */
    public function testSet($content)
    {
        $env = new EnvFile("foo", $content);

        $env->set("0", "# change the comment");
        $env->set("line1", "foo");
        $env->set("\tline2\n", "bar");
        $env->set("\tLiNe3\n", "baz");

        $this->assertNull($env->get("0"));
        $this->assertEquals($env->get("line1"), "foo");
        $this->assertEquals($env->get("line2"), "bar");
        $this->assertEquals($env->get("line3"), "baz");
    }

    /**
     * @dataProvider contentProvider
     */
    public function testGet($content)
    {
        $env = new EnvFile("foo", $content);

        $this->assertNull($env->get("0"));
        $this->assertEquals($env->get("line1"), "the quick");
        $this->assertEquals($env->get("\tline1\n"), "the quick");
        $this->assertEquals($env->get("\tLiNe1\n"), "the quick");
    }

    /**
     * @dataProvider contentProvider
     */
    public function testDelete($content)
    {
        $env = new EnvFile("foo", $content);
        $dupe = new EnvFile("foo", $content);

        $env->delete("0");
        $this->assertEquals($env, $dupe);

        $env->delete("line1");
        $this->assertNotEquals($env, $dupe);
    }

    /**
     * @dataProvider contentProvider
     */
    public function testToArray($content)
    {
        $env = new EnvFile("foo", $content);

        $array = $env->toArray();
        $dupe = new EnvFile("bar", $array);

        $this->assertEquals($array, $dupe->toArray());
    }
}
