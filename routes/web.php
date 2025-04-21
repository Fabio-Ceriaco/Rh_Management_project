<?php

use Illuminate\Mail\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/email', function () {
    Mail::raw('test message rh', function (Message $message) {
        $message->to('test@gmail.com')
            ->subject('Welcome to Rh_Management')
            ->from('rh@rh_management.com');
    });
    echo 'OK';
});
