### Solving Google OAuth cURL Error cURL error 60: SSL certificate problem: unable to get local issuer certificate

Assuming On windows
```
XAMPP server
```
similar for other environment - download and extract for cacert.pem here (a clean file format/data)

https://curl.haxx.se/docs/caextract.html

put it here
```
C:\xampp\php\extras\ssl\cacert.pem
```

in your php.ini put this line in this section ("c:\xampp\php\php.ini"):
```
;;;;;;;;;;;;;;;;;;;;
; php.ini Options  ;
;;;;;;;;;;;;;;;;;;;;

curl.cainfo = "C:\xampp\php\extras\ssl\cacert.pem"
```

restart your webserver/apache

(source: https://laracasts.com/discuss/channels/general-discussion/curl-error-60-ssl-certificate-problem-unable-to-get-local-issuer-certificate)