# minivel-framework
A mini php framework inspired by Laravel developed by Rodrigo Barboza

## Routing
The default route file is "web.php", currently supported request methods are only GET and POST. To add a route you can do this:

### With anonymous functions

```php
    $this->get('', function() {
        echo 'welcome. ';
    });
```

Where the first param is a path of route and the second param is a anonymous function. This route makes a get request and excecute the anonymous function.

### With controllers
The first parameter is the route path and the second parameter is an array with the first position being the path of the controller starting from the root folder (default) "modules", and the second position is the specified controller action.

```php
    $this->get('home', ['controllers/HomeController', 'index']);
```
### Dynamic routing
You can do requests with dynamic routes passing params between keys:

```php
    $this->get('home/{id}', ['controllers/HomeController', 'index']);
```

And you can access this value of dynamic route on the specified controller:

```php
    public function index($data)
    {
        echo "received id by dynamic route: ". $data['id'];
    }
```