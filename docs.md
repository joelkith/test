FORMAT: 1A

# TestDocumentation

# Login

## Login as a user. [POST /auth/login]
Middleware Guest

+ Request (application/json)
    + Body

            {
                "email": "email",
                "password": "string"
            }

+ Response 200 (application/json)
    + Body

            {
                "status": "ok",
                "token": "token",
                "expires_in": "ttl in minutes"
            }

# Forgot Password

## User forgot password. [POST /auth/recovery]


+ Request (application/json)
    + Body

            {
                "email": "email"
            }

+ Response 200 (application/json)
    + Body

            {
                "status": "password sent"
            }

# Reset Password

## Reset user's password after forgot password request. [POST /auth/reset]
After resetting, it invalidates the token used to change the password and issues a new token.

+ Request (application/json)
    + Body

            {
                "password": "string",
                "password_confirmation": "matching password field"
            }

+ Response 200 (application/json)
    + Body

            {
                "status": "ok",
                "token": "token",
                "expires_in": "ttl in minutes"
            }

# Logout

## Logout the user and invalidate the token. [POST /auth/logout]


+ Request (application/json)
    + Body

            []

+ Response 200 (application/json)
    + Body

            {
                "message": "Successfully logged out"
            }