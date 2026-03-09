<!-- vistas/derrota.php -->
<?php
/**
 * =====================================================
 * VISTA DE DERROTA - Juego del Ahorcado
 * =====================================================
 * Este archivo se muestra cuando el jugador pierde la partida.
 * Muestra:
 * - Mensaje de derrota
 * - La palabra secreta que debía adivinar
 * - El dibujo completo del ahorcado
 * - Botones para reiniciar o cambiar temática
 * =====================================================
 */
?>

<div class="resultado-container derrota">
    <!-- 
        ================================================
        Mostramos dos niveles de encabezado para enfatizar
        que el jugador ha perdido la partida.
    -->
    <h1>Lo siento</h1>
    <h2>Has perdido</h2>
    
    <!-- 
        PALABRA DESCUBIERTA
        ================================================
        Revelamos cuál era la palabra secreta que el jugador
        no logró adivinar. Usamos el método getPalabraSecreta()
        del objeto $juego para obtenerla.
        
    -->
    <div class="palabra-descubierta">
        La palabra era: <strong><?php echo $juego->getPalabraSecreta(); ?></strong>
    </div>
    
    <!-- 
        TEMÁTICA DE LA PALABRA 
        ================================================
        Si el jugador estaba jugando con una temática específica, la mostramos aquí.
        La función getNombreTematica() traduce el ID de la temática a su nombre legible para mostrarlo al usuario.
    -->
    <?php if (isset($_SESSION['tema_actual'])): ?>
        <div class="tematica-info">
            Temática: <?php echo getNombreTematica($_SESSION['tema_actual']); ?>
        </div>
    <?php endif; ?>
    
    <!-- 
        
        DIBUJO DEL AHORCADO
        ================================================
        Mostramos el dibujo completo del ahorcado, que representa la derrota.
        El método getDibujoAhorcado() del objeto $juego devuelve la representación
        del dibujo según el número de errores cometidos. En este caso, estará completo.
        La etiqueta <pre> conserva los espacios y saltos de línea para que el dibujo se vea correctamente.
    -->
    <pre class="dibujo">
<?php echo $juego->getDibujoAhorcado(); ?>
    </pre>
    
    <!-- 
        
        BOTONES DE ACCIÓN
        ================================================
        Dos opciones para el jugador:
        1. Reiniciar: Jugar nuevamente con la misma temática
        2. Cambiar temática: Volver al selector de temáticas
        
        Usamos forms con método POST y campos hidden para
        enviar las acciones al servidor.
    -->
    <div class="botones-accion">
        <!-- Formulario para reiniciar la partida -->
        <form method="POST" style="display: inline;">
            <input type="hidden" name="reiniciar" value="1">
            <button type="submit" class="btn-reiniciar">Intentar otra vez</button>
        </form>
        
        <!-- Formulario para cambiar de temática -->
        <form method="POST" style="display: inline;">
            <input type="hidden" name="cambiar_tema" value="1">
            <button type="submit" class="btn-cambiar-tema">Cambiar temática</button>
        </form>
    </div>
</div>