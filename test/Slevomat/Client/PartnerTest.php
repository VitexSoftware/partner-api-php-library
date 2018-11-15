<?php

namespace Test\Slevomat\Client;

use Slevomat\Client\Partner;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2018-11-15 at 22:53:41.
 */
class PartnerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Slevomat_Client_Partner
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Partner(Partner::SERVER_CZ,
            constant('SLEVOMAT_TOKEN'));
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    /**
     * @covers Slevomat_Client_Partner::checkVoucher
     */
    public function testCheckVoucher()
    {
        $code = constant('VOUCHER_CODE');
        $this->object->checkVoucher($code, $response);
    }

    /**
     * @covers Slevomat_Client_Partner::applyVoucher
     */
    public function testApplyVoucher()
    {
        $code = constant('VOUCHER_CODE');
        $this->object->applyVoucher($code, $response);
    }
}