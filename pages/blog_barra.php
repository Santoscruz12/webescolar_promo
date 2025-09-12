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

  </div>
</div>