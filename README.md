# music-service-university
music service for University (Laravel, Angular, Docker)

## 💻 Предварительные требования

Проверьте, что на вашем компьютере установлены следующие компоненты и ПО:

- php (версия 8.2)
- Docker
- Node.js 
- composer

1. Перейдите в директорию api-server:

```bash
cd api-server
```

2. Установите зависимости:
```bash
composer install
```

3. Перейдите в директорию frontend:
```bash
cd ../frontend
```

4. Установите зависимости:
```bash
npm install --force
```

5. Запустите команду:
```bash
npm run build
```

6. Перейдите в директорию api-server:
```bash
cd ../api-server
```

7. Запустите команду:
```bash
docker-compose up -d
```

8. Запустите миграции:
```bash
php artisan migrate
```

9. Заполните базу:
```bash
php artisan db:seed
```