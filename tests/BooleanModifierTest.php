<?php

namespace KnightAR\Laravel\Config\Tests;

use KnightAR\Laravel\Config\Config;
use KnightAR\Laravel\Config\Modifiers\Boolean;

class BooleanModifierTest extends TestCase
{
    private $cfg;

    public function setUp(): void
    {
        parent::setUp();
        $this->cfg = new Config();
        $this->cfg->modifiers->push(new Boolean);
    }

    public function testSet()
    {
        $this->cfg->set('booltrue', true);
        $this->cfg->set('boolfalse', false);
        $data = $this->cfg->flatten();
        $this->assertSame($data['booltrue'], 'true');
        $this->assertSame($data['boolfalse'], 'false');
    }

    public function testGet()
    {
        $this->cfg->set('booltrue', true);
        $this->cfg->set('boolfalse', false);
        $this->assertTrue($this->cfg->get('booltrue'));
        $this->assertFalse($this->cfg->get('boolfalse'));
    }
}
