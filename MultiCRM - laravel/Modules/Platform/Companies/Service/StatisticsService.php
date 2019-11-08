<?php
/**
 * Created by PhpStorm.
 * User: laravel-bap.com
 * Date: 21.07.19
 * Time: 20:29
 */

namespace Modules\Platform\Companies\Service;


use Carbon\Carbon;

class StatisticsService
{

    const PAID_STATUS = 1;

    /**
     * Return sale statistics
     *
     * @param int $lastMonths
     * @return array
     */
    public function sale($lastMonths = 3)
    {

        $result = \DB::table('bap_subscription_invoice')
            ->select(
                \DB::raw("DATE_FORMAT(bap_subscription_invoice.invoice_date,'%Y-%m') as yearMonth"),
                \DB::raw('count(1) as quantity'),
                \DB::raw('sum(price) as income'))
            ->groupBy(\DB::raw("DATE_FORMAT(bap_subscription_invoice.invoice_date,'%Y-%m') "))
            ->whereDate('bap_subscription_invoice.invoice_date', '>=', Carbon::today()->subMonth($lastMonths)->firstOfMonth()->format('Y-m-d'))
            ->whereNull('deleted_at')
            ->where('status', '=', self::PAID_STATUS)
            ->orderBy(\DB::raw("DATE_FORMAT(bap_subscription_invoice.invoice_date,'%Y-%m')"), 'asc');


        $values = $result->get()->flatten()->toArray();

        return $values;
    }

    public function packages($lastMonths = 3)
    {

        $result = \DB::table('bap_subscription_invoice')
            ->select(
                \DB::raw('count(1) as quantity'),
                \DB::raw('plan_name'))
            ->groupBy([\DB::raw("plan_name")])
            ->whereDate('bap_subscription_invoice.invoice_date', '>=', Carbon::today()->subMonth($lastMonths)->firstOfMonth()->format('Y-m-d'))
            ->whereNull('deleted_at')
            ->where('status', '=', self::PAID_STATUS)
            ->orderBy(\DB::raw("count(1)"), 'asc');


        $values = $result->get()->flatten()->toArray();

        return $values;
    }

    public function paymentType($lastMonths = 3)
    {

        $result = \DB::table('bap_subscription_invoice')
            ->select(
                \DB::raw('count(1) as quantity'),
                \DB::raw('provider_name'))
            ->groupBy([\DB::raw("provider_name")])
            ->whereDate('bap_subscription_invoice.invoice_date', '>=', Carbon::today()->subMonth($lastMonths)->firstOfMonth()->format('Y-m-d'))
            ->whereNull('deleted_at')
            ->where('status', '=', self::PAID_STATUS)
            ->orderBy(\DB::raw("count(1)"), 'asc');


        $values = $result->get()->flatten()->toArray();

        return $values;
    }


    public function registered($lastMonths = 3)
    {

        $result = \DB::table('bap_companies')
            ->select(
                \DB::raw("DATE_FORMAT(bap_companies.created_at,'%Y-%m') as yearMonth"),
                \DB::raw('count(1) as quantity'))
            ->groupBy(\DB::raw("DATE_FORMAT(bap_companies.created_at,'%Y-%m') "))
            ->whereDate('bap_companies.created_at', '>=', Carbon::today()->subMonth($lastMonths)->firstOfMonth()->format('Y-m-d'))

            ->orderBy(\DB::raw("DATE_FORMAT(bap_companies.created_at,'%Y-%m')"), 'asc');


        $values = $result->get()->flatten()->toArray();



        return $values;
    }


}
