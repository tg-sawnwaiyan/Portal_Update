# TIS ティーズ

This project can provide portal of Nursing Home and Hospitals in JAPAN. Their related news and related job offers can be searched.

### USING LANGUAGE

- Laravel 5.8
- VueJS

### PREREQUISITES

- PHP 7.3
- MySQL
- Composer
- Git
- Node

### INSTALLATION
```bash
git clone https://github.com/Thuzar-TS/Portal_Update.git
```
Go to project folder.
```bash
git checkout your-branch-name
composer install
npm install
php artisan key:generate
php artisan jwt:secret
```

### DATABASE
Since migration files are not update, you have to import sql file to database.

For Database import (if you installed xampp)
1. Open ```C:/xampp/php/php.ini``` file and make these changes
```bash
max_execution_time = -1
max_input_time = -1
memory_limit = 1000M
post_max_size = 100M
upload_max_filesize = 100M
```
2. stop and start php server again (xampp control panel)

- In Browser, go to localhost/phpmyadmin
- Create database ```portal``` with collation ```utf8mb4_unicode_ci```
- Import ```project/extra_files/portal.sql``` file to your ```portal``` database.

3. Clone .env.example to .env file.
4. Change your computer IP address and database connection in .env file.

### Node_Modules
Some changes in ```node_modules```
- Copy ```extra_files/auth.js, extra_files/index.js``` and overwrite in ```project/node_modules/@websanova/vue-auth/src/```
- Search ```No Results.``` in ```project/node_modules/vuejs-auto-complete/dist/build.js``` and replace with ```検索条件当てはまるデータはありません。```

### RUN
- ```npm run watch```
- ```php artisan serve --host 192.168.100.13 --port 8000```
- In browser ip-address:8000 => Project is running.

### Project Structure
1. Public view
2. Supplier view
3. Admin view

In view part
- In app.blade.php, call index.vue
- In index.vue(main layout), router view here and check authorized, change layouts

Menus
- Menu.vue (public header menu)
- AuthMenu.vue (authorized header menu)
- asideMenu.vue (authorized aside menu)

Components
- All vue files are in ```project/resources/js/```

Routes
- Vue js router view for components (```project/resources/js/router.js```)
- api route for laravel backend (```project/routes/api.php```)

Auth
- Laravel and Vue js JWT authentication
- In .vue components, you can check auth with ```$auth.check(), this.$auth.check()```
- In controllers, ```Auth::user(), auth()->user()```

Mailing System
- Laravel Mail system

Style
- Common css ```project/public/css/mystyle.css```
- css code are partitioned for pages with comment in mystyle.css
- some css codes are in individual components.

