<?php
// Incluir funciones del blog
require_once __DIR__ . '/../blog_functions.php';

// Obtener posts recientes (incluir todos)
$posts_to_show = getRecentBlogPosts(10);
?>

<div class="blog-containerbg">
  <div class="blog-headerbg">
    <span>Blog</span>
    <hr>
  </div>

  <div class="blog-mainbg">
    <div class="blog-buttonbg">
      <button onclick="window.location.href='#blog'">Ver artículo principal</button>
      <a href="/innova/hola/webescolar_promo/pages/admin_blog.php" class="btn-new-post">
        <i class="fas fa-plus"></i> Crear Nuevo Post
      </a>
    </div>

<<<<<<< HEAD
    
      <div class="blog_barra1">
        <img src="/innova/webescolar_promo/assets/image/Servicios_escolares.png" alt="Deserción estudiantil">
        <div class="card-text">Cómo las Universidades Pueden Reducir la Deserción
          Estudiantil con Tecnología de Gestión Escolar.</div>
      </div>
      <div class="blog_barra1">
        <img src="/innova/webescolar_promo/assets/image/Servicios_escolares.png" alt="Deserción estudiantil">
         <div class="card-text">Soluciones Digitales para Combatir la Deserción Escolar
          en Universidades</div>
      </div>
       <div class="blog_barra1">
        <img src="/innova/webescolar_promo/assets/image/Servicios_escolares.png" alt="Deserción estudiantil">
         <div class="card-text">Herramientas Digitales que Ayudan a Prevenir la</div>
      </div>
    
    <!--
      <h1 class="blog-titlebg">Cómo las Universidades Pueden Reducir la Deserción Estudiantil<br>
      <br>con Tecnología de Gestión Escolar.</h1>
      <p class="blog-datebg">16 Diciembre 2024</p>

      <div class="blog-contentbg">
        <div class="blog-imagebg">
          <img  src="/innova/webescolar_promo/assets/image/Imagen_blog.png" alt="Deserción estudiantil">
        </div>
        <div class="blog-textbg">
          <p><strong>El problema de la deserción estudiantil y su impacto financiero y reputacional en las universidades.</strong></p>
          <p><strong>Introducción</strong><br>
          La deserción estudiantil es uno de los mayores retos que enfrentan las universidades hoy en día. No solo representa una pérdida académica significativa, sino que también afecta la estabilidad financiera, la reputación de la institución y, sobre todo, el futuro de los estudiantes.</p>
          <p>En un panorama educativo donde la tecnología juega un papel crucial, la implementación de herramientas avanzadas de gestión escolar, como WebEscolar, puede hacer una diferencia significativa.</p>
        </div>
      </div>
    -->
=======
    <?php if (!empty($posts_to_show)): ?>
      <div class="blog-posts-grid">
        <?php foreach ($posts_to_show as $post): ?>
          <a class="blog_barra1" href="/innova/hola/webescolar_promo/blog.php?id=<?php echo $post['id']; ?>" style="text-decoration:none; color:inherit;">
            <?php if (!empty($post['imagen'])): ?>
              <img src="<?php echo htmlspecialchars($post['imagen']); ?>" alt="<?php echo htmlspecialchars($post['titulo']); ?>">
            <?php else: ?>
              <div class="blog-img-default">Sin imagen</div>
            <?php endif; ?>
            <div class="card-text">
              <h3><?php echo htmlspecialchars($post['titulo']); ?></h3>
              <div class="post-meta">
                <span class="post-date"><?php echo formatBlogDate($post['fecha']); ?></span>
                <span class="post-category"><?php echo getCategoryName($post['categoria']); ?></span>
              </div>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="blog-empty-list">
        <p>No hay más artículos disponibles en este momento.</p>
        <p>¡Vuelve pronto para más contenido interesante!</p>
      </div>
    <?php endif; ?>
>>>>>>> cbceb592b3b5d9123a30d01f68a2deeae5f3d48a
  </div>
</div>