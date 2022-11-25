# API Specs

## Auth

### Login

- Method: `POST`
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
    "message": "string",
    "data": {
        "token" : "string, unique",
        "user_name": "string"
    }
}
```

### Logout

- Method: `POST`
- Endpoint: `/api/v1/logout`
- Header:
    - Authorization : Bearer Token
- Response:

```json
{
    "message": "string"
}
```

### User Profile

- Method: `GET`
- Endpoint: `/api/v1/user`
- Header:
    - Authorization : Bearer Token
- Response:

```json
{
    "id": "integer",
    "role_id": "integer",
    "name": "string",
    "email": "string",
    "email_verified_at": "datetime",
    "created_at": "datetime",
    "updated_at": "datetime",
    "nip": "string",
    "phone_number": "string",
    "address": "string",
    "birthdate": "date",
    "birthplace": "string"
}
```
