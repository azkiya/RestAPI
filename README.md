REST API NEWS-TOPIC
==========

### Requirement
- PHP 7 or higher
- MySQL 5.5 or higher

### Local Setup
- `git clone git@github.com:azkiya/RestAPI.git`
- `cd RestAPI`
- `composer update`
- `bin/console doctrine:migrations:status`
- `bin/console doctrine:migrations:diff` if there are any changes on entity
- `bin/console doctrine:migrations:migrate` to sync entity with database
