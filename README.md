#Description
>[demo]('https://taskerok.000webhostapp.com/')

path|setting
-|-
config/**configDB.php** | _data of connection_
install/**tables.php** | _data about struct tables_

####For set routes

>method **route** define path and must be call **first**
>method **get** define handling for _get request_
>method **post** define handling for _post request_
>method **all** define handling for _any request_

```php
$router = new core\Router();
$router->route('/')->get('controller.getAction')->post('controller.postAtcion');
```
>method **controller** and **action** will be converted (_upper case first letter_)

####For run routes
```php
$router->run();
```