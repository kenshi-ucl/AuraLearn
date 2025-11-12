# Quick fix and redeploy script

Write-Host "Fixing APP_KEY and redeploying..." -ForegroundColor Cyan
Write-Host ""

# Fix APP_KEY (clean value without warnings)
Write-Host "Step 1: Fixing APP_KEY..." -ForegroundColor Yellow
heroku config:set APP_KEY="base64:pZExgdsMk8JYJKtBUzOZINoE56SszP651+xexkpaFJo="
Write-Host "[OK] APP_KEY fixed" -ForegroundColor Green

# Redeploy with fixed package.json
Write-Host ""
Write-Host "Step 2: Deploying fixed version..." -ForegroundColor Yellow
git push heroku main

Write-Host ""
Write-Host "Step 3: Running migrations..." -ForegroundColor Yellow
heroku run "php artisan migrate --force"

Write-Host ""
Write-Host "Step 4: Creating storage symlink..." -ForegroundColor Yellow
heroku run "php artisan storage:link"

Write-Host ""
Write-Host "Step 5: Seeding system settings..." -ForegroundColor Yellow
heroku run "php artisan db:seed --class=SystemSettingsSeeder"

Write-Host ""
Write-Host "Step 6: Caching configuration..." -ForegroundColor Yellow
heroku run "php artisan config:cache"
heroku run "php artisan route:cache"

Write-Host ""
Write-Host "Step 7: Checking status..." -ForegroundColor Yellow
heroku ps

Write-Host ""
Write-Host "[OK] Deployment fixed and complete!" -ForegroundColor Green
Write-Host ""
Write-Host "Open your app:" -ForegroundColor Cyan
heroku open

