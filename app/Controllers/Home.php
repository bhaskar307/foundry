<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        log('hello world');
        
        return view('welcome_message');
    }
}
