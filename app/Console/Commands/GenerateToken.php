<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class GenerateToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larabbs:generate-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '为用户生成token';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $uid = $this->ask("请输入用户id");
        $user = User::find($uid);
        if (!$user) {
            $this->error('用户不存在');
        }
        // 一年以后过期
        $ttl = 365 * 24 * 60;
        $token = auth('api')->setTTL($ttl)->login($user);
        $this->info($token);
    }
}
