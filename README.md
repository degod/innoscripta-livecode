## INTRODUCTION

This was a live coding assessment for the role of a Backend Web Developer at Innoscripta.

## THE CHALLENGE

The challenge is to build the backend functionality for a transaction import command that pulls invoices and their transactions from a given source, store in the DB and serve them via API.

## PRE-REQUISITE FOR SETUP

-   Docker desktop
-   Web browser (to view swaggerUI API documentation)
-   Terminal (git bash)

## HOW TO SETUP

-   Make sure your docker desktop is up and running
-   Launch you terminal and navigate to your working directory

```bash
cd ./working_dir
```

-   Clone repository

```bash
git clone https://github.com/degod/innoscripta-livecode.git
```

-   Move into the project directory

```bash
cd innoscripta-livecode/
```

-   Copy env.example into .env

```bash
cp .env.example .env
```

-   Build app using docker

```bash
docker compose up -d --build
```

-   Log in to docker container bash

```bash
docker compose exec app bash
```

-   Install composer

```bash
composer install
```

-   Create an application key

```bash
php artisan key:generate
```

-   Run database migration and seeder

```bash
php artisan migrate:fresh --seed
```

## RUNNING THE APPLICATION JOB AND TESTING

-   Run the fetch command to get latest transactions (kindly use keys sent via email to populate provider keys in .env first)

```bash
php artisan app:import-transaction
```

PS: You can add params to the console as such `php artisan app:import-transaction 1 100` (page = 1, limit = 100)

-   Just to check if all is fine using the test

```bash
php artisan test
```

## ACCESSING THE API DOCS AND DATABASE

-   To access application, visit
    `http://localhost:9030`

-   To access application's database, visit
    `http://localhost:9031`

## CONTRIBUTING

Please open issues or pull requests against this repository. Follow existing code style and update tests where appropriate.

---

If you want, I can also add a short troubleshooting section based on any errors you see when trying these steps locally. What would you like me to add or change in this README?
