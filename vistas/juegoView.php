<!-- vistas/juegoView.php -->
<?php
/**
 * =====================================================
 * VISTA PRINCIPAL DEL JUEGO - Ahorcado
 * =====================================================
 * Esta es la vista principal del juego, donde el jugador:
 * - Ve la palabra oculta (con guiones bajos)
 * - Observa el dibujo del ahorcado según los errores
 * - Ingresa letras para adivinar
 * - Ve las letras incorrectas ya probadas
 * - Conoce los intentos restantes
 * =====================================================
 */
?>

<div class="juego-container">
    <!-- 
        ENCABEZADO DEL JUEGO
        ================================================
        Muestra el título, la temática actual (si existe)
        y un subtítulo instructivo.
        La temática se obtiene de la sesión y se traduce
        usando getNombreTematica().
    -->
    <div class="header-juego">
        <h1>Ahorcado</h1>
        <?php if (isset($_SESSION['tema_actual'])): ?>
            <div class="tematica-actual">
                Temática: <span class="tematica-badge"><?php echo getNombreTematica($_SESSION['tema_actual']); ?></span>
            </div>
        <?php endif; ?>
        <h2>Adivina la palabra</h2>
    </div>
    
    <!-- 
        PALABRA SECRETA OCULTA
        ================================================
        Muestra la palabra con guiones bajos  por cada
        letra no adivinada y las letras acertadas en su
        posición correcta.
            El método getPalabraOculta() del objeto $juego
            devuelve esta representación de la palabra.
    -->
    <div class="palabra-secreta">
        <?php echo $juego->getPalabraOculta(); ?>
    </div>
    
    <!-- 
        
        DIBUJO DEL AHORCADO
        ================================================
        Representación visual del progreso del juego.
        A medida que el jugador falla, el dibujo se completa:
        La etiqueta <pre> conserva los espacios y saltos de línea.
    -->
    <pre class="dibujo">
<?php echo $juego->getDibujoAhorcado(); ?>
    </pre>
    
    <!-- 
        
        INFORMACIÓN DEL JUEGO
        ================================================
        Dos datos cruciales para el jugador:
        1. Intentos restantes (número de fallos permitidos)
        2. Letras incorrectas ya probadas (para no repetir)
    -->
    <div class="info-juego">
        <!-- Número de intentos que le quedan al jugador -->
        <p><strong>Intentos restantes:</strong> <?php echo $juego->getIntentosRestantes(); ?></p>
        
        <!-- Listado de letras incorrectas (si las hay) -->
        <?php $incorrectas = $juego->getLetrasIncorrectas(); ?>
        <?php if (!empty($incorrectas)): ?>
            <p><strong>Letras incorrectas:</strong></p>
            <div class="letras-incorrectas">
                <?php foreach ($incorrectas as $letra): ?>
                    <span class="letra-incorrecta"><?php echo $letra; ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- 
        Notificaciones y mensajes flash
        ================================================
        Sistema de mensajes que se muestran una sola vez:
        - Letra ya probada
        - Carácter no válido
        - Otros avisos importantes
        
        Después de mostrar el mensaje, se elimina de la
        sesión con unset() para que no reaparezca.
    -->
    <?php if (isset($_SESSION['mensaje_flash'])): ?>
        <div class="mensaje <?php echo $_SESSION['mensaje_flash']['tipo']; ?>">
            <?php echo $_SESSION['mensaje_flash']['mensaje']; ?>
        </div>
        <?php unset($_SESSION['mensaje_flash']); ?>
    <?php endif; ?>
    
    <!-- 
        
        FORMULARIO DE JUEGO (SOLO SI ESTÁ JUGANDO)
        ================================================
        Este formulario SOLO se muestra si el juego está
        en estado 'jugando'. Si el jugador ya ganó o perdió,
        el formulario desaparece.
        
        Validaciones del input:
        - maxlength="1": Solo una letra
        - pattern="[A-Za-z]": Solo letras (no números)
        - required: Campo obligatorio
        - autofocus: Cursor automático para escribir rápido
    -->
    <?php if ($juego->getEstado() === 'jugando'): ?>
        <form method="POST" class="formulario-juego">
            <label for="letra">Ingresa una letra:</label>
            <input type="text" name="letra" id="letra" 
                   maxlength="1" pattern="[A-Za-z]" 
                   placeholder="A" autocomplete="off" 
                   required autofocus>
            <button type="submit" class="btn-probar">Probar</button>
        </form>
    <?php endif; ?>
    
    <!-- 
        
        BOTONES DE ACCIÓN
        ================================================
        Siempre visibles para permitir:
        1. Reiniciar: Nueva partida con misma temática
        2. Cambiar temática: Volver al selector de temas
        
        Ambos usan POST con campos ocultos para acciones.
    -->
    <div class="botones-accion">
        <!-- Reiniciar partida actual -->
        <form method="POST" style="display: inline;">
            <input type="hidden" name="reiniciar" value="1">
            <button type="submit" class="btn-reiniciar">Nueva partida</button>
        </form>
        
        <!-- Cambiar a otra temática -->
        <form method="POST" style="display: inline;">
            <input type="hidden" name="cambiar_tema" value="1">
            <button type="submit" class="btn-cambiar-tema">Cambiar temática</button>
        </form>
    </div>
</div>