@echo off
echo ===================================
echo Fixing AuraBot and AI Validation on Heroku
echo ===================================
echo.

echo Step 1: Setting environment variables...
echo - Configuring Nebius API timeouts...
heroku config:set NEBIUS_TIMEOUT_SECONDS=30 --app limitless-caverns-03788
heroku config:set NEBIUS_CONNECT_TIMEOUT=10 --app limitless-caverns-03788
heroku config:set NEBIUS_READ_TIMEOUT=30 --app limitless-caverns-03788
heroku config:set NEBIUS_ALLOW_MOCK=false --app limitless-caverns-03788
heroku config:set NEBIUS_MAX_RETRIES=1 --app limitless-caverns-03788
echo.
echo - Configuring AuraBot settings...
heroku config:set AURABOT_MAX_TOKENS=1500 --app limitless-caverns-03788
echo.
echo - Configuring AI Validation settings...
heroku config:set AI_VALIDATION_ENABLED=true --app limitless-caverns-03788
heroku config:set AI_VALIDATION_TIMEOUT_SECONDS=25 --app limitless-caverns-03788
heroku config:set AI_VALIDATION_MAX_TOKENS=1200 --app limitless-caverns-03788
echo.

echo Step 2: Committing changes...
git add .
git commit -m "Remove AI validation fallbacks and fix timeout issues"
echo.

echo Step 3: Pushing to Heroku...
git push heroku main
echo.

echo Step 4: Checking deployment status...
heroku ps --app limitless-caverns-03788
echo.

echo ===================================
echo Deployment complete!
echo ===================================
echo.
echo Test URLs:
echo.
echo AuraBot:
echo - Health Check: https://limitless-caverns-03788-f84f5932a44c.herokuapp.com/api/aurabot/health
echo - Test API: https://limitless-caverns-03788-f84f5932a44c.herokuapp.com/api/aurabot/test-api
echo.
echo AI Validation:
echo - Test Validation: https://limitless-caverns-03788-f84f5932a44c.herokuapp.com/api/activities/test-validation
echo.
echo Or open test-api-suite.html in your browser for interactive testing!
echo.
pause
