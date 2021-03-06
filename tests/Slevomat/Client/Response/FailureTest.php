<?php

namespace Slevomat\Client\Response;

use Slevomat\Client\Response\Failure;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2018-11-15 at 23:34:45.
 */
class FailureTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Failure
     */
    protected $object;

    /**
     * Success test data
     * @var array 
     */
    public $testData = [
        'result' => false,
        'error' => [
            'code' => 1102,
            'message' => 'Invalid token was provided.'
        ]
    ];

    /**
     * Get Method accessible
     * 
     * @param string $name
     * 
     * @return type
     */
    protected static function getMethod($name)
    {
        $class  = new \ReflectionClass('Slevomat\Client\Response\Failure');
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Failure($this->testData, 403);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    /**
     * Test Constructor
     *
     * @covers Slevomat\Client\Response\Failure::__construct
     */
    public function testConstructor()
    {
        // Get mock, without the constructor being called
        $mock = $this->getMockBuilder(get_class($this->object))
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $mock->__construct($this->testData, 403);
    }

    /**
     * @covers Slevomat\Client\Response\Failure::parseResponseData
     */
    public function testParseResponseData()
    {
        $parseResponseData = self::getMethod('parseResponseData');
        $result            = $parseResponseData->invokeArgs($this->object,
            [['error' => ['code' => 500, 'message' => 'test error message']]]);
    }

    /**
     * @covers Slevomat\Client\Response\Failure::getData
     */
    public function testGetData()
    {
        $this->object->getData();
    }

    /**
     * @covers Slevomat\Client\Response\Failure::getCode
     */
    public function testGetCode()
    {
        $this->object->getCode();
    }

    /**
     * @covers Slevomat\Client\Response\Failure::getMessage
     */
    public function testGetMessage()
    {
        $this->object->getMessage();
    }

    /**
     * @covers Slevomat\Client\Response\Common::getResult
     */
    public function testGetResult()
    {
        $this->object->getResult();
    }

    /**
     * @covers Slevomat\Client\Response\Common::getHttpCode
     */
    public function testGetHttpCode()
    {
        $this->object->getHttpCode();
    }
}
