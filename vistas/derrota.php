<!-- vistas/derrota.php -->
<div class="resultado-container derrota">
    <h1>Lo siento</h1>
    <h2>Has perdido</h2>
    
    <div class="palabra-descubierta">
        La palabra era: <strong><?php echo $juego->getPalabraSecreta(); ?></strong>
    </div>
    
    <?php if (isset($_SESSION['tema_actual'])): ?>
        <div class="tematica-info">
            Temática: <?php echo getNombreTematica($_SESSION['tema_actual']); ?>
        </div>
    <?php endif; ?>
    
    <pre class="dibujo">
<?php echo $juego->getDibujoAhorcado(); ?>
    </pre>
    
    <div class="botones-accion">
        <form method="POST" style="display: inline;">
            <input type="hidden" name="reiniciar" value="1">
            <button type="submit" class="btn-reiniciar">Intentar otra vez</button>
        </form>
        
        <form method="POST" style="display: inline;">
            <input type="hidden" name="cambiar_tema" value="1">
            <button type="submit" class="btn-cambiar-tema">Cambiar temática</button>
        </form>
    </div>
</div>