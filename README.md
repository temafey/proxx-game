Proxx game microservice
============
 Backend service. Part of the microservice core that contains business logic.

## Implementations

- [x] Environment in Docker
- [x] Command Bus, Event Bus
- [x] EventSourcing
- [x] Snapshotting
- [x] Saga pattern

## Stack

- PHP 8.1
- PostgreSQL 14
- Symfony 6

## Project Setup

Up new environment:

`make install`

Start new game:

`make game-start`

See all make commands

`make help`

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
├── Proxx (Core bounded context)
│   ├── Application
│   │   ├── CommandHandler
│   │   ├── Saga
│   ├── Domain
│   │   ├── Entity
│   │   ├── Command
│   │   ├── Event
│   │   ├── Factory
│   │   └── ValueObject
│   ├── Infrastructure
│   │   └── Repository
│   └── Presentation
│       ├── Cli
└── tests
```
