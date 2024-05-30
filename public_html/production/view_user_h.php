<?php include 'header.php'; ?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Ver Historias de Usuario</h3>
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
                  <th style="width: 20%">Nombre de la Historia de Usuario</th>
                  <th style="width: 20%">Descripcion</th>
                  <th style="width: 20%">Proyecto</th>
                  <th style="width: 20%"># Tickets</th>
                  <th style="width: 20%">Estado</th>
                  <th style="width: 10%">Acciones</th>
                </tr>
              </thead>
              <tbody id="userStoryTableBody">
                <!-- Las filas de historias de usuario se agregarán aquí dinámicamente -->
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
    var type = "get_user_stories_dt";
    $.ajax({
      type: 'POST',
      url: '../ajax/user_h_ajax.php',
      data: {
        type: type
      },
      success: function(response) {
        var userStoryTableBody = $('#userStoryTableBody');
        userStoryTableBody.empty();

        try {
          var userStories = JSON.parse(response);
          $.each(userStories, function(index, userStory) {
            var row = $('<tr>');
            row.append($('<td>').text(userStory.id_historia));
            row.append($('<td>').text(userStory.nom_historia));
            row.append($('<td>').text(userStory.desc_historia));
            row.append($('<td>').text(userStory.project_name));
            row.append($('<td>').text(userStory.total_tickets));
            row.append($('<td>').text(userStory.estado_historia));
            row.append($('<td>').html(`
                  <a href="#" class="btn btn-outline-primary btn-sm edit-user-story" data-id="${userStory.id_historia}">
                    <i class="fa fa-pencil"></i> Editar
                  </a>

                  <a href="#" class="btn btn-outline-danger btn-sm delete-user-story" data-id="${userStory.id_historia}">
                    <i class="fa fa-trash"></i> Eliminar
                  </a>
                  `));
            userStoryTableBody.append(row);
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

    $(document).on('click', '.edit-user-story', function(e) {
      e.preventDefault();
      var userStoryId = $(this).data('id');
      console.log("Edit user story with ID:", userStoryId);
      window.location.href = 'create_user_h.php?id=' + userStoryId;
    });

    $(document).on('click', '.delete-user-story', function(e) {
      e.preventDefault();
      var userStoryId = $(this).data('id');
      if (confirm("¿Estás seguro de que deseas eliminar esta historia de usuario?")) {
        $.ajax({
          type: 'POST',
          url: '../ajax/user_h_ajax.php',
          data: {
            userStoryId: userStoryId,
            type: 'delete_story'
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
        console.log("Eliminación de la historia de usuario cancelada.");
      }
      console.log("Delete user story with ID:", userStoryId);
    });
  });
</script>
</body>
</html>
