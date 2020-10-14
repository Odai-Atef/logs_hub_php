# Custom Logs File generator for LOGS HUB Python 3

### Installation

composer require logs/logs_hub

### Available functions 
We have 4 types of logs:
 - warning
 - error
 - critical
 - info

### Function Parameters
For each function we have five parameters three of them are required and the others are optional
 - message (*)
 - level (*)
 - application (*)
 - user_id
 - extra_data

### env file
The file contains the path of logs file and code for each level

### Usage & Examples
use logs\logs_hub;
$logs = new logs_hub();

- $logs->warning("MESSAGE","NEWS",3,{"key":"value"});
- $logs->error("MESSAGE","NEWS",3);
- $logs->info("MESSAGE","NEWS");
- $logs->critical("MESSAGE","NEWS",None,{"key":"value"});


License
----
Odai Atef
**Free to use**