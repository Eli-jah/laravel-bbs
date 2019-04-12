<?php

namespace App\Observers;

use App\Models\Link;
use Illuminate\Support\Facades\Cache;

// creating, created, updating, updated, saving,
// saved, deleting, deleted, restoring, restored

class LinkObserver
{
    /**
     * Handle the link "created" event.
     *
     * @param  \App\Models\Link $link
     * @return void
     */
    // 在保存时清空 cache_key 对应的缓存
    public function saved(Link $link)
    {
        Cache::forget($link->cache_key);
    }

    /**
     * Handle the link "updated" event.
     *
     * @param  \App\Models\Link $link
     * @return void
     */
    public function updated(Link $link)
    {
        Cache::forget($link->cache_key);
    }

    /**
     * Handle the link "deleted" event.
     *
     * @param  \App\Models\Link $link
     * @return void
     */
    public function deleted(Link $link)
    {
        Cache::forget($link->cache_key);
    }

    /**
     * Handle the link "restored" event.
     *
     * @param  \App\Models\Link $link
     * @return void
     */
    public function restored(Link $link)
    {
        //
    }

    /**
     * Handle the link "force deleted" event.
     *
     * @param  \App\Models\Link $link
     * @return void
     */
    public function forceDeleted(Link $link)
    {
        Cache::forget($link->cache_key);
    }
}
