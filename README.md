### Klosz

---

##### Launching your application 

---

1. Choose the directory where would you like to save your application


2. Clone GitLab repo to launch application locally

        git clone https://gitlab.com/klosz1/klosz.git project_name

3. Change directory for your project name

        cd project_name
        
4. Install composer dependencies

        composer install
           
5. Create a copy of your .env.example file and name it .env

        copy .env.example .env
        
8. Generate an app encryption key

        php artisan key:generate
        
7. Create an empty database for our application

   
8. In the .env file, add database information to allow Laravel to connect to the database

        DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
        
9. Migrate the database

        php artisan migrate
        
10. Seed the database

        php artisan db:seed

11. Serve Laravel

        php artisan serve
        
12. Credentials to login as Super Admin:

        email: example@example.com
        password: 12345678
        

---


        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
    
