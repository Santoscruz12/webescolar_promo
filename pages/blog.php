
<?php
// Incluir funciones del blog
require_once __DIR__ . '/../blog_functions.php';

// Obtener el post más reciente
$recent_posts = getRecentBlogPosts(1);
$post = !empty($recent_posts) ? $recent_posts[0] : null;
?>

<div class="blog-containerbg">
  <div class="blog-headerbg">
    <span>Blog</span>
    <hr>
  </div>

  <div class="blog-mainbg">
    <div class="blog-buttonbg">
      <button onclick="window.location.href='#blog_barra'">Más temas de interés</button>
      <a href="admin_blog.php" class="btn-new-post">
        <i class="fas fa-plus"></i> Crear Nuevo Post
      </a>
    </div>
    
    <?php if ($post): ?>
      <h1 class="blog-titlebg"><?php echo htmlspecialchars($post['titulo']); ?></h1>
      <p class="blog-datebg"><?php echo formatBlogDate($post['fecha']); ?></p>

      <div class="blog-contentbg">

        <?php if (!empty($post['imagen'])): ?>
          <div class="blog-imagebg">
            <img src="<?php echo htmlspecialchars($post['imagen']); ?>" alt="<?php echo htmlspecialchars($post['titulo']); ?>">
          </div>
        <?php else: ?>
          <div class="blog-imagebg blog-img-default">Sin imagen</div>
        <?php endif; ?>

        <div class="blog-textbg">
          <p><strong><?php echo htmlspecialchars($post['resumen']); ?></strong></p>
          <div class="blog-content-full">
            <?php echo nl2br(htmlspecialchars($post['contenido'])); ?>
          </div>
          <div class="blog-meta">
            <p><strong>Categoría:</strong> <?php echo getCategoryName($post['categoria']); ?></p>
            <p><strong>Autor:</strong> <?php echo htmlspecialchars($post['autor']); ?></p>
            <?php if (!empty($post['tags'])): ?>
              <p><strong>Tags:</strong> 
                <?php foreach ($post['tags'] as $tag): ?>
                  <span class="tag"><?php echo htmlspecialchars($tag); ?></span>
                <?php endforeach; ?>
              </p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php else: ?>
      <div class="blog-empty">
        <h2>No hay artículos disponibles</h2>
        <p>Próximamente publicaremos contenido interesante sobre tecnología educativa y gestión escolar.</p>
        <a href="admin_blog.php" class="btn-admin">Administrar Blog</a>
      </div>
    <?php endif; ?>
  </div>
</div>
