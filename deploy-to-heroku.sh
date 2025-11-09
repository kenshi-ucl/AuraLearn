#!/bin/bash

# AuraLearn Backend - Heroku Deployment Script
# This script automates the Heroku deployment process

set -e  # Exit on error

echo "🚀 AuraLearn Backend - Heroku Deployment"
echo "========================================"
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Check if Heroku CLI is installed
if ! command -v heroku &> /dev/null; then
    echo -e "${RED}❌ Heroku CLI is not installed. Please install it first.${NC}"
    echo "Visit: https://devcenter.heroku.com/articles/heroku-cli"
    exit 1
fi

# Check if logged in to Heroku
if ! heroku whoami &> /dev/null; then
    echo -e "${RED}❌ Not logged in to Heroku. Running 'heroku login'...${NC}"
    heroku login
fi

echo -e "${GREEN}✅ Heroku CLI is installed and logged in${NC}"
echo ""

# Ask for app name
read -p "Enter your Heroku app name (or press Enter for auto-generated): " APP_NAME

echo ""
echo "📦 Step 1: Creating Heroku App..."
if [ -z "$APP_NAME" ]; then
    heroku create --stack heroku-24
else
    heroku create "$APP_NAME" --stack heroku-24 || echo "App might already exist, continuing..."
fi

echo ""
echo "🔨 Step 2: Adding Buildpacks..."
heroku buildpacks:clear || true
heroku buildpacks:add heroku/nodejs
heroku buildpacks:add heroku/php
echo -e "${GREEN}✅ Buildpacks added${NC}"

echo ""
echo "💾 Step 3: Database Setup"
echo "Choose your database option:"
echo "1) Add Heroku PostgreSQL ($5/month)"
echo "2) Use existing Supabase (Free)"
read -p "Enter choice (1 or 2): " DB_CHOICE

if [ "$DB_CHOICE" = "1" ]; then
    echo "Adding Heroku PostgreSQL..."
    heroku addons:create heroku-postgresql:essential-0
    echo -e "${GREEN}✅ Heroku PostgreSQL added${NC}"
    USE_SUPABASE=false
else
    echo "Will configure Supabase credentials..."
    USE_SUPABASE=true
fi

echo ""
echo "🔑 Step 4: Generating APP_KEY..."
APP_KEY=$(php artisan key:generate --show)
echo -e "${GREEN}✅ APP_KEY generated: $APP_KEY${NC}"

echo ""
echo "⚙️ Step 5: Setting Environment Variables..."

# Get Heroku app URL
HEROKU_APP_URL=$(heroku info -j | grep "web_url" | cut -d'"' -f4)

# Basic Laravel configuration
heroku config:set APP_NAME="AuraLearn"
heroku config:set APP_ENV=production
heroku config:set APP_DEBUG=false
heroku config:set APP_KEY="$APP_KEY"
heroku config:set APP_URL="$HEROKU_APP_URL"

# Database configuration (if using Supabase)
if [ "$USE_SUPABASE" = true ]; then
    heroku config:set DB_CONNECTION=pgsql
    heroku config:set DB_HOST=aws-1-ap-southeast-1.pooler.supabase.com
    heroku config:set DB_PORT=5432
    heroku config:set DB_DATABASE=postgres
    heroku config:set DB_USERNAME=postgres.bwgaiphnpdtfgyjwohmb
    heroku config:set DB_PASSWORD="AuraLearn1234."
    
    heroku config:set SUPABASE_URL=https://bwgaiphnpdtfgyjwohmb.supabase.co
    heroku config:set SUPABASE_ANON_KEY="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImJ3Z2FpcGhucGR0Zmd5andvaG1iIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NjI1MjQ1NzcsImV4cCI6MjA3ODEwMDU3N30.16dF7WO52eHexIvMsUy6h3XnCyKA1j2BiE3JRHjbClY"
fi

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

echo -e "${GREEN}✅ Environment variables configured${NC}"

echo ""
echo "📤 Step 6: Committing changes and deploying..."

# Check if there are uncommitted changes
if ! git diff-index --quiet HEAD --; then
    echo "Committing deployment files..."
    git add Procfile package.json .htaccess-heroku HEROKU_DEPLOY_GUIDE.md deploy-to-heroku.sh
    git commit -m "Configure for Heroku deployment" || echo "Nothing to commit"
fi

echo "Pushing to Heroku..."
git push heroku main || git push heroku master:main

echo -e "${GREEN}✅ Code deployed to Heroku${NC}"

echo ""
echo "🔧 Step 7: Running post-deployment commands..."

echo "Running migrations..."
heroku run php artisan migrate --force

echo "Creating storage symlink..."
heroku run php artisan storage:link

echo "Seeding system settings..."
heroku run php artisan db:seed --class=SystemSettingsSeeder || echo "Seeder might have already run"

echo "Caching configuration..."
heroku run php artisan config:cache
heroku run php artisan route:cache

echo -e "${GREEN}✅ Post-deployment commands completed${NC}"

echo ""
echo "⚡ Step 8: Scaling web dyno..."
heroku ps:scale web=1
echo -e "${GREEN}✅ Web dyno scaled${NC}"

echo ""
echo "✅ Deployment Complete!"
echo "===================="
echo ""
echo -e "${BLUE}Your app is live at:${NC}"
echo "$HEROKU_APP_URL"
echo ""
echo -e "${BLUE}Useful commands:${NC}"
echo "  heroku logs --tail          # View real-time logs"
echo "  heroku open                 # Open app in browser"
echo "  heroku ps                   # Check dyno status"
echo "  heroku config               # View all config vars"
echo "  heroku run php artisan ...  # Run artisan commands"
echo ""
echo "📖 See HEROKU_DEPLOY_GUIDE.md for more information"
echo ""

# Open app in browser
read -p "Open app in browser? (y/n): " OPEN_BROWSER
if [ "$OPEN_BROWSER" = "y" ] || [ "$OPEN_BROWSER" = "Y" ]; then
    heroku open
fi

echo ""
echo -e "${GREEN}🎉 Happy coding!${NC}"

