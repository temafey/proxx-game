Proxx game microservice
============
 Backend service. Part of the microservice core that contains business logic.

## Implementations

- [x] Environment in Docker
- [x] Command Bus, Event Bus

## Stack

- PHP 8.1

## Requests



## Project Setup

Up new environment:

`make install`

See all make commands

`make help`

Full test circle

`make test`

Execute tests:

`tests-unit` 
`tests-integration`

Static code analysis:

`make style`

Code style fixer:

`make coding-standards-fixer`

Code style checker (PHP CS Fixer and PHP_CodeSniffer):

`make coding-standards`

Psalm is a static analysis tool for finding errors in PHP applications, built on top of PHP Parser:

`make psalm`

PHPStan focuses on finding errors in your code without actually running it.

`make phpstan`

Phan is a static analyzer for PHP that prefers to minimize false-positives. Phan attempts to prove incorrectness rather than correctness.

`make phan`

Deptrac is a static code analysis tool that helps to enforce rules for dependencies between software layers in your PHP projects.

`make layer`

Security Checker is a command line tool that checks if your application uses dependencies with known security vulnerabilities. It uses the Security Check Web service and the Security Advisories Database.

`security-tests`

Enter in php container:

`make php-shell`

Watch containers logs

`make logs`

### Implementation

```
├── src (Core bounded context)
│   ├── Application
│   │   ├── CommandHandler
│   │   ├── QueryHandler
│   │   ├── Dto
│   │   ├── Projector
│   │   ├── Saga
│   │   └── Service
│   ├── Domain
│   │   ├── Entity
│   │   ├── Command
│   │   ├── Query
│   │   ├── Event
│   │   ├── Exception
│   │   ├── Factory
│   │   ├── Service
│   │   └── ValueObject
│   ├── Infrastructure
│   │   └── Repository
│   │   └── Service
│   └── Presentation
│       ├── Cli
│       └── Rpc
└── tests
    ├── Integration
    │   ├── Application
    │   └── Presentation
    └── Unit
        ├── Application
        ├── Domain
        └── Infrastructure
```
