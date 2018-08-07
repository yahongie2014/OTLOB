<?php

namespace App\Console;


use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Carbon\Carbon;
use App\User;
use App\Product;
use App\ItemsOrder;
use App\Feeds;
use App\Report;
use DB;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //$schedule->command('inspire')->hourly();
//dd(Carbon::now()->format('Y-m-d H:i:s'));
        /*$schedule->call(function () {
            $counts['users']['all'] = User::all()->count();

        });*/
        $schedule->call('App\Http\Controllers\AdminController@dailyReport')->dailyAt('22:01');;
        /*$schedule->call(function () {



            // get total No of users
            $counts['users']['all'] = User::all()->count();
            $counts['users']['providers'] = User::where('is_vendor' , 1)->get()->count();

            // get products counts
            $counts['products'] = Product::select(
                DB::raw('count(*) as allProducts') ,
                DB::raw('sum(case when status = 0 then 1 else 0 end) as waiting') ,
                DB::raw('sum(case when status = 1 then 1 else 0 end) as activated'),
                DB::raw('sum(case when status = 2 then 1 else 0 end) as deactivated')
            )->first()->toArray();

            $counts['orders'] = ItemsOrder::select(
                DB::raw('count(*) as allOrders') ,
                DB::raw('sum(case when status = 7 then 1 else 0 end) as completed') ,
                DB::raw('sum(case when status = 4 then 1 else 0 end) as rejected') ,
                DB::raw('sum(case when status = 5 then 1 else 0 end) as preparing') ,
                DB::raw('sum(case when status = 1 then 1 else 0 end) as waiting')
            )->where('created_at', '>', '2018-04-23')->first()->toArray();

            $counts['feed_back'] = Feeds::count();

            $date = Carbon::now()->format('Y-m-d');


            $toDayData = Report::where('date', Carbon::now()->format('Y-m-d'))->first();
            if(!$toDayData){
                $toDayData = new Report();
                $toDayData->date = Carbon::now()->format('Y-m-d');
            }


            $toDayData->all_users = $counts['users']['all'];
            $toDayData->providers = $counts['users']['providers'];
            $toDayData->all_products = $counts['products']['allProducts'];
            $toDayData->waiting_products = $counts['products']['waiting'];
            $toDayData->active_products = $counts['products']['activated'];
            $toDayData->deactivated_products = $counts['products']['deactivated'];
            $toDayData->all_orders = $counts['orders']['allOrders'];
            $toDayData->completed_orders = $counts['orders']['completed'];
            $toDayData->rejected_orders = $counts['orders']['rejected'];
            $toDayData->preparing_orders = $counts['orders']['preparing'];
            $toDayData->waiting_orders = $counts['orders']['waiting'];
            $toDayData->feed_back = $counts['feed_back'];

            $toDayData->save();
            file_put_contents('/var/www/html/party/test.txt',Carbon::now()->format('Y-m-d H:i:s') . " done \n",FILE_APPEND);
            //file_put_contents('/var/www/html/party/test.txt',Carbon::now()->format('Y-m-d') . " done \n",FILE_APPEND);

        });//->dailyAt('17:29');*/
    }
}
