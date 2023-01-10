# Changelog

All notable changes to `smsportal-laravel` will be documented in this file

## 1.1.1 - 2023-01-10

 - Added sendAt parameter to sendSMS (expects time in GMT+2 as YYYY-MM-DD HH:MM:SS, eg 2023-01-10 12:12:11)
 - Added new unit test for new sendAt paramenter
 
## 1.1.0 - 2023-01-06

- Added ability to send a single message to multiple numbers at once, including text replacements
- Added custom exception classes
- Added unit tests
- Added a test mode config setting so that SMS can be tested without actually being sent during dev/testing

## 1.0.0 - 201X-XX-XX

- initial release

