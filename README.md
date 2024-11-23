```
  ____   ___  ____    ____            _                 
 |  _ \ / _ \/ ___|  / ___| _   _ ___| |_ ___ _ __ ___  
 | |_) | | | \___ \  \___ \| | | / __| __/ _ \ '_ ` _ \ 
 |  __/| |_| |___) |  ___) | |_| \__ \ ||  __/ | | | | |
 |_|    \___/|____/  |____/ \__, |___/\__\___|_| |_| |_|
                            |___/                       
```

## Pre-requisites
- Having Docker on your local machine: https://www.docker.com/
- Having npm on your local machine, thanks to nvm :

  curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.40.1/install.sh | bash

## Install
```  
git clone git@github.com:crashmxx/tixel-pos-system.git

- Create and set your environment file
cp .env.local .env

- Run docker containers :
sail up -d

- Db migration + seed
First install :
sail artisan migrate 
sail artisan db:seed

Then the next time : 
sail artisan migrate:refresh --seed

- Composer
sail composer install

- Compile front
npm install
npm run dev

- Launch the PHP tests in cmd
sail artisan test

- Launch the worker for Laravel Reverb
sail artisan reverb:start
```

Then the application should be available on http://localhost


## Connection between POS System and the Website
1. QR Code Generation by POS
When a customer places an order in-store, the POS system performs the following:

Creates an order in the database with an unique access token available 2 hours.
Prints a QR code containing:
The order_id.
The access_token.
Example QR code data:
``` 
{
  "order_id": 1234,
  "access_token": "abcdef1234567890"
}
```
2. Data Access
When the customers scan the QR code:
They are redirected to a URL with the order_id and access_token
https://example.com/order-status?order_id=1234&access_token=abcdef1234567890


3. Channel Subscription for real time update
Thanks to these infos, the website will subscribe to a private laravel Reverb channel

``` 
//routes/channels.php
Broadcast::channel('App.Models.Order.{id}', function ($orderId, $data) {
$order = Order::find($orderId);

    // Verify the order exists
    if (!$order) {
        return false;
    }

    // Validate access token and expiration
    return $data['access_token'] === $order->access_token &&
           $order->access_token_expires_at &&
           !$order->access_token_expires_at->isPast();
});
```

4. On POS System UI, each time an order is updated the information is broadcast to that channel.
