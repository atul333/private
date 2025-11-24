# AdLinker - Technical Documentation

## 📚 Developer Guide

This document provides in-depth technical information for developers working on the AdLinker platform.

---

## Table of Contents
- [Architecture Overview](#architecture-overview)
- [Database Design](#database-design)
- [Authentication & Authorization](#authentication--authorization)
- [Payment Processing](#payment-processing)
- [Event System](#event-system)
- [Wallet System](#wallet-system)
- [Telegram Integration](#telegram-integration)
- [File Upload System](#file-upload-system)
- [API Design](#api-design)
- [Frontend Architecture](#frontend-architecture)
- [Testing Strategy](#testing-strategy)
- [Deployment](#deployment)

---

## 🏗 Architecture Overview

### MVC Pattern
AdLinker follows Laravel's MVC (Model-View-Controller) architecture:

```
Request → Routes → Middleware → Controller → Model → Database
                                    ↓
                                  View → Response
```

### Service Layer
Business logic is encapsulated in service classes:
- `TelegramNotificationService` - Telegram bot interactions
- `LoggingService` - Application logging

### Event-Driven Architecture
Key operations trigger events that are handled asynchronously:
```
Action → Event → Listener → Notification/Side Effect
```

---

## 🗄 Database Design

### Entity Relationship Diagram

```
Users (1) ←→ (1) Advertiser
      (1) ←→ (1) Publisher
      (1) ←→ (1) Wallet
      (1) ←→ (*) Campaigns
      (1) ←→ (*) Messages (as sender)
      (1) ←→ (*) Messages (as receiver)
      (1) ←→ (1) TelegramNotification

Publisher (1) ←→ (*) Channels

Channels (1) ←→ (*) Campaigns

Campaigns (1) ←→ (*) Ads

Wallet (1) ←→ (*) WalletTransactions

Users (1) ←→ (*) Withdrawals
```

### Key Relationships

#### User Model
```php
class User extends Authenticatable
{
    // One-to-One
    public function publisher() { return $this->hasOne(Publisher::class); }
    public function advertiser() { return $this->hasOne(Advertiser::class); }
    public function wallet() { return $this->hasOne(Wallet::class); }
    public function telegramNotification() { return $this->hasOne(TelegramNotification::class); }
    
    // One-to-Many
    public function campaigns() { return $this->hasMany(Campaign::class); }
    public function ads() { return $this->hasMany(Ad::class); }
}
```

#### Campaign Model
```php
class Campaign extends Model
{
    protected $fillable = [
        'publisher_id', 'advertiser_id', 'channel_id',
        'channel_name', 'subscribers', 'channel_link',
        'duration', 'price', 'advertisement_image',
        'advertisement_content', 'status', 'post_link',
        'notes', 'submission_timestamp', 'post_submitted_at'
    ];
    
    protected $casts = [
        'price' => 'decimal:2',
        'subscribers' => 'integer',
        'duration' => 'integer',
        'submission_timestamp' => 'datetime',
        'post_submitted_at' => 'datetime',
    ];
    
    public function advertiser() { return $this->belongsTo(User::class, 'advertiser_id'); }
    public function channel() { return $this->belongsTo(Channel::class); }
    public function ads() { return $this->hasMany(Ad::class); }
}
```

#### Wallet Model
```php
class Wallet extends Model
{
    protected $fillable = ['user_id', 'balance', 'pending_balance'];
    
    protected $casts = [
        'balance' => 'decimal:2',
        'pending_balance' => 'decimal:2',
    ];
    
    public function user() { return $this->belongsTo(User::class); }
    public function transactions() { return $this->hasMany(WalletTransaction::class); }
    
    // Business methods
    public function deposit(float $amount, ?string $description = null): bool
    public function withdraw(float $amount, ?string $payment_method = null, ?string $description = null): bool
}
```

### Database Indexes

Recommended indexes for performance:

```sql
-- Users table
CREATE INDEX idx_users_role ON users(role);
CREATE INDEX idx_users_email ON users(email);

-- Campaigns table
CREATE INDEX idx_campaigns_advertiser ON campaigns(advertiser_id);
CREATE INDEX idx_campaigns_publisher ON campaigns(publisher_id);
CREATE INDEX idx_campaigns_channel ON campaigns(channel_id);
CREATE INDEX idx_campaigns_status ON campaigns(status);
CREATE INDEX idx_campaigns_created ON campaigns(created_at);

-- Channels table
CREATE INDEX idx_channels_publisher ON channels(publisher_id);
CREATE INDEX idx_channels_status ON channels(status);
CREATE INDEX idx_channels_subscribers ON channels(subscribers_count);

-- Wallet Transactions
CREATE INDEX idx_wallet_trans_wallet ON wallet_transactions(wallet_id);
CREATE INDEX idx_wallet_trans_created ON wallet_transactions(created_at);
```

---

## 🔐 Authentication & Authorization

### Authentication Flow

1. **Registration**
```php
// routes/auth.php
Route::post('/register', [RegisterController::class, 'register']);

// User selects role during registration
User::create([
    'name' => $request->name,
    'email' => $request->email,
    'password' => Hash::make($request->password),
    'role' => $request->role, // 'advertiser' or 'publisher'
]);

// Create role-specific record
if ($user->role === 'advertiser') {
    Advertiser::create(['user_id' => $user->id]);
} else {
    Publisher::create(['user_id' => $user->id]);
}
```

2. **Login & Session**
```php
Route::post('/login', [LoginController::class, 'login']);

// Laravel handles session creation
Auth::attempt($credentials);
```

3. **Role-Based Redirection**
```php
// routes/web.php
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role === 'advertiser') {
            return redirect('/advertiser/dashboard');
        } else if ($user->role === 'publisher') {
            return redirect('/publisher/dashboard');
        }
    }
    return view('welcome');
});
```

### Authorization

#### Role Middleware
```php
// app/Http/Middleware/Role.php
public function handle(Request $request, Closure $next, string $role): Response
{
    if (!$request->user() || $request->user()->role !== $role) {
        abort(403, 'Unauthorized action.');
    }
    return $next($request);
}
```

#### Usage in Routes
```php
// Advertiser-only routes
Route::middleware(['auth', 'role:advertiser'])->group(function () {
    Route::get('/{user}/campaigns', [CampaignController::class, 'index']);
    Route::get('/{user}/advertiser/dashboard', [DashboardController::class, 'index']);
});

// Publisher-only routes
Route::middleware(['auth', 'role:publisher'])->group(function () {
    Route::get('/{user}/publisher/dashboard', [DashboardController::class, 'index']);
    Route::get('/{user}/channels/create', [ChannelController::class, 'create']);
});
```

#### Policy-Based Authorization
```php
// In CampaignController
public function show($user, Campaign $campaign)
{
    $this->authorize('view', $campaign);
    return view('campaigns.show', compact('campaign'));
}
```

### API Authentication (Sanctum)

```php
// routes/api.php
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['web', 'auth:sanctum'])->group(function () {
    Route::post('/campaigns/{id}/complete', [CampaignController::class, 'complete']);
});
```

---

## 💳 Payment Processing

### Razorpay Integration

#### Configuration
```php
// config/razorpay.php
return [
    'key_id' => env('RAZORPAY_KEY_ID'),
    'key_secret' => env('RAZORPAY_KEY_SECRET'),
    'webhook_secret' => env('RAZORPAY_WEBHOOK_SECRET'),
    'base_url' => env('RAZORPAY_BASE_URL', 'https://api.razorpay.com/v1'),
];
```

#### Order Creation Flow

1. **Frontend Request**
```javascript
// User clicks "Add Funds"
fetch('/razorpay/create-order', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken
    },
    body: JSON.stringify({ amount: amount })
})
```

2. **Backend Order Creation**
```php
// app/Http/Controllers/RazorpayController.php
public function createOrder(Request $request)
{
    $api = new Api(config('razorpay.key_id'), config('razorpay.key_secret'));
    
    $order = $api->order->create([
        'amount' => $request->amount * 100, // Convert to paise
        'currency' => 'INR',
        'receipt' => 'order_' . time(),
        'notes' => [
            'user_id' => auth()->id(),
            'purpose' => 'wallet_recharge'
        ]
    ]);
    
    return response()->json([
        'order_id' => $order['id'],
        'amount' => $order['amount'],
        'currency' => $order['currency']
    ]);
}
```

3. **Frontend Checkout**
```javascript
var options = {
    "key": razorpayKeyId,
    "amount": orderData.amount,
    "currency": orderData.currency,
    "order_id": orderData.order_id,
    "handler": function (response) {
        verifyPayment(response);
    }
};
var rzp = new Razorpay(options);
rzp.open();
```

4. **Payment Verification**
```php
public function verifyPayment(Request $request)
{
    $signature = hash_hmac(
        'sha256',
        $request->razorpay_order_id . '|' . $request->razorpay_payment_id,
        config('razorpay.key_secret')
    );
    
    if ($signature === $request->razorpay_signature) {
        // Payment verified
        $wallet = Wallet::where('user_id', auth()->id())->first();
        $wallet->deposit($request->amount, 'Razorpay payment');
        
        return response()->json(['success' => true]);
    }
    
    return response()->json(['success' => false], 400);
}
```

#### Webhook Handling
```php
public function handleWebhook(Request $request)
{
    $webhookSignature = $request->header('X-Razorpay-Signature');
    $webhookSecret = config('razorpay.webhook_secret');
    
    $expectedSignature = hash_hmac('sha256', $request->getContent(), $webhookSecret);
    
    if ($webhookSignature === $expectedSignature) {
        $event = $request->all();
        
        switch ($event['event']) {
            case 'payment.captured':
                // Handle successful payment
                break;
            case 'payment.failed':
                // Handle failed payment
                break;
        }
    }
}
```

---

## 🎯 Event System

### Event-Listener Architecture

#### Event: NewCampaignAssigned
```php
// app/Events/NewCampaignAssigned.php
class NewCampaignAssigned
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $campaign;
    public $channel;
    
    public function __construct(Campaign $campaign, Channel $channel)
    {
        $this->campaign = $campaign;
        $this->channel = $channel;
    }
}
```

#### Listener: SendCampaignNotification
```php
// app/Listeners/SendCampaignNotification.php
class SendCampaignNotification
{
    public function handle(NewCampaignAssigned $event)
    {
        $publisher = $event->channel->publisher->user;
        $campaign = $event->campaign;
        
        // Send Telegram notification
        $telegramService = new TelegramNotificationService();
        $telegramService->sendCampaignNotification($publisher, $campaign);
    }
}
```

#### Event Registration
```php
// app/Providers/EventServiceProvider.php
protected $listen = [
    NewCampaignAssigned::class => [
        SendCampaignNotification::class,
    ],
    CampaignLinkSubmitted::class => [
        SendCampaignSubmissionNotification::class,
    ],
    CampaignCompleted::class => [
        SendCampaignCompletionNotifications::class,
    ],
];
```

#### Dispatching Events
```php
// In CampaignController
public function processPayment($user, Campaign $campaign)
{
    // ... payment processing ...
    
    $campaign->update(['status' => 'active']);
    
    $channel = Channel::findOrFail($campaign->channel_id);
    event(new NewCampaignAssigned($campaign, $channel));
    
    // ... redirect ...
}
```

---

## 💰 Wallet System

### Architecture

The wallet system uses a double-entry bookkeeping approach:
- Every transaction is recorded
- Balance is updated atomically
- Pending balance tracks locked funds

### Transaction Flow

#### Deposit (Add Funds)
```php
// app/Models/Wallet.php
public function deposit(float $amount, ?string $description = null): bool
{
    return $this->createTransaction([
        'type' => 'deposit',
        'amount' => $amount,
        'status' => 'completed',
        'description' => $description ?? 'Wallet deposit',
    ]);
}

protected function createTransaction(array $attributes): bool
{
    try {
        DB::beginTransaction();
        
        // Create transaction record
        $transaction = $this->transactions()->create([
            'type' => $attributes['type'],
            'amount' => $attributes['amount'],
            'status' => $attributes['status'],
            'description' => $attributes['description']
        ]);
        
        if ($transaction) {
            // Update wallet balance
            $this->balance += $attributes['amount'];
            $saved = $this->save();
            
            if ($saved) {
                DB::commit();
                return true;
            }
        }
        
        DB::rollBack();
        return false;
        
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Wallet transaction failed', [
            'error' => $e->getMessage(),
            'wallet_id' => $this->id,
            'attributes' => $attributes
        ]);
        return false;
    }
}
```

#### Withdrawal (Request Payout)
```php
public function withdraw(float $amount, ?string $payment_method = null, ?string $description = null): bool
{
    // Check sufficient balance
    if ($this->balance < $amount) {
        return false;
    }
    
    // Move from available to pending
    $this->balance -= $amount;
    $this->pending_balance += $amount;
    
    if ($this->save()) {
        // Create transaction record
        return $this->transactions()->create([
            'type' => 'withdrawal',
            'amount' => -$amount, // Negative for debit
            'status' => 'pending',
            'description' => $description ?? $payment_method,
        ]) ? true : false;
    }
    
    return false;
}
```

#### Campaign Payment
```php
// In CampaignController
public function processPayment($user, Campaign $campaign)
{
    $wallet = Wallet::where('user_id', auth()->id())->firstOrFail();
    
    // Check balance
    if ($wallet->balance < $campaign->price) {
        Session::flash('error', 'Insufficient wallet balance.');
        return redirect()->back();
    }
    
    try {
        // Deduct from wallet
        if (!$wallet->withdraw($campaign->price, "Payment for Campaign on {$campaign->channel_name}")) {
            throw new \Exception('Failed to process wallet transaction');
        }
        
        // Activate campaign
        $campaign->update(['status' => 'active']);
        
        // Dispatch event
        $channel = Channel::findOrFail($campaign->channel_id);
        event(new NewCampaignAssigned($campaign, $channel));
        
        Session::flash('success', 'Payment processed successfully!');
        return redirect('/'. auth()->id() .'/advertiser/dashboard');
        
    } catch (\Exception $e) {
        Session::flash('error', 'An error occurred while processing the payment.');
        return redirect()->back();
    }
}
```

### Transaction Types

| Type | Amount Sign | Description |
|------|-------------|-------------|
| deposit | Positive (+) | Funds added to wallet |
| withdrawal | Negative (-) | Funds withdrawn from wallet |
| payment | Negative (-) | Payment for campaign |
| refund | Positive (+) | Refund from expired campaign |
| earning | Positive (+) | Earnings from completed campaign |

---

## 📱 Telegram Integration

### TelegramNotificationService

```php
// app/Services/TelegramNotificationService.php
class TelegramNotificationService
{
    protected $botToken;
    protected $apiUrl;
    
    public function __construct()
    {
        $this->botToken = env('TELEGRAM_BOT_TOKEN');
        $this->apiUrl = "https://api.telegram.org/bot{$this->botToken}";
    }
    
    public function sendMessage($chatId, $message)
    {
        $url = "{$this->apiUrl}/sendMessage";
        
        $data = [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML'
        ];
        
        return Http::post($url, $data);
    }
    
    public function sendCampaignNotification($publisher, $campaign)
    {
        $notification = $publisher->telegramNotification;
        
        if (!$notification || !$notification->is_active) {
            return;
        }
        
        $message = "🎯 <b>New Campaign Assigned!</b>\n\n";
        $message .= "Channel: {$campaign->channel_name}\n";
        $message .= "Duration: {$campaign->duration} days\n";
        $message .= "Price: ₹{$campaign->price}\n";
        $message .= "Advertiser: {$campaign->advertiser->name}\n\n";
        $message .= "Please review and accept the campaign.";
        
        $this->sendMessage($notification->chat_id, $message);
    }
}
```

### Webhook Handler

```php
// app/Http/Controllers/TelegramNotificationController.php
public function handleWebhook(Request $request)
{
    $update = $request->all();
    
    if (isset($update['message'])) {
        $message = $update['message'];
        $chatId = $message['chat']['id'];
        $text = $message['text'] ?? '';
        
        // Handle /start command
        if ($text === '/start') {
            $this->handleStartCommand($chatId);
        }
        
        // Handle /link command with verification code
        if (strpos($text, '/link') === 0) {
            $this->handleLinkCommand($chatId, $text);
        }
    }
    
    return response()->json(['ok' => true]);
}

protected function handleLinkCommand($chatId, $text)
{
    // Extract verification code
    $parts = explode(' ', $text);
    $code = $parts[1] ?? null;
    
    if ($code) {
        // Find user by verification code
        $user = User::where('verification_code', $code)->first();
        
        if ($user) {
            // Link Telegram account
            TelegramNotification::updateOrCreate(
                ['user_id' => $user->id],
                ['chat_id' => $chatId, 'is_active' => true]
            );
            
            $this->sendMessage($chatId, "✅ Your account has been linked successfully!");
        } else {
            $this->sendMessage($chatId, "❌ Invalid verification code.");
        }
    }
}
```

---

## 📤 File Upload System

### Image Upload for Campaigns

```php
// In CampaignController
public function store(Request $request, $user)
{
    $validated = $request->validate([
        'advertisement_content' => 'required|string',
        'advertisement_image' => 'required|image|mimes:jpg,jpeg|max:2048'
    ], [
        'advertisement_image.mimes' => 'Only .jpg file images are allowed to upload'
    ]);
    
    // Store image
    $imagePath = $request->file('advertisement_image')->store('advertisements', 'public');
    
    // Create campaign with image path
    $campaign = Campaign::create([
        // ... other fields ...
        'advertisement_image' => $imagePath,
    ]);
}
```

### Storage Configuration

```php
// config/filesystems.php
'disks' => [
    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
    ],
],
```

### Accessing Uploaded Files

```blade
<!-- In Blade template -->
<img src="{{ asset('storage/' . $campaign->advertisement_image) }}" alt="Advertisement">
```

### File Validation Rules

| Field | Rules |
|-------|-------|
| advertisement_image | required, image, mimes:jpg,jpeg, max:2048 (KB) |
| channel_logo | nullable, image, mimes:jpg,jpeg,png, max:1024 |

---

## 🌐 API Design

### RESTful Principles

The API follows REST conventions:

```
GET    /campaigns          - List campaigns
POST   /campaigns          - Create campaign
GET    /campaigns/{id}     - Show campaign
PUT    /campaigns/{id}     - Update campaign
DELETE /campaigns/{id}     - Delete campaign
```

### Response Format

#### Success Response
```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "Campaign Name",
        "status": "active"
    },
    "message": "Campaign created successfully"
}
```

#### Error Response
```json
{
    "success": false,
    "error": {
        "code": "INSUFFICIENT_BALANCE",
        "message": "Insufficient wallet balance"
    }
}
```

### API Versioning

Future versions should use URL versioning:
```
/api/v1/campaigns
/api/v2/campaigns
```

---

## 🎨 Frontend Architecture

### Blade Templates

#### Layout Structure
```
layouts/
  └── app.blade.php          # Main layout
      ├── Header
      ├── Navigation
      ├── @yield('content')
      └── Footer
```

#### Component Organization
```blade
<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>@yield('title') - AdLinker</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    @include('components.navbar')
    
    <main>
        @yield('content')
    </main>
    
    @include('components.footer')
</body>
</html>
```

### JavaScript Organization

```javascript
// resources/js/app.js
import './bootstrap';
import axios from 'axios';

// Global axios configuration
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// CSRF token setup
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}
```

### SASS Structure

```scss
// resources/sass/app.scss
@import 'variables';
@import 'bootstrap';
@import 'components/navbar';
@import 'components/cards';
@import 'pages/dashboard';
@import 'pages/campaigns';
```

---

## 🧪 Testing Strategy

### Unit Tests

```php
// tests/Unit/WalletTest.php
class WalletTest extends TestCase
{
    public function test_deposit_increases_balance()
    {
        $wallet = Wallet::factory()->create(['balance' => 100]);
        
        $wallet->deposit(50, 'Test deposit');
        
        $this->assertEquals(150, $wallet->fresh()->balance);
    }
    
    public function test_withdrawal_decreases_balance()
    {
        $wallet = Wallet::factory()->create(['balance' => 100]);
        
        $result = $wallet->withdraw(30, 'upi', 'Test withdrawal');
        
        $this->assertTrue($result);
        $this->assertEquals(70, $wallet->fresh()->balance);
        $this->assertEquals(30, $wallet->fresh()->pending_balance);
    }
    
    public function test_withdrawal_fails_with_insufficient_balance()
    {
        $wallet = Wallet::factory()->create(['balance' => 50]);
        
        $result = $wallet->withdraw(100, 'upi', 'Test withdrawal');
        
        $this->assertFalse($result);
        $this->assertEquals(50, $wallet->fresh()->balance);
    }
}
```

### Feature Tests

```php
// tests/Feature/CampaignTest.php
class CampaignTest extends TestCase
{
    public function test_advertiser_can_create_campaign()
    {
        $advertiser = User::factory()->create(['role' => 'advertiser']);
        $channel = Channel::factory()->create();
        
        $this->actingAs($advertiser)
            ->post("/campaigns", [
                'channel_id' => $channel->id,
                'duration' => 1,
                'price' => 100,
                'advertisement_content' => 'Test ad',
                'advertisement_image' => UploadedFile::fake()->image('ad.jpg')
            ])
            ->assertRedirect();
        
        $this->assertDatabaseHas('campaigns', [
            'advertiser_id' => $advertiser->id,
            'channel_id' => $channel->id,
        ]);
    }
}
```

### Running Tests

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Unit/WalletTest.php

# Run with coverage
php artisan test --coverage
```

---

## 🚀 Deployment

### Production Checklist

1. **Environment Configuration**
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

2. **Optimize Application**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev
```

3. **Build Assets**
```bash
npm run build
```

4. **Database Migration**
```bash
php artisan migrate --force
```

5. **Storage Permissions**
```bash
chmod -R 775 storage bootstrap/cache
```

6. **Queue Worker Setup**
```bash
# Using Supervisor
[program:adlinker-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/path/to/worker.log
```

### Server Requirements

- PHP >= 8.1
- MySQL >= 5.7 or MariaDB >= 10.3
- Nginx or Apache
- Composer
- Node.js & NPM

### Nginx Configuration

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/Adlinker_main/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

---

## 📊 Performance Optimization

### Database Optimization

1. **Eager Loading**
```php
// Instead of N+1 queries
$campaigns = Campaign::all();
foreach ($campaigns as $campaign) {
    echo $campaign->channel->name; // N queries
}

// Use eager loading
$campaigns = Campaign::with('channel')->get();
foreach ($campaigns as $campaign) {
    echo $campaign->channel->name; // 1 query
}
```

2. **Query Optimization**
```php
// Use select to limit columns
Campaign::select('id', 'name', 'status')->get();

// Use chunk for large datasets
Campaign::chunk(100, function ($campaigns) {
    foreach ($campaigns as $campaign) {
        // Process campaign
    }
});
```

### Caching Strategy

```php
// Cache channel list
$channels = Cache::remember('active_channels', 3600, function () {
    return Channel::where('status', 'active')->get();
});

// Cache user wallet balance
$balance = Cache::remember("wallet_balance_{$userId}", 600, function () use ($userId) {
    return Wallet::where('user_id', $userId)->value('balance');
});
```

### Asset Optimization

```bash
# Minify and combine assets
npm run build

# Enable browser caching in .htaccess
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
</IfModule>
```

---

## 🔍 Debugging

### Laravel Telescope (Development)

```bash
composer require laravel/telescope --dev
php artisan telescope:install
php artisan migrate
```

Access at: `http://localhost/telescope`

### Logging

```php
// Log levels
Log::emergency($message);
Log::alert($message);
Log::critical($message);
Log::error($message);
Log::warning($message);
Log::notice($message);
Log::info($message);
Log::debug($message);

// Contextual logging
Log::info('Campaign created', [
    'campaign_id' => $campaign->id,
    'advertiser_id' => $advertiser->id,
]);
```

### Query Debugging

```php
// Enable query log
DB::enableQueryLog();

// Run queries
$campaigns = Campaign::where('status', 'active')->get();

// Get executed queries
dd(DB::getQueryLog());
```

---

## 📝 Code Standards

### PSR-12 Compliance

```php
<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        $campaigns = Campaign::query()
            ->where('advertiser_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('campaigns.index', compact('campaigns'));
    }
}
```

### Naming Conventions

| Type | Convention | Example |
|------|------------|---------|
| Controllers | PascalCase + Controller | `CampaignController` |
| Models | PascalCase (singular) | `Campaign`, `User` |
| Methods | camelCase | `processPayment()` |
| Variables | camelCase | `$campaignId` |
| Database Tables | snake_case (plural) | `campaigns`, `wallet_transactions` |
| Database Columns | snake_case | `advertiser_id`, `created_at` |
| Routes | kebab-case | `/campaigns/create` |
| Views | kebab-case | `campaigns/create.blade.php` |

---

## 🔒 Security Best Practices

### Input Validation

```php
$validated = $request->validate([
    'email' => 'required|email|unique:users',
    'password' => 'required|min:8|confirmed',
    'amount' => 'required|numeric|min:0.01|max:100000',
]);
```

### SQL Injection Prevention

```php
// ✅ Good - Using Eloquent
Campaign::where('status', $status)->get();

// ✅ Good - Using parameter binding
DB::select('SELECT * FROM campaigns WHERE status = ?', [$status]);

// ❌ Bad - Vulnerable to SQL injection
DB::select("SELECT * FROM campaigns WHERE status = '$status'");
```

### XSS Prevention

```blade
{{-- ✅ Good - Escaped output --}}
{{ $campaign->name }}

{{-- ❌ Bad - Unescaped output --}}
{!! $campaign->name !!}
```

### CSRF Protection

```blade
<form method="POST" action="/campaigns">
    @csrf
    <!-- form fields -->
</form>
```

---

This technical documentation provides comprehensive guidance for developers working on the AdLinker platform. For additional information, refer to the [Laravel Documentation](https://laravel.com/docs) and project-specific README.md.
