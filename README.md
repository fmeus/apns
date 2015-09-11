Apple Push Notifications - certificates
=======================================

Additional information on creating the p12 certificates and the test script, see [this blogpost][post].

`p12_to_pem.sh` -- Convert a p12 certifcate/key into PEM format
	Also removes the passphrase from the personal key and combines both the certificate and personal key into a single PEM file

`apns_test.php` -- Script to test APNS certificates by sending a push notification using both the Sandbox and Production certificate

[post]: http://sharedmemorydump.net/renewing-apns-certificates-ios