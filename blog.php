<?php
// Zona horaria
date_default_timezone_set('America/Mexico_City');

require_once __DIR__ . '/blog_functions.php';

$postsPerPage = 9;
$currentPostId = isset($_GET['id']) ? $_GET['id'] : null;
$searchTerm = isset($_GET['q']) ? trim($_GET['q']) : '';
$category = isset($_GET['cat']) ? trim($_GET['cat']) : '';

$allPosts = [];
if ($searchTerm !== '') {
	$allPosts = searchBlogPosts($searchTerm);
} elseif ($category !== '') {
	$allPosts = getBlogPostsByCategory($category);
} else {
	$allPosts = getRecentBlogPosts(1000);
}

// Paginación
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$totalPosts = count($allPosts);
$totalPages = max(1, (int)ceil($totalPosts / $postsPerPage));
$offset = ($page - 1) * $postsPerPage;
$posts = array_slice($allPosts, $offset, $postsPerPage);

function urlWith($params) {
	$query = array_merge($_GET, $params);
	return 'blog.php?' . http_build_query($query);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Blog | WebEscolar</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<link rel="stylesheet" href="assets/css/header.css">
	<link rel="stylesheet" href="assets/css/blog.css">
	<link rel="stylesheet" href="assets/css/web_escolar.css">
</head>
<body>
	<?php include __DIR__ . '/pages/header.php'; ?>

	<main style="padding-top:80px; max-width: 1100px; margin: 0 auto;">
		<div class="blog-container">
			<div class="blog-header" style="display:flex; align-items:center; justify-content:space-between; gap:12px;">
				<div>
					<span style="font-weight:700; font-size:22px; color:#1e3070;">Blog</span>
					<hr>
				</div>
				<form method="get" action="blog.php" style="display:flex; gap:8px; align-items:center;">
					<input type="text" name="q" placeholder="Buscar en el blog..." value="<?php echo htmlspecialchars($searchTerm); ?>" style="padding:10px 12px; border:1px solid #e1e5e9; border-radius:8px; min-width:240px;">
					<button type="submit" class="btn-new-post" style="background:#1e3070; box-shadow:none;">Buscar</button>
					<a href="https://blog.webescolar.com.mx/" class="btn-new-post"><i class="fas fa-plus"></i> Ir al blog</a>
				</form>
			</div>

			<?php if ($currentPostId): $post = getBlogPostById($currentPostId); ?>
				<?php if ($post): ?>
					<h1 class="blog-title"><?php echo htmlspecialchars($post['titulo']); ?></h1>
					<p class="blog-date"><?php echo formatBlogDate($post['fecha']); ?> · <?php echo getCategoryName($post['categoria']); ?> · Por <?php echo htmlspecialchars($post['autor']); ?></p>
					<div class="blog-content">
						<?php if (!empty($post['imagen'])): ?>
							<div class="blog-image"><img src="<?php echo htmlspecialchars($post['imagen']); ?>" alt="<?php echo htmlspecialchars($post['titulo']); ?>"></div>
						<?php endif; ?>
						<div class="blog-text">
							<p><strong><?php echo htmlspecialchars($post['resumen']); ?></strong></p>
							<?php if (!empty($post['video'])): ?>
							<?php $vpath = htmlspecialchars($post['video']); $ext = strtolower(pathinfo($post['video'], PATHINFO_EXTENSION)); $type = ($ext==='webm'?'video/webm':'video/mp4'); ?>
							<div style="margin:15px 0;">
								<video controls controlsList="nodownload" preload="metadata" style="max-width:100%; border-radius:8px; outline:none;" <?php if(!empty($post['imagen'])){ echo 'poster="'.htmlspecialchars($post['imagen']).'"'; } ?>>
									<source src="<?php echo $vpath; ?>" type="<?php echo $type; ?>">
									Tu navegador no soporta reproducción de video.
								</video>
							</div>
							<?php endif; ?>
							<div class="blog-content-full"><?php echo nl2br(htmlspecialchars($post['contenido'])); ?></div>
							<div class="blog-meta">
								<p><strong>Tags:</strong>
									<?php foreach ($post['tags'] as $tag): ?>
										<span class="tag"><?php echo htmlspecialchars($tag); ?></span>
									<?php endforeach; ?>
								</p>
							</div>
						</div>
					</div>

					<?php $related = getRelatedBlogPosts($post, 3); if (!empty($related)): ?>
						<h3 style="margin-top:30px; color:#1e3070;">También te puede interesar</h3>
						<div class="blog-posts-grid">
							<?php foreach ($related as $r): ?>
								<div class="blog_barra1" onclick="window.location.href='blog.php?id=<?php echo $r['id']; ?>'">
									<?php if (!empty($r['imagen'])): ?>
										<img src="<?php echo htmlspecialchars($r['imagen']); ?>" alt="<?php echo htmlspecialchars($r['titulo']); ?>">
									<?php endif; ?>
									<div class="card-text">
										<h3><?php echo htmlspecialchars($r['titulo']); ?></h3>
										<p class="post-excerpt"><?php echo generateBlogExcerpt($r['resumen'], 100); ?></p>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				<?php else: ?>
					<p>No se encontró el artículo.</p>
				<?php endif; ?>

			<?php else: ?>
				<!-- Filtros -->
				<div style="display:flex; gap:10px; flex-wrap:wrap; margin: 10px 0 20px;">
					<?php foreach (getBlogCategories() as $key => $label): ?>
						<a href="<?php echo urlWith(['cat' => $key, 'page' => 1, 'q' => null, 'id' => null]); ?>" class="tag" style="text-decoration:none; <?php echo ($category === $key ? 'background:#2c4a8a;' : ''); ?>">
							<?php echo htmlspecialchars($label); ?>
						</a>
					<?php endforeach; ?>
					<a href="blog.php" class="tag" style="text-decoration:none; background:#6c757d;">Todas</a>
				</div>

				<!-- Listado -->
				<div class="blog-posts-grid">
					<?php if (!empty($posts)): foreach ($posts as $p): ?>
						<div class="blog_barra1" onclick="window.location.href='blog.php?id=<?php echo $p['id']; ?>'">
							<?php if (!empty($p['imagen'])): ?>
								<img src="<?php echo htmlspecialchars($p['imagen']); ?>" alt="<?php echo htmlspecialchars($p['titulo']); ?>">
							<?php endif; ?>
							<div class="card-text">
								<h3><?php echo htmlspecialchars($p['titulo']); ?></h3>
								<p class="post-excerpt"><?php echo generateBlogExcerpt($p['resumen'], 110); ?></p>
								<div class="post-meta">
									<span class="post-date"><?php echo formatBlogDate($p['fecha']); ?></span>
									<span class="post-category"><?php echo getCategoryName($p['categoria']); ?></span>
								</div>
							</div>
						</div>
					<?php endforeach; else: ?>
						<p>No hay artículos para mostrar.</p>
					<?php endif; ?>
				</div>

				<?php if ($totalPages > 1): ?>
					<div style="display:flex; justify-content:center; gap:8px; margin:25px 0;">
						<?php for ($i = 1; $i <= $totalPages; $i++): ?>
							<a class="tag" style="text-decoration:none; <?php echo ($i === $page ? 'background:#2c4a8a;' : ''); ?>" href="<?php echo urlWith(['page' => $i, 'id' => null]); ?>"><?php echo $i; ?></a>
						<?php endfor; ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</main>
<script src="assets/js/menu_toogle.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
