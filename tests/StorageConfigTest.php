<?php

namespace KnightAR\Laravel\Config\Tests;

use KnightAR\Laravel\Config\Config;
use KnightAR\Laravel\Config\Storage\File;

/**
 * Tests for Persisting Config class
 */
class StorageConfigTest extends TestCase
{
    private $sampleFile = 'assets/sample.json';
    private $sampleWrite = 'assets/write.json';

    /**
     *
     * @throws \Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        if (!is_writable(__DIR__.'/assets')) {
            throw new \Exception('Test case unable to write to assets dir');
        }

        $this->sampleFile = __DIR__.'/'.$this->sampleFile;
        $this->sampleWrite = __DIR__.'/'.$this->sampleWrite;

        if (file_exists($this->sampleWrite)) {
            unlink($this->sampleWrite);
        }
        copy($this->sampleFile, $this->sampleWrite);
    }

    public function testLoadData()
    {
        $storage = new File($this->sampleFile);
        $cfg = new Config($storage);
        $this->assertSame($cfg->get('foo.bar.something'), 'something');

    }

    public function testSaveData()
    {
        $storage = new File($this->sampleWrite);
        $cfg = new Config($storage);
        $cfg->set('name', 'first');

        $contents = file_get_contents($this->sampleWrite);
        $this->assertTrue(strpos($contents, '"name":"first"') !== false);

        $cfg->push('name', 'last');

        $contents = file_get_contents($this->sampleWrite);
        $this->assertTrue(strpos($contents, '"name[1]":"last"') !== false);

    }

    public function testClearData()
    {
        $storage = new File($this->sampleWrite);
        $cfg = new Config($storage);
        $cfg->clear();

        $contents = file_get_contents($this->sampleWrite);
        $this->assertTrue($contents === '{}');
    }
}
