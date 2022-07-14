# Festi-nb

## Installation

Install container

```bash
docker compose up -d
```

Install composer

```bash
docker compose exec www composer install
```

Update BDD

```bash
docker compose exec www php bin/console doctrine:schema:update --force
```

Install yarn

```bash
docker compose exec www yarn install
```

Build css and js

```bash
docker compose exec www yarn build
```

Add fake data

```bash
docker compose exec www php bin/console doctrine:fixture:load
```

## Usage

Enter in container

```bash
docker compose exec www bash
```

Build css and js for dev

```bash
docker compose exec www yarn watch
```

## Command git

Add branch

```bash
git banch feature/name_feature
```

Delete branch

```bash
git branch -d feature/name_feature
```

## Access different container

Festinb -> http://localhost:8000

Adminer -> http://localhost:8080

MailDev -> http://localhost:8081
