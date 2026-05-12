<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('about', function () {
    $this->comment('CEA Indonesia Laravel app');
})->purpose('Show app information');
