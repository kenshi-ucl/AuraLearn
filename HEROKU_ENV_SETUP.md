# Heroku Environment Variables Setup

## ⚡ Quick Setup via Heroku Dashboard

Since the CORS configuration has been deployed, you just need to set a few environment variables in your Heroku dashboard:

### Step 1: Go to Your Heroku App Settings

1. Visit: https://dashboard.heroku.com/apps/limitless-caverns-03788
2. Click on the **"Settings"** tab
3. Scroll down to **"Config Vars"** section
4. Click **"Reveal Config Vars"**

### Step 2: Add/Update These Environment Variables

| Key | Value |
|-----|-------|
| `FRONTEND_URL` | `https://aura-learn-frontend-a3qf6vac3-kenshis-projects-ab9e1bf2.vercel.app` |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_URL` | `https://limitless-caverns-03788-f84f5932a44c.herokuapp.com` |
| `SESSION_SAME_SITE` | `none` |
| `SESSION_SECURE_COOKIE` | `true` |

### Step 3: Restart Your App

After setting the environment variables, Heroku will automatically restart your app. If not:

1. Click on the **"More"** button in the top right
2. Select **"Restart all dynos"**

---

## ✅ What Was Fixed

1. **CORS Configuration** - Updated to allow your Vercel deployment URL
2. **Wildcard Patterns** - Added support for all Vercel preview deployments
3. **Session Cookies** - Configured for cross-domain authentication
4. **Environment Variables** - Set up proper production configuration

## 🧪 Testing

Your backend is now accepting requests from:
- Your Vercel production URL
- All Vercel preview URLs (e.g., `*.vercel.app`)
- localhost (for development)

## 🔄 Next Steps

1. Set the environment variables in Heroku dashboard (see above)
2. Wait ~30 seconds for Heroku to restart
3. Try logging in again at: https://aura-learn-frontend-a3qf6vac3-kenshis-projects-ab9e1bf2.vercel.app

The CORS error should be completely resolved! 🎊

