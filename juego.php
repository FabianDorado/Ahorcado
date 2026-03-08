<?php
// juego.php - Controlador principal con temáticas
session_start();

require_once 'clases/JuegoAhorcado.php';

// Cargar palabras por temática
$palabrasPorTematica = require 'config/palabras.php';

// SI VIENE DE INDEX.PHP CON UN TEMA NUEVO
if (isset($_GET['tema']) && array_key_exists($_GET['tema'], $palabrasPorTematica)) {
    $tema = $_GET['tema'];
    $_SESSION['tema_actual'] = $tema;
    
    // Seleccionar palabra aleatoria de la temática
    $palabras = $palabrasPorTematica[$tema];
    $palabraSecreta = $palabras[array_rand($palabras)];
    
    // Crear nuevo juego
    $juego = new JuegoAhorcado($palabraSecreta);
    $_SESSION['juego'] = $juego->toArray();
    
    // Redirigir para limpiar la URL (evitar GET parameters)
    header('Location: juego.php');
    exit;
}

// SI YA HAY UN JUEGO EN SESIÓN
if (isset($_SESSION['juego'])) {
    $juego = JuegoAhorcado::fromArray($_SESSION['juego']);
} else {
    // No hay juego, redirigir al inicio
    header('Location: index.php');
    exit;
}

// PROCESAR FORMULARIO (solo cuando se envía una letra)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['reiniciar'])) {
        // Reiniciar con la MISMA temática
        if (isset($_SESSION['tema_actual'])) {
            $tema = $_SESSION['tema_actual'];
            $palabras = $palabrasPorTematica[$tema];
            $palabraSecreta = $palabras[array_rand($palabras)];
            
            $juego = new JuegoAhorcado($palabraSecreta);
            $_SESSION['juego'] = $juego->toArray();
        } else {
            session_destroy();
            header('Location: index.php');
            exit;
        }
        
        // Redirigir para evitar reenvío
        header('Location: juego.php');
        exit;
        
    } elseif (isset($_POST['cambiar_tema'])) {
        // Volver al selector de temas
        session_destroy();
        header('Location: index.php');
        exit;
        
    } elseif (isset($_POST['letra']) && !empty($_POST['letra']) && $juego->getEstado() === 'jugando') {
        // Procesar la letra solo si el juego está activo
        $juego->procesarLetra($_POST['letra']);
        $_SESSION['juego'] = $juego->toArray();
        
        // Redirigir a la misma página para evitar reenvío del formulario al recargar
        header('Location: juego.php');
        exit;
    }
}

// Determinar qué vista mostrar
$estado = $juego->getEstado();
if ($estado === 'ganado') {
    $vista = 'victoria.php';
} elseif ($estado === 'perdido') {
    $vista = 'derrota.php';
} else {
    $vista = 'juegoView.php';
}

// Obtener el nombre bonito de la temática actual
function getNombreTematica($key) {
    $nombres = [
        'animales' => '🐾 Animales',
        'planetas' => '🪐 Planetas',
        'paises' => '🌍 Países',
        'ciudades' => '🏙️ Ciudades',
        'profesiones' => '👨‍⚕️ Profesiones',
        'frutas' => '🍎 Frutas',
        'deportes' => '⚽ Deportes'
    ];
    return $nombres[$key] ?? ucfirst($key);
}

// Incluir las vistas
include 'includes/header.php';
include "vistas/$vista";
include 'includes/footer.php';
?>