<?php

namespace Test\Slevomat\Client;

use Slevomat\Client\Factory;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2018-11-15 at 23:34:55.
 */
class FactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Factory
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Factory();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    public function badValues(): array
    {
        return [
            ['invalid json'],
            ['{"error": "true"}'],
            ['{"result":true,"data":"error","error":{"code":1102,"message":"Invalid token was provided."}}'],
            ['{"result":false,"data":{},"error":{}}']
        ];
    }

    /**
     * @covers Slevomat\Client\Factory::create
     */
    public function testCreate()
    {
        $this->object->create('{"result":false,"data":{},"error":{"code":1102,"message":"Invalid token was provided."}}',
            403);
    }

    /**
     * @dataProvider badValues
     * @expectedException \RuntimeException
     * @covers Slevomat\Client\Factory::create
     */
    public function testCreateExeptions($badValue)
    {
        $this->object->create($badValue, 403);
    }
}
