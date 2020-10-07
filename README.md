## Utilización de bases de datos mediante MySQLi y PDO

Conexión de PHP con base de datos mediante dos de los drivers más usados como son **PDO y MySQLi*.

Se han utilizado consultas preparadas y una encapsulación de código en un ejemplo sencillo.

**IMPORTANTE**: Si vas a usar este proyecto es necesario cambiar la configuración del archivo ```config_db.php``` así como la tabla que se hace referencia en las consultas.

### Tabla de contenidos
1. [Conexión con MySQLi](#1-Conexión-con-MySQLi)
2. [Conexión con PDO](#2-Conexión-con-PDO)

#### 1. Conexión con MySQLi

Para poder conectarnos a una base de datos con este driver desde un script de PHP necesitamos los siguientes datos:

- La **ip** o nombre del servidor donde está alojado MySQL
- El **usuario** de la base de datos
- La **contraseña** de la base de datos
- El **nombre** de la base de datos

De forma *opcional* se podróa usar el puerto y el socket.

En este caso la conexión se ha encapsulado dentro de una clase llamada ```ConexionMYSQL.php``` la cual dispone de dos métodos, **uno para crear la conexión y otro para cerrarla**.

```
    public function crearConexion() : object {
        @$this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
        if($this->conn->connect_errno) {
            die("Error al conectarse a Mysql: $this->conn->connect_error");
        }

        return $this->conn;
    }

    public function cerrarConexion() {
        $this->conn->close();
    }
```

Este archivo dispone de un constructor que inicializa los valores con lo que le pasamos del archivo ```config_db.php```.

Hecho esto, sería necesario requerir este archivo en aquellos scripts de PHP en donde vayamos a usar la conexión con la base de datos mediante un ```require_once('db/ConexionMYSQL.php')```.

```
    // Database connection
    $conn = new ConexionMYSQL();
    $db = $conn->crearConexion();
    $db->set_charset('utf8');
```

Llegados a este punto tendríamos **dos formas** de realizar las consultas a la base de datos, mediante queries o mediante consultas preparadas.

##### 1.1 Consultas mediantes queries

Este tipo de consultas es la más insegura y permitiría *SQL Injection* si no validamos antes los datos, el código sería:

```
$stmt = $db->query("SELECT * FROM ejercicio10_usuarios WHERE nombre = '$nombreEnviado' AND pass = '$passEnviada'");
```

Donde a la consulta se le pasan directamente los datos que envía el usuario por el formulario. A partir de aquí podríamos usar *num_rows* para ver si la consulta devuelve filas, *fetch_assoc()* para mostrar esa consulta como un array asociativo o *fetch_array()* para claves asociativas y numéricas.

Una vez hecha la consulta sería necesario liberar la memoria de la misma, con ```$stmt->free()``` así como cerrar la conexión con $conn->cerrarConexion()```.

##### 1.2 Consultas preparadas

Esta técnica consiste en preparar la consulta antes de lanzarla y aprovechar para rellenar los valores de la misma mediante **variables** en lugar de consultas.

```
$stmt = $db->prepare("SELECT * FROM ejercicio10_usuarios WHERE nombre = ? AND pass = ?");
$stmt->bind_param('ss', $u, $p); // Podría haberle pasado $nombreEnviado y $passEnviada
$u = $nombreEnviado;
$p = $passEnviada;
$stmt->execute();
```

Como vemos, se compone de tres pasos:

1) Preparar la consulta
2) Rellenar valores
3) Ejecutarla

En el apartado de rellenar valores podemos indicar el dato que se va a introducir:

- i - número entero (*integer*)
- d - número real con doble precisión (*double*)
- s - cadena de texto (*string*)
- b - cadena de texto en formato binario (*blob*)

Hecho esto, tenemos dos formas de procesar los datos, usando **get_result()** o usando **bind_result()**.

La primera sería de esta manera ```$stmt = $query->get_result();``` devolvería la consulta al objeto *$stmt* pudiendo procesarla más tarde con *fetch_object()* y recuperar los valores con:

```
$fila = $stmt->fetch_object();
$_SESSION['login_user'] = $fila->nombre;
$_SESSION['pass_user'] = $fila->pass;
```

La segunda, asigna variables a campos obtenidos en la consulta con ```$query->bind_result($id, $nom, $con);```, donde sería necesario incluir tantas variables como campos devuelve la consulta. Con esta última opción, los datos se procesan con ```$stmt->fetch()```

#### 2. Conexión con PDO

**PDO** significa **PHP Data Objects**, Objetos de Datos de PHP, una extensión
para acceder a bases de datos. PDO permite acceder a diferentes sistemas de
bases de datos con un controlador específico (**MySQL, SQLite, Oracle...**)
mediante el cual se conecta. Independientemente del sistema utilizado, se
emplearán siempre los mismos métodos, lo que hace que cambiar de uno a
otro resulte más sencillo.

Sus ventajas son:

- Más segura en cuanto a limpieza de código
- Las consultas preparadas en PDO ejecutan la limpieza de los valores automáticamente
- Mayor cantidad de actualizaciones en PDO (PHP lo cogió como estandar)
- Permite conectar CUALQUIER base de datos (no solo MySQL)
- Más ordenada y fácil de usar

La conexión a la base de datos se realiza mediante un clase situada en el archivo ```ConexionPDO.php``` en donde disponemos de los métodos necesarios para hacer la conexión.


```
    public function getConexion()
    {
        try {
            $dsn = "mysql:host=$this->host;dbname=$this->db;charset=utf8";
            $this->conn = new PDO($dsn, $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $this->conn;
    }
    public function closeConexion()
    {
        $this->conn = null;
    }
```

En PDO es **obligatorio** el uso de try/catch.

Para poder usar la conexión primero la importaríamos con un **require_once** y después instanciaríamos el objeto:

```
// Database connection
$pdo = new ConexionPDO();
$dbh = $pdo->getConexion();
```

A la hora de realizar consultas usaremos las **consultas preparadas** de dos tipos, mediante el posterior paso de datos (con ?), o usando variables para los valores (con :nombre_variable).

```
// Prepared statement to check if user and pass are in the database
$stmt = $dbh->prepare("SELECT * FROM ejercicio10_usuarios WHERE nombre = ? AND pass = ?");
$nombre = $nombreEnviado;
$pass = $passEnviada;
$stmt->bindParam(1, $nombre);
$stmt->bindParam(2, $pass);
$stmt->execute();
```

La otra opción sería:

```
$stmt = $dbh->prepare("SELECT * FROM ejercicio10_usuarios WHERE nombre = :nombre AND pass = :pass");
$nombre = $nombreEnviado;
$pass = $passEnviada;
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':pass', $pass);
$stmt->execute();
```

Donde los números 1 y 2 indican el primer y segundo dato.

Existe otra opción para pasarle los parámetros llamada **bindValue()** en donde se enlaza el valor de la variable y permanece hasta el **execute()**.

Para el tratamiento de datos podríamos usar **fetch()** pasándole como parámetro el tipo de dato que queremos consultar, ```$row = $stmt->fetch(PDO::FETCH_OBJ)```, en este caso para tratarlo como objeto.

Indicar que en PDO **no es necesario liberar memoria ni cerrar la conexión**.