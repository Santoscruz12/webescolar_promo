<?php
$editId = isset($_GET['edit']) ? $_GET['edit'] : '';
$editingPost = null;
if ($editId) {
    require_once __DIR__ . '/../blog_functions.php';
    $editingPost = getBlogPost($editId);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración del Blog - Web Escolar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Red Hat Display', sans-serif;
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }

        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .admin-header {
            background: linear-gradient(135deg, #1e3070, #2c4a8a);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            text-align: center;
        }

        .admin-header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .admin-header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .form-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #1e3070;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 16px;
            font-family: inherit;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #1e3070;
        }

        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .btn {
            background: linear-gradient(135deg, #1e3070, #2c4a8a);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(30, 48, 112, 0.3);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d, #5a6268);
        }

        .btn-success {
            background: #403e50;
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #c82333);
        }

        .button-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }

        .posts-list {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .posts-list h2 {
            color: #1e3070;
            margin-bottom: 20px;
            text-align: center;
        }

        .post-item {
            border: 1px solid #e1e5e9;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            transition: box-shadow 0.3s ease;
        }

        .post-item:hover {
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .post-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .post-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #1e3070;
        }

        .post-date {
            color: #666;
            font-size: 0.9rem;
        }

        .post-actions {
            display: flex;
            gap: 10px;
        }

        .btn-small {
            padding: 8px 15px;
            font-size: 14px;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .button-group {
                flex-direction: column;
            }
            
            .post-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1><i class="fas fa-blog"></i> Administración del Blog</h1>
            <p>Gestiona los artículos de tu blog de manera fácil y eficiente</p>
        </div>

        <?php
        // Mostrar mensajes de éxito o error
        if (isset($_GET['success'])) {
            echo '<div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> ' . htmlspecialchars($_GET['success']) . '
                  </div>';
        }
        if (isset($_GET['error'])) {
            echo '<div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> ' . htmlspecialchars($_GET['error']) . '
                  </div>';
        }
        ?>

        <div class="form-container">
            <h2><i class="fas fa-plus-circle"></i> <?php echo $editingPost ? 'Editar Post' : 'Crear Nuevo Post'; ?></h2>
            <form action="/innova/webescolar_promo/blog_handler.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="<?php echo $editingPost ? 'update' : 'create'; ?>">
                <?php if ($editingPost): ?>
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($editingPost['id']); ?>">
                <?php endif; ?>
                <div class="form-row">
                    <div class="form-group">
                        <label for="titulo">Título del Post *</label>
                        <input type="text" id="titulo" name="titulo" required value="<?php echo $editingPost ? htmlspecialchars($editingPost['titulo']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="fecha">Fecha de Publicación *</label>
                        <input type="date" id="fecha" name="fecha" required value="<?php echo $editingPost ? htmlspecialchars($editingPost['fecha']) : ''; ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="categoria">Categoría *</label>
                        <select id="categoria" name="categoria" required>
                            <?php
                            $cats = ['tecnologia'=>'Tecnología Educativa','gestion'=>'Gestión Escolar','innovacion'=>'Innovación','tutoriales'=>'Tutoriales','noticias'=>'Noticias'];
                            foreach ($cats as $key=>$label) {
                                $sel = ($editingPost && $editingPost['categoria']===$key) ? 'selected' : '';
                                echo "<option value=\"$key\" $sel>$label</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="autor">Autor *</label>
                        <input type="text" id="autor" name="autor" required value="<?php echo $editingPost ? htmlspecialchars($editingPost['autor']) : ''; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="resumen">Resumen/Descripción Corta *</label>
                    <textarea id="resumen" name="resumen" required><?php echo $editingPost ? htmlspecialchars($editingPost['resumen']) : ''; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="contenido">Contenido Completo *</label>
                    <textarea id="contenido" name="contenido" required><?php echo $editingPost ? htmlspecialchars($editingPost['contenido']) : ''; ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="imagen">Imagen Principal <?php echo $editingPost && !empty($editingPost['imagen']) ? '(dejar en blanco para conservar)' : ''; ?></label>
                        <input type="file" id="imagen" name="imagen" accept="image/*">
                        <?php if ($editingPost && !empty($editingPost['imagen'])): ?>
                            <small>Actual: <?php echo htmlspecialchars($editingPost['imagen']); ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="video">Video (opcional)</label>
                        <input type="file" id="video" name="video" accept="video/mp4,video/webm">
                        <?php if ($editingPost && !empty($editingPost['video'])): ?>
                            <small>Actual: <?php echo htmlspecialchars($editingPost['video']); ?></small>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="estado">Estado</label>
                    <select id="estado" name="estado">
                        <option value="publicado" <?php echo ($editingPost && $editingPost['estado']==='publicado')?'selected':''; ?>>Publicado</option>
                        <option value="borrador" <?php echo ($editingPost && $editingPost['estado']==='borrador')?'selected':''; ?>>Borrador</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tags">Tags (separados por comas)</label>
                    <input type="text" id="tags" name="tags" value="<?php echo $editingPost ? htmlspecialchars(implode(', ', $editingPost['tags'])) : ''; ?>" placeholder="ej: educación, tecnología, gestión">
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> <?php echo $editingPost ? 'Actualizar Post' : 'Guardar Post'; ?>
                    </button>
                    <a href="/innova/webescolar_promo/pages/admin_blog.php" class="btn btn-secondary">
                        <i class="fas fa-undo"></i> Cancelar
                    </a>
                    <a href="/innova/webescolar_promo/blog.php" class="btn">
                        <i class="fas fa-home"></i> Ir al Blog
                    </a>
                </div>
            </form>
        </div>

        <div class="posts-list">
            <h2><i class="fas fa-list"></i> Posts Existentes</h2>
            <div id="posts-container">
                <!-- Los posts se cargarán aquí dinámicamente -->
            </div>
        </div>
    </div>

    <script>
        // Cargar posts existentes al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            loadPosts();
            if (!<?php echo $editingPost ? 'true' : 'false'; ?>) {
                const today = new Date().toISOString().split('T')[0];
                const fecha = document.getElementById('fecha'); if (fecha && !fecha.value) fecha.value = today;
            }
        });

        function loadPosts() {
            fetch('/innova/webescolar_promo/blog_handler.php?action=get_posts')
                .then(r => r.json())
                .then(data => {
                    const c = document.getElementById('posts-container');
                    if (data.posts && data.posts.length) {
                        c.innerHTML = data.posts.map(post => `
                            <div class="post-item">
                                <div class="post-header">
                                    <div class="post-title">${post.titulo}</div>
                                    <div class="post-date">${post.fecha}</div>
                                </div>
                                <p><strong>Categoría:</strong> ${post.categoria} | <strong>Autor:</strong> ${post.autor}</p>
                                <p><strong>Estado:</strong> <span style="color: ${post.estado === 'publicado' ? 'green' : 'orange'}">${post.estado}</span></p>
                                <p>${post.resumen}</p>
                                <div class="post-actions">
                                    <a class="btn btn-small" href="/innova/webescolar_promo/pages/admin_blog.php?edit=${encodeURIComponent(post.id)}">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <button class="btn btn-small btn-danger" onclick="deletePost('${post.id}')">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </div>
                            </div>`).join('');
                    } else {
                        c.innerHTML = '<p style="text-align: center; color: #666;">No hay posts disponibles.</p>';
                    }
                }).catch(()=>{
                    document.getElementById('posts-container').innerHTML = '<p style="text-align: center; color: red;">Error al cargar los posts.</p>';
                });
        }

        function deletePost(id) {
            if (!confirm('¿Eliminar este post?')) return;
            fetch('/innova/webescolar_promo/blog_handler.php', {
                method: 'POST', headers: {'Content-Type':'application/x-www-form-urlencoded'},
                body: `action=delete&id=${encodeURIComponent(id)}`
            }).then(r=>r.json()).then(d=>{ if(d.success){ loadPosts(); alert('Post eliminado'); } else { alert('Error: '+d.message);} });
        }
    </script>
</body>
</html>

