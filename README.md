![GoCardless](https://s3-eu-west-1.amazonaws.com/gocardless-logos/lo-res.jpg)

# York UK Hosting Fork v1.1.0-YUH

This is a fork of v1.1.0 created by York UK Hosting. The fork implements 
the following:

1. Fixes the callback 500 error
2. Account level billing rather than product/service level. A single
   agreement can then used to bill for any invoice.
3. Supression of 'payment failed' emails to prevent confusion
4. Support to request GoCardless payments X days ahead of invoice due date
   to ensure payments are received by the due date rather than after.
5. Store the PreAuth in a separate table so that GoCardless can be used
   alongside a credit/debit card within a single account.

Installation:

The contents of GoCardless_WHMCS directory needs to be copied to the
/modules/gateway directory. The gocardless_hook.php file in the gocardless
subdirectory should be moved to /includes/hooks and the two parameters
modified as required.

v6 compatibility - It has not been tested but it uses init.php and does
not use any templates so will hopefully work. If you do test let me
know the outcome - github@yorkukhosting.com.

# Announcement

__As of 15th August 2013, the GoCardless WHMCS module will no longer be supported.__
You are, however, welcome to continue using the module indefinitely. 

If changes to WHMCS break the module, it is likely that we will release fixes,
but technical assistance will not be available.

The module is open source, so anyone is welcome to modify and distribute the
module as they see fit.

## GoCardless WHMCS Module

The GoCardless WHMCS module provides a simple way to use GoCardless from within WHMCS.

## Requirements

You must have WHMCS version 5.1.2 or later to use this WHMCS module.

### WHMCS 5.2 instructions

WHMCS introduced some breaking changes for modules. To make this module
compatible with v5.2, open both redirect.php and callback.php and follow the
instructions in the first couple of lines of the file.

## Getting started

1. [Download](https://github.com/gocardless/gocardless-whmcs/zipball/master) the latest version of the module.
2. Unzip the downloaded archive
3. Copy the contents of the GoCardless_WHMCS directory into `your_whmcs_install/modules/gateways` so that it replaces the existing version
4. Follow our [dedicated guide](https://gocardless.com/partners/whmcs) to using the module on the GoCardless site

## Support

__As of 15th August 2013, the GoCardless WHMCS module will no longer be supported.__
You are, however, welcome to continue using the module indefinitely. 

If changes to WHMCS break the module, it is likely that we will release fixes,
but technical assistance will not be available.

The module is open source, so anyone is welcome to modify and distribute the
module as they see fit.

## Changelog

__v1.1.0__

* Designed for __variable payments__ - now always uses a £5000 pre-auth
* Always use the "mark as paid instantly" option - WHMCS will still be updated
down the line if there is a failure
* Updates descriptions on pre-authorisations and individual payments
* Prevents customers from setting up multiple pre-authorizations if there is
one set up but not yet billed again for an invoice
* General bug fixes

__v1.0.5__

* Updates for compatability with
[WHMCS Version 5.2](http://docs.whmcs.com/Version_5.2_Release_Notes)

__v1.0.4__

* Fixes an issue where the first payment amount differs from the recurring amount
* Improves support for WHMCS installations with SSL enabled
* Improves logging where WHMCS tries to capture payment for an invoice which
already has a pending bill on GoCardless

__v1.0.3__

* Fixes an issue with connection to our SSL service experienced on some environments

__v1.0.2__

* Fixes issue with the GoCardless payment button in Internet Explorer - only affects a subset of WHMCS installations

__v1.0.1__

* Updates the WHMCS cron so any issues whilst collecting do not affect other payment gateways

__v1.0__

* Adds support for setup fees, allowing one-off products at the beginning of a recurring package
* Support for GoCardless Sandbox mode
* Added "Instant Activation" option to mark payments as paid straight away, rather than waiting for feedback from GoCardless
* Reliability improvements and bug fixes

__v.01__

* Initial release
