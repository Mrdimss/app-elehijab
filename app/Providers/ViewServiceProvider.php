<?php

namespace App\Providers;

use App\Models\Contact;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $messagesCount = Contact::count();
            $view->with('messagesCount', $messagesCount);
        });
    }
}
