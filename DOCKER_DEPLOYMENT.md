# Docker Deployment Guide for AuraLearn Backend

## 🐳 Overview

This Laravel backend is fully Dockerized and ready for deployment on **Render.com** or any container platform.

## 📦 What's Included

- **Multi-stage Dockerfile** with optimized build process
- **Nginx + PHP-FPM** running under Supervisor
- **Production-ready** configuration with security best practices
- **Automatic port binding** via `$PORT` environment variable (Render compatible)
- **Composer** and **Node/Vite** asset compilation included

## 🚀 Quick Start

### Local Development

```bash
# Build the Docker image
docker build -t auralearn-backend ./backend-admin

# Run locally (requires .env file)
docker run --rm -p 8080:8080 \
  --env-file ./backend-admin/.env \
  auralearn-backend
```

### Production Deployment on Render.com

1. **Push your code to GitHub:**
   ```bash
   git add .
   git commit -m "Add Docker configuration"
   git push origin main
   ```

2. **Create a Web Service on Render:**
   - Go to [Render Dashboard](https://dashboard.render.com/)
   - Click **"New +" → "Web Service"**
   - Connect your GitHub repository
   - Select the repository containing `backend-admin/`

3. **Configure the service:**
   - **Name:** `auralearn-backend`
   - **Environment:** `Docker`
   - **Region:** Choose closest to your users
   - **Branch:** `main` (or your default branch)
   - **Root Directory:** `backend-admin` (if backend is in subdirectory)
   - **Dockerfile Path:** `Dockerfile` (or `backend-admin/Dockerfile` if in root)
   - **Docker Build Context:** `.` or `backend-admin`

4. **Environment Variables** (Add these in Render dashboard):

   ```env
   # Application
   APP_NAME=AuraLearn
   APP_ENV=production
   APP_DEBUG=false
   APP_KEY=base64:YOUR_APP_KEY_HERE
   APP_URL=https://your-app.onrender.com

   # Database (Use Render PostgreSQL or your Supabase)
   DB_CONNECTION=pgsql
   DB_HOST=your-db-host
   DB_PORT=5432
   DB_DATABASE=your-database
   DB_USERNAME=your-username
   DB_PASSWORD=your-password

   # Supabase (if using)
   SUPABASE_URL=https://your-project.supabase.co
   SUPABASE_ANON_KEY=your-anon-key

   # AI Configuration
   NEBIUS_API_KEY=your-nebius-api-key
   NEBIUS_BASE_URL=https://api.studio.nebius.com/v1/
   NEBIUS_MODEL=openai/gpt-oss-20b
   EMBEDDING_MODEL=BAAI/bge-multilingual-gemma2

   # RAG Settings
   VECTOR_DIM=1024
   RAG_MAX_CHUNKS=5
   RAG_CHUNK_SIZE=1000
   RAG_CHUNK_OVERLAP=200
   AURABOT_MAX_TOKENS=10000
   AURABOT_ATTEMPT_LIMIT=3

   # Optional: Run migrations on container start
   RUN_MIGRATIONS=true

   # Cache & Sessions
   CACHE_STORE=file
   SESSION_DRIVER=file
   QUEUE_CONNECTION=database
   ```

5. **Deploy:**
   - Click **"Create Web Service"**
   - Render will automatically build and deploy your container
   - Your app will be available at `https://your-app.onrender.com`

## 🏗️ Docker Architecture

### Multi-Stage Build Process

1. **Vendor Stage** - Installs PHP dependencies via Composer
2. **Frontend Stage** - Builds Vite assets (JS/CSS)
3. **Production Stage** - Combines everything into final image

### Runtime Configuration

- **Web Server:** Nginx (listens on `$PORT` or 8080)
- **PHP:** PHP-FPM 8.2
- **Process Manager:** Supervisor (manages nginx + php-fpm)
- **Entrypoint:** Custom script that:
  - Renders nginx config with correct `$PORT`
  - Sets up writable directories
  - Optionally runs migrations

## 📁 Project Structure

```
backend-admin/
├── Dockerfile                 # Main Docker configuration
├── .dockerignore             # Files excluded from build
├── docker/
│   ├── entrypoint.sh         # Container startup script
│   ├── nginx/
│   │   └── default.conf      # Nginx configuration template
│   └── supervisord.conf      # Process manager config
├── app/                      # Laravel application
├── public/                   # Public assets
└── storage/                  # Runtime storage (logs, cache)
```

## ⚙️ Configuration Files

### Dockerfile

Multi-stage build optimized for production:
- Installs system dependencies
- Compiles PHP extensions (pdo_pgsql, zip, redis)
- Builds frontend assets with Vite
- Sets up Nginx + PHP-FPM under Supervisor

### docker/entrypoint.sh

Startup script that:
- Substitutes `$PORT` in nginx config
- Fixes storage permissions
- Runs migrations if `RUN_MIGRATIONS=true`

### docker/nginx/default.conf

Nginx configuration template:
- Listens on `${PORT}` (replaced at runtime)
- Serves Laravel `public/` directory
- Routes requests to PHP-FPM
- Security headers included

### docker/supervisord.conf

Manages two processes:
- `php-fpm` (PHP FastCGI Process Manager)
- `nginx` (Web server)

## 🔧 Advanced Configuration

### Custom Port

By default, the container listens on port 8080. Render automatically sets `$PORT`:

```bash
# Locally with custom port
docker run -e PORT=3000 -p 3000:3000 auralearn-backend
```

### Run Migrations Automatically

```bash
# Via environment variable
docker run -e RUN_MIGRATIONS=true auralearn-backend
```

### Persistent Storage

For uploads and logs, mount volumes:

```bash
docker run -v ./storage:/var/www/html/storage \
  -v ./cache:/var/www/html/bootstrap/cache \
  auralearn-backend
```

### Database Migrations

Run migrations manually:

```bash
# From running container
docker exec -it <container-id> php artisan migrate --force

# One-time container
docker run --rm \
  --env-file .env \
  auralearn-backend \
  php artisan migrate --force
```

## 🧪 Testing Locally

### Build and Test

```bash
# Build image
docker build -t auralearn-backend ./backend-admin

# Test run
docker run --rm -p 8080:8080 \
  -e APP_KEY="base64:test-key" \
  -e DB_CONNECTION=pgsql \
  -e DB_HOST=host.docker.internal \
  -e DB_PORT=5432 \
  -e DB_DATABASE=auralearn \
  -e DB_USERNAME=postgres \
  -e DB_PASSWORD=yourpassword \
  auralearn-backend

# Check health
curl http://localhost:8080/api/aurabot/health
```

### Debug Container

```bash
# Access shell
docker run --rm -it auralearn-backend /bin/bash

# Check logs
docker logs <container-id>

# Follow logs
docker logs -f <container-id>
```

## 📊 Monitoring & Logs

### View Logs

```bash
# Application logs (inside container)
docker exec <container-id> tail -f /var/www/html/storage/logs/laravel.log

# Nginx access logs
docker exec <container-id> tail -f /var/log/nginx/access.log

# PHP-FPM logs
docker logs <container-id> | grep php-fpm
```

### Health Checks

```bash
# Check service status
curl https://your-app.onrender.com/api/aurabot/health

# Expected response:
{
  "success": true,
  "status": "healthy",
  "database": "connected",
  "nebius_api": "connected",
  "timestamp": "2025-01-15T12:00:00Z"
}
```

## 🔒 Security Best Practices

✅ **Implemented:**
- Non-root user (`www-data`)
- Minimal base image (Debian Bullseye)
- No sensitive data in image
- Environment variables for secrets
- Security headers in Nginx
- Production-optimized PHP settings

⚠️ **Recommendations:**
- Use Render's Secret Files for sensitive configs
- Enable HTTPS (Render provides free SSL)
- Set `APP_DEBUG=false` in production
- Use strong `APP_KEY` (generate with `php artisan key:generate`)
- Restrict database access to your Render services

## 🚨 Troubleshooting

### Container Won't Start

```bash
# Check build logs
docker build -t test ./backend-admin

# Run with verbose output
docker run --rm -e APP_DEBUG=true test

# Check entrypoint
docker run --rm --entrypoint /bin/bash -it test
```

### Database Connection Issues

```bash
# Test from container
docker exec -it <container-id> php artisan tinker
>>> DB::connection()->getPdo();

# Check environment
docker exec <container-id> env | grep DB_
```

### Port Binding Issues

```bash
# Verify port
docker exec <container-id> netstat -tuln | grep LISTEN

# Check nginx config
docker exec <container-id> cat /etc/nginx/conf.d/default.conf
```

### Permission Errors

```bash
# Fix storage permissions
docker exec <container-id> chown -R www-data:www-data /var/www/html/storage
docker exec <container-id> chmod -R 775 /var/www/html/storage
```

## 📈 Performance Optimization

### PHP-FPM Tuning

Edit `docker/supervisord.conf` or add PHP-FPM config:

```ini
pm = dynamic
pm.max_children = 50
pm.start_servers = 5
pm.min_spare_servers = 5
pm.max_spare_servers = 35
```

### Nginx Caching

Add to `docker/nginx/default.conf`:

```nginx
location ~* \.(jpg|jpeg|png|gif|ico|css|js)$ {
    expires 1y;
    add_header Cache-Control "public, immutable";
}
```

### Database Connection Pooling

Use Supabase Session Pooler or configure PgBouncer.

## 🔄 CI/CD Integration

### GitHub Actions Example

```yaml
name: Deploy to Render

on:
  push:
    branches: [ main ]

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Deploy to Render
        run: curl https://api.render.com/deploy/your-service-id
```

### Render Auto-Deploy

Render automatically deploys on git push when connected to GitHub.

## 📚 Additional Resources

- [Render Documentation](https://render.com/docs)
- [Laravel Deployment](https://laravel.com/docs/deployment)
- [Docker Best Practices](https://docs.docker.com/develop/dev-best-practices/)
- [Nginx Configuration](https://nginx.org/en/docs/)

## ✅ Deployment Checklist

- [ ] Code pushed to GitHub
- [ ] Render service created
- [ ] Environment variables configured
- [ ] Database connection tested
- [ ] Migrations run successfully
- [ ] Health check endpoint responds
- [ ] HTTPS enabled (automatic on Render)
- [ ] Logs are accessible
- [ ] Storage directories writable
- [ ] AI services configured (Nebius)

## 💡 Tips

1. **Use Render's PostgreSQL** for easy database setup
2. **Enable Auto-Deploy** for continuous deployment
3. **Monitor Logs** via Render dashboard
4. **Set up Health Checks** for automatic restarts
5. **Use Environment Groups** for multiple environments (staging/production)

---

**Your AuraLearn backend is now ready for production! 🎉**

For questions or issues, check the main README or contact the development team.

