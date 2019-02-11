# CodeIgniter Utils

A collection of common libraries for everyday CodeIgniter application development.

This repo contain the common elements in my CI projects, extracted here for reusability sake.
  
## Non-composer Installation
```
+ Download repository
+ Copy/move to application/third-party
+ Edit application/config/autoload.php and add `$autoload['packages'] = array(APPPATH . 'third_party/ci-utils');`
```

## Composer Installation
```
$ composer require isaiahiroko/ci-utils
```

## Usage

### If you intend to use ci-utils's hooks:
+ Edit `application/config/config.php` and add `$config['enable_hooks'] = TRUE;`
+ Edit `application/config/hooks.php` and add `[hooks array]`

### For advance configuration:
+ Edit `application/third_party/ci-utils/config/config.php` as you choose

# Documentation
### Configs
### Core
#### Base Model
#### Base Controller
#### Base API Controller

### Helpers
#### Utils
+ `to_slug`
    Paremters: `$slug` e.g to_slug('one:two')
    Returns: one/two

+ `starts_with`
+ `ends_with`
+ `fill_array`
+ `array_group_by_keys`
+ `prettify`
+ `uglify`
+ `to_primary`
+ `to_at`
+ `to_src`
+ `to_number`
+ `to_money`
+ `to_boolean`
+ `to_view`
+ `to_actions`
+ `is_array_equal`
+ `d`
+ `dd`
+ `rearrange_uploaded_files_array`

### Libraries/Services
#### Authentication $ Authorization
##### Auth
Class name: `libraries\Actions_service.php`
Config file: `config\actions_service.php`

##### Gate
Class name: `libraries\Actions_service.php`
Config file: `config\actions_service.php`

##### Actions
Class name: `libraries\Actions_service.php`
Config file: `config\actions_service.php`

This service library generates standard anchor links for entities (collection, solo and form) views as arrays, and ensure the generated anchor links satisty the current user access policy. Custom actions can also be easily generated using the meta-data defined in the configuration file. 

#### Documents & Files
##### JSON  
##### Spreadsheet 
##### PDF
##### Upload 

#### Notification
##### Alert
Class name: `libraries\Actions_service.php`
Config file: `config\actions_service.php`

##### Notif
Class name: `libraries\Actions_service.php`
Config file: `config\actions_service.php`


#### Others
Class name: `libraries\Actions_service.php`
Config file: `config\actions_service.php`

##### App
Class name: `libraries\Actions_service.php`
Config file: `config\actions_service.php`

##### Activities
Class name: `libraries\Actions_service.php`
Config file: `config\actions_service.php`

##### Compressor
Class name: `libraries\Actions_service.php`
Config file: `config\actions_service.php`

##### HTTP 
Class name: `libraries\Actions_service.php`
Config file: `config\actions_service.php`

##### Inflector 
Class name: `libraries\Actions_service.php`
Config file: `config\actions_service.php`

##### Relationship 
Class name: `libraries\Actions_service.php`
Config file: `config\actions_service.php`

##### State 
Class name: `libraries\Actions_service.php`
Config file: `config\actions_service.php`

##### Table
Class name: `libraries\Actions_service.php`
Config file: `config\actions_service.php`

##### View
Class name: `libraries\Actions_service.php`
Config file: `config\actions_service.php`


### Storage
