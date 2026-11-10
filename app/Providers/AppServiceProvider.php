<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use view;
use DB;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \App\Models\tickets::updated(function ($ticket) {
    $changes = [];
    foreach ($ticket->getChanges() as $field => $value) {
        if (in_array($field, ['updated_at', 'ticket_unique_id'])) { continue; }
        $changes[] = str_replace('_', ' ', $field).': '.strip_tags((string) $ticket->getOriginal($field)).' -> '.strip_tags((string) $value);
    }
    if ($changes) { \App\Services\SupportTicketMail::send($ticket, 'updated', implode("\n", $changes)); }
});
foreach (['created' => 'Comment added', 'updated' => 'Comment edited', 'deleted' => 'Comment deleted'] as $event => $label) {
    \App\Models\Comment::$event(function ($comment) use ($label) {
        $ticket = \App\Models\tickets::find($comment->post_id);
        if ($ticket) { \App\Services\SupportTicketMail::send($ticket, 'updated', $label.': '.strip_tags($comment->body)); }
    });
}
        

        view()->composer('*', function($view) {

    $view->with(['counttickets' => DB::table('tbl_ticketing_system_notifications')->whereNull('read_at')->get()]);
     $view->with(['logodetails' => DB::table('tbl_ticketing_system_logoData')->first()]);
});


    }

   


}
