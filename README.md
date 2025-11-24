# AdLinker - Telegram Advertisement Management Platform

## 📋 Table of Contents
- [Overview](#overview)
- [Features](#features)
- [Technology Stack](#technology-stack)
- [Project Structure](#project-structure)
- [Database Schema](#database-schema)
- [Installation](#installation)
- [Configuration](#configuration)
- [User Roles & Workflows](#user-roles--workflows)
- [Key Components](#key-components)
- [API Endpoints](#api-endpoints)
- [Payment Integration](#payment-integration)
- [Telegram Integration](#telegram-integration)
- [Development](#development)
- [License](#license)

---

## 🎯 Overview

**AdLinker** is a comprehensive web-based platform that connects **Advertisers** with **Publishers** (Telegram channel owners) to facilitate advertisement campaigns on Telegram channels. The platform manages the entire lifecycle of advertising campaigns, from creation and payment to execution and completion.

### Core Concept
- **Advertisers** create campaigns and pay to advertise on Telegram channels
- **Publishers** (channel owners) accept campaigns and post advertisements on their channels
- Platform manages payments, wallets, and campaign lifecycle
- Integrated with Razorpay for payments and Telegram for notifications

---

## ✨ Features

### For Advertisers
- 🎯 Browse and filter available Telegram channels by subscriber count
- 📊 Create advertisement campaigns with custom content and images
- 💳 Wallet-based payment system with Razorpay integration
- 📈 Track campaign status (active, pending, completed, expired)
- 🔄 Campaign refund system for expired campaigns
- 📱 Real-time Telegram notifications

### For Publishers
- 📺 Register and manage Telegram channels
- 💰 Set custom pricing for different campaign durations (1, 2, 3, 7 days)
- ✅ Accept or reject campaign requests
- 🔗 Submit post links after publishing advertisements
- 💸 Withdraw earnings via UPI or Bank Transfer
- 📊 Dashboard with earnings and campaign statistics

### Platform Features
- 🔐 Role-based access control (Advertiser/Publisher)
- 💼 Digital wallet system for all users
- 📝 Transaction history and audit logs
- 🔔 Telegram bot integration for notifications
- 📧 Email notifications for password resets
- 💬 Built-in chat/messaging system
- 📄 Policy pages (Terms, Privacy, Refund, Cancellation)

---

## 🛠 Technology Stack

### Backend
- **Framework**: Laravel 10.x (PHP 8.1+)
- **Database**: MySQL
- **Authentication**: Laravel Sanctum
- **Queue System**: Laravel Queue
- **Events & Listeners**: Laravel Event System

### Frontend
- **Template Engine**: Blade Templates
- **CSS Framework**: Bootstrap 5.2.3 + Custom SASS
- **JavaScript**: Vanilla JS + Axios
- **Build Tool**: Vite 5.0

### Third-Party Integrations
- **Payment Gateway**: Razorpay
- **Notifications**: Telegram Bot API
- **Wallet System**: Custom implementation with transaction management

### Development Tools
- **Package Manager**: Composer (PHP), NPM (JavaScript)
- **Testing**: PHPUnit
- **Code Quality**: Laravel Pint

---

## 📁 Project Structure

```
Adlinker_main/
├── app/
│   ├── Console/              # Artisan commands
│   ├── Events/               # Event classes
│   │   ├── CampaignCompleted.php
│   │   ├── CampaignLinkSubmitted.php
│   │   └── NewCampaignAssigned.php
│   ├── Exceptions/           # Exception handlers
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Advertiser/   # Advertiser-specific controllers
│   │   │   │   ├── DashboardController.php
│   │   │   │   └── CampaignController.php
│   │   │   ├── Publisher/    # Publisher-specific controllers
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── CampaignActionController.php
│   │   │   │   ├── CampaignStatusController.php
│   │   │   │   └── WithdrawalController.php
│   │   │   ├── Api/          # API controllers
│   │   │   ├── Auth/         # Authentication controllers
│   │   │   ├── CampaignController.php
│   │   │   ├── ChannelController.php
│   │   │   ├── ChatController.php
│   │   │   ├── PaymentController.php
│   │   │   ├── RazorpayController.php
│   │   │   ├── TelegramController.php
│   │   │   ├── TelegramNotificationController.php
│   │   │   └── WalletController.php
│   │   ├── Middleware/       # Custom middleware
│   │   │   ├── Role.php      # Role-based access control
│   │   │   ├── PublisherAccess.php
│   │   │   └── LogUserActions.php
│   │   └── Kernel.php
│   ├── Listeners/            # Event listeners
│   │   ├── SendCampaignCompletionNotifications.php
│   │   ├── SendCampaignNotification.php
│   │   └── SendCampaignSubmissionNotification.php
│   ├── Models/               # Eloquent models
│   │   ├── User.php
│   │   ├── Campaign.php
│   │   ├── Channel.php
│   │   ├── Ad.php
│   │   ├── Advertiser.php
│   │   ├── Publisher.php
│   │   ├── Wallet.php
│   │   ├── WalletTransaction.php
│   │   ├── Withdrawal.php
│   │   ├── Message.php
│   │   ├── ChatMessage.php
│   │   └── TelegramNotification.php
│   ├── Notifications/        # Notification classes
│   │   ├── ResetPasswordNotification.php
│   │   └── TelegramNotification.php
│   ├── Providers/            # Service providers
│   └── Services/             # Business logic services
│       ├── LoggingService.php
│       └── TelegramNotificationService.php
├── bootstrap/                # Application bootstrap
├── config/                   # Configuration files
│   ├── app.php
│   ├── database.php
│   ├── razorpay.php          # Razorpay configuration
│   └── ...
├── database/
│   ├── factories/            # Model factories
│   ├── migrations/           # Database migrations
│   └── seeders/              # Database seeders
├── public/                   # Public assets
│   ├── images/
│   ├── js/
│   ├── game/                 # Gaming calculator (separate feature)
│   └── index.php             # Entry point
├── resources/
│   ├── css/
│   ├── js/
│   │   └── app.js
│   ├── sass/
│   │   └── app.scss
│   └── views/                # Blade templates
│       ├── advertiser/       # Advertiser views
│       ├── publisher/        # Publisher views
│       ├── campaigns/        # Campaign views
│       ├── channels/         # Channel views
│       ├── wallet/           # Wallet views
│       ├── auth/             # Authentication views
│       ├── layouts/          # Layout templates
│       └── welcome.blade.php # Landing page
├── routes/
│   ├── web.php               # Web routes
│   ├── api.php               # API routes
│   ├── auth.php              # Authentication routes
│   ├── wallet.php            # Wallet routes
│   ├── telegram.php          # Telegram webhook routes
│   └── channels.php          # Broadcasting channels
├── storage/                  # Storage for logs, cache, uploads
├── tests/                    # Test files
├── vendor/                   # Composer dependencies
├── .env.example              # Environment variables template
├── composer.json             # PHP dependencies
├── package.json              # NPM dependencies
├── vite.config.js            # Vite configuration
└── artisan                   # Artisan CLI
```

---

## 🗄 Database Schema

### Core Tables

#### `users`
Stores all user accounts (both advertisers and publishers)
- `id` - Primary key
- `name` - User's full name
- `email` - Email address (unique)
- `telegram_username` - Telegram username for notifications
- `password` - Hashed password
- `role` - User role (advertiser/publisher)
- `email_verified_at` - Email verification timestamp
- `remember_token` - Remember me token
- `created_at`, `updated_at`

#### `campaigns`
Advertisement campaigns created by advertisers
- `id` - Primary key
- `advertiser_id` - Foreign key to users table
- `publisher_id` - Foreign key to users table
- `channel_id` - Foreign key to channels table
- `channel_name` - Channel name (denormalized)
- `subscribers` - Subscriber count at time of creation
- `channel_link` - Telegram channel link
- `duration` - Campaign duration in days (1, 2, 3, 7)
- `price` - Campaign price
- `advertisement_image` - Path to advertisement image
- `advertisement_content` - Advertisement text content
- `status` - Campaign status (active, pending, completed, expired, rejected)
- `post_link` - Link to the posted advertisement (submitted by publisher)
- `notes` - Additional notes
- `submission_timestamp` - When post link was submitted
- `post_submitted_at` - Timestamp of post submission
- `created_at`, `updated_at`

#### `channels`
Telegram channels registered by publishers
- `id` - Primary key
- `publisher_id` - Foreign key to publishers table
- `name` - Channel name
- `link` - Telegram channel link
- `description` - Channel description
- `logo_path` - Path to channel logo
- `subscribers_count` - Number of subscribers
- `price_1_day` - Price for 1-day campaign
- `price_2_days` - Price for 2-day campaign
- `price_3_days` - Price for 3-day campaign
- `price_7_days` - Price for 7-day campaign
- `status` - Channel status (active, inactive, moderation)
- `created_at`, `updated_at`

#### `wallets`
Digital wallet for each user
- `id` - Primary key
- `user_id` - Foreign key to users table (unique)
- `balance` - Available balance
- `pending_balance` - Balance pending withdrawal
- `created_at`, `updated_at`

#### `wallet_transactions`
Transaction history for wallets
- `id` - Primary key
- `wallet_id` - Foreign key to wallets table
- `type` - Transaction type (deposit, withdrawal, payment)
- `amount` - Transaction amount (positive for credit, negative for debit)
- `status` - Transaction status (completed, pending, failed)
- `description` - Transaction description
- `full_name` - User's full name (for deposits)
- `mobile_number` - User's mobile number (for deposits)
- `created_at`, `updated_at`

#### `withdrawals`
Withdrawal requests by publishers
- `id` - Primary key
- `user_id` - Foreign key to users table
- `amount` - Withdrawal amount
- `status` - Status (pending, payment done, rejected)
- `payment_method` - Payment method (upi, bank_transfer)
- `upi_id` - UPI ID (if payment_method is upi)
- `first_name` - First name (for UPI)
- `account_holder_name` - Account holder name (for bank transfer)
- `account_number` - Bank account number
- `ifsc_code` - IFSC code
- `bank_name` - Bank name
- `mobile_number` - Mobile number
- `created_at`, `updated_at`

#### `publishers`
Publisher-specific information
- `id` - Primary key
- `user_id` - Foreign key to users table (unique)
- `created_at`, `updated_at`

#### `advertisers`
Advertiser-specific information
- `id` - Primary key
- `user_id` - Foreign key to users table (unique)
- `created_at`, `updated_at`

#### `ads`
Individual advertisements (legacy/alternative structure)
- `id` - Primary key
- `user_id` - Foreign key to users table
- `campaign_id` - Foreign key to campaigns table
- `channel_id` - Foreign key to channels table
- `content` - Ad content
- `image_path` - Path to ad image
- `status` - Ad status
- `created_at`, `updated_at`

#### `messages`
Chat/messaging system
- `id` - Primary key
- `sender_id` - Foreign key to users table
- `receiver_id` - Foreign key to users table
- `message` - Message content
- `is_read` - Read status
- `created_at`, `updated_at`

#### `telegram_notifications`
Telegram notification settings
- `id` - Primary key
- `user_id` - Foreign key to users table
- `chat_id` - Telegram chat ID
- `is_active` - Whether notifications are active
- `created_at`, `updated_at`

---

## 🚀 Installation

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js & NPM
- MySQL 5.7+ or MariaDB
- XAMPP/WAMP/LAMP (or any PHP development environment)

### Step-by-Step Installation

1. **Clone the Repository**
   ```bash
   cd e:\xampp\htdocs
   git clone <repository-url> Adlinker
   cd Adlinker/Adlinker_main
   ```

2. **Install PHP Dependencies**
   ```bash
   composer install
   ```

3. **Install Node Dependencies**
   ```bash
   npm install
   ```

4. **Environment Configuration**
   ```bash
   cp .env.example .env
   ```
   
   Edit `.env` file with your configuration:
   ```env
   APP_NAME=AdLinker
   APP_URL=http://localhost/Adlinker/Adlinker_main/public
   
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=adlinker
   DB_USERNAME=root
   DB_PASSWORD=
   
   RAZORPAY_KEY_ID=your_razorpay_key_id
   RAZORPAY_KEY_SECRET=your_razorpay_key_secret
   RAZORPAY_WEBHOOK_SECRET=your_webhook_secret
   
   TELEGRAM_BOT_TOKEN=your_telegram_bot_token
   ```

5. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

6. **Run Database Migrations**
   ```bash
   php artisan migrate
   ```

7. **Create Storage Symlink**
   ```bash
   php artisan storage:link
   ```

8. **Build Frontend Assets**
   ```bash
   npm run build
   # For development with hot reload:
   npm run dev
   ```

9. **Start Development Server**
   ```bash
   php artisan serve
   ```
   
   Or access via XAMPP: `http://localhost/Adlinker/Adlinker_main/public`

---

## ⚙️ Configuration

### Razorpay Setup
1. Create a Razorpay account at [razorpay.com](https://razorpay.com)
2. Get your API Key ID and Secret from Dashboard
3. Add them to `.env` file
4. Configure webhook URL in Razorpay dashboard: `{APP_URL}/api/razorpay/webhook`

### Telegram Bot Setup
1. Create a bot using [@BotFather](https://t.me/botfather) on Telegram
2. Get the bot token
3. Add token to `.env` as `TELEGRAM_BOT_TOKEN`
4. Set webhook URL: `{APP_URL}/api/telegram/webhook`

### File Upload Configuration
- Maximum image size: 2MB
- Allowed formats: JPG, JPEG
- Storage location: `storage/app/public/advertisements`

---

## 👥 User Roles & Workflows

### Advertiser Workflow

1. **Registration & Login**
   - Register as advertiser
   - Verify email (optional)
   - Login to dashboard

2. **Add Funds to Wallet**
   - Navigate to Wallet
   - Add funds via Razorpay
   - Funds credited instantly

3. **Create Campaign**
   - Browse available channels
   - Filter by subscriber count
   - Select channel and duration
   - Upload advertisement image (JPG only)
   - Write advertisement content
   - Review pricing

4. **Payment & Activation**
   - Campaign created with "expired" status
   - Redirected to payment page
   - Pay from wallet balance
   - Campaign status changes to "active"
   - Publisher receives notification

5. **Track Campaign**
   - Monitor campaign status
   - View post link once submitted
   - Receive notifications on completion
   - Request refund if expired

### Publisher Workflow

1. **Registration & Login**
   - Register as publisher
   - Login to dashboard

2. **Add Channel**
   - Register Telegram channel
   - Set channel details (name, link, logo, description)
   - Set subscriber count
   - Define pricing for different durations
   - Submit for moderation

3. **Manage Campaigns**
   - Receive notification for new campaigns
   - Review campaign details
   - Accept or reject campaigns
   - Post advertisement on channel
   - Submit post link

4. **Earnings & Withdrawal**
   - View earnings in wallet
   - Request withdrawal (minimum amount may apply)
   - Choose payment method (UPI/Bank Transfer)
   - Provide payment details
   - Receive payment within 2 business days

---

## 🔑 Key Components

### Controllers

#### `CampaignController`
Manages campaign lifecycle for advertisers
- `index()` - List all campaigns
- `create()` - Show channel selection with filters
- `store()` - Create new campaign
- `show()` - View campaign details
- `processPayment()` - Handle campaign payment
- `update()` - Update campaign details
- `destroy()` - Delete campaign
- `showChannelDetails()` - Display channel information

#### `WalletController`
Handles wallet operations
- `index()` - Display wallet dashboard
- `deposit()` - Add funds to wallet
- `showAddFundsForm()` - Display add funds form
- `addFunds()` - Process fund addition
- `showWithdrawForm()` - Display withdrawal form
- `processWithdrawal()` - Handle withdrawal requests

#### `ChannelController`
Manages Telegram channels
- `create()` - Show channel creation form
- `store()` - Save new channel
- `show()` - Display channel details
- `edit()` - Show edit form
- `update()` - Update channel information
- `destroy()` - Delete channel

#### `Publisher\CampaignActionController`
Publisher campaign actions
- `accept()` - Accept campaign request
- `reject()` - Reject campaign request
- `showSubmitLinkForm()` - Show link submission form
- `submitLink()` - Submit post link

#### `RazorpayController`
Payment processing
- `createOrder()` - Create Razorpay order
- `verifyPayment()` - Verify payment signature
- Webhook handling for payment events

### Models

#### `User`
Main user model with relationships:
- `hasOne(Publisher)` - Publisher profile
- `hasOne(Advertiser)` - Advertiser profile
- `hasOne(Wallet)` - User wallet
- `hasMany(Campaign)` - Created campaigns
- `hasOne(TelegramNotification)` - Telegram settings

#### `Campaign`
Campaign model with:
- `belongsTo(User, 'advertiser_id')` - Campaign creator
- `belongsTo(Channel)` - Target channel
- `hasMany(Ad)` - Associated ads

#### `Wallet`
Wallet model with transaction management:
- `deposit($amount, $description)` - Add funds
- `withdraw($amount, $paymentMethod, $description)` - Withdraw funds
- `createTransaction($attributes)` - Create transaction record

### Events & Listeners

#### Events
- `NewCampaignAssigned` - Fired when campaign is activated
- `CampaignLinkSubmitted` - Fired when publisher submits post link
- `CampaignCompleted` - Fired when campaign is marked complete

#### Listeners
- `SendCampaignNotification` - Sends Telegram notification to publisher
- `SendCampaignSubmissionNotification` - Notifies advertiser of submission
- `SendCampaignCompletionNotifications` - Notifies both parties on completion

### Middleware

#### `Role`
Role-based access control
```php
Route::middleware(['auth', 'role:advertiser'])->group(function () {
    // Advertiser-only routes
});

Route::middleware(['auth', 'role:publisher'])->group(function () {
    // Publisher-only routes
});
```

#### `PublisherAccess`
Ensures publishers can only access their own resources

#### `LogUserActions`
Logs user activities for audit trail

---

## 🌐 API Endpoints

### Authentication
- `POST /register` - User registration
- `POST /login` - User login
- `POST /logout` - User logout
- `POST /password/email` - Send password reset email
- `POST /password/reset` - Reset password

### Campaigns (Web)
- `GET /{user}/campaigns` - List campaigns
- `GET /{user}/campaigns/create` - Create campaign form
- `POST /{user}/campaigns` - Store campaign
- `GET /{user}/campaigns/{campaign}` - View campaign
- `PUT /{user}/campaigns/{campaign}` - Update campaign
- `DELETE /{user}/campaigns/{campaign}` - Delete campaign
- `GET /{user}/campaigns/{campaign}/payment` - Payment page

### Campaigns (API)
- `POST /api/campaigns/{id}/complete` - Mark campaign complete
- `POST /api/campaigns/{id}/expire` - Expire campaign
- `POST /api/campaigns/{campaign}/refund` - Request refund

### Wallet
- `GET /wallet` - Wallet dashboard
- `GET /wallet/add-funds` - Add funds form
- `POST /wallet/add-funds` - Process fund addition
- `GET /wallet/withdraw` - Withdrawal form
- `POST /wallet/withdraw` - Process withdrawal

### Channels
- `GET /{user}/channels/create` - Create channel form
- `POST /{user}/channels` - Store channel
- `GET /{user}/channels/{channel}` - View channel
- `PUT /{user}/channels/{channel}` - Update channel
- `DELETE /{user}/channels/{channel}` - Delete channel

### Publisher Actions
- `POST /publisher/campaign/{campaign}/accept` - Accept campaign
- `POST /publisher/campaign/{campaign}/reject` - Reject campaign
- `GET /publisher/campaign/{campaign}/submit-link` - Submit link form
- `POST /publisher/campaign/{campaign}/submit-link` - Submit link

### Razorpay
- `POST /razorpay/create-order` - Create payment order
- `POST /razorpay/verify-payment` - Verify payment

### Telegram
- `POST /api/telegram/webhook` - Telegram webhook endpoint

---

## 💳 Payment Integration

### Razorpay Flow

1. **Order Creation**
   ```php
   // In RazorpayController
   $order = $razorpay->order->create([
       'amount' => $amount * 100, // Amount in paise
       'currency' => 'INR',
       'receipt' => 'order_' . time()
   ]);
   ```

2. **Frontend Integration**
   - Razorpay checkout modal opens
   - User completes payment
   - Payment details sent to backend

3. **Payment Verification**
   ```php
   $signature = hash_hmac('sha256', 
       $orderId . '|' . $paymentId, 
       $keySecret
   );
   
   if ($signature === $razorpaySignature) {
       // Payment verified
       $wallet->deposit($amount);
   }
   ```

### Wallet System

- **Balance Types**:
  - `balance` - Available for use
  - `pending_balance` - Locked for pending withdrawals

- **Transaction Types**:
  - `deposit` - Adding funds
  - `withdrawal` - Withdrawing funds
  - `payment` - Campaign payments

- **Transaction Flow**:
  1. All transactions logged in `wallet_transactions`
  2. Balance updated atomically using database transactions
  3. Audit trail maintained for all operations

---

## 📱 Telegram Integration

### Notification Service

The `TelegramNotificationService` handles:
- Sending notifications to users
- Campaign assignment alerts
- Post submission confirmations
- Campaign completion notices

### Bot Commands
Users can interact with the bot to:
- Link their Telegram account
- Receive real-time notifications
- Get campaign updates

### Webhook Setup
```php
// routes/telegram.php
Route::post('/webhook', [TelegramNotificationController::class, 'handleWebhook']);
```

---

## 🔧 Development

### Running Tests
```bash
php artisan test
```

### Code Formatting
```bash
./vendor/bin/pint
```

### Database Seeding
```bash
php artisan db:seed
```

### Queue Workers
```bash
php artisan queue:work
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Frontend Development
```bash
# Watch for changes
npm run dev

# Build for production
npm run build
```

---

## 📊 Key Features Explained

### Campaign Status Flow
```
Created (expired) → Payment → Active → Link Submitted → Completed
                                    ↓
                                Rejected
```

### Channel Status
- `active` - Available for campaigns
- `inactive` - Not accepting campaigns
- `moderation` - Pending admin approval

### Pricing Structure
Publishers set individual prices for:
- 1-day campaigns
- 2-day campaigns
- 3-day campaigns
- 7-day campaigns

### Refund System
- Campaigns in "expired" status can be refunded
- Refund amount returned to advertiser's wallet
- Campaign deleted after successful refund

---

## 🔒 Security Features

- **CSRF Protection** - All forms protected with CSRF tokens
- **SQL Injection Prevention** - Eloquent ORM with parameterized queries
- **XSS Protection** - Blade template escaping
- **Password Hashing** - Bcrypt hashing for passwords
- **Role-Based Access Control** - Middleware-based authorization
- **Secure File Uploads** - Validation and sanitization
- **API Authentication** - Laravel Sanctum tokens

---

## 📝 Additional Notes

### Gaming Calculator
The project includes a separate gaming-themed calculator feature located in `public/game/`. This appears to be an independent component.

### Policy Pages
Pre-built policy pages included:
- Terms of Service (`/terms`)
- Privacy Policy (`/privacy`)
- Refund Policy (`/refund`)
- Cancellation Policy (`/cancellation`)
- FAQ (`/faq`)
- Contact (`/contact`)

### Logging
User actions are logged via `LogUserActions` middleware for audit purposes.

---

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

---

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

---

## 📞 Support

For support and queries:
- Check the FAQ page
- Contact via the contact form
- Review the documentation

---

## 🎯 Future Enhancements

Potential features for future development:
- Admin dashboard for platform management
- Analytics and reporting
- Multi-language support
- Mobile app (React Native/Flutter)
- Advanced campaign scheduling
- Automated campaign approval
- Performance metrics for channels
- Rating system for publishers
- Bulk campaign creation
- API for third-party integrations

---

**Built with ❤️ using Laravel & Bootstrap**
