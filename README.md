
Clone the Repository

bash
Copy
Edit
git clone https://github.com/DineeshDS/puzzle.git
cd puzzle
Install PHP Dependencies

bash
Copy
Edit
composer install

bash
Copy
Edit
cp .env.example .env
php artisan key:generate
Set Up Your Environment Variables

Open .env and set your database credentials and any other required variables:

env
Copy
Edit
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
Run Migrations and Seed Database (if applicable)

bash
Copy
Edit
php artisan migrate
Install Node Modules and Compile Assets

bash
Copy
Edit
npm install
npm run dev
🌐 Running the Application
Start the Laravel development server:

bash
Copy
Edit
php artisan serve
Visit http://127.0.0.1:8000 in your browser.