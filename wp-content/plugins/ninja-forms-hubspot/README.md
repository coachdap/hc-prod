# Ninja Forms Hubspot Integration

## Installation for Development

### Installation Steps

- Clone from Github
    - `git clone name`
    - `cd name`
- Install Composer dependencies
    - `composer install`
- (Optional) Install Local Integration Test Runner
    - This requires the installation of [Docker](https://docs.docker.com/install/). This step is optional.
    - Build images
        - `docker-compose build`
    - Start containers and leave them running:
        - `docker-compose up -d`
    - Install tests inside of WordPress PHPunit container:
    - `docker-compose run --rm wordpress_phpunit bash ./bin/install-wp-tests.sh wordpress_test root example mysql trunk`
    
## Development

## Structure And Conventions

- This plugin supports PHP 7.2 or later only.
- We use a PSR-4 autoloader. File and class name must follow that convention.
 

### Directories
- `/lib`
    - This plugin was generated from the email-crm monorepo. It includes a re-namespaced copy of those dependencies in `/lib`.
    - This code is now owned by this repo. You can make changes to it and delete unneeded parts. It is not connected to any upstream. It should slowly get moved into the `/src` directory.
- `/src`
    - The PHP code 
- `/tests`
    - The tests. Please remove this directory before release.
- `/assets`
    - CSS and JavaScripts
    
### Testing

The tests for this plugin are separated into unit tests, which do no run with the WordPress database, and integration tests that do.

- Run unit tests
    - `composer test:unit`
- Run WordPress integration tests
    - If using docker-compose:
        - `docker-compose run --rm wordpress_phpunit composer test:integration`
    - If you have installed the necessary dependencies on your personal computer:
    - `composer test:wordpress`
- Lint and fix code style
    - `composer lint`    

    
## Git Workflow

@todo

## Releasing Updates To NinjaForms.com

@todo
