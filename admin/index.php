<?php 
    require '../includes/funciones.php';
    $auth = estaAutenticado();

    if (!$auth) {
        header('Location: /');
    }

    //Importar la conexión
    require '../includes/config/database.php';
    $db = conectarDB();

    //Escribir el Query
    $query = "SELECT * FROM propiedades";
    
    //Consultar la BD
    $resultadoConsulta = mysqli_query($db, $query);

    //Muestra Mensaje condicional
    $resultado = $_GET['resultado'] ?? null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if ($id) {

            //Eliminar el archivo
            $query ="SELECT imagen FROM propiedades WHERE id = ${id}";
            $resultado = mysqli_query($db, $query);
            $propiedad = mysqli_fetch_assoc($resultado);
            unlink('../imagenes/' . $propiedad['imagen']);

            //Eliminar la propiedad
            $query = "DELETE FROM propiedades WHERE id = ${id}";
            $resultado = mysqli_query($db, $query);
            if ($resultado) {
                header('location: /admin?resultado=3&id='.$id);
                var_dump($_GET);
            }
        }
    }

    //Incluye un template
    incluirTemplate ('header'); 
    ?>
    
    <main class="contenedor seccion">
        <h1>Administrados de Bienes Raices</h1>
        <?php if ( intval( $resultado ) === 1): ?>
            <p class="alerta exito">Anuncio creado correctamente</p>
        <?php elseif ( intval( $resultado ) === 2 ): ?>
            <p class="alerta exito">Anuncio <?php echo $_GET['id'];?> actualizado correctamente</p>
        <?php elseif ( intval( $resultado ) === 3 ): ?>
            <p class="alerta exito">Anuncio <?php echo $_GET['id'];?> eliminado correctamente</p>
        <?php endif;?>

        <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>

        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>  <!--Mostrar los resultados-->
                <?php while( $propiedad = mysqli_fetch_assoc($resultadoConsulta) ): ?>
                    <tr>
                        <td><?php echo $propiedad['id']; ?></td>
                        <td><?php echo $propiedad['titulo']; ?></td>
                        <td><img src="/imagenes/<?php echo $propiedad['imagen']; ?>" class="imagen-tabla" alt=""></td>
                        <td><?php echo "$". $propiedad['precio']; ?></td>
                        <td>
                            <form method="POST" class="w-100">
                                <input type="hidden" name="id" value="<?php echo $propiedad['id']; ?>">
                                <input type="submit" class="boton-rojo-block" value="Eliminar">
                            </form>
                            <!-- <img src="/build/img/trash-alt.svg" class="icono-boton"> -->
                                
                            </a>
                            <a href="propiedades/actualizar.php?id=<?php echo $propiedad['id']; ?>" class="boton-amarillo-block">
                                <img src="/build/img/edit.svg" class="icono-boton editar">
                                Actualizar
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>

<?php 
    //Cerrar la conexión
    mysqli_close($db);

    incluirTemplate ('footer'); 
    ?>