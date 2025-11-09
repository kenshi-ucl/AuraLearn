# 🚀 Deploy to Heroku NOW - Start Here!

You have **3 options** to deploy your Laravel backend to Heroku:

---

## Option 1: 🤖 Automated Script (Recommended for Windows)

Run the PowerShell script that does everything automatically:

```powershell
cd backend-admin
.\deploy-to-heroku.ps1
```

The script will:
- ✅ Create Heroku app
- ✅ Add buildpacks
- ✅ Configure environment variables
- ✅ Deploy code
- ✅ Run migrations
- ✅ Scale dyno
- ✅ Open your app!

**Just answer the prompts and you're done!**

---

## Option 2: 🤖 Automated Script (For Linux/Mac)

Run the bash script:

```bash
cd backend-admin
chmod +x deploy-to-heroku.sh
./deploy-to-heroku.sh
```

---

## Option 3: 📝 Manual Step-by-Step

Follow the quick start guide:

```bash
# 1. Navigate to backend
cd backend-admin

# 2. Create app
heroku create auralearn-backend --stack heroku-24

# 3. Add buildpacks
heroku buildpacks:add heroku/nodejs
heroku buildpacks:add heroku/php

# 4. Generate and set APP_KEY
php artisan key:generate --show
# Copy the key, then:
heroku config:set APP_KEY="paste-your-key-here"

# 5. Set other config vars (see HEROKU_QUICK_START.md for full list)
heroku config:set APP_NAME="AuraLearn"
heroku config:set APP_ENV=production
heroku config:set APP_DEBUG=false
# ... (continue with other variables)

# 6. Deploy
git push heroku main

# 7. Run migrations
heroku run php artisan migrate --force
heroku run php artisan storage:link
heroku run php artisan db:seed --class=SystemSettingsSeeder

# 8. Scale dyno
heroku ps:scale web=1

# 9. Open app
heroku open
```

📖 **See `HEROKU_QUICK_START.md` for complete manual instructions**

---

## 📚 Documentation Available

- **`DEPLOY_NOW.md`** (this file) - Start here!
- **`HEROKU_QUICK_START.md`** - Simple step-by-step manual guide
- **`HEROKU_DEPLOY_GUIDE.md`** - Comprehensive guide with troubleshooting
- **`deploy-to-heroku.ps1`** - Automated PowerShell script (Windows)
- **`deploy-to-heroku.sh`** - Automated Bash script (Linux/Mac)

---

## ⚡ Quick Decision Tree

**Are you on Windows?**
- Yes → Use `.\deploy-to-heroku.ps1` (Option 1)
- No → Use `./deploy-to-heroku.sh` (Option 2)

**Want to learn and do it manually?**
- Yes → Follow `HEROKU_QUICK_START.md` (Option 3)

**Having issues?**
- Read `HEROKU_DEPLOY_GUIDE.md` - full troubleshooting guide

---

## 🎯 What You Need to Know Before Deploying

1. **You're already logged in** to Heroku ✅
2. **Database choice**:
   - Use Heroku Postgres ($5/month) - recommended for production
   - OR use your existing Supabase (free tier)
3. **Cost**: $5-10/month depending on database choice
4. **Time**: ~10-15 minutes for full deployment

---

## 🔥 Let's Deploy!

**Recommended: Just run the PowerShell script (since you're on Windows):**

```powershell
.\deploy-to-heroku.ps1
```

**That's it! The script handles everything else.**

---

## 💬 Need Help?

Common issues and solutions are in `HEROKU_DEPLOY_GUIDE.md`

Good luck! 🚀

