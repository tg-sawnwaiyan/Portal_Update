<?php
namespace App\Providers;

use DB;
use Illuminate\Support\ServiceProvider;

class ViewTwitterServiceProvider extends ServiceProvider
{
    public function boot()
    {
        view()->composer(
            'app',
            'App\Http\ViewTwitter\Twitter'
        );
    }
}
?>