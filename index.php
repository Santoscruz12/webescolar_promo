<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Escolar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="./assets/css/header.css">
<link rel="stylesheet" href="./assets/css/blog.css">
<link rel="stylesheet" href="./assets/css/web_escolar.css">


    

    
</head>

<body>



  <?php include('./pages/header.php'); ?>






   <main class="main-content">
   
    <section id="inicio">
  <?php include('pages/inicio.php'); ?>
</section>

<section id="tecnologia">
  <?php include('pages/tecnologia.php'); ?>
</section>
<section id="testimonios">
  <?php include('pages/testimonios.php'); ?>
</section>

<div id="contenedor-fragmentos">
  <section class="seccion-carrusel" id="alumnos_padres">
    <?php include('pages/alumnos_padres.php'); ?>
  </section>

  <section class="seccion-carrusel" id="portal_soluciones">
    <?php include('pages/portal_soluciones.php'); ?>
  </section>

  <section class="seccion-carrusel" id="servicios_integrados">
    <?php include('pages/servicios_integrados.php'); ?>
  </section>

   <section class="seccion-carrusel" id="servicios_integrados2">
    <?php include('pages/servicios_integrados2.php'); ?>
  </section>
  <section class="seccion-carrusel" id="servicios_escolares">
    <?php include('pages/servicios_escolares.php'); ?>
  </section>
   <section class="seccion-carrusel" id="servicios_academicos">
    <?php include('pages/servicios_academicos.php'); ?>
  </section>
   <section class="seccion-carrusel" id="vinculo_360">
    <?php include('pages/vinculo_360.php'); ?>
  </section>
   <section class="seccion-carrusel" id="servicios_financieros">
    <?php include('pages/servicios_financieros.php'); ?>
  </section>

</div>
<section id="contactanos">
  <?php include('pages/contactanos.php'); ?>
</section>
<section id="conoce_institucion">
  <?php include('pages/conoce_institucion.php'); ?>
</section>
<section id="conoce_mas">
  <?php include('pages/conoce_mas.php'); ?>
</section>
<section id="blog">
  <?php include('pages/blog.php'); ?>
</section>
<section id="blog_barra">
  <?php include('pages/blog_barra.php'); ?>
</section>
<section id="conocemas">
  <?php include('pages/conocemas.php'); ?>
</section>
<section id="gracias">
  <?php include('pages/gracias.php'); ?>
</section>
</main>

</body>
<script src="assets/js/menu_toogle.js"></script>
<script src="assets/js/carrucel.js"></script>
<script src="assets/js/chat.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

</html>