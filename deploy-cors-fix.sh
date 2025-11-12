#!/bin/bash

# Deploy CORS fix to Heroku

echo "🚀 Deploying CORS fix to Heroku..."
echo ""

# Commit changes
git add config/cors.php config/session.php .env
git commit -m "Fix: Update CORS and session config for localhost development" || echo "No changes to commit"

# Push to Heroku
echo "📦 Pushing to Heroku..."
git push heroku main

echo ""
echo "✅ Deployment complete!"
echo ""
echo "🔄 Clearing config cache on Heroku..."
heroku run php artisan config:clear --app limitless-caverns-03788

echo ""
echo "🧪 Testing CORS..."
echo "Waiting for Heroku to restart..."
sleep 5

# Test CORS from localhost:3000
curl -I -X OPTIONS \
  -H "Origin: http://localhost:3000" \
  -H "Access-Control-Request-Method: GET" \
  -H "Access-Control-Request-Headers: Content-Type" \
  https://limitless-caverns-03788-f84f5932a44c.herokuapp.com/api/admin/me

echo ""
echo "✅ CORS fix deployed!"
echo ""
echo "🌐 Your backend should now accept requests from localhost:3000"

