<?php
session_start();
require_once "../config/db_connection.php";

if ($_POST["type"] == "Consulta_proyectos") {
    $sql = "SELECT
        `id_proyecto`,
        `id_usuario`,
        `fecha_inicio`,
        `fecha_fin`,
        `descripcion`,
        `project_name`,
        `project_state`
    FROM `proyectos`";

    $result = $conn->query($sql);

    $proyectos = array();
    while ($row = $result->fetch_assoc()) {
        $proyectos[] = $row;
    }
    echo json_encode($proyectos);
}

if ($_POST["type"] == "create_userh"){
    $userStoryName = $_POST['userStoryName'];
    $userStoryDescription = $_POST['userStoryDescription'];
    $userStoryProject = $_POST['userStoryProject'];

    $sql = "INSERT INTO `historias_usuario`
        (
        `nom_historia`,
        `desc_historia`,
        `id_proyecto`)
    values (
    '$userStoryName',
    '$userStoryDescription',
    '$userStoryProject'
    )";

    if ($conn->query($sql) === TRUE) {
        echo "Historia creada exitosamente.";
    } else {
        echo "Error al crear el Historia: " . $conn->error;
    }
}

if ($_POST["type"] == "get_user_stories_dt") {
    $sql = "SELECT
        t1.id_historia,
        t1.nom_historia,
        t1.desc_historia,
        t1.project_name,
        t1.total_tickets,
        CASE
            WHEN t1.total_tickets = t1.total_tickets_finalizados THEN 'Finalizado'
            ELSE 'En Proceso'
        END AS estado_historia
    FROM (
        SELECT
            historias_usuario.id_historia,
            historias_usuario.nom_historia,
            historias_usuario.desc_historia,
            proyectos.project_name,
            COUNT(tickets.id_ticket) AS total_tickets,
            SUM(CASE WHEN tickets.estado_ticket = 'Finalizado' THEN 1 ELSE 0 END) AS total_tickets_finalizados
        FROM
            historias_usuario
        LEFT JOIN proyectos ON historias_usuario.id_proyecto = proyectos.id_proyecto
        LEFT JOIN tickets ON historias_usuario.id_historia = tickets.id_historia
        GROUP BY
            historias_usuario.id_historia,
            historias_usuario.nom_historia,
            historias_usuario.desc_historia,
            proyectos.project_name
    ) AS t1;
    ";
    
    $result = $conn->query($sql);

    $userStories = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $userStories[] = $row;
        }
    }

    echo json_encode($userStories);
}

if ($_POST["type"] == "get_story_by_id") {
    if (isset($_POST['StoryId'])) {
        $StoryId = $conn->real_escape_string($_POST['StoryId']);

        $sql = "SELECT
            `id_historia`,
            `nom_historia`,
            `desc_historia`,
            `id_proyecto`
        FROM `historias_usuario`
        WHERE `id_historia` = '$StoryId'";
        
        $result = $conn->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $projectData = array(
                    "StoryId" => $row['id_historia'],
                    "StoryName" => $row['nom_historia'],
                    "StoryDesc" => $row['desc_historia'],
                    "StoryIdProyect" => $row['id_proyecto']
                );
                echo json_encode($projectData);
            } else {
                echo "No se encontró ningúna historia con el ID proporcionado";
            }
        } else {
            echo "Error al ejecutar la consulta: " . $conn->error;
        }
    } else {
        echo "ID de historia no proporcionado";
    }
}

if ($_POST["type"] == "update_story") {
    if (!empty($_POST["StoryId"])) {
        $StoryId = $_POST["StoryId"];
        $userStoryName = $_POST['userStoryName'];
        $userStoryDescription = $_POST['userStoryDescription'];
        $userStoryProject = $_POST['userStoryProject'];

        $sql = "UPDATE `historias_usuario`
        set `id_historia` = '$StoryId',
          `nom_historia` = '$userStoryName',
          `desc_historia` = '$userStoryDescription',
          `id_proyecto` = '$userStoryProject'
        where `id_historia` = '$StoryId';";

        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo "La historia ha sido actualizada correctamente.";
        } else {
            echo "Error al actualizar la historia: " . mysqli_error($conn);
        }
    } else {
        echo "Error: No se proporcionó el ID de la historia para la actualización.";
    }
}

if ($_POST["type"] == "delete_story") {
    if (!empty($_POST["userStoryId"])) {    
        $StoryId = $_POST["userStoryId"];

        $sql = "DELETE
        FROM `historias_usuario`
        WHERE `id_historia` = '$StoryId';";

        $delete = mysqli_query($conn, $sql);
        if ($delete) {
            echo "La historia ha sido eliminado correctamente.";
        } else {
            echo "Error al eliminar la historia: " . mysqli_error($conn);
        }
    }
}

$conn->close();
