<?php

require_once __DIR__ ."/config.php";

$method = $_POST['action'];
switch($method) {
    case 'CREATE':
        $nome = htmlspecialchars($_POST['nome']);
        $cognome = htmlspecialchars($_POST['cognome']);
        $email = htmlspecialchars($_POST['email']);
        $data_nascita = htmlspecialchars($_POST['data_nascita']);

        $sql = "INSERT INTO persona (nome, cognome, email, data_nascita) VALUES (:nome, :cognome, :email, :data_nascita)";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            ":nome" => $nome,
            ":cognome" => $cognome,
            ":email" => $email,
            ":data_nascita" => $data_nascita
        ]);

        echo "Inserimento completato.";
        break;    
    case 'READ':
        if (isset($_POST['id'])) {
            $id = htmlspecialchars($_POST['id']);

            $sql = "SELECT * FROM persona WHERE id = :id";
            $statement = $pdo->prepare($sql);
            
            $statement->execute([":id" => $id]);
            $result = $statement->fetch();

            if ($result) {
                echo "ID: " . $result['id'] . "<br>";
                echo "Nome: " . $result['nome'] . "<br>";
                echo "Cognome: " . $result['cognome'] . "<br>";
                echo "Email: " . $result['email'] . "<br>";
                echo "Data di Nascita: " . $result['data_nascita'];
            } else {
                echo "Nessun dato trovato per l'ID " . $id;
            }
        } else {
            echo "Errore durante inserimento dell'ID";
        }
        break;
    case 'UPDATE':
        $id = htmlspecialchars($_POST['id']);
        $nome = htmlspecialchars($_POST['nome']);
        $cognome = htmlspecialchars($_POST['cognome']);
        $email = htmlspecialchars($_POST['email']);

        $sql = "UPDATE persona SET nome = :nome, cognome = :cognome, email = :email WHERE id = :id";
        $statement = $pdo->prepare($sql);

        $statement->execute([":id" => $id, ":nome" => $nome, ":cognome" => $cognome, ":email" => $email
    ]);

    echo "Record aggiornato con successo.";
        break;
    case 'DELETE':
        if (isset($_POST['id'])) {
            $id = htmlspecialchars($_POST['id']);
            $sql = "DELETE FROM persona WHERE id = :id";
        
            $statement = $pdo->prepare($sql);
            $statement->execute([":id" => $id]);
            echo "Record con ID $id eliminato.";
        } else {
            echo "Errore: ID mancante per la cancellazione.";
        }
        break;
}
?>
