# AdLinker - Quick Start Guide

## 🚀 Get Started in 5 Minutes

This guide will help you set up and run the AdLinker project quickly.

---

## Prerequisites

Make sure you have the following installed:
- ✅ PHP 8.1 or higher
- ✅ Composer
- ✅ Node.js & NPM
- ✅ MySQL/MariaDB
- ✅ XAMPP/WAMP (or any PHP server)

---

## Installation Steps

### 1. Navigate to Project Directory
```bash
cd e:\xampp\htdocs\Adlinker\Adlinker_main
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Configure Environment
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Database

Edit `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=adlinker
DB_USERNAME=root
DB_PASSWORD=
```

Create database:
```sql
CREATE DATABASE adlinker;
```

### 5. Run Migrations
```bash
php artisan migrate
```

### 6. Create Storage Link
```bash
php artisan storage:link
```

### 7. Build Frontend Assets
```bash
# For development
npm run dev

# For production
npm run build
```

### 8. Start Server
```bash
# Using Artisan
php artisan serve

# Or access via XAMPP
# http://localhost/Adlinker/Adlinker_main/public
```

---

## 🎯 First Steps After Installation

### Create Test Users

#### Option 1: Using Tinker
```bash
php artisan tinker
```

```php
// Create an advertiser
$advertiser = User::create([
    'name' => 'Test Advertiser',
    'email' => 'advertiser@test.com',
    'password' => Hash::make('password123'),
    'role' => 'advertiser'
]);
Advertiser::create(['user_id' => $advertiser->id]);
Wallet::create(['user_id' => $advertiser->id, 'balance' => 1000, 'pending_balance' => 0]);

// Create a publisher
$publisher = User::create([
    'name' => 'Test Publisher',
    'email' => 'publisher@test.com',
    'password' => Hash::make('password123'),
    'role' => 'publisher'
]);
Publisher::create(['user_id' => $publisher->id]);
Wallet::create(['user_id' => $publisher->id, 'balance' => 0, 'pending_balance' => 0]);
```

#### Option 2: Using Registration Page
1. Go to `/register`
2. Fill in the form
3. Select role (Advertiser or Publisher)
4. Submit

### Test Credentials
After creating test users:
- **Advertiser**: advertiser@test.com / password123
- **Publisher**: publisher@test.com / password123

---

## 📋 Common Tasks

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Run Migrations Fresh
```bash
php artisan migrate:fresh
```

### Seed Database (if seeders are available)
```bash
php artisan db:seed
```

### Watch for Frontend Changes
```bash
npm run dev
```

### Run Tests
```bash
php artisan test
```

---

## 🔧 Optional Configuration

### Razorpay Setup (for payments)

1. Get API keys from [Razorpay Dashboard](https://dashboard.razorpay.com)
2. Add to `.env`:
```env
RAZORPAY_KEY_ID=your_key_id
RAZORPAY_KEY_SECRET=your_key_secret
RAZORPAY_WEBHOOK_SECRET=your_webhook_secret
```

### Telegram Bot Setup (for notifications)

1. Create bot with [@BotFather](https://t.me/botfather)
2. Add to `.env`:
```env
TELEGRAM_BOT_TOKEN=your_bot_token
```

---

## 📁 Project Structure Overview

```
Adlinker_main/
├── app/                    # Application code
│   ├── Http/Controllers/   # Controllers
│   ├── Models/             # Eloquent models
│   ├── Services/           # Business logic
│   └── Events/             # Event classes
├── database/
│   └── migrations/         # Database migrations
├── resources/
│   ├── views/              # Blade templates
│   ├── js/                 # JavaScript files
│   └── sass/               # SASS files
├── routes/
│   ├── web.php             # Web routes
│   └── api.php             # API routes
└── public/                 # Public assets
```

---

## 🎨 User Roles

### Advertiser Features
- Create advertisement campaigns
- Browse and select Telegram channels
- Manage wallet and payments
- Track campaign status

### Publisher Features
- Register Telegram channels
- Accept/reject campaign requests
- Submit post links
- Withdraw earnings

---

## 🔑 Key URLs

After installation, access these URLs:

| URL | Description |
|-----|-------------|
| `/` | Landing page |
| `/register` | User registration |
| `/login` | User login |
| `/advertiser/dashboard` | Advertiser dashboard |
| `/publisher/dashboard` | Publisher dashboard |
| `/campaigns` | Campaign management |
| `/wallet` | Wallet management |
| `/channels/create` | Create channel (publisher) |

---

## 🐛 Troubleshooting

### Issue: "Class not found" error
**Solution:**
```bash
composer dump-autoload
```

### Issue: "Permission denied" on storage
**Solution:**
```bash
chmod -R 775 storage bootstrap/cache
```

### Issue: Assets not loading
**Solution:**
```bash
npm run build
php artisan storage:link
```

### Issue: Database connection error
**Solution:**
- Check MySQL is running
- Verify `.env` database credentials
- Ensure database exists

### Issue: "419 Page Expired" on form submission
**Solution:**
- Clear browser cache
- Check `@csrf` token in forms
- Run: `php artisan config:clear`

---

## 📊 Sample Workflow

### As Advertiser:

1. **Login** → `/login`
2. **Add Funds** → `/wallet` → Add Funds
3. **Create Campaign** → `/campaigns/create`
4. **Select Channel** → Choose from list
5. **Upload Ad** → Image + Content
6. **Pay** → From wallet
7. **Track** → View in dashboard

### As Publisher:

1. **Login** → `/login`
2. **Add Channel** → `/channels/create`
3. **Wait for Campaign** → Check dashboard
4. **Accept Campaign** → Review and accept
5. **Post Ad** → On Telegram channel
6. **Submit Link** → Provide post URL
7. **Withdraw** → Request payout

---

## 🔍 Development Tips

### Enable Debug Mode
```env
APP_DEBUG=true
APP_ENV=local
```

### Watch Logs
```bash
tail -f storage/logs/laravel.log
```

### Database GUI Tools
- **phpMyAdmin**: http://localhost/phpmyadmin
- **TablePlus**: https://tableplus.com/
- **MySQL Workbench**: https://www.mysql.com/products/workbench/

### Code Editor Extensions
- **VS Code**: Laravel Extension Pack
- **PHPStorm**: Laravel Plugin

---

## 📚 Learning Resources

### Laravel Documentation
- [Official Docs](https://laravel.com/docs)
- [Laracasts](https://laracasts.com)
- [Laravel News](https://laravel-news.com)

### Project-Specific Docs
- `README.md` - Project overview and features
- `TECHNICAL_DOCUMENTATION.md` - In-depth technical guide
- `QUICK_START.md` - This file

---

## 🎯 Next Steps

After setup, explore:

1. **Database Schema** - Check migrations to understand data structure
2. **Routes** - Review `routes/web.php` for available endpoints
3. **Controllers** - Study `app/Http/Controllers/` for business logic
4. **Models** - Examine `app/Models/` for relationships
5. **Views** - Browse `resources/views/` for UI templates

---

## 💡 Pro Tips

### Quick Commands
```bash
# Restart development server
php artisan serve --port=8000

# Watch for file changes
npm run dev

# Clear everything
php artisan optimize:clear

# Create new controller
php artisan make:controller MyController

# Create new model with migration
php artisan make:model MyModel -m
```

### Useful Artisan Commands
```bash
# List all routes
php artisan route:list

# List all commands
php artisan list

# Interactive shell
php artisan tinker

# Run specific migration
php artisan migrate --path=/database/migrations/2024_01_01_create_table.php
```

---

## 🆘 Getting Help

If you encounter issues:

1. Check `storage/logs/laravel.log` for errors
2. Review `.env` configuration
3. Ensure all dependencies are installed
4. Clear cache and config
5. Check database connection

---

## ✅ Verification Checklist

After installation, verify:

- [ ] Can access homepage
- [ ] Can register new user
- [ ] Can login successfully
- [ ] Database tables created
- [ ] Storage link working
- [ ] Assets loading correctly
- [ ] No errors in console
- [ ] Can create campaign (advertiser)
- [ ] Can create channel (publisher)
- [ ] Wallet system working

---

**You're all set! Happy coding! 🚀**

For detailed information, refer to:
- `README.md` - Complete project documentation
- `TECHNICAL_DOCUMENTATION.md` - Technical deep dive
