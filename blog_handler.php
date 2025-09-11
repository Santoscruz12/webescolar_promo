<?php
// Configurar zona horaria
date_default_timezone_set('America/Mexico_City');

// Nota: No forzamos header JSON globalmente porque algunas rutas redirigen con Location

// Archivo JSON donde se guardarán los posts
$blog_file = __DIR__ . '/data/blog_posts.json';

// Crear directorio si no existe
$data_dir = dirname($blog_file);
if (!is_dir($data_dir)) {
    mkdir($data_dir, 0755, true);
}

// Función para cargar posts desde JSON
function loadPosts() {
    global $blog_file;
    
    if (!file_exists($blog_file)) {
        return [];
    }
    
    $content = file_get_contents($blog_file);
    $data = json_decode($content, true);
    
    return $data ? $data : [];
}

// Función para guardar posts en JSON
function savePosts($posts) {
    global $blog_file;
    
    $json_data = json_encode($posts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    return file_put_contents($blog_file, $json_data) !== false;
}

// Función para subir imagen
function uploadImage($file) {
    $upload_dir = __DIR__ . '/assets/image/blog/';
    $web_base = 'assets/image/blog/';
    
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $max_size = 5 * 1024 * 1024; // 5MB
    
    if (!in_array($file['type'], $allowed_types)) {
        return ['success' => false, 'message' => 'Tipo de imagen no permitido'];
    }
    if ($file['size'] > $max_size) {
        return ['success' => false, 'message' => 'La imagen es demasiado grande (máximo 5MB)'];
    }
    
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = 'blog_' . time() . '_' . uniqid() . '.' . $extension;
    $filepath = $upload_dir . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        return ['success' => true, 'filename' => $filename, 'path' => $web_base . $filename];
    }
    return ['success' => false, 'message' => 'Error al subir la imagen'];
}

// Función para subir video (opcional)
function uploadVideo($file) {
    $upload_dir = __DIR__ . '/assets/video/blog/';
    $web_base = 'assets/video/blog/';
    
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    $allowed_types = ['video/mp4', 'video/webm'];
    $max_size = 30 * 1024 * 1024; // 30MB
    
    if (!in_array($file['type'], $allowed_types)) {
        return ['success' => false, 'message' => 'Tipo de video no permitido'];
    }
    if ($file['size'] > $max_size) {
        return ['success' => false, 'message' => 'El video es demasiado grande (máximo 30MB)'];
    }
    
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = 'vid_' . time() . '_' . uniqid() . '.' . $extension;
    $filepath = $upload_dir . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        return ['success' => true, 'filename' => $filename, 'path' => $web_base . $filename];
    }
    return ['success' => false, 'message' => 'Error al subir el video'];
}

function generateSlug($title) {
    $slug = strtolower(trim($title));
    $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');
    $slug .= '-' . time();
    return $slug;
}

function validatePost($data) {
    $errors = [];
    if (empty($data['titulo'])) { $errors[] = 'El título es requerido'; }
    if (empty($data['fecha'])) { $errors[] = 'La fecha es requerida'; }
    if (empty($data['categoria'])) { $errors[] = 'La categoría es requerida'; }
    if (empty($data['autor'])) { $errors[] = 'El autor es requerido'; }
    if (empty($data['resumen'])) { $errors[] = 'El resumen es requerido'; }
    if (empty($data['contenido'])) { $errors[] = 'El contenido es requerido'; }
    return $errors;
}

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'get_posts':
        header('Content-Type: application/json; charset=utf-8');
        $posts = loadPosts();
        echo json_encode(['success' => true, 'posts' => $posts]);
        break;
    case 'delete':
        header('Content-Type: application/json; charset=utf-8');
        $id = $_POST['id'] ?? '';
        if (empty($id)) { echo json_encode(['success' => false, 'message' => 'ID no proporcionado']); exit; }
        $posts = loadPosts();
        $found = false;
        foreach ($posts as $key => $post) {
            if ($post['id'] == $id) { unset($posts[$key]); $found = true; break; }
        }
        if ($found) {
            $posts = array_values($posts);
            echo json_encode(['success' => savePosts($posts)]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Post no encontrado']);
        }
        break;
    case 'update':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: pages/admin_blog.php');
            break;
        }
        $id = $_POST['id'] ?? '';
        if (empty($id)) {
            header('Location: pages/admin_blog.php?error=' . urlencode('ID faltante'));
            break;
        }
        $errors = validatePost($_POST);
        if (!empty($errors)) {
            header('Location: pages/admin_blog.php?edit=' . urlencode($id) . '&error=' . urlencode(implode(', ', $errors)));
            break;
        }
        $posts = loadPosts();
        $found = false;
        foreach ($posts as &$post) {
            if ($post['id'] == $id) {
                $post['titulo'] = trim($_POST['titulo']);
                $post['fecha'] = $_POST['fecha'];
                $post['categoria'] = $_POST['categoria'];
                $post['autor'] = trim($_POST['autor']);
                $post['resumen'] = trim($_POST['resumen']);
                $post['contenido'] = trim($_POST['contenido']);
                $post['estado'] = $_POST['estado'] ?? $post['estado'];
                $post['tags'] = !empty($_POST['tags']) ? array_map('trim', explode(',', $_POST['tags'])) : [];
                // Imagen opcional
                if (!empty($_FILES['imagen']['name'])) {
                    $upload_result = uploadImage($_FILES['imagen']);
                    if (!$upload_result['success']) {
                        header('Location: pages/admin_blog.php?edit=' . urlencode($id) . '&error=' . urlencode($upload_result['message']));
                        exit;
                    }
                    $post['imagen'] = $upload_result['path'];
                }
                // Video opcional
                if (!empty($_FILES['video']['name'])) {
                    $vup = uploadVideo($_FILES['video']);
                    if (!$vup['success']) {
                        header('Location: pages/admin_blog.php?edit=' . urlencode($id) . '&error=' . urlencode($vup['message']));
                        exit;
                    }
                    $post['video'] = $vup['path'];
                }
                $post['fecha_modificacion'] = date('Y-m-d H:i:s');
                $found = true;
                break;
            }
        }
        unset($post);
        if (!$found) {
            header('Location: pages/admin_blog.php?error=' . urlencode('Post no encontrado'));
            break;
        }
        if (savePosts($posts)) {
            header('Location: pages/admin_blog.php?success=' . urlencode('Post actualizado correctamente'));
        } else {
            header('Location: pages/admin_blog.php?edit=' . urlencode($id) . '&error=' . urlencode('No se pudo guardar'));
        }
        break;
    default:
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = validatePost($_POST);
            if (!empty($errors)) {
                header('Location: pages/admin_blog.php?error=' . urlencode(implode(', ', $errors)));
                break;
            }

            $imagen_path = '';
            if (!empty($_FILES['imagen']['name'])) {
                $upload_result = uploadImage($_FILES['imagen']);
                if (!$upload_result['success']) {
                    header('Location: pages/admin_blog.php?error=' . urlencode($upload_result['message']));
                    break;
                }
                $imagen_path = $upload_result['path'];
            }

            $video_path = '';
            if (!empty($_FILES['video']['name'])) {
                $vup = uploadVideo($_FILES['video']);
                if (!$vup['success']) {
                    header('Location: pages/admin_blog.php?error=' . urlencode($vup['message']));
                    break;
                }
                $video_path = $vup['path'];
            }

            $new_post = [
                'id' => time() . '_' . uniqid(),
                'titulo' => trim($_POST['titulo']),
                'fecha' => $_POST['fecha'],
                'categoria' => $_POST['categoria'],
                'autor' => trim($_POST['autor']),
                'resumen' => trim($_POST['resumen']),
                'contenido' => trim($_POST['contenido']),
                'imagen' => $imagen_path,
                'video' => $video_path,
                'estado' => $_POST['estado'] ?? 'publicado',
                'tags' => !empty($_POST['tags']) ? array_map('trim', explode(',', $_POST['tags'])) : [],
                'slug' => generateSlug($_POST['titulo']),
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'fecha_modificacion' => date('Y-m-d H:i:s')
            ];

            $posts = loadPosts();
            array_unshift($posts, $new_post);
            if (savePosts($posts)) { header('Location: pages/admin_blog.php?success=' . urlencode('Post creado correctamente')); }
            else { header('Location: pages/admin_blog.php?error=' . urlencode('Error al guardar el post')); }
        } else {
            header('Location: pages/admin_blog.php');
        }
        break;
}
?>

