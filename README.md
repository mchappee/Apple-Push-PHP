# Apple-Push-PHP
A completely self-contained php script for apple push notifications using HTTP/2.  Everything else that I found required a ton of 3rd-party module bullshit hell like composer and "Rando-John's Extra-Special PHP Lib" with redundant functions.  This relies on php, json, curl, and openssl.  All of these modules are standard in most distros.

You'll have to know your Apple Dev info.  Here's a little help with the variables:
- $teamid can be found on the Apple developer account page under "Membership".
- $bundleid can be found in XCode as "Bundle Identifier".
- $devicetoken is the, uh, device token of the device you're pushing a message to.
- $authkeyid can be found in your Dev account under "Certificates, Identifiers & Profiles", then "keys", then choose/create your push key, then "Key ID".
- $authkeyfile this is the pem-encoded AuthKey referenced above.  I hope you saved it because you don't get to re-download it.  You must convert it to a .pem file.  I used the following command:  openssl pkcs8 -nocrypt -in AuthKey.p8 -out AuthKey.pem

If you fill those out correctly you'll get an "HTTP/2 200" response, otherwise match the error code to this list:
https://developer.apple.com/documentation/usernotifications/setting_up_a_remote_notification_server/handling_notification_responses_from_apns

