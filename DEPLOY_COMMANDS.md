# 🚀 Heroku Deployment Commands - Copy & Paste

Since you've already run `heroku login`, follow these commands step by step.

**IMPORTANT**: Make sure Heroku CLI is in your PATH. If you see "command not found", you may need to:
1. Restart your terminal/PowerShell
2. Or find where Heroku is installed (usually `C:\Program Files\heroku\bin\heroku.cmd`)

---

## Step 1: Navigate to backend directory

```bash
cd C:\client\AuraLearn\backend-admin
```

---

## Step 2: Create Heroku app

Choose a unique name for your app (or let Heroku generate one):

```bash
# Option A: Custom name (replace "auralearn-backend" with your preferred name)
heroku create auralearn-backend --stack heroku-24

# Option B: Let Heroku generate a name
heroku create --stack heroku-24
```

**⚠️ IMPORTANT**: Note the app name and URL from the output!

Example output:
```
Creating app... done, ⬢ auralearn-backend-12345
https://auralearn-backend-12345.herokuapp.com/ | https://git.heroku.com/auralearn-backend-12345.git
```

---

## Step 3: Add buildpacks (Node.js + PHP)

```bash
heroku buildpacks:add heroku/nodejs
heroku buildpacks:add heroku/php
```

Verify:
```bash
heroku buildpacks
```

---

## Step 4: Generate APP_KEY

Run this locally to generate a key:

```bash
php artisan key:generate --show
```

**Copy the output!** It will look like: `base64:xxxxxxxxxxxxx`

---

## Step 5: Choose Database Option

### Option A: Add Heroku PostgreSQL ($5/month - Recommended)

```bash
heroku addons:create heroku-postgresql:essential-0
```

**Then set these config vars:**

```bash
heroku config:set APP_NAME="AuraLearn"
heroku config:set APP_ENV=production
heroku config:set APP_DEBUG=false
heroku config:set APP_KEY="PASTE_YOUR_KEY_FROM_STEP_4_HERE"
```

Get your app URL from Step 2 and set it:
```bash
heroku config:set APP_URL=https://YOUR-APP-NAME.herokuapp.com
```

### Option B: Use Existing Supabase (Free)

```bash
heroku config:set APP_NAME="AuraLearn"
heroku config:set APP_ENV=production
heroku config:set APP_DEBUG=false
heroku config:set APP_KEY="PASTE_YOUR_KEY_FROM_STEP_4_HERE"
```

Get your app URL from Step 2 and set it:
```bash
heroku config:set APP_URL=https://YOUR-APP-NAME.herokuapp.com
```

**Supabase Database credentials:**
```bash
heroku config:set DB_CONNECTION=pgsql
heroku config:set DB_HOST=aws-1-ap-southeast-1.pooler.supabase.com
heroku config:set DB_PORT=5432
heroku config:set DB_DATABASE=postgres
heroku config:set DB_USERNAME=postgres.bwgaiphnpdtfgyjwohmb
heroku config:set DB_PASSWORD="AuraLearn1234."
heroku config:set SUPABASE_URL=https://bwgaiphnpdtfgyjwohmb.supabase.co
heroku config:set SUPABASE_ANON_KEY="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImJ3Z2FpcGhucGR0Zmd5andvaG1iIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NjI1MjQ1NzcsImV4cCI6MjA3ODEwMDU3N30.16dF7WO52eHexIvMsUy6h3XnCyKA1j2BiE3JRHjbClY"
```

---

## Step 6: Set AI and RAG Configuration

```bash
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
```

---

## Step 7: Set Other Configuration

```bash
heroku config:set CACHE_STORE=file
heroku config:set SESSION_DRIVER=file
heroku config:set QUEUE_CONNECTION=database
heroku config:set FILESYSTEM_DISK=local
heroku config:set MAIL_MAILER=log
```

Verify all config:
```bash
heroku config
```

---

## Step 8: Deploy to Heroku

```bash
git push heroku main
```

**If you're on a different branch:**
```bash
git push heroku master:main
```

**⏳ This will take a few minutes...**

---

## Step 9: Run Post-Deployment Commands

```bash
# Run database migrations
heroku run php artisan migrate --force

# Create storage symlink
heroku run php artisan storage:link

# Seed system settings
heroku run php artisan db:seed --class=SystemSettingsSeeder

# Cache configuration for better performance
heroku run php artisan config:cache
heroku run php artisan route:cache
```

---

## Step 10: Scale Web Dyno

```bash
heroku ps:scale web=1
```

---

## Step 11: Check Status

```bash
# Check dyno status
heroku ps

# View logs
heroku logs --tail
```

---

## Step 12: Open Your App!

```bash
heroku open
```

Or manually visit: `https://YOUR-APP-NAME.herokuapp.com`

Test the health endpoint: `https://YOUR-APP-NAME.herokuapp.com/api/aurabot/health`

---

## 🎉 Success Checklist

- [ ] App created on Heroku
- [ ] Buildpacks added (Node.js + PHP)
- [ ] APP_KEY generated and set
- [ ] Database configured (Heroku Postgres or Supabase)
- [ ] All environment variables set
- [ ] Code pushed to Heroku
- [ ] Migrations ran successfully
- [ ] Storage symlink created
- [ ] System settings seeded
- [ ] Configuration cached
- [ ] Web dyno scaled to 1
- [ ] App accessible in browser

---

## 🔍 Useful Commands

```bash
# View all config variables
heroku config

# View recent logs
heroku logs -n 200

# View real-time logs
heroku logs --tail

# Restart app
heroku restart

# Run artisan commands
heroku run php artisan tinker

# Access bash shell
heroku run bash

# Check app info
heroku info

# View releases
heroku releases

# Rollback to previous release
heroku rollback
```

---

## 🚨 Troubleshooting

**Issue: "command not found: heroku"**
- Solution: Restart your terminal or find Heroku installation path
- Windows: Usually `C:\Program Files\heroku\bin\heroku.cmd`
- Add to PATH or use full path: `"C:\Program Files\heroku\bin\heroku.cmd" --version`

**Issue: "Application Error" after deployment**
```bash
heroku logs --tail
```
Check for errors and verify APP_KEY is set:
```bash
heroku config:get APP_KEY
```

**Issue: Database connection failed**
```bash
# Test database connection
heroku run php artisan tinker --execute="DB::connection()->getPdo();"
```

**Issue: Assets not loading (404)**
```bash
# Verify build folder exists
heroku run ls -la public/build

# Force rebuild
git commit --allow-empty -m "Trigger rebuild"
git push heroku main
```

---

## 💰 Monthly Cost

### Option A (Heroku Postgres):
- Eco Dyno: $5/month
- Heroku Postgres Essential-0: $5/month
- **Total: $10/month**

### Option B (Supabase):
- Eco Dyno: $5/month
- Supabase: Free tier
- **Total: $5/month**

---

## 🔄 Future Updates

To deploy changes:

```bash
# 1. Make your changes locally
git add .
git commit -m "Your changes"

# 2. Push to Heroku
git push heroku main

# 3. Run migrations if needed
heroku run php artisan migrate --force

# 4. Clear cache
heroku run php artisan cache:clear
heroku run php artisan config:cache
```

---

## 📞 Need Help?

- Heroku Status: https://status.heroku.com/
- Heroku PHP Docs: https://devcenter.heroku.com/categories/php-support
- Laravel Heroku Guide: https://devcenter.heroku.com/articles/getting-started-with-laravel

---

**Your AuraLearn backend will be live on Heroku! 🚀**

Start with **Step 1** and work through each step carefully.

