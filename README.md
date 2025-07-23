# 🔍 Laravel Website-Wide Search App

This Laravel application implements a **Website-Wide Search System** using **Laravel Scout** and **Meilisearch**, supporting fuzzy and partial matches across multiple content types (blogs, products, pages, FAQs).

---

## ⚙️ Technology Stack

- **Laravel 10**
- **MySQL 8**
- **Meilisearch v1.8** (Search Engine)
- **Docker + Docker Compose**
- **Laravel Scout**
- **Laravel Queue** (DB driver)
- **Laravel Scheduler** (optional)

---

## 🚀 Setup Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/laravel-search-app.git
cd laravel-search-app


### 2. Copy .env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=search_app
DB_USERNAME=laravel
DB_PASSWORD=secret

SCOUT_DRIVER=meilisearch
MEILISEARCH_HOST=http://meilisearch:7700
MEILISEARCH_KEY=masterKey

QUEUE_CONNECTION=database

### 3. Start Docker Containers
docker-compose up -d --build

### 4. Install Dependencies & Set Permissions
docker exec -it search_app bash

# Inside container:
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan scout:import "App\\Models\\Blog"
php artisan scout:import "App\\Models\\Products"
php artisan scout:import "App\\Models\\Pages"
php artisan scout:import "App\\Models\\Faqs"

### 5. Unified Search API
{
   "current_page":1,
   "data":[
      {
         "type":"Blog",
         "title":"Laravel Developer Needed",
         "snippet":"Learn to use Laravel Scout with Meilisearch...",
         "link":"http:\/\/localhost:8000\/Blog\/30",
         "updated_at":"2025-07-23T14:19:27.000000Z"
      },
....
   ],
  
}

### 6. Enable DB Queue
php artisan queue:table
php artisan migrate
#Start queue worker:

### 7. Optional: Schedule Re-Indexing (e.g., daily)
In app/Console/Kernel.php:
$schedule->command('scout:rebuild-all')->daily();
Then in Docker container:
php artisan schedule:run


### 8. 🔁 Rebuild Index Manually
php artisan scout:flush "App\\Models\\Blog"
php artisan scout:import "App\\Models\\Blog"
# Repeat for Product, Page, Faq

#Or use a custom command:
php artisan scout:rebuild-all


### 9. 🔍 Sample Queries and Results
Query	Matches
deve-	"developer", "development", etc.
faq-	All FAQ questions/answers
shop-	Product with category "Shop Tools"
laravel-	Blog titles or content with "Laravel"


### 10.API Endpoints
GET /api/search?q=	Unified search across all content
GET /api/search/logs	(optional) Admin search logs
GET /api/search/suggestions?q=	(optional) Typeahead


### 11.🐳 Docker Services
| Service       | URL / Port                                     |
| ------------- | ---------------------------------------------- |
| App (Laravel) | [http://localhost:8000](http://localhost:8000) |
| MySQL         | localhost:3306                                 |
| Meilisearch   | [http://localhost:7700](http://localhost:7700) |
| Queue Worker  | Run manually                                   |


### 12. ✅ To-Do (Optional Features)
 Typeahead suggestions API

 Admin-only logs

 UI (Frontend) for search results

 Unit + Feature tests

📌 License
MIT – Free to use for any commercial or personal project.

