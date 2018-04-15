# next5
The application is built using Laravel (https://laravel.com/) and Vue.js (https://vuejs.org/) with Bootstrap-vue (https://bootstrap-vue.js.org/).

There are two API endpoints:
- GET /api/next5: returns a JSON containing the the next 5 races sorted by time (ascending)
- GET /api/show/{race_id}: return a JSON containing thedetails about a single race and the list of competitors in that race (sorted by position)

## Installation
- Clone repository
- Create a .env file similar to .env.example (insert mySQL database connection info)
- Run "composer install"
- Run "npm install"
- Run "npm run dev" (the app works in development environment)
- If "npm run dev" fails on Linux try installing libpng library ( On centos 7 run "yum install -y libpng12"). Then retry "npm run dev"
- Run "php artisan db:seed"
- Go to you project dir and run "chmod 777 -R storage"

## Screenshots
Next 5 races list:
<p align="center"><img src="/resources/screenshots/Next5-1.png"></p>

Single race details:
<p align="center"><img src="/resources/screenshots/Next5-2.png"></p>

Race closed:
<p align="center"><img src="/resources/screenshots/Next5-3.png"></p>