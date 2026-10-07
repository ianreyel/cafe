<?php
require_once __DIR__ . '/../config/connection.php';

class Comanda {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function criar($user_id, $mesa_id) {
        try {
            $this->pdo->beginTransaction();

            $stmtComanda = $this->pdo->prepare("INSERT INTO comanda (user_id, mesa_id, estado) VALUES (?, ?, 'aberta')");
            $stmtComanda->execute([$user_id, $mesa_id]);

            $stmtMesa = $this->pdo->prepare("UPDATE mesa SET estado = 'em uso' WHERE id = ?");
            $stmtMesa->execute([$mesa_id]);

            $this->pdo->commit();
            return true;

        } catch (\PDOException $e) {
            $this->pdo->rollBack();
            throw $e; 
        }
    }

    public function criar_pedido($comanda_id) {
        $stmt = $this->pdo->prepare("INSERT INTO pedidos (comanda_id) VALUES (?)");
        return $stmt->execute([$comanda_id]);
    }

    public function listar($filtro, $valor) {
        $stmt = $this->pdo->prepare("SELECT * FROM comanda WHERE $filtro = ?");
        $stmt->execute([$valor]);
        return $stmt->fetchAll();
    }

    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM comanda WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function pedidos($comanda_id) {
        $sql = "
            SELECT p.id as pedido_id, prod.nome, pi.quantidade, pi.preco, (pi.quantidade * pi.preco) AS subtotal
            FROM pedidos p
            INNER JOIN pedido_items pi ON pi.pedido_id = p.id
            INNER JOIN produtos prod ON pi.produto_id = prod.id
            WHERE p.comanda_id = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$comanda_id]);
        return $stmt->fetchAll();
    }
}
?>