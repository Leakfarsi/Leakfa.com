# Leakfa.com API Document
This document contains how to use the api service of leakfa.com
#### NOTE
* All the GET request arguments are sent in the URL
* All respond bodies are JSON format
---
#### search.php
```http
 GET /api/search.php
```
* Check data breaches
	* Request Argument
		* hash: *(required)* The sha1 of `Mobile or email address`.
		* mode: *(required)* `pow` or `recaptcha`.
		* nonce: (required if mode is set to `pow`) The string which makes the first 5 sha1 of `hash + nonce` equals to `aaaaa`.
		* token: (required if mode is set to `recaptcha`) The user response token provided by the reCAPTCHA client-side integration on your site.
	* Respond Body
		* status: The bool indicate that whether the query being failed or not.
		* error: The string of the error message.
		* result: The object which contain the information of leaked data.
		 		* key: The source of data breach
		 		* value: The array of strings which indicate which information was being leaked.
---
#### subscribe.php
```http
 GET /api/subscribe.php
```

---
#### stat.php
```http
 GET /api/stat.php
```
