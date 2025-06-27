<?php

namespace App\Console\Commands;

use App\Models\OwnerRestaurant;
use Illuminate\Console\Command;

class UpdateStatusRestaurant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updateStatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       $currentTime=now()->format('H:i');
       $restaurants=OwnerRestaurant::all();
       foreach($restaurants as $restaurant)
       {
        $isOpen=($currentTime >= '10:00' && $currentTime < '10:18');
        $restaurant->update(['status'=>$isOpen?'now_open':'closed']);
       }
       return Command::SUCCESS;
    }
}
