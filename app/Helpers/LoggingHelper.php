<?php

use Illuminate\Support\Facades\Auth;

function gilog($name, $action, $request = [])
{
    return true;
    $activity = activity()->causedBy(Auth::user());
    if (!empty($request)) $activity->withProperties($request);
    if (!empty($action)) $activity->performedOn($action);
    $activity->log($name);
}
