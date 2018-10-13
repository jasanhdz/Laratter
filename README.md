# Curso de Php con Laravel

## ¿Porque laravel?
Laravel está orientado a apliaciones de desarrollo rápido, eso significa que tiene un monton de código ya implementado para nosotros y non necesitamos hacer tanto esfuerzo para tener un montón de funcionalidades muy modernas.
**Por ejemplo:**
- Notificaciones en tiempo real: donde conectamos una aplicación backend como **laravel** con un frontend como **vue.js** con laravel-eco.
- Login con redes sociales, que quizas sería un montón de configuración del lado de la aplicación y que **laravel-socialite** nos ahorra casí todo el trabajo.

## Installación

Lo que yo recomiendo para usuarios windows es descargar un entorno Todo en uno, que incluye php, mysql, apache, y otros servicios, en esté curso estaremos ocupando **XAMPP**. 
Una vez instalado xampp, procedemos a instalar composer, visitando la página oficial de composer y seguir las instrucciones.

Ahora que ya tenemos composer instalado lo que vamos a hacer es ir a la carpeta de **htdocs** que es la carpeta que usa xampp para entrar al servidor.

Nos colocaremos en esa ruta desde la Terminal y instalaremos Laravel de forma global dentro de composer con el siguiente comando. ```composer global require "laravel/installer"```.

Esto nos instalará **Laravel** de forma Global. Una vez instalado podremos crear proyectos Laravel en la carpeta que quieramos.

## Iniciar proyecto con Laravel

Para iniciar un nuevo proyecto en Laravel lo que tenemos que hacer es correr el comando en terminal: 
```php
# Indicamos que queremos crear un proyecto laravel nuevo y le pasamos un Nombre, que será la carpeta donde instalará todo el entorno laravel.
laravel new "NombreProyecto"
```

## Inicia el Proyecto de Laravel

Comenzaremos lanzando nuestro servidor de larevel y para inicializar el servidor utilizamos el comando “php artisan serve”
```php
php artisan serve
```
Laravel nos genera todos los archivos necesarios para nuestro web app ahora seguiremos construyendo nuestra aplicación, modificaremos nuestros archivos de rutas y cómo mostrar html en laravel, comenzaremos editando el archivo web.php aquí observamos que tenemos en view: welcome, este es el archivo que se nos mostró al entrar a localhost:8000 y lo podemos editar para ver los cambios.

## Agrega Rutas en el Controller y Templates de Blade

Ahora regresaremos a nuestro archivo web.php aprenderemos a agregar secciones de nuestro sitio implementando una página de “acerca de nosotros” en localhost:8000/acerca donde podemos mostrar información acerca de nuestra compañía o sitio web.
```php
Route::get('/about', function () {
return 'acerca de nosotros';
});
```
Ahora generaremos una vista para mostrar en la nueva sección de nuestro sitio recién creada, con esto vamos a crear una nueva vista y la haremos copiando el contenido de nuestro archivo welcome.blade.php y lo modificaremos apra crear nuestra vista “acerca de nosotros”.

## Blade: usando repeticiones y condicionales

Ahora veremos instrucciones para crear controllers y además instrucciones de flujo con BLADE cambiando los enlaces y la forma en la que los estamos generando.

La sintáxis ``{{ var }}`` equivale al comando echo de PHP.

La sintáxis para declarar un if:
```php
@if (isset($teacher))
                <p>Profesor: {{ $teacher }} </p>
                @else
                <p>Profesor a definir</p>
                @endif
```
Sintáxis para declarar un **ForEach** en blade:
```php
  @foreach ($links as $link => $text)
    <a href=" {{ $link }} " target="_blank"> {{$text}} </a>
  @endforeach
```
Debemos de Recordar que los valores que lee blade deben ser definidos y pasados por párametro dentro de un objeto donde creamos la ruta. **ejemplo:**
```php
Route::get('/', function () {
    $links= [
        'https://platzi.com/laravel' => 'Curso de Laravel',
        'https://laravel.com' => 'Página de laravel',
    ];
    return view('welcome', [
        'links' => $links,
        'teacher' => 'Guido Contreras Woda'
    ]);
});
```
## Controllers

los controllers son clases y objetos que vamos a usar para modelar los problemas a resolver, puntualmente resolver el problema de recibir iun pedido de la red y dar una respuesta.

Vamos a mejorar nuestra aplicación llevándonos el código que hicimos en el archivo de rutas hacia los controllers.

Esto lo haremos utilizando artisan primero recuerden tener activo su servidor y en otro servidor vamos a ejecurar el comando:
```php
php artisan make:controller --help
```
y aquí le pediremos ayuda para saber que argumentos requiere.

Ahora procederemos a crear nuestro controller utilizando php artisan make:controller PagesController y será creado exitosamente por último procederemos a mover las direcciones a nuestro controlador.

### Creando Controllador

En la terminal ejecutaremos el comando php artisan make:controller seguido del nombre que recibirá nuestro controlador.

Cuando el controlador hallá sido creado, lo que haremos es ir a la dirección ``Http\Controllers\PagesController.php`` que es el archivo que creamos desde la terminal.

Este PagesController no es más que una clase que será el controllador y dentro de ella, tendrá métodos que realizarán una *acción* cuando sean llamados en el **route**. Ejemplo:
```php
<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function getHome() {
        $links= [
            'https://platzi.com/laravel' => 'Curso de Laravel',
            'https://laravel.com' => 'Página de laravel',
        ];
        return view('welcome', [
            'links' => $links,
            'teacher' => 'Guido Contreras Woda'
        ]);
    }

    public function About() {
        return view('about');
    }
}
```

### Modificando route

Vamos a llevarnos la function que estámos realizando y vamos a llevarla al controlador, ahí es donde vamos a poner la lógica necesaria para responder al llamado de la ruta.

En la ruta unicamente le pasaremos, como párametro el nombre del controlador seguido de su action, ejemplo:
```php
Route::get('/', 'PagesController@getHome');
Route::get('/acerca', 'PagesController@About');
```
## Crea Layouts en Blade para Evitar la Duplicación de Código

Ahora vamos a aparender a crear Layouts para poder crear pagínas nuevas fácilmente, reutilizando código que nuestras páginas tendrán en común usaremos 3 comandos principales Layout files @extends @yield @section.

para crear templates o un html padre(layout) lo que vamos a hacer es crear una nueva carpeta, donde iremos poniendo los **layouts** que vamos a ir creando.

Dentro de la carpeta crearemos nuestro primer layout que se llamara: **app.blade.php** esté archivo contendra todo el html que queremos heredar, y donde el contenido sea modificado se colocarán **yield** para indicar que esa section podrá ser modificada.

Ahora en nuestro archivo que queremos mezclar con el layout, lo que haremos será:
1. Indicar que el archivo no está solo, lo que haremos será decir que el archivo hereda de otro con la palabra reservada ``@extends('name')``.
2. Agregaremos el HTML que queremos modificar o incluir envolviéndolo el las etiquetas 
```
@section('content') 
<Html>HTML que queremos incluir</Html>
@endsection
``` 
3. Una vez puesto estó podemos revisar que la mezcla de html se hallá realizado correctamente, de no ser así revisar las etiquetas @yield y @extends tengan los párametros correctos.

### ¿Qué hacer si quiero modificar una linea dinámicamente?

Para modificar una linea dinámicamente puedo hacer qué está linea sea modificado usando la etiqueta @yield, y a la vez puedo darle un valor por defecto en caso de que el valor no sea modificado o agregado.
Ejemplo:
```php
# En esté ejemplo lo haremos con la linea <title></title>
<title>@yield('title', 'Laratter by Platzi') </title>
```
- Como primer párametro le indicaremos el nombre de la section que tendrá este campo, y como segundo párametro le pondremos un valor por defecto en caso de no ser modificado.

- Si deseo modificarlo solo debo especificarlo en mi archivo. Y si no lo hago el valor por defecto se heredará.

## Integrando Boostrap 

Ahora agregaremos Bootstrap a nuestro proyecto para poder acelerar el proceso de desarrollo, en la sección de enlaces puedes acceder a la versión qu estaremos utilizando.

Vamos a empezar a desarrollar nuestro proyecto, vamos a borrar todo el contenido default de nuestro sitio y vamos a comenzar a diseñar la página principal de nuestro sitio.

1. Vamos a entrar a la página de **boostrap** y entraremos en la sección de descargas, ahi copiaremos el CDN, el que contrendrá un link y un script. El link lo pegaremos en el head, mientras que el script lo pondremos antes de cerrar la etiqueta **body**.
2. Entraremos al template de nuestro welcome.blade y pondremos el siguiente código
```html
<div class="jumbotron text-center">
    <h1>Laratter</h1>
    <nav>
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link" href="/">Home</a>
            </li class="nav-item">
            <li>
                <a class="nav-link" href="/acerca">Acerca de Nosotros</a>
            </li>
        </ul>
    </nav>
</div>
```
3. Ahora crearemos contenido dinámico usando images para mostrar en nuestro welcome.

Primero crearemos un *array* de nombre **messages** dentro de nuestro controlador antes de retornar la vista.
Este array va tener 4 objetos por ahora, con los valores de: **id, content e image.** 
```php
$messages = [
            [
                'id' => 1,
                'content' => 'Esté es mi primer mensaje',
                'image' => 'https://source.unsplash.com/category/nature/600x338?4',
            ],
            [
                'id' => 2,
                'content' => 'Esté es mi segundo mensaje',
                'image' => 'https://source.unsplash.com/category/nature/600x338?1',
            ],
            [
                'id' => 3,
                'content' => 'Esté es mi tercer mensaje',
                'image' => 'https://source.unsplash.com/category/nature/600x338?2',
            ],
            [
                'id' => 4,
                'content' => 'Otro mensaje más mensaje',
                'image' => 'https://source.unsplash.com/category/nature/600x338?3',
            ]
        ];
``` 
Las images serán requeridas de una api llamada [Unsplash](https://gersonlazaro.com/unsplash-api-miles-de-fotos-gratis-en-tu-sitio-web-o-aplicacion/).

4. Ahora en la vista vamos a crear una Fila donde vamos a mostrar los elementos de los objetos que creamos en la variable **message** 
5. Adentro del la fila crearemos un forEach para iterar los elementos del objeto e imprimir su valores del siguiente manera.
```html
<div class="row">
    @forelse ($messages as $message)
        <div class="col-6">
            <img class="img-thumbnail" src=" {{$message['image']}} " alt="">
            <p class="card-text">
                {{ $message['content'] }}
                <a href="/messages/{{ $message['id'] }}">Leer más</a>
            </p>
        </div>
    @empty
        <p>No hay mensajes destacados!</p>        
    @endforelse
</div>
```
- **ForElse** es un Foreach que tendra un else cuando no encuentre elementos dentro del array.
- **Empty** Nos ayudará a mostrar un mensaje alternativo cuando el objeto venga vacío
- Al final debemos cerrar el ForElse usando **endforelese**.

6. Ahora vamos a retornar la vista pasandole como primer párametro la vista y como segundo párametro la información que va a requerir, donde pondremos la el arreglo $messages que creamos de la siguiente manerá.
```php
return view('welcome', [
            'messages' => $messages,
        ]);
```
7. Por ultimo eliminaremos el elemento **Acerca de nosotros** porque no la ocuparemos, así que eliminaremos: la vista, controlador y la ruta para que ya no exista más.

## Migrations

Las migrations: son como un versionamiento de la base de datos, cada migration que creemos nos va a permitir modificar nuestro esquema de base de datos de una forma específica; podemos crear tablas, podemos editar una tabla que ya existe, agregando columnas, editando una columna existente, podemos eliminar tanto columnas como tablas. Vamos a poder afectar como necesitemos nuestra base de datos.

Lo bueno de esto es que cada migration que creemos, la vamos a poder commitear a nuestro repositorio y mantener un historial de cómo se fue modificando nuestra base de datos.

Para utilizar migrations vamos a utilizar artisan
``php artisan make:migration [ argumentos ]`` 

### Comandos de migration

``migrate:install`` instalar Crear el repositorio de migración
``migrate:refresh`` Restablecer y volver a ejecutar todas las migraciones
``migrate:reset``   Retroceder todas las migraciones de base de datos
``migrate:rollback`` Retroceder la última migración de la base de datos
``migrate:status`` Muestra el estado de cada migración

### Opciones y argumentos de migration

Argumento Obligatorio **Name <name>**

``--create[=CREATE]`` La tabla a crear
``--table[=TABLE]`` La tabla a migrar
``--path [= PATH]`` La ubicación donde se debe crear el archivo de migración
``--realpath`` Indique que las rutas de archivo de migración proporcionadas son rutas absolutas previamente resueltas

## Corriendo Migraciones en Nuestra Base de Datos

Ahora aprenderemos a configurar nuestra base de datos para poder utilizarza en nuestros proyectos con laravel, para esto necesitamos tener instalado en nuestro entorno local un servicio mySQL en el puerto 3306 que es el que este utiliza comúnmente.

Modificaremos nuestro archivo de entorno (.env) y aquí tenemos que colocar los datos requeridos para la autentificación, es decir, colocar el nombre de la base de datos, el nombre del usuario y la contraseña que ustedes estén utilizando, siempre que hagamos cambios en nuestro archivo de entorno tenemos que detener artisan y volver a ejecutarlo.

A continuación comenzaremos a darle forma a nuestro esquema de base de datos utilizando la herramienta de laravel llamada "migration"
Para crear migrations vamos a utilizar artisan con los comandos:

``php artisan make:migration [ argumentos ]``

En este caso crearemos la tabla para almacenar nuestros mensajes utilizando php artisan

``php artisan make:migration create_messages_table --create messages``

y la vamos a encontrar en la carpeta principal de nuestro proyecto, en la subcarpeta migrations.

Una vez preparada nuestra migración debemos ejecutar php artisan migrate y esto ejecutará todas las migraciones que tengamos

### Ejemplo de la clase 

1. Primero vamos a modificar el archivo de entorno(.env) y aquí colocamos los datos requeridos para la autenticación especialmente los de la base de datos.
2. Donde especificamos el nombre de la base de datos, está ya la tenemos que haber creado anteriormente.
3. Una vez modificado el archivo de entorno debemos apagar el servidor y volver a levantarlo para que arranque con la nueva configuración que nosotros le pusimos.
4. Ahora empezaremos a configurar nuestra base de datos, para ello laravel nos trae una herramienta que se llama **migrations**
5. Vamos a crear la tabla de de **messages** usando migration:

```php
<?php
# 1) Le pasamos el nombre de la migration: crerated_messages_table
# 2) Antes de ejecutarlo le vamos a pasar la option --create: para indicar que queremos crear una tabla 
# 3) Como párametro le pasamos el nombre de la tabla: messages
php artisan make:migration crerated_messages_table --create mesaages 
?>
```
Despues de ejecutarlo nos indicará que creo una nueva migration con una fecha, la fecha es muy importnante porque la migration se van a ejecutar secuencialmente por fecha, y con el nombre que le dijimos que tiene.
``Created Migration: 2018_10_12_044210_create_messages_table``

6. Las maigration las vamos a encontrar dentro de nuestro proyecto en la carpeta *database* dentro de la carpeta *migrations* y veremos que laravel ya trae migrations para nosotros: created_users y created_password estás dos migratios la vamos a utilizar cuando hagamos autenticación en Laravel.

7. La nueva migration es una clase que se llama como le dijimos y tiene 2 métodos; up y down. 
- El método up se va a ejecutar cuando le digamos a artisan que ejecute nuestras migratios.
- El método down se va a ejecutar cuando le digamos a artisan que queremos volver atrás una migration.
**Es muy importante que usemos los dos, siempre que hagamos algo es tenemos que poder deshacerlo así cualquier punto de nuestras migratios se puede volver atrás**

En el método *Up()* tenemos una llamada al esquema create, esto es porque le dijimos que iba a hacer una migration de creación, entonces ya va a estár creando una tabla en base de datos. El primer párametro es el nombre de la tabla y el segundo párametro es una función anónima que vamos a usar para configurar está tabla, dentro de está function tenemos un objeto que se llama **Blueprint** esté *blueprint* es el que vamos a usar para configurar, le vamos a poder llamar métodos en esté objeto *blueprint* que van a decirle a laravel como queremos que se vea nuestra tabla, por ejemplo: si queremos un string o un varchar le podemos decir al *blueprint* que queremos un string y luego le decimos como queremos que se llame esa columna.
```php
public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('content');
            $table->string('image');
        });
    }
```
**Con estó laravel ya sabe que cuando cree está tabla messages va a tener una columna de tipo string con el nombre que le pasamos por párametro.**

También vamos a querer tener la fecha en la que se creo este mensaje. Laravel tiene una convención para su ORM que es que todas las tablas y objetos que usemos de base de datos vienen con la fecha de creación(created_at) y la fecha de ultima modificación(updated_at). y eso es la linea que hace **timestamps** 
```php
 Schema::create('messages', function (Blueprint $table) {
# Está linea indica nuestra primary key, autoincremental
            $table->increments('id');
# Esta linea nos va a crear created_at y udated_at como dos columnas sepradas como objetos de tipo fecha.
            $table->timestamps();
        });
```
8. Despues de crear las tablas vamos a correr en la terminal el comando 
``php artisan migrate``
**Esto le va a decir a laravel que ejecute todas las migrations que tenga pendientes hasta la fecha actual.**

9. Ahora que ya tenemos nuestra tabla creada podremos ver los campos de las tablas vacios. Probablemente nuestros mensajes los leamos cronológicamente los más nuevos primero. Para eso sería bueno crear un indice sobre la columna de creación del mensaje. Para ello vamos a ir a la terminar y crear una nueva migration.

Esta nueva migration la vamos a llamar diferente porque no estamos creando tabla nueva estamos modificando una tabla ya existente.
``php artisan make:migration: add_created_at_index_to_messages_table --table messages``
- Si ven estamos siendo muy espeficificos, eso es bueno este archivo es muy claro lo que va a hacer y despues será facil entender viendo solamente el nombre de archivo que es lo que se esperá que haga está migration.
- Después le pondre --table: lo que significa que está migration es de edición de una tabla.
- Y la tabla que estoy editando es messages de nuevo.
*Por ultimo me crea una nueva migration con el nombre que le dimos y la fecha actulizada*.

10. Ahora el **Schema** no dice **create** sino que dice **table** Es porque esté app asume que la tabla ya existe y el **down()** no dice como decía el anterior porque esté down no va a borrar la tabla enterá sino que debería solamente borrar el indice. 
```php
public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            //
        });
    }
```
11. Ahora vamos a agregar el código necesario para agregar el indice 

- Agregar un indice es tan fácil como decirle al **Blueprint** ``$table->index()``. El primer párametro del index será el nombre de la columna ``$table->index('nombrecolumna')`` , si yo quisiera agregar un indice de multiples columnas podría pasarle un array con los nombres de columnas ``$table->index(['columna1', 'columna2'])`` pero en nuestro caso solo tendremos una columna solo le dejaremos el *created_at*.
- Para elimnar un indice en el método **down()** le voy a decir al **Blueprint** el método **dropIndex()** y como párametro le tengo que pasar el nombre del indice.
1. El nombre del indice se construye a través del nombre de la tabla en nuestro caso *messages*, guión bajo el nombre del o las columnas involucradas, en nuestro caso *created_at* guión bajo y la palabra index. 
```php
Schema::table('messages', function (Blueprint $table) {
            $table->dropIndex('messages_created_at_index');
        });
```
- Si quisieramos podríamos elegir el nombre de nuestro indice pasandolo como segundo párametro al método index, y después hacer el **dropIndex()** pasandole como párametro el nombre que le pusimos. Ejemplo: 
```php
public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->index('created_at', 'my_created_at_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropIndex('my_created_at_index');
        });
    }
```
**De no hacerlo así recordemos la convención: nombre de la tabla, nombre de las columnas y la palabra index, todo separado por comas.**
``tabla_columnas_index``

## Usando Eloquent el ORM de Laravel

Ahora vamos a usar Eloquent para acceder a una base de datos, para eso vamos a empezar creando un modelo, el modelo es lo que nos va a representar nuestros objetos en nuestro dominio, nosotros vamos a tener: mensajes, usuarios, vamos a tener una relación entre ellos, vamos a tener otros objetos como por ejemplo conversaciones, todo esto va a hacer parte de nuestro modelo, para ello empecemos modelando el mensaje.

1. Vamos a ir al terminal y vamos a escribir el comando:
``php artisan make:model Message``
2. Una vez creado vamos a ir a la carpeta de App en la raíz.

Aquí tenemos el modelo de message, esta dentro del namespace de app y extiende de la clase Eloquent\Model.
**Eloquent** es el ORM que viene en laravel por defecto.
Un ORM: Object relational mapping es una librería que nos ayudá a convertir un esquema relacional; que es una base de datos relacional a un esquema de objetos, que van a hacer estos objetos que vamos a definir como nuestro modelo, particularmente Eloquent ocupa un patrón que se llama **Active-record**, así que si escuchan estó sepan que en nuestro caso también van a estar hablando de eloquent.

3. Nuestra clase Message no tiene nada pero en realidad tiene un montón de lógica escondida dentro de la clase model.
4. Ahora vamos a tratar de usarla para eso vamos a ir a nuestro pagesController y vamos a replazar el array de $messages por un llamado a nuestro modelo.
``$messages = App\Message::all() ``
5. Si ahora vamos a nuestron home podres nota que aún no tenemos nada, ya que aún no tenemos datos en nuestras tablas, para ello vamos a hacer 2 insert en nuestra base de datos manualmente, para ello iremos a la DB y los insertaremos en la tabla messages.
6. Si ahora actualizamos nuestra home notaremos que ya tenemos mensajes, esto significa que por detrás laravel hizo una **query** a la base de datos con el modelo **messages** y trajo todos los modelos que tenía en la tabla.

- Por un lado el nombre de la clase es importante porque laravel va a usar el nombre de la clase para buscar el nombre de la tabla Message va a resultar en una tabla messages, es decir la misma palabra en ingles en plural. 
- Si una clase tiene más de una palabra, imaginemos si tuvieramos
```php
class MessageContent exteds Model {
    // El resultado sería message_contents
}
```
En donde cada palabra sería separada por guío bajo y la última palabra sería pluralizada.

- Luego Laravel asume que tiene una primary key con nombre *id* eso es importante porque lo utilizaremos cuando veamos relaciones, porque va asumir siempre que una relación va a ir hacia el *id* de la otra tabla.

7. Por último pudimos acceder al objeto messages usandolo como un array. Si vamos a la vista welcome veremos que accedimos a messages como si fuera un array, auque en realidad sea un objeto.

8. Nosotros podemos hacer un var_dump en laravel usando **dd** donde nos imprimirá el arreglo en forma de lista descendente, mucho más facil de leer que un var_dump normal.

9. En general nosotros no usamos lo objetos como un array, los usamos atraves de sus propiedades, para ello tocá ir a cambiar el acceso a los indices por las propiedades del objeto.

## Trae un Solo Mensaje de la Base de Datos

Vamos a usar el objeto messages y vamos a usar un controller y una vista para hacer toda la ruta completa de un recurso de la aplicación.

Comencemos desde las rutas: la idea es que podamos recibir un mensaje con un id de mensaje especifico y poder mostrarlo como una página única.

1. Vamos a las routes web, vamos a necesita una nueva ruta, vamos a configurar la route y podremos *messages* como prefijo y luego quiero obtener el ID del mensaje, ahora esté ID es algo que va a variar, es un párametro. Para poder decirle a laravel que en la ruta va un párametro tengo que usar la sintaxis {párametro}. Entre llaves voy a decirle el párametro que quiero recibir, y en segundo párametro de la route pondremos el controllador que aún vamos a crear.

2. Vamos a ir a la terminal y vamos a crear el controlador con la ayuda de artisan, el comando sería el siguiente:
``php artisan make:controller MessagesController``

3. Ahora vamos a agregar el método que le dijimos a la ruta. 

### ¿Comó recibimos el ID?

Todo lo que pongamos en una ruta como párametro de ruta vendrá como párametro a esté método, particularmente como un el párametro es un id lo usamos como convención. Y aquí lo que nos queda es ir a buscar el message por id y luego una view de un message!

**¿Como voy buscar un message por id?**

Utilizando la clase message igual que buscamos todos los messages, pero está vez el método no es **all()** sino que es **find()**. find recíbe un párametro que es el id que estamos buscando.

Y luego en la variable message ya voy a tener el mensaje por id. Recuerden siempre que utilicen un clase debemos importar el **namespace** 

```php
class MessagesController extends Controller
{
    public function show($id) {
        // ir a buscar el messages por ID
        $message = Message::find($id);
        // una view de un messages
        return view('messages.show', [
            'message' => $message
        ]);
    }
}
```
Por último me voy a imaginar como me gustaría tener un vista, en esté caso nosotros especificamos que queremos tener un una view que se llama **show** y que está dentro de la carpeta **messages**. Recuerden siempre que en las vistas utilicemos un punto Laravel lo va a tomar como una carpeta. 
De está forma puedo agrupar todas las vistas que tienen que ver con messages en una sola carpeta.

Vamos a crear un archivo Show que va extender del layout dentro de la carpeta messages y el archivo se llamará show.blade.php

Si ahora yo recargó está página, ahora ya va a encontrar la vista simplemente tendremos que rellenarla con lo que queramos mostrar.

### Creando Vista Show

Ahora nosotros vamos a crear la vista obteniendo los datos del mensaje con el id que estámos pasando como párametro, la página quedaría de la siguiente manera.
```html
@extends('layouts.app')

@section('content')
<h1 class="h3">Message id: {{ $message->id }} </h1>
<img class="img-thumbnail" src="{{ $message->image }}">
<p class="card-text"> {{ $message->content }} 
<small class="text-muted">{{ $message->created_at }}</small>
</p>
@endsection
```

### ¿Comó podemos evitar que la página fallé cuando no encuntre un objeto?

Para ello vamos a utilizar una funcionalidad de laravel que se llama: **Route Model Binding** Y que nos permite usar esté párametro para ir la base de datos directamente y que si no existe eso fallé directamente laravel.

Para ello está linea que tenemos aquí ``$message = Message::find($id);`` en el MessagesController la vamos a remplazar por un párametro.

Le vamos a decir a Laravel: el párametro no es solamente un id, es un id de message, y eso lo hacemos pidiendole que nos de un **Mensaje**.
```php
class MessagesController extends Controller
{
    public function show(Message $message) {
        return view('messages.show', [
            'message' => $message
        ]);
    }
}
```
Si yo hagó esto veremos que en el messages/1, el contenido se muestra correctamente. 
**Porque Laravel tomo ese id=1 y dijó: yo tengo que armar un Menssage en base a esté id. Voy a hacer la query y voy a darle el objeto directamente**.

Pero si nosotros ponemos un ID que no existe, entonces vamos a obtener una exception **NotFoundHttpException**. Laravel está mostrando un error que no es del Tipo de *Estás usando mál un objeto*. Ahora el error es un mensaje **404**.

Laravel convierte automáticamente un erro **NotFoundHttpException** en **una página 404** que significa que: ESE RECURSO NO EXISTE. 

Con estó resolvemos el problema de si existe o no existe en base de datos, laravel lo cubre por nosotros.

## Crea Formularios Seguros en Laravel

Vamos a empezar creando el form de un mensaje, para eso vamos a ir a la *homepage* que es ``welcome.blade.php`` donde vamos a ingregar un formulario a nuestro html.
Inmeditamente después del jumbotron vamos a crear el form que quedaría de la siguiente manera:
```html
<div class="row">
    <form action="/messages/create" method="post">
        <div class="form-group">
            <input type="text" name="message" class="form-control" placeholder="¿Qué estás pensando?" id="">
        </div>
    </form>
</div>
```
Si le hacemos submit al formulario nos marcará un error ya que la ruta aún no existe, para ello vamos a crearla en nuestras rutas web.

1. Agregaremos la ruta de tipo post, ya que nosotros especificamos nuestro método en el form, el cúal quedaría de la siguiente manera: 
```php
Route::post('/messages/create', 'MessagesController@create');
```
Si se fijan uso las mismas palabras entre la ruta y el controler, no es necesario pero después es más fácil recordar donde está cada uno.

2. Luego si actualizó este pedido vamos a tener un error, el cúal es; *TokeMismatchException*. Ahora por más que yo cree la función **created()** en el controller y retorne un mensaje.
```php
public function create() {
        return "Created!!";
    }
```

Si yo actualizo estó va a seguir fallando, veamos el error que nos está dando laravel: dice que está verificando un token con la sigle Csrf **VerifyCsrfToken.php**.

La sigla **Csrf** significa: (del inglés Cross-site request forgery o falsificación de petición en sitios cruzados).

Esté es un problema de seguridad del que laravel nos protege por defecto esté problema es que alguien podría enviar un formulario a nuestro sitio sin venir de nuestro sitio, para eso es que cada vez que laravel recibe un formulario va verificar en sesión si ese formulario fue creado por nuestra aplicación. 

Para que estó funcione y verificar el error que tenemos en pantalla, tenemos que agregar un **fiel()** especifico en nuestro formulario, para ello vamos a volver al código del formulario y en el *welcome.blade* dentro del formulario en cualquier lado voy a hacer *echo* de un **csrf_field()** qué es una función que proveé laravel para generar un Token en esté formulario, entonces cuando laravel reciba el formulario lo va recibir con esté token.
```html
<form action="/messages/create" method="post">
        <div class="form-group">
            {{ csrf_field() }} <!-- Token del formulario --> 
            <input type="text" name="message" class="form-control" placeholder="¿Qué estás pensando?" id="">
        </div>
    </form>
```
3. Ahora vamos a volver a la home y veamos el html del formulario; como vemos aquí tenemos nuestro *form-group* y tenemos un input *type="hiden"* como *name="_token"* y como tiene un texto al azar value="HSDDHSDFSXZCMZLC", esté texto al azar está guardado en nuestra sesión.

Entonces cuando recíba esté input laravel va a tratar de encontrarlo en la sesión y si no es el mismo va a dar el error que teníamos en pantalla **VerifyCsrfToken.php**. Si no lo encuentra en el pedido del form también dará ese mismo error. 

Una vez creado el token, ya vamos a poder entrar al ruta donde enviamos la información.

### ¿Comó recibimos el pedido?

Para eso vamos a usar un párametro de esté pedido que no es un párametro de ruta sino que es un párametro que le podemos pedir a laravel, un objeto más que le podemos pedir a laravel, y ese objeto es el objeto **Request**
```php
public function create(Request $request) {
        dd($request->all());
        return "Created!!";
    }
```
Para saber que tenemos en el objeto *Request* vamos a usar la función que vimos anteriormente que hace un *var_dump y exit = dd()* y como párametro le vamos a dar todo el contenido del request ``dd($request->all());``. Estó va a salir en esté punto y nunca va a retornar el mensaje *Created!!*.

Si volvemos a refrescar la página veremos que el objeto *Request* tiene el **Token** y el **Message** esté objeto lo vamos a usar para procesar el pedido.



















