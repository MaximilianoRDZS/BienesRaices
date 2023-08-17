<?php
    require '../includes/funciones.php';
    // Proteger esta ruta.
    
    $auth = estaAutenticado();
    if(!$auth) {
        header('Location: /');
    }

    //Importa la conexión
    require '../includes/config/database.php';

    $db = conectarDB();

    // //Escribir el Query
    $query = "SELECT * FROM propiedades";

    // //Consultar la BD
    $resultado = mysqli_query($db, $query);

    // //Muestra mensaje condicional
    $resultado = $_GET['resultado'] ?? null;

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if($id) {

            //Eliminar el archivo
            $query = "SELECT imagen FROM propiedades WHERE id = ${id}";

            $resultado = mysqli_query($db, $query);
            $propiedad = mysqli_fetch_assoc($resultado);

            unlink('../../imagenes/' . $propiedad['imagen']);

            //Eliminar la propiedad
            $query = "DELETE FROM propiedades WHERE id = ${id}";
            $resultado = mysqli_query($db, $query);

            if($resultado) {
                header('Location: /bienesraices/admin?resultado=3');
            }
        }
    }

    //Incluye un template

    incluirTemplates('header');
?>

    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>

        <?php if( intval( $resultado ) === 1): ?>  
            <p class="alerta exito">Anuncio Creado correctamente</p>  
        <?php elseif ( intval( $resultado ) === 2): ?>
            <p class="alerta exito">Anuncio Actualizado correctamente</p>
        <?php elseif ( intval( $resultado ) === 3): ?>
            <p class="alerta exito">Anuncio Eliminado correctamente</p>
        <?php endif; ?>

        <a href="<?php $_SERVER['SERVER_NAME'] ?>/bienesraices/admin/propiedades/crear.php" class="boton boton-verde">Nueva propiedad</a>

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

            <tbody> <!-- Mostrar  los Resultados -->
                <?php while( $propiedad = mysqli_fetch_assoc($resultadoConsulta) ): ?>
                <tr>
                    <td><?php echo $propiedad['id']; ?></td>
                    <td><?php echo $propiedad['titulo']; ?></td>
                    <td><img src="<?php $_SERVER['SERVER_NAME'] ?>/bienesraices/imagenes/<?php echo $propiedad['imagen']; ?>"/></td>
                    <td><?php echo $propiedad['precio']; ?></td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $propiedad['id']; ?>">

                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="<?php $_SERVER['SERVER_NAME'] ?>/bienesraices/admin/propiedades/actualizar.php?id=<?php echo $propiedad['id']; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>

<?php

    //Cerrar la conexión
    mysqli_close($db);

    incluirTemplates('footer');
?>

<script src="/bienesraices/build/js/bundle.min.js"></script>