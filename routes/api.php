<?php

Route::group(['prefix' => '/clinics'], function () {
    require 'clinics.php';
});

Route::group(['prefix' => '/patients'], function(){
    require 'patients.php';
});
