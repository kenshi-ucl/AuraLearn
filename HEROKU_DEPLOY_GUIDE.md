# 🚀 Heroku Deployment Guide for AuraLearn Backend

## ✅ Prerequisites (Already Done)
- ✅ Git installed
- ✅ Heroku CLI installed
- ✅ Logged in to Heroku (`heroku login`)
- ✅ PHP 8.2 specified in composer.json
- ✅ Procfile created
- ✅ heroku-postbuild script added to package.json

## 📋 Step-by-Step Deployment

### Step 1: Initialize Git Repository (if not already done)

```bash
cd backend-admin
git init
git add .
git commit -m "Initial commit for Heroku deployment"
```

### Step 2: Create Heroku App

```bash
# Create app with latest stack
heroku create auralearn-backend --stack heroku-24

# Or if you want Heroku to generate a random name:
# heroku create --stack heroku-24

# Note the app name (e.g., auralearn-backend-12345.herokuapp.com)
```

### Step 3: Add Buildpacks (Order Matters!)

```bash
# Add Node.js first (for Vite build)
heroku buildpacks:add heroku/nodejs

# Add PHP second (for Laravel)
heroku buildpacks:add heroku/php

# Verify buildpacks
heroku buildpacks
```

### Step 4: Add PostgreSQL Database

**Option A: Heroku Postgres (Recommended - $5/month)**
```bash
heroku addons:create heroku-postgresql:essential-0
```

**Option B: Use your existing Supabase (Free)**
```bash
# Skip the addon, we'll configure Supabase credentials in Step 5
```

### Step 5: Configure Environment Variables

```bash
# Generate APP_KEY locally first
php artisan key:generate --show
# Copy the output (e.g., base64:xxxxx)

# Set Laravel configuration
heroku config:set APP_NAME="AuraLearn"
heroku config:set APP_ENV=production
heroku config:set APP_DEBUG=false
heroku config:set APP_KEY="base64:PASTE_YOUR_KEY_HERE"

# Set your Heroku app URL (replace YOUR-APP-NAME)
heroku config:set APP_URL=https://YOUR-APP-NAME.herokuapp.com

# Option A: If using Heroku Postgres
# Laravel will auto-configure from DATABASE_URL

# Option B: If using Supabase (Your current setup)
heroku config:set DB_CONNECTION=pgsql
heroku config:set DB_HOST=aws-1-ap-southeast-1.pooler.supabase.com
heroku config:set DB_PORT=5432
heroku config:set DB_DATABASE=postgres
heroku config:set DB_USERNAME=postgres.bwgaiphnpdtfgyjwohmb
heroku config:set DB_PASSWORD="AuraLearn1234."

# Supabase Configuration
heroku config:set SUPABASE_URL=https://bwgaiphnpdtfgyjwohmb.supabase.co
heroku config:set SUPABASE_ANON_KEY="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImJ3Z2FpcGhucGR0Zmd5andvaG1iIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NjI1MjQ1NzcsImV4cCI6MjA3ODEwMDU3N30.16dF7WO52eHexIvMsUy6h3XnCyKA1j2BiE3JRHjbClY"

# AI Configuration (Nebius)
heroku config:set NEBIUS_API_KEY="eyJhbGciOiJIUzI1NiIsImtpZCI6IlV6SXJWd1h0dnprLVRvdzlLZWstc0M1akptWXBvX1VaVkxUZlpnMDRlOFUiLCJ0eXAiOiJKV1QifQ.eyJzdWIiOiJnb29nbGUtb2F1dGgyfDExNTA2OTc0MDQ0ODAwNTU0MDUyOCIsInNjb3BlIjoib3BlbmlkIG9mZmxpbmVfYWNjZXNzIiwiaXNzIjoiYXBpX2tleV9pc3N1ZXIiLCJhdWQiOlsiaHR0cHM6Ly9uZWJpdXMtaW5mZXJlbmNlLmV1LmF1dGgwLmNvbS9hcGkvdjIvIl0sImV4cCI6MTkxNjQwMzI2MywidXVpZCI6IjAxOTk3YzEzLTUwZjQtN2ExNy04NzMzLTgzNGM1ZGE0YWNjMyIsIm5hbWUiOiJhdXJhbGVhcm4iLCJleHBpcmVzX2F0IjoiMjAzMC0wOS0yM1QxNDoxNDoyMyswMDAwIn0.Y5iqoa7Jk_Pv16N7lR-igAxYx-SQ4InhbYsuPbTO3_U"
heroku config:set NEBIUS_BASE_URL=https://api.studio.nebius.com/v1/
heroku config:set NEBIUS_MODEL=openai/gpt-oss-20b
heroku config:set EMBEDDING_MODEL=BAAI/bge-multilingual-gemma2

# RAG Configuration
heroku config:set VECTOR_DIM=1024
heroku config:set RAG_MAX_CHUNKS=5
heroku config:set RAG_CHUNK_SIZE=1000
heroku config:set RAG_CHUNK_OVERLAP=200
heroku config:set AURABOT_MAX_TOKENS=10000
heroku config:set AURABOT_ATTEMPT_LIMIT=3

# Cache and Session
heroku config:set CACHE_STORE=file
heroku config:set SESSION_DRIVER=file
heroku config:set QUEUE_CONNECTION=database
heroku config:set FILESYSTEM_DISK=local

# Mail Configuration
heroku config:set MAIL_MAILER=log

# Verify all configs
heroku config
```

### Step 6: Deploy to Heroku

```bash
# Push to Heroku
git push heroku main

# If you're on a different branch (e.g., master):
# git push heroku master:main
```

### Step 7: Run Post-Deployment Commands

```bash
# Run database migrations
heroku run php artisan migrate --force

# Create storage symlink
heroku run php artisan storage:link

# Seed system settings (optional)
heroku run php artisan db:seed --class=SystemSettingsSeeder

# Clear and cache config
heroku run php artisan config:cache
heroku run php artisan route:cache
heroku run php artisan view:cache

# Verify database connection
heroku run php artisan tinker --execute="DB::connection()->getPdo();"
```

### Step 8: Scale Web Dyno

```bash
# Scale to 1 web dyno (Eco dyno - $5/month)
heroku ps:scale web=1

# Check dyno status
heroku ps
```

### Step 9: Open Your App!

```bash
# Open in browser
heroku open

# Or visit manually:
# https://YOUR-APP-NAME.herokuapp.com

# Test health endpoint:
# https://YOUR-APP-NAME.herokuapp.com/api/aurabot/health
```

## 🔍 Monitoring & Debugging

### View Logs
```bash
# Real-time logs
heroku logs --tail

# Last 200 lines
heroku logs -n 200

# Filter by type
heroku logs --source app --tail
```

### Run Commands
```bash
# Access Laravel Tinker
heroku run php artisan tinker

# Clear cache
heroku run php artisan cache:clear
heroku run php artisan config:clear

# Check environment
heroku run php -v
heroku run composer --version
```

### Database Access
```bash
# Connect to Heroku Postgres (if using)
heroku pg:psql

# Or connect to Supabase directly
psql "postgresql://postgres.bwgaiphnpdtfgyjwohmb:AuraLearn1234.@aws-1-ap-southeast-1.pooler.supabase.com:5432/postgres"
```

## ⚡ Quick Commands Reference

```bash
# Restart app
heroku restart

# Check app info
heroku info

# View config vars
heroku config

# Set single config
heroku config:set KEY=value

# Unset config
heroku config:unset KEY

# View releases
heroku releases

# Rollback to previous release
heroku rollback

# Run artisan commands
heroku run php artisan COMMAND

# Access bash
heroku run bash
```

## 🚨 Troubleshooting

### Issue: Application Error (500)
```bash
# Check logs
heroku logs --tail

# Verify APP_KEY is set
heroku config:get APP_KEY

# Clear cache
heroku run php artisan config:clear
heroku run php artisan cache:clear
```

### Issue: Database Connection Failed
```bash
# Verify database credentials
heroku config | grep DB_

# Test connection
heroku run php artisan tinker --execute="DB::connection()->getPdo();"

# Check if pgvector extension exists (for Supabase)
heroku run php artisan tinker --execute="DB::statement('CREATE EXTENSION IF NOT EXISTS vector');"
```

### Issue: Assets Not Loading (404)
```bash
# Verify Vite built assets
heroku run ls -la public/build

# Rebuild assets
git commit --allow-empty -m "Rebuild assets"
git push heroku main
```

### Issue: Permission Denied on storage/
```bash
# Heroku's filesystem is ephemeral
# Use cloud storage for uploads (S3, Cloudinary, etc.)
# Or keep using local storage (will reset on dyno restart)
```

### Issue: Slow Response Times
```bash
# Check dyno performance
heroku ps

# Upgrade dyno type (if needed)
heroku ps:scale web=1:standard-1x

# Enable OPcache (add to composer.json require):
# "ext-opcache": "*"
```

## 📊 Cost Breakdown

- **Eco Dyno**: $5/month (550 hours)
- **Heroku Postgres Essential-0**: $5/month (1GB storage)
- **OR Use Supabase**: Free tier available

**Total with Heroku Postgres**: ~$10/month
**Total with Supabase**: ~$5/month

## 🔄 Updating Your App

```bash
# Make changes locally
git add .
git commit -m "Update description"

# Deploy to Heroku
git push heroku main

# Run migrations if needed
heroku run php artisan migrate --force
```

## 🌐 Custom Domain (Optional)

```bash
# Add custom domain
heroku domains:add www.auralearn.com

# Configure DNS with your provider
# Add CNAME record: www -> YOUR-APP-NAME.herokuapp.com
```

## 🎉 Success Checklist

- [ ] Heroku app created
- [ ] Buildpacks added (Node.js + PHP)
- [ ] Environment variables configured
- [ ] Database connected (Heroku Postgres or Supabase)
- [ ] Code pushed to Heroku
- [ ] Migrations run successfully
- [ ] Storage symlink created
- [ ] Web dyno scaled to 1
- [ ] App opens without errors
- [ ] Health endpoint returns success
- [ ] Admin login works
- [ ] Database queries work
- [ ] AI features functional

## 📞 Support

If you encounter issues:
1. Check logs: `heroku logs --tail`
2. Verify config: `heroku config`
3. Test database: `heroku run php artisan tinker`
4. Review Heroku status: https://status.heroku.com/

---

**Your AuraLearn backend is now live on Heroku! 🚀**

