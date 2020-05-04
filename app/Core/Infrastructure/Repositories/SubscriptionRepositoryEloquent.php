<?php

namespace App\Core\Infrastructure\Repositories;

use App\Core\Infrastructure\Repositories\Contract\PlanRepository;
use App\Core\Infrastructure\Repositories\Contract\SubscriptionRepository;
use App\Domain\Models\Subscription;
use App\Events\SubscriptionHasBeenCreated;
use App\Events\SubscriptionHasBeenRenewed;
use Illuminate\Support\Collection;
use MicroServiceWorld\Core\Infrastructure\Repositories\Criteria\DepartmentCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Carbon\Carbon;
use Log;

/**
 * Class SubscriptionRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SubscriptionRepositoryEloquent extends BaseRepository implements SubscriptionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Subscription::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app(DepartmeimportSubscriptionFromOldRecordsntCriteria::class));
    }

    /**
     * @param string $type
     * @param string $uuid
     * @return Collection
     */
    public function retrieveSubscriptionByModelTypeUuid($type, $uuid): ?Subscription
    {
        return $this->where('model_type', $type)->where('model_id', $uuid)->first();
    }

    /**
     * fix start and end dates of subscription
     * @param Carbon $membershipStartDate
     * @param Carbon $membershipEndDate
     * @return array
     */
    protected function fixSubscriptionDates(Carbon $membershipStartDate, Carbon $membershipEndDate){

        //calculate membership_start_date if its not defined
        if( $membershipStartDate->year < 1 &&
            $membershipEndDate->year > 1)
        {
            $membershipStartDate = $membershipEndDate->copy()->subtract(1,'year');
        }
        //calculate membership_end_date if its not defined
        elseif ($membershipEndDate->year < 1 &&
            $membershipStartDate->year > 1)
        {
            $membershipEndDate = $membershipStartDate->copy()->add(1, 'year');
        }
        return ['startDate' => $membershipStartDate, 'endDate' => $membershipEndDate];
    }

    /**
     * check if subscription has been renewed
     * @param $type
     * @param array $data
     * @return bool
     */
    protected function checkIfSubscriptionHasRenewed($type, array $data){
        $subscription = $this->retrieveSubscriptionByModelTypeUuid($type, $data['id']);
        if($subscription){
            //if subscription record does not match with start date and end dates then subscription has been renewed
            return $result = $subscription->period_start != $data['membership_start_date'] ||
            $subscription->period_end != $data['membership_end_date'] ? true: false;
        }
    }

    /**
     * Import subscription records
     * @param Collection $subscriptions
     * @param string $department
     * @param PlanRepository $contract
     */
    public function importSubscriptionFromOldRecords(Collection $subscriptions , string $department ,PlanRepository $contract)
    {
        foreach($subscriptions as $subscription)
        {
            $startDate = Carbon::parse($subscription['membership_start_date']);
            $endDate = Carbon::parse($subscription['membership_end_date']);

            extract($this->fixSubscriptionDates($startDate,$endDate));

            //add condition check that if membership_start_date <= today <=  membership_end_date then subscription is valid\
            $date = Carbon::now();
            if($startDate->lessThanOrEqualTo($date)  &&  $endDate->greaterThanOrEqualTo($date) )
            {
                if($this->checkIfSubscriptionHasRenewed($department, $subscription) === true){
                    event(new SubscriptionHasBeenRenewed($subscription));
                }
                // save or update  data in subscriptions
                $subRecord = Subscription::updateOrCreate(
                    [
                        'model_id' => $subscription['id'],
                        'model_type' => $department
                    ],
                    [
                        'department' => $department,
                        'model_type' => $department,
                        'model_id' => $subscription['id'],
                        'plan_id' => $contract->getPlanByDepartmentName($department)->id,
                        'period_start' => $startDate,
                        'period_end' => $endDate,
                        'discount' => $subscription['membership_discount']
                    ]
                );

                //trigger event on create subscription : SubscriptionHasBeenCreated($subscription)
                if($subRecord->wasRecentlyCreated === true){
                    event(new SubscriptionHasBeenCreated($subscription));
                }
            }
            //Invalid date subscription discarded
            else{
                Log::info("Subscription Discarded",$subscription);
            }
        }

    }
}
