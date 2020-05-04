<?php

namespace Tests\Feature\Subscription;

use App\Domain\Models\Item;
use App\Events\Item\ItemHasBeenCreated;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;
use MicroServiceWorld\Domain\Models\GatewayUser;
use Tests\TestCase;

/**
 * Class CreateItemTest
 * @package Tests\Feature\Subscription
 */
class CreateItemTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateItemSuccess()
    {
        Event::fake([ItemHasBeenCreated::class]);

        $plan = factory(Item::class)->make();
        $fields = $plan->only([
            'name', 'description', 'amount', 'tax_rate', 'currency'
        ]);

        $response = $this->actingAs(GatewayUser::createTestUser(null, ['subscription-service-create-item']))
            ->json('POST', '/items', $fields, ['X-Department' => 'vehicles']);


        $response->assertStatus(201);
        $this->assertDatabaseHas('items',
            ['name' => $fields['name'], 'amount' => $fields['amount'], 'department' => 'vehicles']);
        $response->assertJsonStructure([
            'data' => ['id', 'name', 'amount', 'department', 'description']
        ]);
    }

    public function testCreateItemForbidden()
    {
        $plan = factory(Item::class)->make();
        $fields = $plan->only([
            'name', 'description', 'amount', 'tax_rate', 'currency'
        ]);

        $response = $this->actingAs(GatewayUser::createTestUser(null))
            ->json('POST', '/items', $fields,
                ['X-Department' => 'vehicles']);

        $response->assertForbidden();
    }

    public function testCreateItemValidtions()
    {
        $plan = factory(Item::class)->make();
        $fields = $plan->only(['description']);

        $response = $this->actingAs(GatewayUser::createTestUser(null,
            ['subscription-service-create-item']))
            ->json('POST', '/items', $fields,
                ['X-Department' => 'vehicles']);

        $response->assertStatus(422);
    }

    public function testCreateItemWithUniqueValidation()
    {
        $plan = factory(Item::class)->create(['department' => 'vehicles']);
        $planFields = ['name' => $plan->name, 'amount' => $plan->amount, 'department' => 'vehicles'];
        $response = $this->actingAs(GatewayUser::createTestUser(null,
            ['subscription-service-create-item']))
            ->json('POST', '/items', $planFields,
                ['X-Department' => 'vehicles']);
        $response->assertStatus(422);
    }

}
