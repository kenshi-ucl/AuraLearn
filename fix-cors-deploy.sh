#!/bin/bash

# AuraLearn CORS Fix - Heroku Deployment Script
# This script updates the Heroku environment variables to allow Vercel deployment

echo "🚀 Updating Heroku environment variables for CORS..."

# Set the frontend URL
heroku config:set FRONTEND_URL="https://aura-learn-frontend-a3qf6vac3-kenshis-projects-ab9e1bf2.vercel.app" --app limitless-caverns-03788

# Set production environment
heroku config:set APP_ENV=production --app limitless-caverns-03788
heroku config:set APP_DEBUG=false --app limitless-caverns-03788
heroku config:set APP_URL="https://limitless-caverns-03788-f84f5932a44c.herokuapp.com" --app limitless-caverns-03788

# Update session configuration for cross-domain cookies
heroku config:set SESSION_SAME_SITE=none --app limitless-caverns-03788
heroku config:set SESSION_SECURE_COOKIE=true --app limitless-caverns-03788

echo "✅ Environment variables updated!"
echo ""
echo "📦 Deploying changes to Heroku..."

# Commit and push changes
git add config/cors.php
git commit -m "Fix: Update CORS configuration to allow Vercel deployments"
git push heroku main

echo "✅ Deployment complete!"
echo ""
echo "🧪 Testing CORS configuration..."
echo "Waiting for Heroku to restart..."
sleep 10

# Test the CORS headers
echo ""
echo "Testing CORS headers from your Vercel domain..."
curl -I -X OPTIONS \
  -H "Origin: https://aura-learn-frontend-a3qf6vac3-kenshis-projects-ab9e1bf2.vercel.app" \
  -H "Access-Control-Request-Method: POST" \
  -H "Access-Control-Request-Headers: Content-Type" \
  https://limitless-caverns-03788-f84f5932a44c.herokuapp.com/api/user/login

echo ""
echo "✅ CORS fix deployment complete!"
echo ""
echo "🌐 Your Vercel app should now be able to access the backend."
echo "🔄 Try logging in again at: https://aura-learn-frontend-a3qf6vac3-kenshis-projects-ab9e1bf2.vercel.app"

