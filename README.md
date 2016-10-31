# Simples
Projeto final de exemplo do curso básico de PHP
----
Imagine ter uma estrutura de projeto simples e intuitiva com apenas um comando.. Com Simples isso é possível. Se você tem um projeto pequeno, com poucas necessidades e poucos recursos pode simplesmente usar:
```
composer create-project phpzm/simples.cloud
```
ou
```
git clone https://github.com/phpzm/simples.cloud.git {dir}
cd {dir}
composer install
```
E sair usando feliz da vida recursos básicos para um desenvolver um site ou sistema em PHP

# Rotas
## Criando rotas

Rotas simples
```php
return function($router) {

    $router->on('GET', '/', function() {
       return 'Hello World!';
    });
}
```

Rotas dinâmicas
```php
return function($router) {

    $router->get('/:controller/:method', function($controller, $method) {
       return 'Hello World!';
    });
}
```

Grupos de Rotas
```php
return function($router) {

    $router->group('GET', '/site', ['more/files/routes.php', 'more/files/site.php']); //list of route files
    $router->group('*', '/api', 'api/routes');// dir with route files
}
```

Rotas com Interação com Controllers
```php
return function($router) {

    $router->post('/client/save', '\Namespace\ClientController@save');
    $router->resource('client', '\Namespace\ClientController');
}
```
Um `$router->resource` vai criar:<br>
<table>
<thead>
<tr>
  <th>Verb</th> <th>Path</th> <th>Action</th> <th>Route Name</th>
</tr>
</thead>

<tbody>
<tr>
<td>GET</td>
<td>
  <code class=" language-php">
    /route
  </code>
</td>
<td>index</td>
<td>route.index</td>
</tr>

<tr>
<td>GET</td>
<td>
  <code class=" language-php">
    /route/create
  </code>
</td>
<td>create</td>
<td>route.create</td>
</tr>

<tr>
<td>GET</td>
<td>
  <code class=" language-php">
    /route/{id}
  </code>
</td>
<td>show</td>
<td>route.show</td>
</tr>

<tr>
<td>GET</td>
<td>
  <code class=" language-php">
    /route/{id}/edit
  </code>
</td>
<td>edit</td>
<td>route.edit</td>
</tr>


<tr>
<td>POST</td>
<td>
  <code class=" language-php">
    /route
   </code>
</td>
<td>store</td>
<td>route.store</td>
</tr>

<tr>
<td>PUT/PATCH</td>
<td>
  <code class=" language-php">
    /route/{id}
  </code>
</td>
<td>update</td>
<td>route.update</td>
</tr>

<tr>
<td>DELETE</td>
<td>
  <code class=" language-php">
    /route/{id}
  </code>
</td>
<td>destroy</td>
<td>route.destroy</td>
</tr>
</tbody>
</table>
