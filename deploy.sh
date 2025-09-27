 git pull origin develope
chmod 777 -R ./

if [ ! -f "./.env" ]; then
    cp ./.env.example ./.env
fi

docker-compose up -d --build

docker-compose exec myurist-app composer install --ignore-platform-reqs --no-interaction --prefer-dist --optimize-autoloader
docker-compose exec myurist-app php artisan key:generate

docker-compose exec myurist-app php artisan migrate

docker-compose exec myurist-app php artisan cache:clear
docker-compose exec myurist-app php artisan auth:clear-resets
docker-compose exec myurist-app php artisan route:cache
docker-compose exec myurist-app php artisan config:cache
docker-compose exec myurist-app php artisan view:cache

docker-compose exec myurist-app npm ci
docker-compose exec myurist-app npm run production
