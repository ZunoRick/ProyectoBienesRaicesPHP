<?php 
    require '../../includes/app.php';
    use App\Propiedad;
    use Intervention\Image\ImageManagerStatic as Image;

    estaAutenticado();

    //Base de datos
    $db = conectarDB();

    $propiedad = new Propiedad();

    //Consultar para obtener los vendedores
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta);

    //Arreglo con mensaje de errores 
    $errores = Propiedad::getErrores();

    //Ejecutar el código después de que el usuario envia el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        /* Crea una nueva instancia */
        $propiedad = new Propiedad($_POST['propiedad']);

        /** Subida de archivos **/
        //Generar un nombre único
        $nombreImagen = md5( uniqid( rand(), true) ) . ".jpg";

        /*Setear la imagen*/
        //Realiza un resize a la imagen con intervention
        if ($_FILES['propiedad']['tmp_name']['imagen']) {
            $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
            $propiedad->setImagen($nombreImagen);
        }

        /*Validar */
        $errores = $propiedad->validar();
        
        //Revisar que el arreglo de errores esté vacío
        if (empty($errores)) {
            //Crear una carpeta
            if (!is_dir(CARPETA_IMAGENES)) {
                mkdir(CARPETA_IMAGENES);
            }

            //Guarda en la base de datos
            //Mensaje de éxito o error
            if ($propiedad->guardar()) {
                //Guarda la imagen en el servidor
                $image->save(CARPETA_IMAGENES . $nombreImagen);
                header('Location: /admin?resultado=1');
            }
        }   
    }

    incluirTemplate ('header'); 
    ?>
    
    <main class="contenedor seccion">
        <h1>Crear</h1>

        <a href="/admin" class="boton boton-verde">&larr; Volver</a>

        <?php foreach ($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <form action="/admin/propiedades/crear.php" class="formulario" method="POST" enctype="multipart/form-data">
            <?php include '../../includes/templates/formulario_propiedades.php';?>
            <div class="alinear-derecha">
                <input type="submit" value="Crear Propiedad" class="boton boton-verde">
            </div>
        </form>
    </main>

<?php incluirTemplate ('footer'); ?>