<?php
// juego.php - Controlador principal
session_start();

require_once 'clases/JuegoAhorcado.php';

// Inicializar o cargar juego existente
if (!isset($_SESSION['juego'])) {
    $juego = new JuegoAhorcado();
    $_SESSION['juego'] = $juego->toArray();
} else {
    $juego = JuegoAhorcado::fromArray($_SESSION['juego']);
}

// Procesar formulario
$mensaje = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['reiniciar'])) {
        session_destroy();
        header('Location: juego.php');
        exit;
    } elseif (isset($_POST['letra']) && !empty($_POST['letra'])) {
        $mensaje = $juego->procesarLetra($_POST['letra']);
        $_SESSION['juego'] = $juego->toArray();
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

// Incluir las vistas
include 'includes/header.php';
include "vistas/$vista";
include 'includes/footer.php';
?>