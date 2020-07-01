# DeBounce.io Email Validator

> This is a fork of the official WP Plugin [DeBounce.io Email Validator](https://wordpress.org/plugins/debounce-io-email-validator/)

## Fork Improvements

I've added some options to minimize the number of API calls:

* **Replaced wp_cache with wp_transient.**
Allow also cache API calls if not external cache available.
* **Added option to only verify emails that are not among your users.**
Avoid re-checking email on users or clients that already exist when login.
* **Added WooCommerce billing and shipping email verification.**
Allow check order emails if is not hooked `is_email()` validation.
* **Fixed "on registration" hook & added on WooCommerce registration hook.**
Replaced correct hook filter for user registration and added filter for WooCommerce customer registration.
