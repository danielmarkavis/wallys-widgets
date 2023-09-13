<?php

namespace Tests\Unit;

use App\Services\WidgetService;
use PHPUnit\Framework\TestCase;

class WallyTest extends TestCase
{
    private WidgetService $widgetService;
    private array $packs = [
        5000,
        2000,
        1000,
        500,
        250
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->widgetService = new WidgetService();
    }

    /**
     * A basic test example.
     *
     * @throws \Exception
     */
    public function test_packs_for_1(): void
    {
        $this->widgetService->setPacks($this->packs);

        $order = $this->widgetService->execute( 1 );

        $expectedResult = [
            '250' => 1
        ];

        $this->assertEquals($expectedResult, $order);
    }

    /**
     * A basic test example.
     *
     * @throws \Exception
     */
    public function test_packs_for_250(): void
    {
        $this->widgetService->setPacks($this->packs);

        $order = $this->widgetService->execute( 250 );

        $expectedResult = [
            '250' => 1
        ];

        $this->assertEquals($expectedResult, $order);
    }

    /**
     * A basic test example.
     *
     * @throws \Exception
     */
    public function test_packs_for_251(): void
    {
        $this->widgetService->setPacks($this->packs);

        $order = $this->widgetService->execute( 251 );

        $expectedResult = [
            '500' => 1
        ];

        $this->assertEquals($expectedResult, $order);
    }

    /**
     * A basic test example.
     *
     * @throws \Exception
     */
    public function test_packs_for_501(): void
    {
        $this->widgetService->setPacks($this->packs);

        $order = $this->widgetService->execute( 501 );

        $expectedResult = [
            '500' => 1,
            '250' => 1
        ];

        $this->assertEquals($expectedResult, $order);
    }

    /**
     * A basic test example.
     *
     * @throws \Exception
     */
    public function test_packs_for_12001(): void
    {
        $this->widgetService->setPacks($this->packs);

        $order = $this->widgetService->execute( 12001 );

        $expectedResult = [
            '5000' => 2,
            '2000' => 1,
            '250' => 1
        ];

        $this->assertEquals($expectedResult, $order);
    }

}
