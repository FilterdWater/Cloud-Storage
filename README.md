# How to Start This Project on Your Local Machine

1. Clone the files to your machine.

2. Run the following command in the root of the project's directory:

   ```bash
   docker run --rm -v $(pwd):/var/www/html -w /var/www/html composer:latest install
   ```
3. Make a .env file using the contents of .env.example.

4. Run the following command in the root of the project's directory:
   ```bash
   ./vendor/bin/sail artisan key:generate
   ```
5. Run the following command in the root of the project's directory:
   ```bash
   ./vendor/bin/sail npm install
   ```
6. Run the following command in the root of the project's directory:
   ```bash
   ./vendor/bin/sail npm run dev
   ```
7. Run the following command in the root of the project's directory:
   ```bash
   ./vendor/bin/sail artistian
   ```