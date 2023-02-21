<?php
class Genesis
{

    function __construct()
    {
    }

    function __destruct()
    {
    }

    public function encabezado($ruta){
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Prueba</title>
            <link rel="icon" href="<?php echo $ruta ?>assets/icono.png">
            <!--CDN Bootstrap 5.2.0 -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
            <!--Tipografía-->
            <link href="https: //fonts.googleapis.com/css2? family= Open+Sans:ital@1 & display=swap" rel="stylesheet">
        </head>

        <body>
<?php
    }

    public function piedepagina($ruta){
?>
            <!-- Option 1: Bootstrap Bundle with Popper-->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
            <!--Jquery<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        -->
            
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

            <!--CDN de sweetalert2 -->
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <!--Referencia al JS -->
            <script src="<?php echo $ruta;?>scripts/scripts.js"></script>
        </body>

        </html>
<?php
    }

    /**
     * Función que permite conectar a la BD haciendo uso
     * de PDO 
     */
    private function conexionBD(){
        $dbase = "usando_sql";
        $user = "root";
        $password = "";
        $dsn = "mysql:dbname=" . $dbase . ";host=localhost";

        try {
            $link = new PDO(
                $dsn,
                $user,
                $password,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
            );

            return $link;
            echo "Conectado...";
        } catch (PDOException $e) {
            echo "Conexion Fallida :( " . $e->getMessage();
        }
    }

    /**
     * Contiene todo el contenido del form
     */
    public function formularioAgregar(){
?>
        <div class="container">
            <div class="row d-flex justify-content-center align-items-center">
                <main class="col-md-7">
                    <h2 class="text-center">Formulario de registro</h2>
                    <br>
                    <form action="#" id="formulario" method="post">
                        
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-success text-light">Nombre &nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <input type="text" class="form-control" id="nombre" placeholder="Ingrese su nombre" name="nombre">
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text bg-success text-light">Apellidos &nbsp;&nbsp;</span>
                            <input type="text" class="form-control" id="apellido" placeholder="Ingrese sus apellidos" name="apellidos">
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text bg-success text-light">Correo &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <input type="email" class="form-control" id="correo" placeholder="Ingrese sus apellidos" name="correo">
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text bg-success text-light">Contraseña</span>
                            <input type="password" class="form-control" id="password" placeholder="Ingrese sus apellidos" name="contraseña">
                        </div>


                        <div class="mb-3 text-center">
                            <button type="submit" name="agregar" class="btn btn-outline-primary">Agregar</button>
                            <button  name="Regresar" class="btn btn-outline-success" onclick="window.location.href='index.php?opc=1'">Regresar</button>
                        </div>
                    </form>
                </main>
            </div>
        </div>
        
<?php
    }

    /**
     * Esta función recibe como parametro los datos que se van a insertar en la BD
     * en caso de ser exitoso, en consola se mostrará un mensaje exitoso de lo contrario
     * se mostrará el error de la consulta
     */
    public function agregarRegistro($nombre,$apellido,$correo,$contraseña){
        
            $conexion = $this->conexionBD();
            try {
                $sSQL = "INSERT INTO usuarios(nombre, apellido, correo, contraseña) VALUES(?,?,?,?);";
                $stm = $conexion->prepare($sSQL);
                $stm->bindValue(1, $nombre);
                $stm->bindValue(2, $apellido);
                $stm->bindValue(3, $correo);
                $stm->bindValue(4, $contraseña);
                $stm->execute();
                
                return "Registro Exitoso";
                
            } catch (PDOException $e) {
                echo "Error en la consulta: ".$e->getMessage();
            }
        }

    /**
     * Permite listar los registros de la BD haciendo uso de un filtro
     * que funciona con el nombre y apellido, ademas paginar los registros
     */
    public function listarRegistros(){

        $conexion = $this->conexionBD();

        try {

            /**
             * Se define la catidad de registros que se quiere mostrar 
             * por página
             */
            $registrosPorPagina = 2;

            /**
             * Sentencia SQL que permite saber el número total de registros 
             * en la tabla, para posteriormente guardar el resultado en una
             * variable
             */
            $sSQL = "SELECT COUNT(*) as total FROM usuarios";
            $stm = $conexion->prepare($sSQL);
            $stm->execute();
            $totalRegistros = $stm->fetch(PDO::FETCH_ASSOC)['total'];

            /**
             * Se Calcula la cantidad de páginas necesarias para 
             * mostrar todos los registros
             */
            $totalPaginas = ceil($totalRegistros / $registrosPorPagina);

            /**
             * Se obtiene el número de la página actual haciendo uso de get
             *  y sino está definida se le asigna el 1 como primer valor
             */
            $paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

            /**
             * Se Calcula el registro inicial para la página actual
             */
            $registroInicial = ($paginaActual - 1) * $registrosPorPagina;

            /**
             * En caso de recibir un parametro "filtrar" a través del metodo post
             * en la consulta se incluirá una cláusula WHERE que buscará aquellos
             * registros cuyo campo "nombre" o "apellido" contengan el valor de "filtrar"
             * y se limita a la cantidad de registros inicial. En caso contrario se muestran
             * todos los registros teniendo en cuenta el regitroinicial y por pagina.
             */
            if (isset($_GET["filtrar"])) {
                $sSQL = "SELECT * FROM usuarios WHERE CONCAT(nombre,'',apellido) LIKE ? LIMIT $registroInicial, $registrosPorPagina";
            } else {
                $sSQL = "SELECT * FROM usuarios LIMIT $registroInicial, $registrosPorPagina";
            }

            $stm = $conexion->prepare($sSQL);
            if (isset($_GET["filtrar"])) {
                $var = $_GET["filtrar"];
                $stm->bindValue(1, "%$var%");
            }

            $stm->execute();
        ?>
            <div class="container">
                <div class="row d-flex justify-content-center align-items-center">
                    <h2>Tabla Registros</h2>
                    <p>Se pueden encontrar todos los registros guardados en la base de datos:</p>

                    <form method="GET" action="">
                        <strong>Filtro</strong>
                        <input type="text" class="form-control" name="filtrar" value="" placeholder="Buscar" size="76" />
                        <input type="submit" class="btn btn-outline-success" value="Filtrar" />
                        <input type="hidden" name="opc" value="1" />
                        <input type="button" value="Agregar Registro" class="btn btn-outline-success" onclick="window.location='./index.php?opc=5';">
                    </form>
                    <!--Tabla para visualizar los registros de la BD con un while-->
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Correo</th>
                                <th>Contraseña</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($rs = $stm->fetch(PDO::FETCH_ASSOC)) : ?>
                                <tr>
                                    <td><?php echo $rs["nombre"]; ?></td>
                                    <td><?php echo $rs["apellido"]; ?></td>
                                    <td><?php echo $rs["correo"]; ?></td>
                                    <td><?php echo $rs["contraseña"]; ?></td>
                                </tr>
                            <?php endwhile ?>
                        </tbody>
                    </table>

                    <!--Barra de paginación-->
                    <nav>
                        <ul class="pagination">
                            <?php if ($paginaActual > 1) : ?>
                                <li class="page-item"><a class="page-link" href="index.php?opc=1&pagina=<?php echo $paginaActual - 1; ?>">Anterior</a></li>
                            <?php endif; ?>
                            <?php for ($i = 1; $i <= $totalPaginas; $i++) : ?>
                                <?php if ($i == $paginaActual) : ?>
                                    <li class="page-item active"><a class="page-link" href="#"><?php echo $i; ?></a></li>
                                <?php else : ?>
                                    <li class="page-item"><a class="page-link" href="index.php?opc=1&pagina=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                <?php endif; ?>
                            <?php endfor; ?>
                            <?php if ($paginaActual < $totalPaginas) : ?>
                                <li class="page-item"><a class="page-link" href="index.php?opc=1&pagina=<?php echo $paginaActual + 1; ?>">Siguiente</a></li>
                            <?php endif; ?>
                        </ul>
                    </nav>

                </div>
            </div>
       <?php
        } catch (PDOException $e) {
            "Error en la consulta: " . $e->getMessage();
        }
    }


    public function formularioEliminar(){
    }

    public function formularioEditar(){
    }

    public function consultar(){
    }

//Fin de la clase
}
?>