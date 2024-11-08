# Test Data Storage API

## Requirements

Make sure you have docker installed on your machine.

## Setup and Running the Application

### 1. Setup

In the project folder, run these commands to build and run the Docker image:

```bash
docker build -t whmcs-test .
docker run -d -p 8080:8080 --name whmcs-test -v $(pwd):/var/www/html whmcs-test
```
_*Volume is passed to view the generated file without entering the container_

### 2. Usage

#### Send a POST request

To use the API, send a `POST` request to `http://localhost:8080/api.php` with the following JSON data:

```json
{
  "source": "example",
  "payload": {
    "email": "user@example.com",
    "name": "John Doe"
  }
}
```

#### Run tests

To run the test, execute the follwing command:

```bash
docker exec whmcs-test ./vendor/bin/phpunit tests
```