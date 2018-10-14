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

## Validación y creación de datos en laravel con Eloquent

Qué pasa por ejemplo en Twitter cuando escribimos más de 144 cáracteres, el sistema no nos permite escribir más de eso, entonces como hacemos si en nuestro formulario alguien escribe un montón de texto, nosotros tenemos que protegernos de estó!

### Validaciones en los controllers

Vamos a ir al controller que recibe esté pedido App\Http\Controllers\MessagesController y en el método create que habiamos dejado anteriormente vamos a crear la validación. Para validar vamos a usar el método **validate** del **controller** de laravel, esté método ya viene en el controller que nosotros extendemos en nuestro controller.

Si yo escribo ``$this->validate()`` voy a tener disponible un método que tiene 3 párametros.

1. El primer párametro tiene que ser el $request que estamos recibiendo en esté método así laravel sabe que es lo que está validando.
2. El segundo párametro es un array y se le conoce como el **array de reglas** esté array tiene la siguiente forma: 
```php
$this->validate($resquest, [

])
```
Cada *key* de esté array corresponde a un field de nuestro pedido, en nuestro caso será message y luego cada *value* de esté array puede ser un string o un array de reglas, en caso de que queramos qué este message sea requerido, es decir que si no viene esté dato esto *no sea valido*, tendríamos que escribir **required**.

Si nosotros escribimos un texto valido, el mensaje se envía correctamente, pero si nosotros enviamos el campo vacío entonces Laravel nos redirecciona a la misma página en la que estabamos con una variable especial; que es la variable de errores con los erros que sucedieron en ese pedido.

Para poder ver está variable vamos a tener que ir al *template* de nuestra *homePage*. 

Ahora en todos los pedidos tenemos disponible una variable **errors** que es una variable que contiene un objeto de tipo *Message bug* el tipo de esté objeto no nos importa mucho, lo importante van a ser los *métodos* que le vamos a poder preguntar a esté objeto para que nos diga si hay un error en el formulario.

- Lo primero que vamos a hacer es crear un if en el formulario y preguntar si hay algún error con esté método ``errors->any()`` el método *any()* va a devolver si hay almenos un error en el formulario que estamos viendo actualmente.

Lo que puedo hacer aquí sería iterar esté listado de errores de la siguiente manera:

```php
<form action="/messages/create" method="post">
        <div class="form-group">
            {{ csrf_field() }}
            <input type="text" name="message" class="form-control" placeholder="¿Qué estás pensando?" id="">
            @if ($errors->any())
                @foreach ($errors as $error)                
                @endforeach
            @endif
        </div>
    </form>
```
En esté caso yo estaría iterando todos los errores pero a mi en este caso solo me interesa si hay un error en el mensaje. En el input de name:message, asi que vamos a aprovechar y usar otro método de esté objeto que se llama ``get()`` que recibe el name del input que queremos saber si tiene o no tiene error.
```php
    @if ($errors->any())
        @foreach ($errors->get('message') as $error)
            <div>{{$error}}</div>
        @endforeach
    @endif
```

En esté caso el **foreach** ``$errors->get('message')`` nos dará todos los errores relacionados al message.

Ahora si nosotros intentamos enviar el formulario vacío veremos que tendrémos un nuevo mensaje de error especifico en el campo *message* que dice ``The message field is required.`` Laravel por defecto está en ingles pero nosotros podremos traducir o elegir el mensaje que queremos mostrar en esté campo.

Nosotros incluso podemos ser más especificos y preguntar si hay algún *error* del *campo message* nadamas, por ejemplo con el método *has()*
```php
@if ($errors->has('message'))
        @foreach ($errors->get('message') as $error)
            <div>{{$error}}</div>
        @endforeach
    @endif
```

Si entre los errores hay un error en el campo message quiero mostrar todos los errores del campo message y voy a aprovechar para estilizar esté campo y se muestre como un error con la clase de boostrap ``class="invalid-feedback"`` y vamos a incluir en la clase del input la clase ``is-invalid`` cuando exista un error para ello usaremos un **if** de la siguiente manera:
```php
<input type="text" name="message" class="form-control @if($errors->has('message')) is-invalid @endif" placeholder="¿Qué estás pensando?" id="">
    @if ($errors->has('message'))
        @foreach ($errors->get('message') as $error)
            <div class="invalid-feedback">{{$error}}</div>
        @endforeach
    @endif
```
Tanto el input como el texto tendrá una marca de que hubo un error, estó es importante para que el usuario entienda que es lo que hizo mál, si no le damos un feedback visual quizá no entienda que es lo que está pasando.

Ahora agregemos una nueva regla a esté campo, pongamos que no pueda escribir más de 160 cáracteres, ¿como hacemos eso? bueno, tendremos que ir al controller y agregarle otra validación.

Podemos crear un array que para mi el lo más cuerente y agregar una segunda regla a ese array, está regla es una regla de cantidad máxima de cáracteres y particularmente se llama **max** pero max es una regla parametrizada porque necesitas decirle cuantos cáraceres es el máximo. Entonces para parametrizar un regla tenemos que poner ``:`` ejemplo: ``max:144`` estó le dice al validador que esté campo tiene que tener un maximo de 144 cáracteres 
```php
$this->validate($request, [
            'message' => ['required', 'max:144'],
        ]);
```

### ¿Como hacemos para customizar estos mensajes?

El validador tiene un **tercer párametro** que es un array, a esté se le conoce como el **array de mensajes** y tiene una estructura similar al array de reglas, pero en vez de ser solamante el *campo* que tiene como *key*. **La key** es una *combinación del campo* y la *regla* que estamos construyendo en esté caso podría customizar el mensaje de ``'message' => 'required'`` escribiendo ``'message.require'`` y como value le podría dar decir que texto le podría dar al usuario cuando esa regla fallé, ejemplo:
```php
$this->validate($request, [
            'message' => ['required', 'max:144'],
        ], [
            'message.required' => 'Por favor, escribe tu mensaje',
            'message.max' => 'El mensaje no puede superar los 144 cáracteres',
        ]);
```
Está no es la única forma de validar con laravel, si nosotros tenemos mucho código de validación en los controllers, puede ser que los controllers se vuelvan muy largos, entonces lo que nos ofrece laravel es una forma de modelar el pedido y que el pedido se valide a sí mismo. **¿Como se hace esto?** atraves de algo que se conoce como los **form-request**.

Vamos a crear un form-request para la creación de un mensaje, para ello voy a ir al terminal y vamos a usar *artisan* para crear el request.
```php artisan make:request CreateMessageRequest``
Es un nombre bien significativo de lo que vamos a hacer, si volvemos a nuestro editor lo vamos a poder encontrar en la carpeta App\Http\Request.

Si entramos a el notaremos que tiene 2 métodos, el método *authorize()* y el método *rules()* que es donde vamos a poner las reglas. Por lo pronto como voy a autorizar a cualquiera voy a poner el return de autorize a true.

Y luego voy a copiarme las reglas que puse en el controller a está clase, vuelvo al messagesController, y esté array de reglas que es el *segundo párametro de validate* me lo voy a llevar al CreateMessageRequest la estructura es exactemente la misma, espera el mismo array de reglas que espera el método validate.
```php
public function rules()
    {
        return [
            'message' => ['required', 'max:144'],
        ];
    }
``` 

**Pero aquí estaríamos perdiendo esos mensajes. ¿Como hariamos para recuperar esos mensajes que habíamos usado en el controller?**

Bueno en el *CreateMessageRequest* tenemos un 3 método que podemo *pisar* en esté request que es ``public function messages()`` y aquí tenemos que devolver el mismo array que teníamos en el controller (**array de mensajes**). Vamos a hacer un return de esté array.
```php
public function messages() {
        return [
            'message.required' => 'Por favor, escribe tu mensaje',
            'message.max' => 'El mensaje no puede superar los 144 cáracteres',
        ];
    }
```

Luego lo único que quedá es decirle a Laravel que por un lado ya no queremos usar el validate y por otro lado esté request ya no es cualquier request. Ahora es un **CreateMessageRequest** que como tiene un *namespace* hay que traerlo para poder usarlo.
```php
public function create(CreateMessageRequest $request) {
        
        return "Llego!!";
    }
```

Siempre recuerden que cuando usen una clase que no está en el mismo namespace que la clase que están usando tenemos que importarla en con *use* 

Ahora estamos en la misma situación la diferencia es que nuestro controller está mucho más limpio.

- Lo único que tiene es es que necesita esté tipo de request **CreateMessageRequest**.
- Si el request falla nunca llegá a retornar la linea de abajo.

## Como Guardar el mensaje en Base de datos con el Modelo de Eloquent.

En la función **create()** voy a tener el request con todos los datos que acabó de recibir, entonces como le digo a eloquent que cree un nuevo mensaje usando la clase Message con el método create() y esté recibe como párametro un array de datos. Donde la **key** es la columna y el valor son los datos que queremos ponerle a esa columna:
```php
$message = Message::create([
    'content' => $request->input['message'],
    'image' => 'https://source.unsplash.com/category/nature/600x338?4'.mt_rand(0,1000)
]);
```
Ahora cuando enviemos el mensaje nos dará un error de **MassAssigmentException** = (**Creación de objetos de forma masiva**). 

Para qué nosotros podamos crear un objeto como lo hemos querido crear aquí tenemos que decirle que cosas proteger y que cosas no. Ahora vamos a configurar el message para que no tiré esté error. 

Voy a ir a App\Message y le voy a agregar una propiedad que es una propiedad *protected* que se llama guarded. **guarded:** es una propiedad de columnas que están protegidas, si yo le doy un array vacío [] le estoy diciendo no protejas nada, pero yo podría decirle que proteger alguna o no. En esté caso no hay algo que me preocupe. 

Si ven un error de **MassAssigmentException** Recuerden la propiedad: **protected guarded**.

Ahora despues de haber creado el mensaje voy a hacer redireccionar al usuario a esa página con el objeto que acaba de crear de la siguiente manera:
```php
public function create(CreateMessageRequest $request) {
        $message = Message::create([
            'content' => $request->input('message'),
            'image' => 'http://source.unsplash.com/category/nature/600x338?'.mt_rand(1, 100)
        ]);

        return redirect('/messages/'.$message->id);
    }
```

## Seeding y Model Factories

Cuando empezamos un nuevo proyecto en general no tenemos datos y casi sea un poco engorrozo crear los datos atraves de un formulario, por ejemplo si queremos probar un listado que tuviera 100 items o 500 items o ver como se comporta nuestro sistema cuando tenemos muchos datos. Crearlos 1 a 1 a mano o incluso en la base de datos podría ser bastante complicado, para eso laravel nos ofrece 2 conceptos, el concepto de model factories y el concepto de seeds. Vamos a ver como usarlos para llenar nuestra base de datos de mensajes.

Comencemos definiendo que es un mensaje con el model factorie de mensajes para eso vamos a ir a la carpeta *database* y dentro de ella vamos a tener *factories* hay un solo archivo que es el ModelFactorie.php que tiene la definición ya de un usuario que te prové laravel cuando comencemos a usar usuarios.

Debajo de esa definición vamos a agregar una definición para message, para crear una definición usamos la variable *factorie* y el método *define*, el método tiene 2 párametros, el primero es la clase que vamos a definir, en nuestro caso ``App\Message::class`` y el segundo párametro es una función anónima ``function(){}``, está función anónima recibirá un objeto que nos va a facilitar la creación de datos al azar, esté objeto se llama **faker**, si vemos el ejemplo que nos da laravel para user tenemos está firma. 
```php
$factory->define(App\User::class, function (Faker\Generator $faker) {}
```
Así que nosotros vamos a escribir lo mismo en nuestra función, y luego aquí dentro de está función anónima vamos a usar faker para generar estós datos falsos. Si ven está función anónima devuelve un array en el caso del *user*, así que vamos a hacer lo mismo. 

Esté array tiene la misma estructura que usamos para crear un message cuando llamamos al método **create** es decir la *key* del array va a ser el nombre de la columna y el *value* va a ser el valor que queremos darle a esa columna. Pero a diferencia que lo que hicimos con create vamos a usar el *generador de fake* para crear estos datos, por ejemplo podemos decir a faker que queremos **words:**, estó le dice a faker dame palabras al azar, faker tiene un montón de métodos interesantes para generar texto; tiene **word:**(que te da 1 sola palabra), tiene **words:**(como método que le puedes pedir las palabras que quieres, y si quieres como un texto, tienes que decirle *true*, pára que lo devuelva como texto, sino lo devuelve como un array de 5 palabras), tienes **paragraph:** que devuelve un párrafo un poco más largo que la cantidad de palabras, o tienes uno que es mi favorito para el contenido que es **realText():** que es una función que devolverá texto basado en un libro, particularmente está devolviendo texto basado en *Alicia en el país de las maravillas*, vamos a dejar ese que nos va a dar una sensación un poco más realista sobre los mensajes que veamos en nuestro sitio.

De otra forma lo que generá con los métodos: word, paragraph es lo que se conoce como **lorem ipsum:** el textó en latín que se usa para rellenar contenido.

Y luego en la tabla ``'image => '',`` nosotros venimos usando *lorenpixel*, en esté caso *faker* tiene un método que se llama *imageUrl()* una url de *lorenpixel* así que podemos seguir usando la misma url que venimos usando en nuestros ejemplos.
Si yo guardó esto le puedo pedir ahora a laravel que me de un mensaje basado en está definición. Para probar estó en vez de ir através del navegador, vamos a usar una herramienta de consola que nos da laravel através de artisan que se llama **tinker**.
```php
$factory->define(App\Message::class, function (Faker\Generator $faker) {
    return [
        'content' => $faker->relText(),
        'image' => $faker->imageUrl(),
    ];
});
```
Para usar está herramienta tenemos que asegurarnos que ya la tengamos en el proyecto, desde laravel 5.4 es una *dependencia externa* tinker, así que veamos si la tenemos ya descargada, y estó lo revisamos en la lista de rquire de nuestro archivo *composer.json* 

Estó ya trajo tinker por defecto pero como ven no está en laravel framework porque podrían para producción quitarlo del proyecto y no agregar ese código a su proyecto productivo, y por último para asegurarme de que esté incluido en laravel voy a ir a la configuración en la parte ``app.php`` y voy a buscar el *TinkerServiceProvider* aquí por defecto laravel ya incluyo tinker así que podemos empezar a usarlo.

Recuerden estó en laravel 5.4 lo quitarón del frameword y es un paquete externo.
en caso de no tenerlo agregado en *app.php*, agregarlo de la siguiente manera:
``Laravel\Tinker\TinkerServiceProvider::class,``

En cosola necesitamos ejecutar ``php artisan tinker``, estó abrirá lo que se conoce como un *repel*, es un *loop* entre leer, evaluar lo que estamos escribiendo, mostranos la salida y volver empezar.

¿Qué quiero hacer yo?: quiero usar la definición de ``app\Message::class`` para contruir un mensaje, estó se hace atraves de una función que se llamá *factory()* la función recibe como párametro el objeto que quiero construir en nuestro caso (*App\Message::class*) y luego de llamar a la función factory puedo llamar al método **make** que me va a construir una instancia de esa clase o al método **create** que la va a construir y guardar en base de datos.

Si probamos con el método make y guardo el resultado en una variable $message, vermos que el resultado de esto es un objeto message con el contenido del texto, y una imagen al azar de lorenpixel. Si yo vuelvo a ejcutar estó tendre un nuevo contenido y una nueva imagen al azar de *lorenpixel*, si yo vuelvo a ejecutar estó tendré un nuevo contenido y una nueva imagen al azar de lorenpixel, cuantas veces necesite ejecutar estó me va a generar siempre datos al azar.

Ahora tratemos de crear uno de estós, cambiando el método *make*, por *create*. Ahora tengo un objeto message con contenido al azar, con imagen y además con un id en base de datos y con fecha de creación y actualización, esté objeto que acabó de crear desde tinker ya está creado en base de datos también.

Y asi ahora lo busco con el comando ``App\Message::find(id)`` lo voy a encontrar en la base de datos, con el mismo contenido y la misma imagen, el mismo id y las mismas fechas.

Pero no lo vamos a crear desde tinker, esto lo hicimos simplemente para interactuar con esté factory, lo que vamos a usar son los **seeds** 

Ahora cierro tinker, [ctrl + c] e iré al editor nuevamente a la carpeta database, pero está vez no a factories, sino a *seeds*. 

En la carpeta *seeds* tengo la clase **DatabaseSeeder()** qué tiene un solo método, el método **run()**. En esté método laravel nos ofrece una forma de separar nuestros **seeds** en diferentes clases. Por lo prontó solo usaremos el método *factorie* para crear messages así que lo voy a hacer en está misma clase.

El nombre de la clase App\Message, pero si yo quiero el string de la clase le tengo que pedir la constante class de la clase message, que estó es equivalente a:
```php
factory('App\Message')->create(); // Estó es equivalente a la linea de abajo
factory(App\Message::class)->create();

# Pero usar los ::class es mucho más práctico para luego encontrar ese uso de esa clase es más formal
```
Les recomiendo siempre que puedan usar class en vez de usar el nombre en un string 

Voy a hacer los mismo que acabo de hacer aquí en *tinker*:
``factory(App\Message::class)->create();`` y estó creará un mensaje, ¿Como ejecuto estó?: de nuevo desde terminal lo haremos con el comando:
``php artisan db:seed``
db: es el namespace de esté comando y seed es el comando específico.

Ahora efectivamente abrá creado en base de datos un nuevo mensaje, pero nosotros queremos crear cientos de mensajes y crear de a uno pero *ejecutar 100 veces db:seed* tampoco es muy práctico.

Lo que podemos hacer es decirle al factory, cuantos queremos crear, se lo decimos de varias formas, podemos decirle como segundo párametro la cantidad: 
```php
factory(App\Message::class, 100)->create();
```
Ó podemos agregar antes del método create un llamado a **times()** qué esto quizá sea mas legible:
```php
``factory(App\Message::class)
    ->times(100)
    ->create();``
```
Van a ver que tardá un poquito más, pero si vamos a la homepages tendremos un montón de mensajes nuevos, vamos a darle refresh y veremos los mensajes. Ahora nuestra home a quedado muy grande para la cantidad de datos que tenemos. Si fueramos a generar cientos más está página no sería viable, además si nos fijamos nuestro texto quedó bastante largo, faker, por defecto generó textos de 200 cáracteres y eso superá el limite de 144 que queríamos tener, lo cuál no es realista para nuesto sitio.

Vamos a corregir el factory y vamos aprovechar para ver un método que nos permite regenerar todos los datos en una base de datos recien creada.

Si volvemos a database\factories\UserFactory puedo cambiar el **realText** agregandole un párametro, que sean cuantos cáracteres quiero tener como máximo, ahora podría poner 144, pero eso haría que todos los mensajes tengan 144 cáracteres.
Algo más realista sería hacer un número al azar entre un minimo de *20* cáracteres y un máximo de *144* le vamos a pasar un **random_init()** entré 20 y 144.

Ahora si yo vuelvo a ejecutar db:seed me va a crear 100 nuevos mensajes pero los anteriores van a seguir existiendo. ¿Entonces como hago para limpiar todo?: y crear los nuevos 100 mensajes.

Para ello vamos a aprovechar las **migrations**, voy a volver atrás todas las migrations, volver a crear la base de datos y hacer **db:seed** todo con un solo comando. ``php artisan migrate:refresh --seed``

Está opción de ``--seed`` cuando termine las migrations va a ejecutar *db:seed* automáticamente.

## Paginación de mensajes 

Ahora que hemos generado muchos datos en nuestra base de datos hizó que nuestra home liste todos los mensajes y se vuelva muy cargada, como hacemos con laravel para páginar esa homepage y poder mostrar de a bloques de mensajes y no todos juntos.

Para eso vamos aprovechar Eloquent, vamos a agregar un método que se llama **paginate**, vamos a ir a nuestro controller de la homepage, y si vemos nosotros estamos llamando a *message::all*, all trae todos los mensajes.

Nosotros queremos traer un página de mensajes, nosotros queremos traer una página de mensajes, entonces en vez de *all()* voy a llamar al método *paginate()*.

Paginate tiene un primer párametro opcional que es, cuantos mensajes queremos por página, *por defecto* nos va traer *15 mensajes* por página, y nosotros debemos pasarle el número de items que queremos.

Si nosotros probamos ahora el resultado, notaremos que la página nos trae los 15 mensajes que le pedimos, pero ahora la página corto a los 10 mensajes. Esto funcionó porque tanto el ``message::all()`` como el ``message::paginate()`` devuelven una colección de mensajes que se puede iterar, entonces *foreach messages* sigue funcionando y cada uno de ellos sigue siendo un objeto message, si nos fijamos laravel nos ofrece funcionalidades compatibles entre sí. 

Pero hay una diferencía, el método **paginate** nos va a dar un objeto especial, que nos va a permitir mostrar los links a la página anterior y a la página siguiente, ¿como hacemos esto?: desde el **Template**. Ahora iremos a nuestra view homepage y si vemos tenemos un *forelse messages*, dentró del forelse está el código que se va a ejecutar 1 vez por cada mensaje y luego dentro del *empty* está el código que se va a ejecutar solamante cuando no hay mensajes.

Entonces fuera de está estructurá voy a preguntar si tengo mensajes quiero mostrar los links a las páginas. Solo cuando uso los métodos de paginación voy a tener un método especial en la variable en esté caso messages que es **links()** el código quedaría así:
```php
@if (count($messages))
        {{ $messages->links() }}
@endif
```

Recuerden qué esto solo es posible cuando usen los métodos de paginación si nosotros hacemos una query o hacemos message::all, no vamos a tener esté método y nos va a adar un error.

Si ahora hacemos refresh a la home podremos ver que nos aparecen los links a las páginas siguientes. Ahora lo que nosotros podemos hacer es darle estilos a los links para que se vean más presentables. Para ello usamos (bootstrap-4) y podemos decirselo a los links pasandoselo como párametro.
```php
@if (count($messages))
<div class="mt-2 mx-auto">
/*En la versión con laravel 5.4 ya no es necesario, pues laravel ya implementa bootstrap-4*/
        {{ $messages->links(/*'pagination::bootstrap-4'*/) }}
</div>
@endif
```
## Autenticación de Usuarios

Todos los proyectos en algún momento quieren *registrar* usuarios y permitir login de *usuarios*, vamos a ver en laravel como se hace eso.

Para eso vamos a usar un comando de laravel que nos va a ayudar mucho al comienzo de la autenticación de usuarios, pero antes de ejecutar esté comando, vamos a hacer un backup de nuestro layout, porque esté comando va a pisar todo nuestro layout con un layout que nos generá laravel para el registro y login de los usuarios, entonces vamos a crear la copia llendó al layout.blade y crearemos otro archivo con la misma información del layout pero con otro nombre, estó solo es para comparar como cambian los elementos del layout con lo que generó laravel.

Ahora vamos a ir a la consola y vamos a ejecutar ``php artisan make:auth``, estó hace un Scaffold; estó es como el código inicial que podemos usar para un funcionalidad. Esté comando tiene solamante opciones, no tiene ningun párametro requerido y las opciones son las mismas que siempre con la exception de ``--views`` que podemos decirle que solo nos haga un Scaffold de las *views*.

Pero como estamos recíen arrancando vamos a ejecutar el párametro sin ningun párametro ``php artisan make:auth`` nos preguntará el layout y le diremos que si en caso de que lo hallá elegido bien.

Ahora cuando nosotros vallamos a nuestro proyecto; nuestra home cambió, ahora tenemos un header que dice laravel con 2 botones, *login* y *registro*, luego nuestro *jumbotron* de larater y por último nuestro contenido que tendremos que corregir nuestro contenido por qué se ha roto.

Laravel usa los views que nosotros tenemos y le agregá el contenido necesario para hacer login y registro ya tengó generado un registro con: nombre,email,contrseña y confirmpass.

Si nosotros lo probamos nos vamos a poder *logear*, también podremos hacer *logout* y podemos hacer el *login* con los datos que *logueamos*, ahorá ya tenemos implementado con un solo comando: **login, registro e incluso recordar password**. Incluso yo tengo una opción de **Forgot Your Password?** para que me envié un email y me envié a un formulario en el que pueda cambiar mi contraseña.

Ahora veamos porque se rompieron nuestro estilos, si vamos a las views en resource/views verémos que tenemos una carpeta nueva que se llama *auth* y además nuestro archivo app.blade tiene código nuevo, laravel ha cambiado nuestro layout porque el layout por defecto es app.blade *lo actualizó* con el código de autenticación *usando clases de boostrap 3* así que lo que nos quedá aquí es cambiar el código de boostrap 3 para que sea compatible con *lo que hicimos de boostrap 4*.

Por ejemplo: el navegador tenemos que corregirlo para que tengamos también nuestros links, como el link al la home: donde dice laravel veremos que está usando una **variable de configuración** y por defecto usa el string Laravel, nosotros podemos corregir todas las partes que necesitemos cambiar. Luego tenemos la sección de links de Login y Register donde tenemos un *if* qué pregunta; si soy un invitado con ``Auth::guest()`` voy a mostrar Login y Register, y luego en el else si ya está logeado va a mostrar un *dropdown* con el nombre del usuario ``Auth::user()->name`` y luego un botón de *logout*.

Si hacemos login nos llevá a una nueva ruta. Veamos las rutas que tenemos en la aplicación, en nuestras rutas laravel agrego:
```php
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
```
Nosotros no queremos la ruta del home así que la vamos a quitar y luego ``Auth::routes()`` lo vamos a dejar porque son todas las rutas que navegamos recíen, formulario: registro, login, submit todó resumido en una sola linea. Como hagó ahora para decirle que cuando me *registro* o hagó *login*, para eso tendremos que ir a los controllers que creó laravel, si vamos a controllers veremos que hay una nueva carpeta que se llama *Auth* que tiene 4 controllers nuevos. si entramos a cada uno de ellos veremos que tienen muy poco código, solo lo necesario para editar los casos más puntuales, por ejemplo hay una variable protegida que dice ``protected $redirectTo = '/home';`` la cuál nosotros vamos a cambiar a la welcome con dejando solo '/', los mismo en el RegisterController. Ahora si nosotros entramos a sitio nos redireccinará al index del sitio.

Veamos que pasó con nuestro contenido, porque es qué se ve diferente. Ahora Laravel nos pisó nuestro layout.app con un layout que sirve para hacer *login* y *register* pero el problema en *laravel 5.4* es qué todavía está usando bootstrap-3, si miramos el código generado en app.blade vamos a ver que más allá de los cambios que hizó laravel, por ejemplo el title ahora lo busca como una configruración, hay un estilo que lo busca con una función *asset* e incluso también hay un *script* que *no teníamos* antes, lo qué falta aquí es el estilo de bootstrap-4, si vamos bajo de todo veremos que tampoco está nuestro script de bootstrap 4. Y si hay un srcript que usa la función *asset*.

Voy a ir a mi backup y vamos a restaurar en un principio bootstrap4 y después iremos viendo como convertir estos templates al estilo de bootstrap4.

**Laravel 5.4 aún usa bootstrap 3, pero Laravel 5.6 en Adelante Usa Bootstrap 4. Por lo tanto no es necesario borrar los estilos y agregar los de bootstrap 4 porque laravel ya los tiene instalados en el frameword.**

















