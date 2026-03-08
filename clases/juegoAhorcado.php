<?php
// clases/JuegoAhorcado.php - Lógica pura del juego
class JuegoAhorcado {
    private $palabraSecreta;
    private $letrasAdivinadas;
    private $letrasIncorrectas;
    private $intentosMaximos;
    private $estado;
    
    public function __construct($palabra = null) {
        $this->intentosMaximos = 6;
        $this->letrasAdivinadas = [];
        $this->letrasIncorrectas = [];
        $this->estado = 'jugando';
        
        if ($palabra) {
            $this->palabraSecreta = strtoupper($palabra);
        } else {
            $palabras = require __DIR__ . '/../config/palabras.php';
            // Por defecto toma animales si no se especifica
            $this->palabraSecreta = strtoupper($palabras['animales'][array_rand($palabras['animales'])]);
        }
    }
    
    public function procesarLetra($letra) {
        // Validar que el juego no haya terminado
        if ($this->estado !== 'jugando') {
            $resultado = ['tipo' => 'error', 'mensaje' => 'El juego ya terminó'];
            // Guardar mensaje en sesión para mostrarlo después de la redirección
            if (session_status() === PHP_SESSION_ACTIVE) {
                $_SESSION['mensaje_flash'] = $resultado;
            }
            return $resultado;
        }
        
        $letra = strtoupper(trim($letra));
        
        // Validar que sea una letra válida
        if (!ctype_alpha($letra) || strlen($letra) !== 1) {
            $resultado = ['tipo' => 'error', 'mensaje' => 'Ingresa una sola letra válida'];
            if (session_status() === PHP_SESSION_ACTIVE) {
                $_SESSION['mensaje_flash'] = $resultado;
            }
            return $resultado;
        }
        
        // Verificar si ya fue usada
        if (in_array($letra, $this->letrasAdivinadas) || in_array($letra, $this->letrasIncorrectas)) {
            $resultado = ['tipo' => 'error', 'mensaje' => 'Ya usaste esa letra'];
            if (session_status() === PHP_SESSION_ACTIVE) {
                $_SESSION['mensaje_flash'] = $resultado;
            }
            return $resultado;
        }
        
        // Procesar la letra
        if (strpos($this->palabraSecreta, $letra) !== false) {
            $this->letrasAdivinadas[] = $letra;
            $resultado = ['tipo' => 'acierto', 'mensaje' => '¡Correcto!'];
        } else {
            $this->letrasIncorrectas[] = $letra;
            $resultado = ['tipo' => 'fallo', 'mensaje' => '¡Fallaste!'];
        }
        
        // Verificar si ganó
        if ($this->verificarVictoria()) {
            $this->estado = 'ganado';
            $resultado = ['tipo' => 'victoria', 'mensaje' => '¡FELICIDADES! Has ganado'];
        }
        // Verificar si perdió
        elseif ($this->verificarDerrota()) {
            $this->estado = 'perdido';
            $resultado = ['tipo' => 'derrota', 'mensaje' => 'Lo siento - Has perdido'];
        }
        
        // Guardar mensaje en sesión para mostrarlo después de la redirección
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION['mensaje_flash'] = $resultado;
        }
        
        return $resultado;
    }
    
    private function verificarVictoria() {
        $letrasPalabra = array_unique(str_split($this->palabraSecreta));
        $letrasFaltantes = array_diff($letrasPalabra, $this->letrasAdivinadas);
        return empty($letrasFaltantes);
    }
    
    private function verificarDerrota() {
        return count($this->letrasIncorrectas) >= $this->intentosMaximos;
    }
    
    public function getPalabraOculta() {
        $resultado = '';
        for ($i = 0; $i < strlen($this->palabraSecreta); $i++) {
            $letra = $this->palabraSecreta[$i];
            if (in_array($letra, $this->letrasAdivinadas)) {
                $resultado .= $letra . ' ';
            } else {
                $resultado .= '_ ';
            }
        }
        return trim($resultado);
    }
    
    public function getLetrasIncorrectas() {
        return $this->letrasIncorrectas;
    }
    
    public function getIntentosRestantes() {
        return $this->intentosMaximos - count($this->letrasIncorrectas);
    }
    
    public function getEstado() {
        return $this->estado;
    }
    
    public function getPalabraSecreta() {
        return $this->palabraSecreta;
    }
    
    public function getDibujoAhorcado() {
        $errores = count($this->letrasIncorrectas);
        $dibujos = [
            "  +---+\n      |\n      |\n      |\n      |\n    ===",
            "  +---+\n  O   |\n      |\n      |\n      |\n    ===",
            "  +---+\n  O   |\n  |   |\n      |\n      |\n    ===",
            "  +---+\n  O   |\n /|   |\n      |\n      |\n    ===",
            "  +---+\n  O   |\n /|\\  |\n      |\n      |\n    ===",
            "  +---+\n  O   |\n /|\\  |\n /    |\n      |\n    ===",
            "  +---+\n  O   |\n /|\\  |\n / \\  |\n      |\n    ==="
        ];
        return $dibujos[min($errores, 6)];
    }
    
    public function toArray() {
        return [
            'palabraSecreta' => $this->palabraSecreta,
            'letrasAdivinadas' => $this->letrasAdivinadas,
            'letrasIncorrectas' => $this->letrasIncorrectas,
            'intentosMaximos' => $this->intentosMaximos,
            'estado' => $this->estado
        ];
    }
    
    public static function fromArray($data) {
        $juego = new self($data['palabraSecreta']);
        $juego->letrasAdivinadas = $data['letrasAdivinadas'];
        $juego->letrasIncorrectas = $data['letrasIncorrectas'];
        $juego->intentosMaximos = $data['intentosMaximos'] ?? 6;
        $juego->estado = $data['estado'];
        return $juego;
    }
}
?>