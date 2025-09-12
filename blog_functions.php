<?php
// Configurar zona horaria
date_default_timezone_set('America/Mexico_City');

// Archivo JSON donde se guardan los posts
$blog_file = __DIR__ . '/data/blog_posts.json';

/**
 * Cargar todos los posts desde el archivo JSON
 */
function loadBlogPosts() {
    global $blog_file;
    
    if (!file_exists($blog_file)) {
        return [];
    }
    
    $content = file_get_contents($blog_file);
    $data = json_decode($content, true);
    
    return $data ? $data : [];
}

/**
 * Obtener un post específico por ID
 */
function getBlogPost($id) {
    $posts = loadBlogPosts();
    
    foreach ($posts as $post) {
        if ($post['id'] == $id) {
            return $post;
        }
    }
    
    return null;
}

/**
 * Alias para getBlogPost (compatibilidad)
 */
function getBlogPostById($id) {
    return getBlogPost($id);
}

/**
 * Obtener posts por categoría
 */
function getBlogPostsByCategory($category) {
    $posts = loadBlogPosts();
    $filtered = [];
    
    foreach ($posts as $post) {
        if ($post['categoria'] == $category && $post['estado'] == 'publicado') {
            $filtered[] = $post;
        }
    }
    
    return $filtered;
}

/**
 * Obtener los posts más recientes
 */
function getRecentBlogPosts($limit = 5) {
    $posts = loadBlogPosts();
    $published = [];
    
    // Filtrar solo posts publicados
    foreach ($posts as $post) {
        if ($post['estado'] == 'publicado') {
            $published[] = $post;
        }
    }
    
    // Ordenar por fecha (más recientes primero)
    usort($published, function($a, $b) {
        return strtotime($b['fecha']) - strtotime($a['fecha']);
    });
    
    return array_slice($published, 0, $limit);
}

/**
 * Formatear fecha para mostrar
 */
function formatBlogDate($date) {
    $timestamp = strtotime($date);
    $meses = [
        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
        5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
        9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
    ];
    
    $dia = date('j', $timestamp);
    $mes = $meses[date('n', $timestamp)];
    $año = date('Y', $timestamp);
    
    return "$dia $mes $año";
}

/**
 * Generar resumen del contenido
 */
function generateBlogExcerpt($content, $length = 150) {
    $content = strip_tags($content);
    if (strlen($content) <= $length) {
        return $content;
    }
    
    return substr($content, 0, $length) . '...';
}

/**
 * Obtener categorías disponibles
 */
function getBlogCategories() {
    return [
        'tecnologia' => 'Tecnología Educativa',
        'gestion' => 'Gestión Escolar',
        'innovacion' => 'Innovación',
        'tutoriales' => 'Tutoriales',
        'noticias' => 'Noticias'
    ];
}

/**
 * Obtener nombre de categoría
 */
function getCategoryName($category) {
    $categories = getBlogCategories();
    return isset($categories[$category]) ? $categories[$category] : ucfirst($category);
}

/**
 * Buscar posts por término
 */
function searchBlogPosts($term) {
    $posts = loadBlogPosts();
    $results = [];
    $term = strtolower($term);
    
    foreach ($posts as $post) {
        if ($post['estado'] == 'publicado') {
            $searchable = strtolower($post['titulo'] . ' ' . $post['resumen'] . ' ' . $post['contenido']);
            if (strpos($searchable, $term) !== false) {
                $results[] = $post;
            }
        }
    }
    
    return $results;
}

/**
 * Obtener posts relacionados (misma categoría)
 */
function getRelatedBlogPosts($current_post, $limit = 3) {
    $posts = getBlogPostsByCategory($current_post['categoria']);
    $related = [];
    
    foreach ($posts as $post) {
        if ($post['id'] != $current_post['id']) {
            $related[] = $post;
            if (count($related) >= $limit) {
                break;
            }
        }
    }
    
    return $related;
}

/**
 * Obtener estadísticas del blog
 */
function getBlogStats() {
    $posts = loadBlogPosts();
    $published = 0;
    $drafts = 0;
    $categories = [];
    
    foreach ($posts as $post) {
        if ($post['estado'] == 'publicado') {
            $published++;
        } else {
            $drafts++;
        }
        
        if (!isset($categories[$post['categoria']])) {
            $categories[$post['categoria']] = 0;
        }
        $categories[$post['categoria']]++;
    }
    
    return [
        'total' => count($posts),
        'published' => $published,
        'drafts' => $drafts,
        'categories' => $categories
    ];
}
?>
