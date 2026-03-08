<!-- vistas/juegoView.php -->
<div class="juego-container">
    <div class="header-juego">
        <h1>Ahorcado</h1>
        <?php if (isset($_SESSION['tema_actual'])): ?>
            <div class="tematica-actual">
                Temática: <span class="tematica-badge"><?php echo getNombreTematica($_SESSION['tema_actual']); ?></span>
            </div>
        <?php endif; ?>
        <h2>Adivina la palabra</h2>
    </div>
    
    <div class="palabra-secreta">
        <?php echo $juego->getPalabraOculta(); ?>
    </div>
    
    <pre class="dibujo">
<?php echo $juego->getDibujoAhorcado(); ?>
    </pre>
    
    <div class="info-juego">
        <p><strong>Intentos restantes:</strong> <?php echo $juego->getIntentosRestantes(); ?></p>
        
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
    
    <!-- Mostrar mensajes flash si existen -->
    <?php if (isset($_SESSION['mensaje_flash'])): ?>
        <div class="mensaje <?php echo $_SESSION['mensaje_flash']['tipo']; ?>">
            <?php echo $_SESSION['mensaje_flash']['mensaje']; ?>
        </div>
        <?php unset($_SESSION['mensaje_flash']); ?>
    <?php endif; ?>
    
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
    
    <div class="botones-accion">
        <form method="POST" style="display: inline;">
            <input type="hidden" name="reiniciar" value="1">
            <button type="submit" class="btn-reiniciar">Nueva partida</button>
        </form>
        
        <form method="POST" style="display: inline;">
            <input type="hidden" name="cambiar_tema" value="1">
            <button type="submit" class="btn-cambiar-tema">Cambiar temática</button>
        </form>
    </div>
</div>