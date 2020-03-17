# Jakmall Calculator

## Software Requirements
- Docker
- MySQL

## Vendor installation
```
./composer install
```
## Run the Calculator
```
./calculator
```

## Configuration Data
```
Database configuration : ./config/database
File configuration : ./config/file

ps: Data stored file location on folder ./data
```

## Run Migration
```
"vendor/bin/doctrine" orm:schema-tool:update --force --dump-sql
```
