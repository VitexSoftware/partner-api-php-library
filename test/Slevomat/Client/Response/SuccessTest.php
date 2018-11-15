<?php

namespace Test\Slevomat\Client\Response;

use Slevomat\Client\Response\Success;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2018-11-15 at 23:36:49.
 */
class SuccessTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Success
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Success(
            ['result' => true, 'data' => ['token' => '123456789012345',
                'code' => '234567890-123', 'voucherData' => ['title' => 'VoucherName']],
            'error' => ['code' => 0, 'message' => null]], 200);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    /**
     * @covers Slevomat\Client\Response\Success::getData
     */
    public function testGetData()
    {
        $this->object->getData();
    }

    /**
     * @covers Slevomat\Client\Response\Success::getIterator
     */
    public function testGetIterator()
    {
        $this->object->getIterator();
    }
}