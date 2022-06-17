<?php

namespace App\Traits;

trait Logger
{
    private function log($action)
    {
        log($action, $this->action, $this->request);
    }
}
