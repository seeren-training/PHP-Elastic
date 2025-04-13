# Sandbox

## Prerequist

- [Docker](https://www.docker.com/) ^28.0

## Configuration

Generate secrets

```bash
mkdir secrets
```

```bash
openssl rand -base64 -out secrets/db-password.txt 32 
```

## Run

```bash
docker compose up
```

Services availables:

- Web server: http://localhost:9000
- Kibana: http://localhost:5601

## Usage

### Features

This boilerplate provide data-fixtures, migration and route to explore Elastic search.

### Commands

Run commands inside container
```bash
docker exec -it server bash
```

Regenerate schema and seed data:

```bash
composer migrate
```

