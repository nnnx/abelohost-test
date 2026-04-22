# Тестовое AbeloHost 22.04.2026

## Установка

```
docker-compose build
docker-compose up -d
docker-compose exec php-fpm composer install
```

## Импорт БД с тестовыми данными
```
make db-restore
```

## Веб-доступ
```
URL: http://localhost:8000/
```