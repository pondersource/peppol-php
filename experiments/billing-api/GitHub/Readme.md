# [GitHub billing](https://docs.github.com/en/rest/reference/billing)

Any free account has limited minutes for use(2000 action minutes per month for private repositories. Limits are per user/organization). By default, Actions will stop running when they are exceeded.

[An introduction to curl using GitHub's API.](https://gist.github.com/joyrexus/85bf6b02979d8a7b0308)


## Root endpoint

```
curl https://api.github.com

```

# [Getting started with the REST API](https://docs.github.com/en/rest/guides/getting-started-with-the-rest-api)

## Authentication 🐾

### Basic authentication

```
curl -user "username" https://api.github.com

```

#### To Authenticate with the GitHub API we will use [OAuth and personal access tokens](https://docs.github.com/en/rest/overview/other-authentication-methods#via-oauth-and-personal-access-tokens)

```
$ curl -i -u username https://api.github.com/users/octocat

OR

$ curl -i -u your_username:$token https://api.github.com/users/octocat

```

#### Withoud authenication we only have visibility to the public information. For example:

* Info only about public repositories

```
$ curl -i https://api.github.com/users/octocat/repos
```


* Info about public + private repositories

```
$ curl -i -H "Authorization: token $TOKEN"  https://api.github.com/users/octocat/repos

```
#### Try to get your own user profile

```
curl -i -u your_username:your_token https://api.github.com/user
```

## Get billing information for a user

### Get Actions 

```
curl \
  -H "Accept: application/vnd.github.v3+json" \
  https://api.github.com/users/USERNAME/settings/billing/actions
```


###  Get Packages

```
curl \
  -H "Accept: application/vnd.github.v3+json" \
  https://api.github.com/users/USERNAME/settings/billing/packages
```

### Get Shared Storage 

```
curl \
  -H "Accept: application/vnd.github.v3+json" \
  https://api.github.com/users/USERNAME/settings/billing/shared-storage
```

