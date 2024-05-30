<?php
session_start();
require_once "../config/db_connection.php";

// Consultar historias de usuario
if ($_POST["type"] == "Consulta_historias_usuario") {
    $sql = "SELECT
                `id_historia`,
                `id_proyecto`,
                `nom_historia`,
                `desc_historia`
            FROM `historias_usuario`";

    $result = $conn->query($sql);

    $historias = array();
    while ($row = $result->fetch_assoc()) {
        $historias[] = $row;
    }
    echo json_encode($historias);
}

// Crear ticket
if ($_POST["type"] == "create_ticket"){
    $ticketTitle = $_POST['ticketTitle'];
    $ticketDescription = $_POST['ticketDescription'];
    $ticketUserStory = $_POST['ticketUserStory'];
    $ticketComments = $_POST['ticketComments'];
    $ticketStatus = $_POST['ticketStatus'];

    $sql = "INSERT INTO `tickets`
            (
                `titulo_ticket`,
                `descr_ticket`,
                `estado_ticket`,
                `comentarios_ticket`,
                `id_historia`
            )
            VALUES (
                '$ticketTitle',
                '$ticketDescription',
                '$ticketStatus',
                '$ticketComments',
                '$ticketUserStory'
            )";

    if ($conn->query($sql) === TRUE) {
        echo "Ticket creado exitosamente.";
    } else {
        echo "Error al crear el ticket: " . $conn->error;
    }
}

// Obtener datos de tickets para la tabla
if ($_POST["type"] == "get_tickets_dt") {
    $sql = "SELECT
                tickets.id_ticket,
                tickets.titulo_ticket,
                tickets.descr_ticket,
                tickets.estado_ticket,
                tickets.comentarios_ticket,
                historias_usuario.nom_historia
            FROM tickets
            LEFT JOIN historias_usuario ON tickets.id_historia = historias_usuario.id_historia";

    $result = $conn->query($sql);

    $tickets = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tickets[] = $row;
        }
    }

    echo json_encode($tickets);
}

// Obtener ticket por ID
if ($_POST["type"] == "get_ticket_by_id") {
    if (isset($_POST['ticketId'])) {
        $ticketId = $conn->real_escape_string($_POST['ticketId']);

        $sql = "SELECT
                    `id_ticket`,
                    `titulo_ticket`,
                    `descr_ticket`,
                    `estado_ticket`,
                    `comentarios_ticket`,
                    `id_historia`
                FROM `tickets`
                WHERE `id_ticket` = '$ticketId'";

        $result = $conn->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $ticketData = array(
                    "ticketId" => $row['id_ticket'],
                    "ticketTitle" => $row['titulo_ticket'],
                    "ticketDescription" => $row['descr_ticket'],
                    "ticketStatus" => $row['estado_ticket'],
                    "ticketComments" => $row['comentarios_ticket'],
                    "ticketUserStoryId" => $row['id_historia']
                );
                echo json_encode($ticketData);
            } else {
                echo "No se encontró ningún ticket con el ID proporcionado";
            }
        } else {
            echo "Error al ejecutar la consulta: " . $conn->error;
        }
    } else {
        echo "ID del ticket no proporcionado";
    }
}

// Actualizar ticket
if ($_POST["type"] == "update_ticket") {
    if (!empty($_POST["ticketId"])) {
        $ticketId = $_POST["ticketId"];
        $ticketTitle = $_POST['ticketTitle'];
        $ticketDescription = $_POST['ticketDescription'];
        $ticketUserStory = $_POST['ticketUserStory'];
        $ticketComments = $_POST['ticketComments'];
        $ticketStatus = $_POST['ticketStatus'];

        $sql = "UPDATE `tickets`
                SET `titulo_ticket` = '$ticketTitle',
                    `descr_ticket` = '$ticketDescription',
                    `estado_ticket` = '$ticketStatus',
                    `comentarios_ticket` = '$ticketComments',
                    `id_historia` = '$ticketUserStory'
                WHERE `id_ticket` = '$ticketId'";

        if ($conn->query($sql) === TRUE) {
            echo "El ticket ha sido actualizado correctamente.";
        } else {
            echo "Error al actualizar el ticket: " . $conn->error;
        }
    } else {
        echo "Error: No se proporcionó el ID del ticket para la actualización.";
    }
}

// Eliminar ticket
if ($_POST["type"] == "delete_ticket") {
    if (!empty($_POST["ticketId"])) {
        $ticketId = $_POST["ticketId"];

        $sql = "DELETE FROM `tickets` WHERE `id_ticket` = '$ticketId'";

        if ($conn->query($sql) === TRUE) {
            echo "El ticket ha sido eliminado correctamente.";
        } else {
            echo "Error al eliminar el ticket: " . $conn->error;
        }
    } else {
        echo "Error: No se proporcionó el ID del ticket para la eliminación.";
    }
}

$conn->close();
?>
