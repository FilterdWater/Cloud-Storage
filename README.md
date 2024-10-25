# How to Start This Project on Your Local Machine

1. Clone the files to your machine.

2. Run the following commands in the root of the project's directory
   (the command below creates a docker container which has composer and will be removed after use)
   ```bash
   docker run --rm -v $(pwd):/var/www/html -w /var/www/html composer:latest install
   ```

4. Make a .env file using the contents of .env.example.

5. (This command will start sail)
   ```bash
   ./vendor/bin/sail up
   ``` 
   or for detached mode
   ```bash
   ./vendor/bin/sail up -d
   ``` 

6. (Generates a key for encryption):
   ```bash
   ./vendor/bin/sail artisan key:generate
   ```


6. (Installed dependecys):
   ```bash
   ./vendor/bin/sail npm install
   ```

7. (Starts vite among other things):
   ```bash
   ./vendor/bin/sail npm run dev
   ```

8. (Test data and users):
   ```bash
   ./vendor/bin/sail artistian migrate:fresh --seed
   ```