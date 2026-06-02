Custom WooCommerce Subscription System

A lightweight, secure, and PHPCS-compliant WordPress plugin that adds custom subscription functionality to WooCommerce without relying on the official WooCommerce Subscriptions extension.

This plugin was built for WPAegis to provide manual subscription handling, including expiration logic, renewal flows, reminder emails, and frontend visibility — all using standard WooCommerce products.

Overview

WPAegis Custom WooCommerce Subscriptions allows you to mark regular WooCommerce products as subscription-based products, define their duration, and automatically manage:

Subscription expiry dates

Reminder and expiry emails

Renewal links

Customer-facing subscription information

Cart restrictions for subscription products

The plugin is built using modern WordPress best practices, follows WordPress Coding Standards (PHPCS), and uses a clean, modular file structure for maintainability.

Features

Product-Level Subscription Controls

Enable/disable subscription per product

Select subscription duration (1 Month / 1 Year)

Secure meta saving with nonce validation

Subscription Lifecycle Management

Automatic expiry date calculation on order completion

Scheduled cron jobs for:

7-day expiry reminder

Expiry handling

Safe cron scheduling (prevents duplicate events)

Email Notifications

Reminder email before subscription expiry

Expiry notification email

Uses WooCommerce’s native mailer system

Customer Experience

Displays subscription expiry date on:

My Account → Orders

Order details page

Renewal button linking directly to checkout

Cart & Checkout Rules

Prevents multiple subscription products in the cart

Automatically removes old subscription products if a new one is added

Empties cart after successful checkout

Code Quality & Security

Fully PHPCS-compliant (WordPress standard)

Object-oriented architecture

No anonymous functions

Proper sanitization, escaping, and nonce verification

Namespaced meta keys and hooks (WPAegis-prefixed)
