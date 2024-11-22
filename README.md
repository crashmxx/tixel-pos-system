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
```

Then the application should be available on http://localhost
