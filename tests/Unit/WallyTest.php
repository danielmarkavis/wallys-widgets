<?php

namespace Tests\Unit;

use App\Repositories\WidgetRepository;
use Database\Seeders\WidgetSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\WidgetService;
use Tests\TestCase;

class WallyTest extends TestCase
{
    use RefreshDatabase;

    private WidgetService $widgetService;
    public array $packs = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(WidgetSeeder::class);
        $this->widgetService = app(WidgetService::class);
        $repository = app(WidgetRepository::class);
        $this->packs = collect($repository->getQuery()->orderby('size', 'desc')->get()->toArray())->pluck('size')->toArray();
    }

    /**
     * A basic test example.
     *
     * @throws \Exception
     */
    public function test_packs_for_1(): void
    {
        $order = $this->widgetService
            ->setPacks($this->packs)
            ->execute( 1 );

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
        $order = $this->widgetService
            ->setPacks($this->packs)
            ->execute( 250 );

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
        $order = $this->widgetService
            ->setPacks($this->packs)
            ->execute( 251 );

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
        $order = $this->widgetService
            ->setPacks($this->packs)
            ->execute( 501 );

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
        $order = $this->widgetService
            ->setPacks($this->packs)
            ->execute( 12001 );

        $expectedResult = [
            '5000' => 2,
            '2000' => 1,
            '250' => 1
        ];

        $this->assertEquals($expectedResult, $order);
    }

    /**
     * A basic test example.
     *
     * @throws \Exception
     */
    public function test_packs_for_14800(): void
    {
        $order = $this->widgetService
            ->setPacks($this->packs)
            ->execute( 14800 );

        $expectedResult = [
            '5000' => 2,
            '2000' => 2,
            '1000' => 1
        ];

        $this->assertEquals($expectedResult, $order);
    }
}
