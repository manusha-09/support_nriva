<?php

namespace App\Bootstrap;

use Illuminate\Foundation\Bootstrap\HandleExceptions as LaravelHandleExceptions;

class HandleExceptions extends LaravelHandleExceptions
{
    public function handleError($level, $message, $file = '', $line = 0, $context = [])
    {
        $vendorPath = strtolower($this->app->basePath('vendor').DIRECTORY_SEPARATOR);
        $sourcePath = strtolower($file);

        if (($level === E_DEPRECATED || $level === E_USER_DEPRECATED)
            && strpos($sourcePath, $vendorPath) === 0) {
            return;
        }

        parent::handleError($level, $message, $file, $line, $context);
    }
}
