#!/bin/bash
# Script to convert p12 to pem and remove pass pharse

# Sandbox/Development certificate and key
openssl pkcs12 -clcerts -nokeys -out apns-dev-cert.pem -in apns-dev-cert.p12 
openssl pkcs12 -nocerts -out apns-dev-key.pem -in apns-dev-key.p12
openssl rsa -in apns-dev-key.pem -out apns-dev-key-noenc.pem

# Production certificate and key
openssl pkcs12 -clcerts -nokeys -out apns-prod-cert.pem -in apns-prod-cert.p12 
openssl pkcs12 -nocerts -out apns-prod-key.pem -in apns-prod-key.p12
openssl rsa -in apns-prod-key.pem -out apns-prod-key-noenc.pem