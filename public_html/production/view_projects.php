<?php include 'header.php'; ?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Ver Proyectos</h3>
      </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="x_panel">
          <div class="x_content">
            <table class="table table-striped table-bordered projects">
              <thead>
                <tr>
                  <th style="width: 1%">#</th>
                  <th style="width: 20%">Nombre del Proyecto</th>
                  <th style="width: 20%">Estado</th>
                  <th style="width: 20%">Fecha de Inicio</th>
                  <th style="width: 20%">Fecha de Finalización</th>
                  <th style="width: 10%">Acciones</th>
                </tr>
              </thead>
              <tbody id="projectTableBody">
                <!-- Las filas de proyectos se agregarán aquí dinámicamente -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->

</div>
</div>
<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!-- bootstrap-progressbar -->
<script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
<!-- Custom Theme Scripts -->
<script src="../build/js/custom.min.js"></script>

<script>
  $(document).ready(function() {
    var type = "get_projects_dt";
    $.ajax({
      type: 'POST',
      url: '../ajax/project_ajax.php',
      data: {
        type: type
      },
      success: function(response) {
        var projectTableBody = $('#projectTableBody');
        projectTableBody.empty();

        try {
          var projects = JSON.parse(response);
          $.each(projects, function(index, project) {
            var row = $('<tr>');
            row.append($('<td>').text(project.id_proyecto));
            row.append($('<td>').text(project.project_name));
            console.log(project.project_state);
            var stateText;
            switch (project.project_state) {
              case "1":
                stateText = "En Proceso";
                break;
              case "2":
                stateText = "Atrasado";
                break;
              case "3":
                stateText = "Finalizado";
                break;
              default:
                stateText = "Estado Desconocido";
                break;
            }
            row.append($('<td>').text(stateText));
            row.append($('<td>').text(project.fecha_inicio));
            row.append($('<td>').text(project.fecha_fin));
            row.append($('<td>').html(`
                  <a href="#" class="btn btn-outline-primary btn-sm edit-project" data-id="${project.id_proyecto}">
                    <i class="fa fa-pencil"></i> Editar
                  </a>

                  <a href="#" class="btn btn-outline-danger btn-sm delete-project" data-id="${project.id_proyecto}">
                    <i class="fa fa-trash"></i> Eliminar
                  </a>
                  `));
            projectTableBody.append(row);
          });
        } catch (e) {
          console.error("Error parsing JSON response:", e);
          console.error("Response:", response);
        }
      },
      error: function(xhr, status, error) {
        console.error(error);
      }
    });

    $(document).on('click', '.edit-project', function(e) {
      e.preventDefault();
      var projectId = $(this).data('id');
      console.log("Edit project with ID:", projectId);
      window.location.href = 'create_project.php?id=' + projectId;
    });

    $(document).on('click', '.delete-project', function(e) {
      e.preventDefault();
      var projectId = $(this).data('id');
      if (confirm("¿Estás seguro de que deseas eliminar este proyecto?")) {
        $.ajax({
          type: 'POST',
          url: '../ajax/project_ajax.php',
          data: {
            projectId: projectId,
            type: 'delete_project'
          },
          success: function(response) {
            console.log(response);
            location.reload();
          },
          error: function(xhr, status, error) {
            console.error('Error:', error);
          }
        });
      } else {
        console.log("Eliminación del proyecto cancelada.");
      }
      console.log("Delete project with ID:", projectId);
    });
  });
</script>
</body>
</html>