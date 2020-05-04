<?php

namespace App\Console\Commands;

use App\Core\Infrastructure\Repositories\Contract\SubscriptionRepository;
use App\Domain\Models\Subscription;
use Illuminate\Support\Facades\Http;
use App\Core\Infrastructure\Repositories\Contract\PlanRepository;
use Illuminate\Console\Command;
class ImportServicePoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:service-point';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import services from vehicle and courier endpoints';

    /**
     * @var PlanRepository
     */
    protected $planContract;

    /**
     * @var SubscriptionRepository
     */
    protected $subscriptionContract;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(PlanRepository $contract, SubscriptionRepository $subscriptionContract)
    {
        parent::__construct();
        $this->planContract = $contract;
        $this->subscriptionContract = $subscriptionContract;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // define array of services and endpoints
        $endPoints = [
            Subscription::DEPARTMENT_VEHICLE => 'https://www.serviceright-autos.nl/api/servicepoints.php?secret-token=902e83d0-a371-453a-bc06-4be4f114b5b1',
            Subscription::DEPARTMENT_COURIER => 'https://www.serviceright-koeriers.nl/api/servicepoints.php?secret-token=902e83d0-a371-453a-bc06-4be4f114b5b1'
        ];
        foreach($endPoints as $department => $endPoint){
            // fetch data from end point
            $res = Http::get($endPoint);
            $subscriptions = collect($res->json());
            if($subscriptions->isNotEmpty()){
                $this->subscriptionContract->importSubscriptionFromOldRecords($subscriptions , $department , $this->planContract);
            }
        }
    }
}
