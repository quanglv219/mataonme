<?php

use App\Models\User;

if (! function_exists('getUserInfos')) {
    function getUserInfos($id = null) {
        // This method will return all the information from all tables about the authenticated user
        $id = $id ?? auth()->id();
        return User::with(['social', 'links'])->where('id', $id)->first();
    }
}

if (! function_exists('currentSubscription')) {
    function currentSubscription() {
        return auth()->user()->subscriptions()->first();
    }
}