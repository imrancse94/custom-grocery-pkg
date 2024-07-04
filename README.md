# Installation Instructions

1. ``composer require imrancse94/grocery``<br/><br/>
2. ``php artisan vendor:publish --tag=grocery``<br/><br/>
3. Need to install vue js ``npm i vue@latest vue-router yup clsx pinia sweetalert2 tailwind-merge vee-validate @vitejs/plugin-vue``<br/><br/>
4. Need to configure vue js with vite
    ``'resources/js/grocery/app.js',
   'resources/js/grocery/grocery.css'``
    add these line into vite.config.js file then import ``@vitejs/plugin-vue`` and include ``vue()`` under `plugins` like below image<br/><br/>
    
5. ```
    import { defineConfig } from 'vite';
    import laravel from 'laravel-vite-plugin';
    import vue from '@vitejs/plugin-vue';
    export default defineConfig({
        plugins: [
            vue(),
            laravel({
                input: [
                    'resources/css/app.css',
                    'resources/js/app.js',
                    'resources/js/grocery/app.js',
                    'resources/js/grocery/grocery.css'
                ],
                refresh: true,
           }),
        ],
    });
   ``` 
   6. Install tailwindcss `npm install -D tailwindcss && npx tailwindcss init` and add necessary configuration into `tailwind.config.js` like below<br/>
       ```
       export default {
           content: [
               "./resources/**/*.blade.php",
               "./resources/**/*.js",
               "./resources/**/*.vue"
    
           ],
           theme: {
               darkMode: 'class',
               extend: {
                   strokeWidth: {
                       '3': '3',
                   }
               }
           },
            plugins: [],
       }

      ```
7. Add 4 variables in `.env` file  
   ````
      VITE_GOOGLE_RECAPTCHA_KEY=""
      GOOGLE_RECAPTCHA_SECRET=""
      ADMIN_EMAIL=""
      DB_CONNECTION=pgsql
    ````
8. `php artisan config:cache`<br/><br/>
9. `php artisa make:migrate`<br/><br/>
10. `php artisan db:seed --class="Imrancse94\Grocery\database\seeders\DatabaseSeeder"`
