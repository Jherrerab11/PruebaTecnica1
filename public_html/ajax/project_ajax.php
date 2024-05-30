<?php
session_start();
require_once "../config/db_connection.php";

if ($_POST["type"] == "create_project") {
    $projectName = $conn->real_escape_string($_POST['projectName']);
    $projectDescription = $conn->real_escape_string($_POST['projectDescription']);
    $projectStartDate = $conn->real_escape_string($_POST['projectStartDate']);
    $projectEndDate = $conn->real_escape_string($_POST['projectEndDate']);
    $projectStatus = $conn->real_escape_string($_POST['projectStatus']);
    $userId = $_SESSION['user_id'];

    $sql = "INSERT INTO proyectos (
        id_usuario, 
        fecha_inicio, 
        fecha_fin, 
        descripcion, 
        project_name,
        project_state)
         VALUES (
            '$userId', 
            '$projectStartDate', 
            '$projectEndDate', 
            '$projectDescription', 
            '$projectName',
            '$projectStatus'
    )";
    if ($conn->query($sql) === TRUE) {
        echo "Proyecto creado exitosamente.";
    } else {
        echo "Error al crear el proyecto: " . $conn->error;
    }
}

if ($_POST["type"] == "get_projects_dt") {
    $sql = "SELECT 
    id_proyecto, 
    project_name, 
    project_state, 
    fecha_inicio, 
    fecha_fin 
    FROM proyectos";
    $result = $conn->query($sql);

    $projects = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (strtotime($row['fecha_fin']) < time()) {
                $update_sql = "UPDATE proyectos SET project_state = 2 WHERE id_proyecto = " . $row['id_proyecto'];
                $conn->query($update_sql);
            }
            $projects[] = $row;
        }
    }

    echo json_encode($projects);
}

if ($_POST["type"] == "get_project_by_id") {
    if (isset($_POST['projectId'])) {
        $projectId = $conn->real_escape_string($_POST['projectId']);

        $sql = "SELECT * FROM proyectos WHERE id_proyecto = '$projectId'";
        $result = $conn->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $projectData = array(
                    "projectId" => $row['id_proyecto'],
                    "projectName" => $row['project_name'],
                    "projectDescription" => $row['descripcion'],
                    "projectStartDate" => $row['fecha_inicio'],
                    "projectEndDate" => $row['fecha_fin'],
                    "projectState" => $row['project_state']
                );
                echo json_encode($projectData);
            } else {
                echo "No se encontró ningún proyecto con el ID proporcionado";
            }
        } else {
            echo "Error al ejecutar la consulta: " . $conn->error;
        }
    } else {
        echo "ID de proyecto no proporcionado";
    }
}

if ($_POST["type"] == "update_project") {
    if (!empty($_POST["projectId"])) {
        $projectId = $_POST["projectId"];
        $projectName = $_POST["projectName"];
        $projectDescription = $_POST["projectDescription"];
        $projectStartDate = $_POST["projectStartDate"];
        $projectEndDate = $_POST["projectEndDate"];
        $projectStatus = $_POST["projectStatus"];

        $sql = "UPDATE `proyectos`
        SET 
        `fecha_inicio` = '$projectStartDate',
        `fecha_fin` = '$projectEndDate',
        `descripcion` = '$projectDescription',
        `project_name` = '$projectName',
        `project_state` = '$projectStatus'
        WHERE `id_proyecto` =  '$projectId';";

        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo "El proyecto ha sido actualizado correctamente.";
        } else {
            echo "Error al actualizar el proyecto: " . mysqli_error($conn);
        }
    } else {
        echo "Error: No se proporcionó el ID del proyecto para la actualización.";
    }
}

if ($_POST["type"] == "delete_project") {
    if (!empty($_POST["projectId"])) {    
        $projectId = $_POST["projectId"];

        $sql = "delete
        from `pruebatecnicadb`.`proyectos`
        where `id_proyecto` = '$projectId';";

        $delete = mysqli_query($conn, $sql);
        if ($delete) {
            echo "El proyecto ha sido eliminado correctamente.";
        } else {
            echo "Error al eliminar el proyecto: " . mysqli_error($conn);
        }
    }
}
