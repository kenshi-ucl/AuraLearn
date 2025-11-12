# Deploy CORS fix to Heroku (Windows PowerShell)

Write-Host "🚀 Deploying CORS fix to Heroku..." -ForegroundColor Green
Write-Host ""

# Commit changes
Write-Host "📝 Committing changes..." -ForegroundColor Yellow
git add config/cors.php config/session.php .env
git commit -m "Fix: Update CORS and session config for localhost development" 2>&1 | Out-Null
if ($LASTEXITCODE -ne 0) {
    Write-Host "  (No changes to commit)" -ForegroundColor Gray
}

# Push to Heroku
Write-Host "📦 Pushing to Heroku..." -ForegroundColor Yellow
git push heroku main

if ($LASTEXITCODE -eq 0) {
    Write-Host ""
    Write-Host "✅ Deployment complete!" -ForegroundColor Green
    Write-Host ""
    Write-Host "🔄 Clearing config cache on Heroku..." -ForegroundColor Yellow
    heroku run php artisan config:clear --app limitless-caverns-03788
    
    Write-Host ""
    Write-Host "✅ CORS fix deployed!" -ForegroundColor Green
    Write-Host ""
    Write-Host "🌐 Your backend should now accept requests from localhost:3000" -ForegroundColor Cyan
    Write-Host ""
    Write-Host "🧪 Test by trying to login from your localhost:3000 frontend" -ForegroundColor Yellow
} else {
    Write-Host ""
    Write-Host "❌ Deployment failed. Please check the error above." -ForegroundColor Red
}

