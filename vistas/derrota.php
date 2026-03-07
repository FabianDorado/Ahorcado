<div class="resultado derrota">
    <h1>GAME OVER</h1>
    
    <p>La palabra era:</p>
    <div class="palabra-secreta">
        <?php echo $juego->getPalabraSecreta(); ?>
    </div>
    
    <pre class="dibujo">
  +---+
  |   |
  O   |
 /|\  |
 / \  |
      |
    ===
    </pre>
    
    <form method="POST">
        <input type="hidden" name="reiniciar" value="1">
        <button type="submit" class="boton">Intentar de nuevo</button>
    </form>
</div>