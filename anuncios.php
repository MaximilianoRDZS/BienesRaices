<?php
    require 'includes/app.php';
    incluirTemplates('header');
?>

    <main class="contenedor seccion">

        <h2>Casas y Departamentos en Venta</h2>


        <?php
            $limite = 10;
            include 'includes/templates/anuncios.php';
        ?>
    </main>

<?php
    incluirTemplates('footer');
?>

<script src="build/js/bundle.min.js"></script>
