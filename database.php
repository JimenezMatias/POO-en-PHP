<?php
// 6. Implementar una clase PHP llamada `Database` que encapsule la lógica de conexión a la base de datos con PDO.
//Incluir métodos como `getUserById($id)`, `createUser($nombre, $email)`,
// etc para separar la lógica de base de datos de la lógica de negocio.
//Usar esta clase desde un script de prueba para insertar, consultar y actualizar usuarios.


class Database {
	private $pdo;
	private $host = 'localhost';
	private $db   = 'instituto';
	private $user = 'root';
	private $pass = 'jimenez1234';  
	private $port = 3306;  
	private $charset = 'utf8mb4';  
	private $dsn;
	
	private $options = [
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,    // Excepciones en caso de error
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,          // Fetch por defecto en array asociativo
		PDO::ATTR_EMULATE_PREPARES   => false,                     // Sentencias preparadas reales
	];

	public function __contruct() {
		$this->dsn = "mysql:host=$this->host;port=$this->port;dbname=$this->db;charset=$this->charset";
		try {
			$this->pdo = new PDO($this->dsn, $this->user, $this->pass, $this->options);
			echo "conexion exitosa a la base de datos";
		} catch (PDOException $e) {
			// Manejar error de conexión (log y mensaje genérico al usuario)
			error_log($e->getMessage());
			exit('Error al conectarse a la base de datos.'.$e);
		}
	}

	public function createUser($email, $estado) {
		try {
			$sql = "INSERT INTO usuarios (email, estado) VALUES (:email, :estado)";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([
				':email' => $email,
				':estado' => $estado
			]);

			return true;
		} catch (PDOException $e) {
			error_log($e->getMessage());

        echo "Error al crear un nuevo usuario";
		}
	}

	public function getUserById($id) {
		
		try {
			$sql = "SELECT * FROM usuarios WHERE id = :id";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([':id' => $id]);
	
			return true;
		} catch (PDOException $e) {
			error_log($e->getMessage());
			echo "Error al buscar el usuario";
		}
	}

    public function updateUserEstado($id, $nuevoEstado) {

        try {
            $sql = "UPDATE usuarios SET estado = :estado WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':estado' => $nuevoEstado, ':id' => $id]);

            return true;
        } catch (PDOException $e) {
            error_log($e->getMessage());
			echo "Error al buscar el usuario";
        }
    }
} 

?>