<?php


namespace Alipay\EasySDK\Test\payment\common;


use Alipay\EasySDK\Kernel\Factory;
use Alipay\EasySDK\Test\TestAccount;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    protected $app = null;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $account = new TestAccount();
        $this->app = Factory::setOptions($account->getTestAccount());
    }

    public function testCrate()
    {
        $result = $this->app->payment()->common()->create("Iphone6 16G",
            microtime(), "88.88", "2088002656718920");
        $this->assertEquals('10000', $result['code']);
        $this->assertEquals('Success', $result['msg']);
        return $result['out_trade_no'];
    }

    public function testQuery()
    {
        $result = $this->app->payment()->common()->query('1234567890');
        $this->assertEquals('10000', $result['code']);
        $this->assertEquals('Success', $result['msg']);
    }

    public function testCancel()
    {
        $result = $this->app->payment()->common()->cancel($this->testCrate());
        $this->assertEquals('10000', $result['code']);
        $this->assertEquals('Success', $result['msg']);
    }

    public function testClose()
    {
        $result = $this->app->payment()->common()->close($this->testCrate());
        $this->assertEquals('10000', $result['code']);
        $this->assertEquals('Success', $result['msg']);
    }

    public function testRefund()
    {
        $result = $this->app->payment()->common()->refund($this->testCrate(), '0.01');
        $this->assertEquals('40004', $result['code']);
        $this->assertEquals('Business Failed', $result['msg']);
        $this->assertEquals('ACQ.TRADE_STATUS_ERROR', $result['sub_code']);
        $this->assertEquals('交易状态不合法', $result['sub_msg']);
    }
}