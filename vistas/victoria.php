<div class="resultado victoria">
    <h1>¡VICTORIA!</h1>
    
    <div class="palabra-secreta">
        <?php echo $juego->getPalabraSecreta(); ?>
    </div>
    
    <p class="mensaje-exito">¡Felicidades! Has adivinado la palabra</p>
    
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
        <button type="submit" class="boton">Jugar de nuevo</button>
    </form>
</div>