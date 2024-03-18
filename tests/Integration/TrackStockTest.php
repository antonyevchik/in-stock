<?php

namespace Integration;

use App\Models\History;
use App\Models\Stock;
use App\Notifications\ImportantStockUpdate;
use App\UseCases\TrackStock;
use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class TrackStockTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Notification::fake();
        $this->mockClientRequest(true, 24900);
        $this->seed(RetailerWithProductSeeder::class);
        (new TrackStock(Stock::first()))->handle();
    }

    /** @test */
    public function it_notifies_the_user()
    {
        Notification::assertSentTimes(ImportantStockUpdate::class, 1);
    }

    /** @test */
    public function it_refreshes_the_local_stock()
    {
        tap(Stock::first(), function ($stock) {
            $this->assertEquals(24900, $stock->price);
            $this->assertTrue($stock->in_stock);
        });
    }

    /** @test  */
    public function it_records_to_history()
    {
        $this->assertEquals(1, History::count());
    }
}
