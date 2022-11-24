# API Specs

## Auth

### Login

- Method: POST
- Endpoint: `/api/v1/login`
- Header:
  - Accept: application/json
  - Content-Type: application/json
- Body:

```json
{
    "email": "string",
    "password": "string, min:8",
    "device_name": "string"
}
```
- Response:

```json
{
    "message": "Login success",
    "data": {
        "token" : "string, unique",
        "user_name": "string"
    }
}
```

### Logout

- Method: POST
- Endpoint: `/api/v1/logout`
- Header:
    - Authorization : Bearer Token
- Response:

```json
{
    "message": "string"
}
```
