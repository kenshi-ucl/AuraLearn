# AuraLearn Backend - Heroku Deployment Script (PowerShell)
# This script automates the Heroku deployment process for Windows

$ErrorActionPreference = "Stop"

Write-Host "🚀 AuraLearn Backend - Heroku Deployment" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Check if Heroku CLI is installed
try {
    $null = Get-Command heroku -ErrorAction Stop
    Write-Host "✅ Heroku CLI is installed" -ForegroundColor Green
} catch {
    Write-Host "❌ Heroku CLI is not installed. Please install it first." -ForegroundColor Red
    Write-Host "Visit: https://devcenter.heroku.com/articles/heroku-cli"
    exit 1
}

# Check if logged in to Heroku
try {
    $null = heroku whoami 2>&1
    Write-Host "✅ Logged in to Heroku" -ForegroundColor Green
} catch {
    Write-Host "❌ Not logged in to Heroku. Running 'heroku login'..." -ForegroundColor Red
    heroku login
}

Write-Host ""

# Ask for app name
$AppName = Read-Host "Enter your Heroku app name (or press Enter for auto-generated)"

Write-Host ""
Write-Host "📦 Step 1: Creating Heroku App..." -ForegroundColor Yellow
if ([string]::IsNullOrWhiteSpace($AppName)) {
    heroku create --stack heroku-24
} else {
    try {
        heroku create $AppName --stack heroku-24
    } catch {
        Write-Host "App might already exist, continuing..." -ForegroundColor Yellow
    }
}

Write-Host ""
Write-Host "🔨 Step 2: Adding Buildpacks..." -ForegroundColor Yellow
try { heroku buildpacks:clear } catch {}
heroku buildpacks:add heroku/nodejs
heroku buildpacks:add heroku/php
Write-Host "✅ Buildpacks added" -ForegroundColor Green

Write-Host ""
Write-Host "💾 Step 3: Database Setup" -ForegroundColor Yellow
Write-Host "Choose your database option:"
Write-Host "1) Add Heroku PostgreSQL (`$5/month)"
Write-Host "2) Use existing Supabase (Free)"
$DbChoice = Read-Host "Enter choice (1 or 2)"

$UseSupabase = $false
if ($DbChoice -eq "1") {
    Write-Host "Adding Heroku PostgreSQL..." -ForegroundColor Yellow
    heroku addons:create heroku-postgresql:essential-0
    Write-Host "✅ Heroku PostgreSQL added" -ForegroundColor Green
} else {
    Write-Host "Will configure Supabase credentials..." -ForegroundColor Yellow
    $UseSupabase = $true
}

Write-Host ""
Write-Host "🔑 Step 4: Generating APP_KEY..." -ForegroundColor Yellow
$AppKey = php artisan key:generate --show
Write-Host "✅ APP_KEY generated: $AppKey" -ForegroundColor Green

Write-Host ""
Write-Host "⚙️ Step 5: Setting Environment Variables..." -ForegroundColor Yellow

# Get Heroku app URL
$HerokuInfo = heroku info -j | ConvertFrom-Json
$HerokuAppUrl = $HerokuInfo.app.web_url

# Basic Laravel configuration
heroku config:set APP_NAME="AuraLearn"
heroku config:set APP_ENV=production
heroku config:set APP_DEBUG=false
heroku config:set APP_KEY="$AppKey"
heroku config:set APP_URL="$HerokuAppUrl"

# Database configuration (if using Supabase)
if ($UseSupabase) {
    heroku config:set DB_CONNECTION=pgsql
    heroku config:set DB_HOST=aws-1-ap-southeast-1.pooler.supabase.com
    heroku config:set DB_PORT=5432
    heroku config:set DB_DATABASE=postgres
    heroku config:set DB_USERNAME=postgres.bwgaiphnpdtfgyjwohmb
    heroku config:set DB_PASSWORD="AuraLearn1234."
    
    heroku config:set SUPABASE_URL=https://bwgaiphnpdtfgyjwohmb.supabase.co
    heroku config:set SUPABASE_ANON_KEY="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImJ3Z2FpcGhucGR0Zmd5andvaG1iIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NjI1MjQ1NzcsImV4cCI6MjA3ODEwMDU3N30.16dF7WO52eHexIvMsUy6h3XnCyKA1j2BiE3JRHjbClY"
}

# AI Configuration
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
heroku config:set MAIL_MAILER=log

Write-Host "✅ Environment variables configured" -ForegroundColor Green

Write-Host ""
Write-Host "📤 Step 6: Committing changes and deploying..." -ForegroundColor Yellow

# Check if there are uncommitted changes
$GitStatus = git status --porcelain
if ($GitStatus) {
    Write-Host "Committing deployment files..." -ForegroundColor Yellow
    git add Procfile package.json .htaccess-heroku HEROKU_DEPLOY_GUIDE.md deploy-to-heroku.sh deploy-to-heroku.ps1
    try {
        git commit -m "Configure for Heroku deployment"
    } catch {
        Write-Host "Nothing to commit" -ForegroundColor Yellow
    }
}

Write-Host "Pushing to Heroku..." -ForegroundColor Yellow
try {
    git push heroku main
} catch {
    try {
        git push heroku master:main
    } catch {
        Write-Host "Error pushing to Heroku. Please check your git configuration." -ForegroundColor Red
        exit 1
    }
}

Write-Host "✅ Code deployed to Heroku" -ForegroundColor Green

Write-Host ""
Write-Host "🔧 Step 7: Running post-deployment commands..." -ForegroundColor Yellow

Write-Host "Running migrations..." -ForegroundColor Yellow
heroku run php artisan migrate --force

Write-Host "Creating storage symlink..." -ForegroundColor Yellow
heroku run php artisan storage:link

Write-Host "Seeding system settings..." -ForegroundColor Yellow
try {
    heroku run php artisan db:seed --class=SystemSettingsSeeder
} catch {
    Write-Host "Seeder might have already run" -ForegroundColor Yellow
}

Write-Host "Caching configuration..." -ForegroundColor Yellow
heroku run php artisan config:cache
heroku run php artisan route:cache

Write-Host "✅ Post-deployment commands completed" -ForegroundColor Green

Write-Host ""
Write-Host "⚡ Step 8: Scaling web dyno..." -ForegroundColor Yellow
heroku ps:scale web=1
Write-Host "✅ Web dyno scaled" -ForegroundColor Green

Write-Host ""
Write-Host "✅ Deployment Complete!" -ForegroundColor Green
Write-Host "====================" -ForegroundColor Green
Write-Host ""
Write-Host "Your app is live at:" -ForegroundColor Cyan
Write-Host $HerokuAppUrl -ForegroundColor Cyan
Write-Host ""
Write-Host "Useful commands:" -ForegroundColor Cyan
Write-Host "  heroku logs --tail          # View real-time logs"
Write-Host "  heroku open                 # Open app in browser"
Write-Host "  heroku ps                   # Check dyno status"
Write-Host "  heroku config               # View all config vars"
Write-Host "  heroku run php artisan ...  # Run artisan commands"
Write-Host ""
Write-Host "📖 See HEROKU_DEPLOY_GUIDE.md for more information" -ForegroundColor Cyan
Write-Host ""

# Open app in browser
$OpenBrowser = Read-Host "Open app in browser? (y/n)"
if ($OpenBrowser -eq "y" -or $OpenBrowser -eq "Y") {
    heroku open
}

Write-Host ""
Write-Host "🎉 Happy coding!" -ForegroundColor Green

