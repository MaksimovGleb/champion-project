<?php

namespace App\Console\Commands;

use App\Models\Favorite;
use App\Models\Like;
use App\Models\Payment\Payment;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Event;

class RefFix extends Command
{
    protected $signature = 'ref:fix';
    //php artisan ref:fix
    protected $description = 'переносит рефералов и выплаты от одного пользователя к другому';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Event::fake(); // Отключение observer.

        $this->info(sprintf("переносит рефералов и выплаты от одного пользователя к другому"));

        $n = $this->ask('Введите id, пользователя у которого нужно забрать рефералов');
        $m = $this->ask('Введите id, пользователя которому нужно отдать рефералов');

        Payment::where('user_id', $n)->update(['user_id' => $m]);
        User::where('user_ref_id', $n)->update(['user_ref_id' => $m]);

        $this->info(sprintf("перенесены"));
        Event::spy();

        return null;
    }
}
