<?php

namespace Tests\Feature\Subscription;

use App\Domain\Models\Subscription;
use App\Events\Subscription\SubscriptionHasBeenCreated;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;
use MicroServiceWorld\Domain\Models\GatewayUser;
use Tests\TestCase;

/**
 * Class CreateSubscriptionTest
 * @package Tests\Feature\Subscription
 */
class CreateSubscriptionTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateSubscriptionSuccess()
    {
        Event::fake([SubscriptionHasBeenCreated::class]);
        $plan = factory(Subscription::class)->make();
        $fields = $plan->only([
            'model_type', 'model_id', 'period_start',
            'period_end', 'discount', 'plan_id'
        ]);
        $this->expectsEvents([SubscriptionHasBeenCreated::class]);

        $response = $this->actingAs(GatewayUser::createTestUser(null, ['subscription-service-create-subscription']))
            ->json('POST', '/subscriptions', $fields,
                ['X-Department' => 'vehicles']);
        $response->assertStatus(201);

        $this->assertDatabaseHas('subscriptions',
            ['model_type' => $fields['model_type'], 'model_id' => $fields['model_id'],
                'department' => 'vehicles']);

        $response->assertJsonStructure([
            'data' => ['id', 'model_type', 'model_id', 'department', 'plan_id']
        ]);
    }

    public function testCreateSubscriptionForbidden()
    {
        $plan = factory(Subscription::class)->make();
        $fields = $plan->only([
            'model_type', 'model_id', 'period_start',
            'period_end', 'discount', 'plan_id'
        ]);

        $response = $this->actingAs(GatewayUser::createTestUser(null))
            ->json('POST', '/subscriptions', $fields,
                ['X-Department' => 'vehicles']);

        $response->assertForbidden(403);
    }

    public function testCreateSubscriptionValidtions()
    {
        $plan = factory(Subscription::class)->make();
        $fields = $plan->only(['discount']);

        $response = $this->actingAs(GatewayUser::createTestUser(null, ['subscription-service-create-subscription']))
            ->json('POST', '/subscriptions', $fields, ['X-Department' => 'vehicles']);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['model_type', 'plan_id', 'model_id', 'period_end', 'period_start']);
    }

}
