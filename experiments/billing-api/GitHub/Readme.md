 # [GitHub billing](https://docs.github.com/en/rest/reference/billing)

[An introduction to curl using GitHub's API.](https://gist.github.com/joyrexus/85bf6b02979d8a7b0308)


## Root endpoint

```
curl https://api.github.com

```

## Basic authentication

```
curl -user "username" https://api.github.com

```


## Get GitHub Actions billing for a user

```
curl \
  -H "Accept: application/vnd.github.v3+json" \
  https://api.github.com/users/USERNAME/settings/billing/actions
```

* Copy curl command from browser

```
curl 'https://github.com/settings/billing/actions_usage' \
  -H 'authority: github.com' \
  -H 'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="96", "Google Chrome";v="96"' \
  -H 'accept: text/html' \
  -H 'x-requested-with: XMLHttpRequest' \
  -H 'sec-ch-ua-mobile: ?1' \
  -H 'user-agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Mobile Safari/537.36' \
  -H 'sec-ch-ua-platform: "Android"' \
  -H 'sec-fetch-site: same-origin' \
  -H 'sec-fetch-mode: cors' \
  -H 'sec-fetch-dest: empty' \
  -H 'referer: https://github.com/settings/billing' \
  -H 'accept-language: en-US,en;q=0.9,el;q=0.8' \
  -H 'cookie:...' \ 
 --compressed

```

##  Get GitHub Packages billing for a user

```
curl \
  -H "Accept: application/vnd.github.v3+json" \
  https://api.github.com/users/USERNAME/settings/billing/packages
```

* Copy Curl command from browser 

```
curl 'https://github.com/settings/billing/packages_usage' \
  -H 'authority: github.com' \
  -H 'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="96", "Google Chrome";v="96"' \
  -H 'accept: text/html' \
  -H 'x-requested-with: XMLHttpRequest' \
  -H 'sec-ch-ua-mobile: ?1' \
  -H 'user-agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Mobile Safari/537.36' \
  -H 'sec-ch-ua-platform: "Android"' \
  -H 'sec-fetch-site: same-origin' \
  -H 'sec-fetch-mode: cors' \
  -H 'sec-fetch-dest: empty' \
  -H 'referer: https://github.com/settings/billing' \
  -H 'accept-language: en-US,en;q=0.9,el;q=0.8' \
  -H 'cookie:...' \
 --compressed

```
## Get shared storage billing for a user

```
curl \
  -H "Accept: application/vnd.github.v3+json" \
  https://api.github.com/users/USERNAME/settings/billing/shared-storage
```

* Copy Curl command from browser 

```
curl 'https://github.com/settings/billing/shared_storage_usage' \
  -H 'authority: github.com' \
  -H 'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="96", "Google Chrome";v="96"' \
  -H 'accept: text/html' \
  -H 'x-requested-with: XMLHttpRequest' \
  -H 'sec-ch-ua-mobile: ?1' \
  -H 'user-agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Mobile Safari/537.36' \
  -H 'sec-ch-ua-platform: "Android"' \
  -H 'sec-fetch-site: same-origin' \
  -H 'sec-fetch-mode: cors' \
  -H 'sec-fetch-dest: empty' \
  -H 'referer: https://github.com/settings/billing' \
  -H 'accept-language: en-US,en;q=0.9,el;q=0.8' \
  -H 'cookie:...' \
 --compressed
```


