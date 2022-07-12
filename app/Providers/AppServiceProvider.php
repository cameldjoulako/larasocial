<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use Illuminate\Pagination\Paginator;

use App\Models\FriendRequest;
use App\Models\Notification;
use App\Models\Ticket;
use App\Models\TicketResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        view()->composer(["admin/layouts/app"], function ($view) {
            $unread_tickets = TicketResponse::where("is_read", "=", 0)
                ->where("response_by", "!=", auth()->user()->id)
                ->count();

            $view->with([
                "unread_tickets" => $unread_tickets
            ]);
        });

        view()->composer(["home"], function ($view) {
            if (auth()->check())
            {
                $unresponded_friend_requests = FriendRequest::where("sent_to", "=", auth()->user()->id)
                    ->where("status", "=", "sent")
                    ->count();

                $unread_tickets = auth()->user()->get_unread_tickets();
            }
            else
            {
                $unresponded_friend_requests = 0;
                $unread_tickets = 0;
            }

            $view->with([
                "unresponded_friend_requests" => $unresponded_friend_requests,
                "unread_tickets" => $unread_tickets
            ]);
        });
    }
}
