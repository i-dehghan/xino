<img style="width: 100%;" src="resources/img/xino.png">

## Install Project

- composer install.
- ./sail build
- ./sail up -d

## About Project
- The purpose of this app is add dynamically config to default laravel configs.
By default we can create config file in Config folder and use own custom config.
- but in this app we create a table with name configs that maintains my custom configs per types.
table structure is key-value and key is unique.
- in config controller we write crud base solid principle, use clean code and document methods.
config module have a service that connect controller to repository.
we can call config service and use every method of config.
repository.
- you can use crud methods with api and use service getSystemConfig to get config per name and list of configs.

