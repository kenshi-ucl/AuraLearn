# ⚡ Heroku Quick Start - Manual Deployment

This is a simplified step-by-step guide if you prefer to deploy manually without using the automated scripts.

## Prerequisites ✅
- [x] Git installed
- [x] Heroku CLI installed
- [x] Heroku login completed (`heroku login`)

---

## 🚀 Deploy in 8 Steps

### Step 1: Navigate to backend directory
```bash
cd backend-admin
```

### Step 2: Initialize Git (if needed)
```bash
# Check if git is initialized
git status

# If not, initialize it
git init
git add .
git commit -m "Initial commit"
```

### Step 3: Create Heroku app
```bash
# Create with custom name
heroku create auralearn-backend --stack heroku-24

# OR let Heroku generate a name
heroku create --stack heroku-24
```

**Note the app name from the output!** (e.g., `auralearn-backend-12345`)

### Step 4: Add buildpacks
```bash
heroku buildpacks:add heroku/nodejs
heroku buildpacks:add heroku/php
```

### Step 5: Configure environment
```bash
# Generate APP_KEY
php artisan key:generate --show
# Copy the output

# Set basic config (replace YOUR-APP-NAME and PASTE-KEY-HERE)
heroku config:set APP_NAME="AuraLearn"
heroku config:set APP_ENV=production
heroku config:set APP_DEBUG=false
heroku config:set APP_KEY="PASTE-KEY-HERE"
heroku config:set APP_URL=https://YOUR-APP-NAME.herokuapp.com

# Database - Option A: Add Heroku Postgres
heroku addons:create heroku-postgresql:essential-0

# Database - Option B: Use Supabase (run these if using Supabase)
heroku config:set DB_CONNECTION=pgsql
heroku config:set DB_HOST=aws-1-ap-southeast-1.pooler.supabase.com
heroku config:set DB_PORT=5432
heroku config:set DB_DATABASE=postgres
heroku config:set DB_USERNAME=postgres.bwgaiphnpdtfgyjwohmb
heroku config:set DB_PASSWORD="AuraLearn1234."
heroku config:set SUPABASE_URL=https://bwgaiphnpdtfgyjwohmb.supabase.co
heroku config:set SUPABASE_ANON_KEY="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImJ3Z2FpcGhucGR0Zmd5andvaG1iIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NjI1MjQ1NzcsImV4cCI6MjA3ODEwMDU3N30.16dF7WO52eHexIvMsUy6h3XnCyKA1j2BiE3JRHjbClY"

# AI & RAG Config
heroku config:set NEBIUS_API_KEY="eyJhbGciOiJIUzI1NiIsImtpZCI6IlV6SXJWd1h0dnprLVRvdzlLZWstc0M1akptWXBvX1VaVkxUZlpnMDRlOFUiLCJ0eXAiOiJKV1QifQ.eyJzdWIiOiJnb29nbGUtb2F1dGgyfDExNTA2OTc0MDQ0ODAwNTU0MDUyOCIsInNjb3BlIjoib3BlbmlkIG9mZmxpbmVfYWNjZXNzIiwiaXNzIjoiYXBpX2tleV9pc3N1ZXIiLCJhdWQiOlsiaHR0cHM6Ly9uZWJpdXMtaW5mZXJlbmNlLmV1LmF1dGgwLmNvbS9hcGkvdjIvIl0sImV4cCI6MTkxNjQwMzI2MywidXVpZCI6IjAxOTk3YzEzLTUwZjQtN2ExNy04NzMzLTgzNGM1ZGE0YWNjMyIsIm5hbWUiOiJhdXJhbGVhcm4iLCJleHBpcmVzX2F0IjoiMjAzMC0wOS0yM1QxNDoxNDoyMyswMDAwIn0.Y5iqoa7Jk_Pv16N7lR-igAxYx-SQ4InhbYsuPbTO3_U"
heroku config:set NEBIUS_BASE_URL=https://api.studio.nebius.com/v1/
heroku config:set NEBIUS_MODEL=openai/gpt-oss-20b
heroku config:set EMBEDDING_MODEL=BAAI/bge-multilingual-gemma2
heroku config:set VECTOR_DIM=1024
heroku config:set RAG_MAX_CHUNKS=5
heroku config:set RAG_CHUNK_SIZE=1000
heroku config:set RAG_CHUNK_OVERLAP=200
heroku config:set AURABOT_MAX_TOKENS=10000
heroku config:set AURABOT_ATTEMPT_LIMIT=3

# Other settings
heroku config:set CACHE_STORE=file
heroku config:set SESSION_DRIVER=file
heroku config:set QUEUE_CONNECTION=database
heroku config:set FILESYSTEM_DISK=local
heroku config:set MAIL_MAILER=log
```

### Step 6: Deploy!
```bash
git push heroku main

# If you're on master branch:
# git push heroku master:main
```

### Step 7: Run post-deploy commands
```bash
heroku run php artisan migrate --force
heroku run php artisan storage:link
heroku run php artisan db:seed --class=SystemSettingsSeeder
heroku run php artisan config:cache
heroku run php artisan route:cache
```

### Step 8: Scale web dyno
```bash
heroku ps:scale web=1
```

---

## 🎉 Done! Open your app:
```bash
heroku open
```

Or visit: `https://YOUR-APP-NAME.herokuapp.com`

---

## 📊 Check Status

```bash
# View logs
heroku logs --tail

# Check dyno status
heroku ps

# View config
heroku config

# Test health endpoint
curl https://YOUR-APP-NAME.herokuapp.com/api/aurabot/health
```

---

## 🔧 Useful Commands

```bash
# Restart app
heroku restart

# Run artisan command
heroku run php artisan tinker

# Clear cache
heroku run php artisan cache:clear

# Access bash
heroku run bash

# View database
heroku pg:psql  # If using Heroku Postgres
```

---

## 🚨 Troubleshooting

**App shows "Application Error"**
```bash
heroku logs --tail
# Check what went wrong in the logs
```

**Database connection failed**
```bash
# Test database
heroku run php artisan tinker --execute="DB::connection()->getPdo();"

# Verify config
heroku config | grep DB_
```

**Assets not loading**
```bash
# Check if build folder exists
heroku run ls -la public/build

# Force rebuild
git commit --allow-empty -m "Rebuild"
git push heroku main
```

---

## 💰 Cost

- **Eco Dyno**: $5/month
- **Heroku Postgres Essential-0**: $5/month
- **OR use Supabase free tier**: $0/month

**Total**: $5-10/month

---

## 📚 Full Documentation

See `HEROKU_DEPLOY_GUIDE.md` for comprehensive guide with troubleshooting, monitoring, and advanced configuration.

---

**Your backend is now live on Heroku! 🚀**

