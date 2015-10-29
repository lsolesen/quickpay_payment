OVERVIEW
========

This module works as an integration between the Danish payment 
gateway provider QuickPay.dk. 

It supports the QuickPay v10 platform which is not supported by 
the regular Quickpay package.

It is currently compatible with Drupal Commerce.

The project consists of two modules. A core module which is used as a code 
base for submodules, i.e. the Commerce package.

Development of these modules has been sponsored by QuickPay themselves.

=== NOTICE ===

Your QuickPay account must created be on the new QuickPay v10 platform. 
If you are not sure what platform you are on, please contact 
the QuickPay support team.


AUTHOR / MAINTAINER
===================
Patrick Tolvstein, Perfect Solution ApS
info@perfect-solution.dk

CHANGELOG
===================
= 1.1.0 - 29/10-2015 =
* Add UberCart module to the project.
* Add text_on_statement setting.
* Add order number prefix on order numbers sent to QuickPay.
* Add Paii support.
* Add customer email for PayPal support.
* Add Google Analytics.
* Add permission check on callback handlers.
* Fix problem with card icons not being shown correctly on some installs.
* Add order number reference on API payment authorizations.
* Add tax support for Paii.