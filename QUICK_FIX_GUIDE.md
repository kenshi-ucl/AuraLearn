# 🚀 Quick Fix Guide - Set Heroku Environment Variables

## ✅ Good News!

The CORS configuration has been **successfully deployed** to Heroku! 

The code changes are live, but you need to complete **ONE FINAL STEP** to make login work.

---

## 🎯 What You Need to Do (5 Minutes)

### Step 1: Open Heroku Dashboard

Click this link: https://dashboard.heroku.com/apps/limitless-caverns-03788/settings

### Step 2: Reveal Config Vars

1. Scroll down to the section called **"Config Vars"**
2. Click the button **"Reveal Config Vars"**

### Step 3: Add These 6 Variables

Click **"Add"** and enter each of these **exactly as shown**:

| **Key** | **Value** |
|---------|-----------|
| `FRONTEND_URL` | `https://aura-learn-frontend-a3qf6vac3-kenshis-projects-ab9e1bf2.vercel.app` |
| `SESSION_SAME_SITE` | `none` |
| `SESSION_SECURE_COOKIE` | `true` |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_URL` | `https://limitless-caverns-03788-f84f5932a44c.herokuapp.com` |

**Important:** 
- Type each key name **exactly** (case-sensitive)
- Copy and paste the values to avoid typos
- Don't add quotes around the values

### Step 4: Wait for Restart

After you add the last variable, Heroku will automatically restart your app (takes ~30 seconds).

### Step 5: Test Login

1. Go to: https://aura-learn-frontend-a3qf6vac3-kenshis-projects-ab9e1bf2.vercel.app
2. Try to sign in
3. It should work! ✅

---

## 🔍 How to Verify It Worked

Open your browser's Developer Console (press F12):
- **Before fix:** You see `CORS policy` errors in red
- **After fix:** No CORS errors, login works smoothly

---

## ❓ What If It Still Doesn't Work?

1. **Double-check spelling** - Make sure all config var keys are typed exactly
2. **Clear browser cache** - Press Ctrl+Shift+Delete, clear cached images
3. **Wait 1 minute** - Sometimes Heroku takes a bit to fully restart
4. **Check Heroku logs:**
   - Go to: https://dashboard.heroku.com/apps/limitless-caverns-03788
   - Click "More" → "View logs"
   - Look for any error messages

---

## 📝 Summary

**What was fixed:**
- ✅ CORS configuration updated (deployed)
- ✅ Wildcard patterns for Vercel URLs (deployed)
- ✅ Session cookie settings (needs env vars)
- ✅ Production environment config (needs env vars)

**What you need to do:**
- ⏳ Set 6 environment variables in Heroku dashboard (5 minutes)

**After that:**
- ✅ Login will work perfectly
- ✅ All API calls will work
- ✅ Your app is production-ready

---

## 🎉 That's It!

Once you set those environment variables, your Vercel app will be able to communicate with your Heroku backend perfectly. No more CORS errors!

**Have questions?** Check the full documentation in `CORS_FIX_COMPLETE.md`

