<?php

namespace Tests\Feature\Subscription;

use App\Domain\Models\Plan;
use App\Events\Plan\PlanHasBeenCreated;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;
use MicroServiceWorld\Domain\Models\GatewayUser;
use Tests\TestCase;

class CreateSubscriptionPlanTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreatePlanSuccess()
    {
        Event::fake([PlanHasBeenCreated::class]);

        $plan = factory(Plan::class)->make();
        $fields = $plan->only([
            'name', 'description',
        ]);

        $response = $this->actingAs(GatewayUser::createTestUser(null,
            ['subscription-service-create-plan']))
            ->json('POST', '/plans', $fields,
                ['X-Department' => 'vehicles']);

        $response->assertStatus(201);
        $this->assertDatabaseHas('plans', ['name' => $fields['name']]);
        $response->assertJsonStructure([
            'data' => ['id', 'name', 'department', 'description']
        ]);
    }

    public function testCreatePlanForbidden()
    {
        $plan = factory(Plan::class)->make();
        $fields = $plan->only([
            'name', 'description',
        ]);

        $response = $this->actingAs(GatewayUser::createTestUser(null))
            ->json('POST', '/plans', $fields,
                ['X-Department' => 'vehicles']);

        $response->assertForbidden();
    }

    public function testCreatePlanValidations()
    {
        $plan = factory(Plan::class)->make();
        $fields = $plan->only(['description',
        ]);

        $response = $this->actingAs(GatewayUser::createTestUser(null,
            ['subscription-service-create-plan']))
            ->json('POST', '/plans', $fields,
                ['X-Department' => 'vehicles']);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    public function testCreatePlanWithUniqueValidation()
    {
        $plan = factory(Plan::class)->create(['department' => 'vehicles']);
        $planFields = ['name' => $plan->name, 'department' => 'vehicles'];
        $response = $this->actingAs(GatewayUser::createTestUser(null,
            ['subscription-service-create-plan']))
            ->json('POST', '/plans', $planFields,
                ['X-Department' => 'vehicles']);

        $response->assertJsonValidationErrors(['name']);
        $response->assertStatus(422);
    }

}
