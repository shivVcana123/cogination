<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Events\WebhookReceived;
use Laravel\Cashier\Events\WebhookHandled;

use Illuminate\Support\Str;
use Laravel\Cashier\Http\Controllers\WebhookController as ControllersWebhookController;
class WebhookController extends Controller
{
   public function __construct(){
    dd('ddd');
   }
   public function handleWebhook(){
    dd('ddddddd');
   }

}
