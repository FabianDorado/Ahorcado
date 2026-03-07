<div class="juego-container">
    <h1>Ahorcado</h1>
    <h2>Adivina la palabra</h2>
    
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
    
    <?php if ($mensaje && $mensaje['tipo'] !== 'victoria' && $mensaje['tipo'] !== 'derrota'): ?>
        <div class="mensaje <?php echo $mensaje['tipo']; ?>">
            <?php echo $mensaje['mensaje']; ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" class="formulario-juego">
        <label for="letra">Ingresa una letra:</label>
        <input type="text" name="letra" id="letra" 
               maxlength="1" pattern="[A-Za-z]" 
               placeholder="A" autocomplete="off" 
               required autofocus>
        <button type="submit">Probar</button>
    </form>
    
    <form method="POST">
        <input type="hidden" name="reiniciar" value="1">
        <button type="submit" class="btn-reiniciar">Nueva partida</button>
    </form>
</div>