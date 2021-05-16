<?php 
    require 'includes/funciones.php';
    incluirTemplate ('header'); 
    ?>
    
    <main class="contenedor seccion">
        <h1>Conoce sobre Nosotros</h1>

        <div class="contenido-nosotros">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/nosotros.webp" type="image/webp">
                    <source srcset="build/img/nosotros.jpg" type="image/jpeg">
                    <img src="build/img/nosotros.jpg" alt="Sobre Nosotros" loading="lazy">
                </picture>
            </div>

            <div class="texto-nosotros">
                <blockquote>
                    25 Años de experiencia
                </blockquote>

                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores explicabo placeat itaque architecto ab, accusamus quibusdam, cum eligendi neque quidem at, corporis aspernatur similique iusto commodi tempora soluta quas? Voluptate.
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores explicabo placeat itaque architecto ab, accusamus quibusdam, cum eligendi neque quidem at, corporis aspernatur similique iusto commodi tempora soluta quas? Voluptate.
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores explicabo placeat itaque architecto ab, accusamus quibusdam, cum eligendi neque quidem at, corporis aspernatur similique iusto commodi tempora soluta quas? Voluptate.
                </p>

                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores explicabo placeat itaque architecto ab, accusamus quibusdam, cum eligendi neque quidem at, corporis aspernatur similique iusto commodi tempora soluta quas? Voluptate.
                </p>
            </div> <!--.texto-nosotros-->>
        </div>
    </main>

    <section class="contenedor seccion">
        <h1>Más Sobre Nosotros</h1>
        <div class="iconos-nosotros">
            <div class="icono">
                <img src="build/img/icono1.svg" alt="Icono seguridad" loading="lazy">
                <h3>Seguridad</h3>
                <p>Dolorem laboriosam, exercitationem eos placeat nulla ipsam qui fugit. Provident accusamus voluptatibus illum possimus vero, doloribus quasi. Reiciendis quas quaerat corporis deleniti.</p>
            </div>

            <div class="icono">
                <img src="build/img/icono2.svg" alt="Icono Precio" loading="lazy">
                <h3>Precio</h3>
                <p>Dolorem laboriosam, exercitationem eos placeat nulla ipsam qui fugit. Provident accusamus voluptatibus illum possimus vero, doloribus quasi. Reiciendis quas quaerat corporis deleniti.</p>
            </div>

            <div class="icono">
                <img src="build/img/icono3.svg" alt="Icono Tiempo" loading="lazy">
                <h3>Tiempo</h3>
                <p>Dolorem laboriosam, exercitationem eos placeat nulla ipsam qui fugit. Provident accusamus voluptatibus illum possimus vero, doloribus quasi. Reiciendis quas quaerat corporis deleniti.</p>
            </div>
        </div>
    </section>

<?php incluirTemplate ('footer'); ?>