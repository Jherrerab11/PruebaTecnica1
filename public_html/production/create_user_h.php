<?php include 'header.php'; ?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="page-title">
        <div class="title_left">
            <h3>Crear Historias de Usuario</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form id="createUserHForm">
                        <div class="form-group">
                            <label for="userStoryName">Nombre de la Historia de Usuario</label>
                            <input type="text" class="form-control" id="userStoryName" name="userStoryName" required>
                        </div>
                        <div class="form-group">
                            <label for="userStoryDescription">Descripción de la Historia de Usuario</label>
                            <textarea class="form-control" id="userStoryDescription" name="userStoryDescription" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="userStoryProject">Proyecto</label>
                            <select class="form-control" aria-label="Selecciona tu proyecto" id="userStoryProject">
                                <option disabled selected>Selecciona tu proyecto</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-dark btn-lg btn-block mt-3" id="createProjectButton">Crear Historia</button>
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
        $.ajax({
            type: "POST",
            url: "../ajax/user_h_ajax.php",
            data: {
                type: "Consulta_proyectos"
            },
            dataType: "json",
            success: function(response) {
                response.forEach(function(proyectos) {
                    $("#userStoryProject").append(
                        $("<option>", {
                            value: proyectos.id_proyecto,
                            text: proyectos.project_name,
                        })
                    );
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
            },
        });

        function getStoryIdFromUrl() {
            var urlParams = new URLSearchParams(window.location.search);
            return urlParams.has('id') ? urlParams.get('id') : null;
        }

        function loadProjectData() {
            var StoryId = getStoryIdFromUrl();
            if (StoryId) {
                $.ajax({
                    type: 'POST',
                    url: '../ajax/user_h_ajax.php',
                    data: {
                        StoryId: StoryId,
                        type: 'get_story_by_id'
                    },
                    success: function(response) {
                        var responseData = JSON.parse(response);
                        $('#userStoryName').val(responseData.StoryName);
                        $('#userStoryDescription').val(responseData.StoryDesc);
                        $('#userStoryProject').val(responseData.StoryIdProyect);

                        $('#createUserHForm').attr('data-project-id', StoryId);
                        $('#createProjectButton').text('Actualizar Historia');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }
        }

        loadProjectData();



        $('#createUserHForm').submit(function(e) {
            e.preventDefault();

            var userStoryName = $('#userStoryName').val(); 
            var userStoryDescription = $('#userStoryDescription').val(); 
            var userStoryProject = $('#userStoryProject').val(); 
            var type = "create_userh";
            var StoryId = $(this).attr('data-project-id');

            if (StoryId) {
                type = "update_story";
            }
            console.log(userStoryProject);
            $.ajax({
                type: 'POST',
                url: '../ajax/user_h_ajax.php',
                data: {
                    userStoryName: userStoryName,
                    StoryId: StoryId,
                    userStoryDescription: userStoryDescription, 
                    userStoryProject: userStoryProject, 
                    type: type
                },
                success: function(response) {
                    $('#success-message').text(response).show();
                    $('#createUserHForm')[0].reset();
                },
                error: function(xhr, status, error) {
                    $('#error-message').text('Error: ' + error).show();
                }
            });
        });
    });
</script>