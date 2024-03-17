<?php

namespace Tests;

use App\Clients\StockStatus;
use Facades\App\Clients\ClientFactory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @param bool $available
     * @param int  $price
     *
     * @return void
     */
    public function mockClientRequest(bool $available = true, int $price = 29900): void
    {
        ClientFactory::shouldReceive('make->checkAvailability')
            ->andReturn(new StockStatus($available, $price));
    }
}
