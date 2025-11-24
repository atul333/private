# AdLinker - System Architecture & Flow Diagrams

## 📐 Visual Documentation

This document contains visual representations of the AdLinker system architecture, workflows, and data flows.

---

## 🏗️ System Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                         CLIENT LAYER                             │
├─────────────────────────────────────────────────────────────────┤
│  Web Browser (Chrome, Firefox, Safari, Edge)                    │
│  - Blade Templates (HTML)                                       │
│  - Bootstrap CSS + Custom SASS                                  │
│  - JavaScript (Vanilla + Axios)                                 │
└────────────────────┬────────────────────────────────────────────┘
                     │ HTTP/HTTPS
                     ▼
┌─────────────────────────────────────────────────────────────────┐
│                      WEB SERVER LAYER                            │
├─────────────────────────────────────────────────────────────────┤
│  Nginx / Apache                                                  │
│  - Static File Serving                                          │
│  - PHP-FPM Integration                                          │
│  - SSL/TLS Termination                                          │
└────────────────────┬────────────────────────────────────────────┘
                     │
                     ▼
┌─────────────────────────────────────────────────────────────────┐
│                    APPLICATION LAYER                             │
├─────────────────────────────────────────────────────────────────┤
│  Laravel 10.x (PHP 8.1+)                                        │
│                                                                  │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐         │
│  │   Routes     │  │ Middleware   │  │ Controllers  │         │
│  │              │→ │              │→ │              │         │
│  │ - web.php    │  │ - Auth       │  │ - Campaign   │         │
│  │ - api.php    │  │ - Role       │  │ - Wallet     │         │
│  │ - wallet.php │  │ - CSRF       │  │ - Channel    │         │
│  └──────────────┘  └──────────────┘  └──────┬───────┘         │
│                                              │                  │
│  ┌──────────────┐  ┌──────────────┐  ┌──────▼───────┐         │
│  │   Models     │  │   Services   │  │    Events    │         │
│  │              │  │              │  │              │         │
│  │ - User       │  │ - Telegram   │  │ - Campaign   │         │
│  │ - Campaign   │  │ - Logging    │  │   Assigned   │         │
│  │ - Wallet     │  │              │  │ - Link       │         │
│  │ - Channel    │  │              │  │   Submitted  │         │
│  └──────┬───────┘  └──────────────┘  └──────┬───────┘         │
│         │                                    │                  │
│         │                            ┌───────▼────────┐         │
│         │                            │   Listeners    │         │
│         │                            │                │         │
│         │                            │ - Send         │         │
│         │                            │   Notifications│         │
│         │                            └────────────────┘         │
└─────────┼──────────────────────────────────────────────────────┘
          │
          ▼
┌─────────────────────────────────────────────────────────────────┐
│                      DATA LAYER                                  │
├─────────────────────────────────────────────────────────────────┤
│  MySQL Database                                                  │
│                                                                  │
│  ┌──────────┐  ┌──────────┐  ┌──────────┐  ┌──────────┐       │
│  │  users   │  │campaigns │  │ channels │  │ wallets  │       │
│  └────┬─────┘  └────┬─────┘  └────┬─────┘  └────┬─────┘       │
│       │             │              │             │              │
│  ┌────▼─────┐  ┌───▼──────┐  ┌───▼──────┐  ┌───▼──────┐       │
│  │publishers│  │   ads    │  │wallet_   │  │withdraw- │       │
│  │advertisers│ │          │  │trans-    │  │als       │       │
│  └──────────┘  └──────────┘  │actions   │  └──────────┘       │
│                               └──────────┘                      │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│                   EXTERNAL SERVICES                              │
├─────────────────────────────────────────────────────────────────┤
│  ┌──────────────┐         ┌──────────────┐                     │
│  │   Razorpay   │         │   Telegram   │                     │
│  │              │         │   Bot API    │                     │
│  │ - Payments   │         │              │                     │
│  │ - Webhooks   │         │ - Messages   │                     │
│  └──────────────┘         │ - Webhooks   │                     │
│                           └──────────────┘                      │
└─────────────────────────────────────────────────────────────────┘
```

---

## 🔄 Campaign Lifecycle Flow

```
┌─────────────────────────────────────────────────────────────────┐
│                    ADVERTISER WORKFLOW                           │
└─────────────────────────────────────────────────────────────────┘

    ┌──────────┐
    │  Login   │
    └────┬─────┘
         │
         ▼
    ┌──────────┐
    │Add Funds │ ──────────┐
    │to Wallet │           │
    └────┬─────┘           │
         │                 ▼
         │          ┌─────────────┐
         │          │  Razorpay   │
         │          │  Payment    │
         │          └──────┬──────┘
         │                 │
         │                 ▼
         │          ┌─────────────┐
         │          │   Wallet    │
         │          │  Updated    │
         │          └─────────────┘
         │
         ▼
    ┌──────────┐
    │  Browse  │
    │ Channels │
    └────┬─────┘
         │
         ▼
    ┌──────────┐
    │  Select  │
    │ Channel  │
    │& Duration│
    └────┬─────┘
         │
         ▼
    ┌──────────┐
    │  Upload  │
    │   Ad     │
    │ Content  │
    └────┬─────┘
         │
         ▼
    ┌──────────┐
    │ Campaign │
    │ Created  │
    │(expired) │
    └────┬─────┘
         │
         ▼
    ┌──────────┐
    │   Pay    │
    │   from   │
    │  Wallet  │
    └────┬─────┘
         │
         ▼
    ┌──────────┐
    │ Campaign │
    │ Activated│
    │ (active) │
    └────┬─────┘
         │
         │  ┌────────────────────────────────────┐
         └─→│  Event: NewCampaignAssigned        │
            │  Listener: SendCampaignNotification│
            └────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│                    PUBLISHER WORKFLOW                            │
└─────────────────────────────────────────────────────────────────┘

    ┌──────────┐
    │ Telegram │
    │Notification│
    │ Received │
    └────┬─────┘
         │
         ▼
    ┌──────────┐
    │  Login   │
    │   to     │
    │Dashboard │
    └────┬─────┘
         │
         ▼
    ┌──────────┐
    │  Review  │
    │ Campaign │
    └────┬─────┘
         │
         ├─────────────┐
         │             │
         ▼             ▼
    ┌──────┐      ┌──────┐
    │Accept│      │Reject│
    └───┬──┘      └───┬──┘
        │             │
        │             ▼
        │        ┌──────────┐
        │        │ Campaign │
        │        │ Rejected │
        │        └──────────┘
        │
        ▼
    ┌──────────┐
    │   Post   │
    │   Ad on  │
    │ Telegram │
    └────┬─────┘
         │
         ▼
    ┌──────────┐
    │  Submit  │
    │Post Link │
    └────┬─────┘
         │
         │  ┌────────────────────────────────────┐
         └─→│  Event: CampaignLinkSubmitted      │
            │  Listener: SendSubmissionNotif     │
            └────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│                    COMPLETION FLOW                               │
└─────────────────────────────────────────────────────────────────┘

    ┌──────────┐
    │Advertiser│
    │ Reviews  │
    │   Post   │
    └────┬─────┘
         │
         ▼
    ┌──────────┐
    │  Marks   │
    │ Campaign │
    │ Complete │
    └────┬─────┘
         │
         │  ┌────────────────────────────────────┐
         └─→│  Event: CampaignCompleted          │
            │  Listener: SendCompletionNotif     │
            └────────────────────────────────────┘
                              │
                              ▼
                        ┌──────────┐
                        │Publisher │
                        │  Wallet  │
                        │ Credited │
                        └──────────┘
```

---

## 💰 Wallet Transaction Flow

```
┌─────────────────────────────────────────────────────────────────┐
│                      DEPOSIT FLOW                                │
└─────────────────────────────────────────────────────────────────┘

User → Add Funds Form
         │
         ▼
    Razorpay Order Created
         │
         ▼
    Razorpay Checkout Modal
         │
         ▼
    User Completes Payment
         │
         ▼
    Payment Verification
         │
         ├─── Valid ────┐
         │              │
         │              ▼
         │         ┌─────────────┐
         │         │  DB::begin  │
         │         │ Transaction │
         │         └──────┬──────┘
         │                │
         │                ▼
         │         ┌─────────────┐
         │         │   Create    │
         │         │ Transaction │
         │         │   Record    │
         │         └──────┬──────┘
         │                │
         │                ▼
         │         ┌─────────────┐
         │         │   Update    │
         │         │   Wallet    │
         │         │   Balance   │
         │         └──────┬──────┘
         │                │
         │                ▼
         │         ┌─────────────┐
         │         │ DB::commit  │
         │         └──────┬──────┘
         │                │
         │                ▼
         │         Success Message
         │
         └─── Invalid ──→ Error Message

┌─────────────────────────────────────────────────────────────────┐
│                    WITHDRAWAL FLOW                               │
└─────────────────────────────────────────────────────────────────┘

Publisher → Withdrawal Request
              │
              ▼
         Check Balance
              │
              ├─── Sufficient ───┐
              │                  │
              │                  ▼
              │           ┌─────────────┐
              │           │   Deduct    │
              │           │    from     │
              │           │   Balance   │
              │           └──────┬──────┘
              │                  │
              │                  ▼
              │           ┌─────────────┐
              │           │     Add     │
              │           │     to      │
              │           │   Pending   │
              │           └──────┬──────┘
              │                  │
              │                  ▼
              │           ┌─────────────┐
              │           │   Create    │
              │           │ Withdrawal  │
              │           │   Record    │
              │           └──────┬──────┘
              │                  │
              │                  ▼
              │           ┌─────────────┐
              │           │   Admin     │
              │           │  Reviews    │
              │           └──────┬──────┘
              │                  │
              │                  ├─── Approved ───┐
              │                  │                │
              │                  │                ▼
              │                  │         ┌─────────────┐
              │                  │         │   Payment   │
              │                  │         │  Processed  │
              │                  │         └──────┬──────┘
              │                  │                │
              │                  │                ▼
              │                  │         ┌─────────────┐
              │                  │         │   Deduct    │
              │                  │         │    from     │
              │                  │         │   Pending   │
              │                  │         └─────────────┘
              │                  │
              │                  └─── Rejected ──→ Refund to Balance
              │
              └─── Insufficient ──→ Error Message

┌─────────────────────────────────────────────────────────────────┐
│                    CAMPAIGN PAYMENT FLOW                         │
└─────────────────────────────────────────────────────────────────┘

Campaign Created (expired)
         │
         ▼
    Payment Page
         │
         ▼
    Check Wallet Balance
         │
         ├─── Sufficient ───┐
         │                  │
         │                  ▼
         │           ┌─────────────┐
         │           │   Deduct    │
         │           │    from     │
         │           │   Wallet    │
         │           └──────┬──────┘
         │                  │
         │                  ▼
         │           ┌─────────────┐
         │           │   Activate  │
         │           │  Campaign   │
         │           └──────┬──────┘
         │                  │
         │                  ▼
         │           ┌─────────────┐
         │           │   Notify    │
         │           │  Publisher  │
         │           └─────────────┘
         │
         └─── Insufficient ──→ Add Funds Prompt
```

---

## 🔐 Authentication & Authorization Flow

```
┌─────────────────────────────────────────────────────────────────┐
│                    REGISTRATION FLOW                             │
└─────────────────────────────────────────────────────────────────┘

    ┌──────────┐
    │   User   │
    │  Visits  │
    │/register │
    └────┬─────┘
         │
         ▼
    ┌──────────┐
    │  Fills   │
    │   Form   │
    │  Selects │
    │   Role   │
    └────┬─────┘
         │
         ▼
    ┌──────────┐
    │ Validate │
    │   Data   │
    └────┬─────┘
         │
         ├─── Valid ────┐
         │              │
         │              ▼
         │         ┌─────────────┐
         │         │   Create    │
         │         │    User     │
         │         └──────┬──────┘
         │                │
         │                ▼
         │         ┌─────────────┐
         │         │   Create    │
         │         │ Role Record │
         │         │ (Advertiser/│
         │         │  Publisher) │
         │         └──────┬──────┘
         │                │
         │                ▼
         │         ┌─────────────┐
         │         │   Create    │
         │         │   Wallet    │
         │         └──────┬──────┘
         │                │
         │                ▼
         │         ┌─────────────┐
         │         │    Login    │
         │         │    User     │
         │         └──────┬──────┘
         │                │
         │                ▼
         │         ┌─────────────┐
         │         │  Redirect   │
         │         │     to      │
         │         │  Dashboard  │
         │         └─────────────┘
         │
         └─── Invalid ──→ Show Errors

┌─────────────────────────────────────────────────────────────────┐
│                      LOGIN FLOW                                  │
└─────────────────────────────────────────────────────────────────┘

    ┌──────────┐
    │   User   │
    │  Visits  │
    │  /login  │
    └────┬─────┘
         │
         ▼
    ┌──────────┐
    │  Enters  │
    │   Email  │
    │ Password │
    └────┬─────┘
         │
         ▼
    ┌──────────┐
    │ Validate │
    │Credentials│
    └────┬─────┘
         │
         ├─── Valid ────┐
         │              │
         │              ▼
         │         ┌─────────────┐
         │         │   Create    │
         │         │   Session   │
         │         └──────┬──────┘
         │                │
         │                ▼
         │         ┌─────────────┐
         │         │Check User   │
         │         │    Role     │
         │         └──────┬──────┘
         │                │
         │                ├─── Advertiser ──→ /advertiser/dashboard
         │                │
         │                └─── Publisher ───→ /publisher/dashboard
         │
         └─── Invalid ──→ Show Error

┌─────────────────────────────────────────────────────────────────┐
│                  AUTHORIZATION FLOW                              │
└─────────────────────────────────────────────────────────────────┘

Request → Route → Middleware
                      │
                      ▼
                 Check Auth
                      │
                      ├─── Authenticated ───┐
                      │                     │
                      │                     ▼
                      │              ┌─────────────┐
                      │              │Check Role   │
                      │              │ Middleware  │
                      │              └──────┬──────┘
                      │                     │
                      │                     ├─── Match ───→ Allow
                      │                     │
                      │                     └─── No Match ─→ 403 Forbidden
                      │
                      └─── Not Authenticated ──→ Redirect to Login
```

---

## 📊 Database Relationships

```
┌─────────────────────────────────────────────────────────────────┐
│                    ENTITY RELATIONSHIPS                          │
└─────────────────────────────────────────────────────────────────┘

         ┌──────────────┐
         │    Users     │
         │              │
         │ - id         │
         │ - name       │
         │ - email      │
         │ - role       │
         └───┬──────┬───┘
             │      │
    ┌────────┘      └────────┐
    │                        │
    ▼                        ▼
┌──────────┐          ┌──────────┐
│Advertiser│          │Publisher │
│          │          │          │
│- user_id │          │- user_id │
└────┬─────┘          └────┬─────┘
     │                     │
     │                     ▼
     │              ┌──────────┐
     │              │ Channels │
     │              │          │
     │              │- id      │
     │              │- name    │
     │              │- link    │
     │              │- price_* │
     │              └────┬─────┘
     │                   │
     │                   │
     ▼                   ▼
┌─────────────────────────────┐
│        Campaigns            │
│                             │
│ - id                        │
│ - advertiser_id ────────────┼──→ Users
│ - publisher_id ─────────────┼──→ Users
│ - channel_id ───────────────┼──→ Channels
│ - status                    │
│ - price                     │
└─────────────────────────────┘

         ┌──────────────┐
         │    Users     │
         └───┬──────────┘
             │
             │ 1:1
             ▼
         ┌──────────────┐
         │   Wallets    │
         │              │
         │ - user_id    │
         │ - balance    │
         │ - pending    │
         └───┬──────────┘
             │
             │ 1:N
             ▼
    ┌────────────────────┐
    │ WalletTransactions │
    │                    │
    │ - wallet_id        │
    │ - type             │
    │ - amount           │
    │ - status           │
    └────────────────────┘
```

---

## 🎯 Campaign Status State Machine

```
┌─────────────────────────────────────────────────────────────────┐
│                  CAMPAIGN STATUS FLOW                            │
└─────────────────────────────────────────────────────────────────┘

                    ┌──────────┐
                    │ CREATED  │
                    │(expired) │
                    └────┬─────┘
                         │
                         │ Payment
                         │ Successful
                         ▼
                    ┌──────────┐
                    │  ACTIVE  │
                    └────┬─────┘
                         │
                         ├─────────────┐
                         │             │
                         │ Publisher   │ Publisher
                         │ Accepts     │ Rejects
                         │             │
                         ▼             ▼
                    ┌──────────┐  ┌──────────┐
                    │  ACTIVE  │  │ REJECTED │
                    │          │  └──────────┘
                    └────┬─────┘
                         │
                         │ Publisher
                         │ Submits Link
                         ▼
                    ┌──────────┐
                    │  ACTIVE  │
                    │(link     │
                    │submitted)│
                    └────┬─────┘
                         │
                         │ Advertiser
                         │ Confirms
                         ▼
                    ┌──────────┐
                    │COMPLETED │
                    └──────────┘

Legend:
- expired: Campaign created but not paid
- active: Campaign paid and running
- rejected: Publisher rejected the campaign
- completed: Campaign successfully finished
```

---

## 🔄 Event-Driven Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                    EVENT SYSTEM                                  │
└─────────────────────────────────────────────────────────────────┘

Action                    Event                    Listener
  │                         │                         │
  │                         │                         │
  ▼                         ▼                         ▼
┌──────────┐         ┌──────────────┐        ┌─────────────┐
│ Campaign │         │NewCampaign   │        │   Send      │
│ Activated│────────→│Assigned      │───────→│ Campaign    │
│          │         │              │        │Notification │
└──────────┘         └──────────────┘        └──────┬──────┘
                                                     │
                                                     ▼
                                              ┌─────────────┐
                                              │  Telegram   │
                                              │    Bot      │
                                              │   Sends     │
                                              │  Message    │
                                              └─────────────┘

┌──────────┐         ┌──────────────┐        ┌─────────────┐
│   Link   │         │CampaignLink  │        │   Send      │
│Submitted │────────→│Submitted     │───────→│ Submission  │
│          │         │              │        │Notification │
└──────────┘         └──────────────┘        └──────┬──────┘
                                                     │
                                                     ▼
                                              ┌─────────────┐
                                              │   Notify    │
                                              │ Advertiser  │
                                              └─────────────┘

┌──────────┐         ┌──────────────┐        ┌─────────────┐
│ Campaign │         │Campaign      │        │   Send      │
│Completed │────────→│Completed     │───────→│ Completion  │
│          │         │              │        │Notifications│
└──────────┘         └──────────────┘        └──────┬──────┘
                                                     │
                                                     ├──→ Notify Advertiser
                                                     │
                                                     └──→ Notify Publisher
```

---

## 🌐 Request/Response Cycle

```
┌─────────────────────────────────────────────────────────────────┐
│                  HTTP REQUEST FLOW                               │
└─────────────────────────────────────────────────────────────────┘

Browser
   │
   │ HTTP Request
   ▼
Web Server (Nginx/Apache)
   │
   │ Forward to PHP-FPM
   ▼
public/index.php
   │
   │ Bootstrap Laravel
   ▼
Kernel
   │
   │ Load Service Providers
   ▼
Router
   │
   │ Match Route
   ▼
Middleware Stack
   │
   ├─→ EncryptCookies
   ├─→ VerifyCsrfToken
   ├─→ Authenticate
   └─→ Role
       │
       ▼
   Controller
       │
       ├─→ Validate Request
       ├─→ Process Business Logic
       ├─→ Interact with Models
       └─→ Query Database
           │
           ▼
       View/JSON Response
           │
           ▼
   Middleware (Response)
           │
           ▼
   Browser
```

---

This visual documentation provides a comprehensive overview of the AdLinker system architecture and workflows. Use these diagrams as reference when developing or understanding the system.
