<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('about', function () {
    $this->comment('Pooling Fund - KSO Laravel app');
})->purpose('Show app information');
