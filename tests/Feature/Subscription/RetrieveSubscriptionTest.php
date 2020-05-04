<?php

namespace Tests\Feature\Subscription;

use App\Domain\Models\Subscription;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;
use MicroServiceWorld\Domain\Models\GatewayUser;
use Tests\TestCase;
use Illuminate\Support\Str;
/**
 * Class CreateSubscriptionTest
 * @package Tests\Feature\Subscription
 */
class RetrieveSubscriptionTest extends TestCase
{
    use DatabaseTransactions;


    public function testRetrieveSubscriptionSuccess(){

        $subscription = factory(Subscription::class)->create();
        $response = $this->actingAs(GatewayUser::createTestUser(null,['access-subscription-system']))
            ->withHeaders(['X-Department' => 'vehicles'])
            ->json('GET',"/support/subscriptions/{$subscription->model_type}/{$subscription->model_id}");

        $response->assertStatus(200);
        $this->assertDatabaseHas('subscriptions', ['model_id' => $subscription->model_id]);
        $response->assertJsonStructure(['data' => ['id','department','model_type','model_id','plan_id','active','active_from','active_until']]);
    }

    public function testRetrieveSubscriptionForbidden(){
        $subscription = factory(Subscription::class)->create();
        $response = $this->actingAs(GatewayUser::createTestUser(null))
            ->withHeaders(['X-Department' => 'vehicles'])
            ->json('GET',"/support/subscriptions/{$subscription->model_type}/{$subscription->model_id}");
        $response->assertStatus(403);
    }

    public function testRetrieveSubscriptionValidations(){
        $randomUuid = (string) Str::uuid();
        $randomType = (string) Str::random();
        $subscription = factory(Subscription::class)->create();
        $response = $this->actingAs(GatewayUser::createTestUser(null,['access-subscription-system']))
            ->withHeaders(['X-Department' => 'vehicles'])
            ->json('GET',"/support/subscriptions/{$randomType}/{$randomUuid}");
        $response->assertStatus(404);
    }

}
