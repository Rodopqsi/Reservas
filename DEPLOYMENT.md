# Deployment Guide for Reserva Aulas

## Render Deployment

### Prerequisites
1. GitHub repository with the code
2. Render account
3. PostgreSQL database (can be created on Render)

### Steps to Deploy

1. **Connect Repository**
   - Go to Render dashboard
   - Click "New +" → "Web Service"
   - Connect your GitHub repository

2. **Configure Build Settings**
   - Build Command: `composer install --no-dev --optimize-autoloader && npm install && npm run build`
   - Start Command: `php artisan migrate --force && php artisan db:seed --force && php artisan serve --host 0.0.0.0 --port $PORT`
   - Environment: PHP

3. **Environment Variables**
   Set these in Render dashboard:
   ```
   APP_NAME=Reserva Aulas
   APP_ENV=production
   APP_KEY=base64:9hI95u98rZa5om8cdclWoGQATjMXW3pg3ZohW7K+3XY=
   APP_DEBUG=false
   APP_URL=https://your-app-name.onrender.com
   
   DB_CONNECTION=pgsql
   DB_HOST=your-postgres-host
   DB_PORT=5432
   DB_DATABASE=your-database-name
   DB_USERNAME=your-username
   DB_PASSWORD=your-password
   ```

4. **Database Setup**
   - Create PostgreSQL database on Render
   - Update environment variables with database credentials

5. **Deploy**
   - Click "Create Web Service"
   - Wait for deployment to complete

### Using Docker
Alternatively, you can use the provided Dockerfile:
```bash
docker build -t reserva-aulas .
docker run -p 8080:8080 reserva-aulas
```

### Manual Deployment Commands
```bash
# Install dependencies
composer install --no-dev --optimize-autoloader
npm install
npm run build

# Run migrations
php artisan migrate --force
php artisan db:seed --force

# Start server
php artisan serve --host=0.0.0.0 --port=8080
```

### Troubleshooting
- Ensure all environment variables are set correctly
- Check that the database connection is working
- Verify that the build process completes successfully
- Monitor logs for any errors during deployment