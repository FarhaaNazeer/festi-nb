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


## Pousser notre branch sur le repo distant 

git push --set-upstream origin feature/nom-de-ma-branche

## Faire ma PR

Cliquer sur le lien qui a été généré dans mon terminal pour directement ouvrir ma pull request
M'assigner ma pull request
Identifier les autres membres du groupe


## Process - Merge branch 
Vérifier que l'on a pas de changement en stage sur notre branch 

1. Se positionner sur la develop : git checkout develop 
2. Se mettre à jour sur la develop : git pull --rebase origin develop 
3. Vérifier combien j'ai de commit sur ma PR

4. Si 1 commit -> git merge feature/nom-de-ma-branch --no-ff
5. Si + 1 commit -> git merge feature/nom-de-ma-branch

## Access different container

Festinb -> http://localhost:8000

Adminer -> http://localhost:8080

MailDev -> http://localhost:8081
