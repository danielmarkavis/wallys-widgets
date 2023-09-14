<?php

namespace Tests\Unit;

use App\Models\Widget;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\WidgetService;
use Tests\TestCase;

class WidgetTest extends TestCase
{
    use RefreshDatabase;

    private WidgetService $widgetService;

    /**
     * @throws \Exception
     */
    public function test_pack_create(): void
    {
        $widget = Widget::factory()->create();

        $this->assertModelExists($widget);
    }

    /**
     * @throws \Exception
     */
    public function test_pack_delete(): void
    {
        $widget = Widget::factory()->create();

        $this->assertModelExists($widget);

        $widget->delete();

        $this->assertModelMissing($widget);
    }

    /**
     * @throws \Exception
     */
    public function test_pack_has_4000(): void
    {
        Widget::factory([
            'size' => 4000,
        ])->create();

        $this->assertDatabaseHas('widgets', [
            'size' => 4000,
        ]);
    }

    /**
     * @throws \Exception
     */
    public function test_packs_count_is_2(): void
    {
        Widget::factory(['size' => 1])->create();
        Widget::factory(['size' => 2])->create();

        $this->assertDatabaseCount('widgets', 2);
    }

}
