<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\DownNotifyContentService;

class SendOrderAsyncNotify implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    /**
     * Create a new job instance.
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     * @return void
     */
    public function handle()
    {
        $DownNotifyContentService = new DownNotifyContentService();
        $result = $DownNotifyContentService->send();
        if(!$result)
        {
            $num = $this->getDelay($this->job->attempts());
            $this->job->release($num);
        }
    }

    /**
     * 回调间隔
     * @param int $num
     * @return float|int
     */
    protected function getDelay(int $num)
    {
        if($num == 1)
        {
            return $num;
        }else{
            return $num*15;
        }
    }
}
