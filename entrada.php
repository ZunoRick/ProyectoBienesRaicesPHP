<?php 
    require 'includes/app.php';
    incluirTemplate ('header'); 
    ?>
    
    <main class="contenedor seccion contenido-centrado">
        <h1>Guía para la decoración de tu hogar</h1>

        <picture>
            <source srcset="build/img/destacada2.webp" type="image/webp">
            <source srcset="build/img/destacada2.jpg" type="image/jpeg">
            <img src="build/img/destacada2.jpg" alt="Imagen de la Propiedad" loading="lazy">
        </picture>

        <p class="informacion-meta">Escrito el: <span>20/10/2021</span> Por: <span>Admin</span> </p>

        <div class="resumen-propiedad">
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores explicabo placeat itaque architecto ab, accusamus quibusdam, cum eligendi neque quidem at, corporis aspernatur similique iusto commodi tempora soluta quas? Voluptate.
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores explicabo placeat itaque architecto ab, accusamus quibusdam, cum eligendi neque quidem at, corporis aspernatur similique iusto commodi tempora soluta quas? Voluptate.
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores explicabo placeat itaque architecto ab, accusamus quibusdam, cum eligendi neque quidem at, corporis aspernatur similique iusto commodi tempora soluta quas? Voluptate.
            </p>

            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores explicabo placeat itaque architecto ab, accusamus quibusdam, cum eligendi neque quidem at, corporis aspernatur similique iusto commodi tempora soluta quas? Voluptate.
            </p>
        </div>
    </main>

<?php incluirTemplate ('footer'); ?>