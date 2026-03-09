<!-- vistas/victoria.php -->
<?php
/**
 * =====================================================
 * VISTA DE VICTORIA - Juego del Ahorcado
 * =====================================================
 * Este archivo se muestra cuando el jugador gana la partida
 * (adivina todas las letras de la palabra secreta).
 * 
 * Características destacadas:
 * - Mensaje de felicitación
 * - Revela la palabra secreta adivinada
 * - Muestra la temática utilizada
 * - Botones para continuar jugando
 * =====================================================
*/
?>

<div class="resultado-container victoria">
    <!-- 
        
        ENCABEZADO DE VICTORIA
        ================================================
        Dos niveles de encabezado para enfatizar el logro del jugador
    -->
    <h1>¡FELICIDADES!</h1>
    <h2>Has ganado</h2>
    
    <!-- 
        
        REVELACIÓN DE LA PALABRA
        ================================================
        Mostramos la palabra secreta que el jugador adivinó correctamente.
        Usamos el método getPalabraSecreta() del objeto $juego para obtenerla palabra original.
         La etiqueta <strong> resalta la palabra para darle protagonismo.
    -->
    <div class="palabra-descubierta">
        La palabra era: <strong><?php echo $juego->getPalabraSecreta(); ?></strong>
    </div>
    
    <!-- 
        
        INFORMACIÓN DE TEMÁTICA
        ================================================
        Si el jugador estaba jugando con una temática específica, la mostramos aquí.
        Esto refuerza el contexto del logro y puede motivar al jugador a seguir explorando otras temáticas.
         La función getNombreTematica() traduce el ID de la temática a su nombre legible para mostrarlo al usuario.
    -->
    <?php if (isset($_SESSION['tema_actual'])): ?>
        <div class="tematica-info">
            Temática: <?php echo getNombreTematica($_SESSION['tema_actual']); ?>
        </div>
    <?php endif; ?>
    
    <!-- 
        
        BOTONES DE ACCIÓN
        ================================================
        1. Jugar otra vez con la misma temática (reiniciar)
        2. Cambiar de temática para probar algo nuevo
    -->
    <div class="botones-accion">
        <!-- Formulario para reiniciar con misma temática -->
        <form method="POST" style="display: inline;">
            <input type="hidden" name="reiniciar" value="1">
            <button type="submit" class="btn-reiniciar">Jugar otra vez</button>
        </form>
        
        <!-- Formulario para cambiar de temática -->
        <form method="POST" style="display: inline;">
            <input type="hidden" name="cambiar_tema" value="1">
            <button type="submit" class="btn-cambiar-tema">Cambiar temática</button>
        </form>
    </div>
</div>