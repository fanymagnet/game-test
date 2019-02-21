<?php

namespace common\tests\unit\models;

use common\models\MoneyPrizes;

/**
 * Class ConvertMoneyToBonusTest
 * @package common\tests\unit\models
 */
class MoneyPrizeTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    public function testConvertMoneyToBonus(): void
    {
        expect('test convert value 1', MoneyPrizes::convertMoneyToBonus(2,3.00) === 06.00)->true();
        expect('test convert value 2', MoneyPrizes::convertMoneyToBonus(5,5.45) === 27.25)->true();
        expect('test convert value 3', MoneyPrizes::convertMoneyToBonus(8,8.26) === 66.08)->true();
    }
}
