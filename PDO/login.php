<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesiones y cookies</title>

    <!-- ESTILOS CSS -->
    <style>
        *{
            width: 80%;
            margin: 0px auto;
            padding: 0px;
        }

        h5{
            text-align: center;
        }

        form{
            margin: 10px;
            padding: 5px;
        }

        fieldset{
            margin-top: 10px;
            border: 1px dashed blue;
            box-shadow: 0px 2px 4px gray;
        }

        input[type="submit"]{
            width: 30%;
            margin-top: 10px;
        }

        #nota{
            margin-top: 15px;
        }  

        #contenedor{
            margin-top: 30px;
        }  
    </style>
</head>
<body>
    
    <div id="contenedor">
        <h5>Esta zona tiene el acceso restringido</h5>
        <h5>Para entrar debe identificarse</h5>
    </div>

    <fieldset>
        <form action="contenido.php" method="POST">
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario">

            <br>

            <label for="pass">Clave:</label>
            <input type="password" name="pass" id="pass">

            <input type="submit" value="Entrar" name="login">
        </form>
    </fieldset>

    <p id="nota">
        NOTA: Si no dispone de identificación o tiene problemas para entrar
        póngase en contacto con el <a href="">administrador</a> del sitio.
    </p>
</body>
</html>