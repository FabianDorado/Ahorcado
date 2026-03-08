<?php
// index.php - Página de inicio con selección de temática
session_start();
// Limpiar cualquier juego anterior al volver al inicio
session_destroy();

// Cargar las temáticas disponibles
$tematicas = require 'config/palabras.php';

// Función para obtener el nombre bonito de la temática
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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ahorcado - Selecciona temática</title>
    <link rel="stylesheet" href="assets/css/estilo.css">
</head>
<body>
    <div class="container">
        <h1>AHORCADO</h1>
        <h2>Selecciona una temática para comenzar</h2>
        
        <form action="juego.php" method="GET" id="formTematica">
            <div class="tematicas-grid">
                <?php foreach ($tematicas as $key => $palabras): ?>
                    <div class="tematica-card" onclick="selectTematica('<?php echo $key; ?>')">
                        <h3><?php echo getNombreTematica($key); ?></h3>
                        <div class="palabras-count"><?php echo count($palabras); ?> palabras</div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <input type="hidden" name="tema" id="temaSeleccionado" value="">
            <button type="submit" class="btn-jugar" id="btnJugar" disabled>
                ¡JUGAR!
            </button>
        </form>
        
        <div class="instrucciones">
            Haz clic en una temática para seleccionarla
        </div>
    </div>
    
    <script>
        function selectTematica(tema) {
            // Remover selección anterior
            document.querySelectorAll('.tematica-card').forEach(card => {
                card.classList.remove('selected');
            });
            
            // Seleccionar la card actual
            event.currentTarget.classList.add('selected');
            
            // Actualizar input hidden
            document.getElementById('temaSeleccionado').value = tema;
            
            // Habilitar botón
            document.getElementById('btnJugar').disabled = false;
        }
    </script>
    <footer>
        <p>Juego del Ahorcado - Desarrollado para explicar PHP<br>
        &copy;2026, Diseñado y desarrollado por grupo2.<br>
        <small>Estructuras de lenguaje por la profesora Jimena Timana</small></p>
    </footer>
</body>
</html>