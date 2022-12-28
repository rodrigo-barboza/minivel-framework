# minivel-framework
A mini php framework inspired by Laravel

## Routing
The default route file is "web.php", actually the request methods are only GET and POST. if you can add a route you can do this:

### With annonymus functions

    $this->get('', function() {
        echo 'welcome. ';
    });

Where the first param is a path of route. This route makes a get request and excecute the anonymus function there.

### With controllers
The first parameter is the route path and the second parameter is an array with the first position being the path of the controller starting from the root folder (default) "modules", and the second position is the specified controller action.

    $this->get('home', ['controllers/HomeController', 'index']);

### Dynamic routing
You can do requests with dynamic routes passing params between keys:

    $this->get('home/{id}', ['controllers/HomeController', 'index']);

And you can access this value of dynamic route on the specified controller:

    public function index($data)
    {
        echo "received id by dynamic route: ". $data['id'];
    }

