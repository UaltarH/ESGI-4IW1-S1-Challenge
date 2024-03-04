# ESGI-4IW1-S1-Challenge
Challenge Semestriel 4IW1 S1 
## Contributors
@mathieuPvss @UaltarH

## Description
### Presentation
TechCare

Une appli de gestion de devis/factures pour les professionnels de la réparation d'appareils électroniques (PC, Tablette, Laptop, smartphone etc..)

### Links

- Design guide : [gauthierlo.fr/design-guide](https://gauthierlo.fr/design-guide)
- [Figma](https://www.figma.com/file/EuPrtnvbAS47qctvKVdVQa/Maquette?type=design&node-id=48%3A3&mode=design&t=Mz4atjCaNVXF4s7s-1) : Moodboard, components, PC and Mobile model
- [Personas](https://docs.google.com/document/d/1c7YCqi9ueTfaiMFdBP9AVpnFgzDwBnv3SVf198GYIHk/edit?usp=sharing)
  
### Symfony Docker (PHP8 / Caddy / Postgresql)

A [Docker](https://www.docker.com/)-based installer and runtime for the [Symfony](https://symfony.com) web framework, with full [HTTP/2](https://symfony.com/doc/current/weblink.html), HTTP/3 and HTTPS support.

### Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/)
2. Run `docker compose build --pull --no-cache` to build fresh images
3. Run `docker compose up` (the logs will be displayed in the current shell) or Run `docker compose up -d` to run in background 
4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
5. Run `docker compose down --remove-orphans` to stop the Docker containers.
6. Run `docker compose logs -f` to display current logs, `docker compose logs -f [CONTAINER_NAME]` to display specific container's current logs


## Prod 

1. `docker compose down`
2. `docker system prune -a`
3. `SERVER_NAME=DOMAIN_NAME APP_SECRET=PASS_OF_SERV CADDY_MERCURE_JWT_SECRET=ChangeThisMercureHubJWTSecretKey docker compose -f docker-compose.yml -f docker-compose.prod.yml up -d --wait`
4. `docker compose exec php npm i --force`
5. `docker compose exec php npm run build`
6. `docker compose exec php bin/console d:m:m:`

   
