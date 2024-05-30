<?php include 'header.php'; ?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="page-title">
    <div class="title_left">
      <h3>Crear Proyecto</h3>
    </div>
  </div>
  <div class="clearfix"></div>

  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
          <form id="createProjectForm">
            <div class="form-group">
              <label for="projectName">Nombre del Proyecto</label>
              <input type="text" class="form-control" id="projectName" name="projectName" required>
            </div>
            <div class="form-group">
              <label for="projectDescription">Descripción</label>
              <textarea class="form-control" id="projectDescription" name="projectDescription" rows="4" required></textarea>
            </div>
            <div class="form-group">
              <label for="projectStartDate">Fecha de Inicio</label>
              <input type="date" class="form-control" id="projectStartDate" name="projectStartDate" required>
            </div>
            <div class="form-group">
              <label for="projectEndDate">Fecha de Finalización</label>
              <input type="date" class="form-control" id="projectEndDate" name="projectEndDate" required>
            </div>
            <div class="form-group">
              <label for="projectStatus">Estado del Proyecto</label>
              <select class="form-control" id="projectStatus" name="projectStatus" required>
                <option value="1">En Proceso</option>
                <option value="2">Atrasado</option>
                <option value="3">Finalizado</option>
              </select>
            </div>
            <button type="submit" class="btn btn-dark btn-lg btn-block" id="createProjectButton">Crear Proyecto</button>
            <div id="success-message" style="display: none; color: green; margin-top: 10px;"></div>
            <div id="error-message" style="display: none; color: red; margin-top: 10px;"></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->

<!-- footer content -->
<footer>
  <div class="pull-right">
    DevTracker - Proyecto de Desarrollo de Software
  </div>
  <div class="clearfix"></div>
</footer>
<!-- /footer content -->
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
</body>

</html>
<script>
  $(document).ready(function() {

    function getProjectIdFromUrl() {
      var urlParams = new URLSearchParams(window.location.search);
      return urlParams.has('id') ? urlParams.get('id') : null;
    }

    function loadProjectData() {
      var projectId = getProjectIdFromUrl();
      if (projectId) {
        $.ajax({
          type: 'POST',
          url: '../ajax/project_ajax.php',
          data: {
            projectId: projectId,
            type: 'get_project_by_id'
          },
          success: function(response) {
            var responseData = JSON.parse(response);
            $('#projectName').val(responseData.projectName);
            $('#projectDescription').val(responseData.projectDescription);
            $('#projectStartDate').val(responseData.projectStartDate);
            $('#projectEndDate').val(responseData.projectEndDate);
            $('#projectStatus').val(responseData.projectState);
            $('#createProjectForm').attr('data-project-id', projectId); 
            $('#createProjectButton').text('Actualizar Proyecto');
          },
          error: function(xhr, status, error) {
            console.error('Error:', error);
          }
        });
      }
    }

    loadProjectData();

    $('#createProjectForm').submit(function(e) {
      e.preventDefault();

      var projectName = $('#projectName').val();
      var projectDescription = $('#projectDescription').val();
      var projectStartDate = $('#projectStartDate').val();
      var projectEndDate = $('#projectEndDate').val();
      var projectStatus = $('#projectStatus').val();
      var type = "create_project";
      var projectId = $(this).attr('data-project-id'); 

      if (projectId) {
        type = "update_project"; 
      }

      $.ajax({
        type: 'POST',
        url: '../ajax/project_ajax.php',
        data: {
          projectId: projectId, 
          projectName: projectName,
          projectDescription: projectDescription,
          projectStartDate: projectStartDate,
          projectEndDate: projectEndDate,
          projectStatus: projectStatus,
          type: type
        },
        success: function(response) {
          $('#success-message').text(response).show();
          $('#createProjectForm')[0].reset();
        },
        error: function(xhr, status, error) {
          $('#error-message').text('Error: ' + error).show();
        }
      });
    });
  });
</script>