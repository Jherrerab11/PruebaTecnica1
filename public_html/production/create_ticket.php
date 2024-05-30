<?php include 'header.php'; ?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="page-title">
        <div class="title_left">
            <h3>Crear Ticket</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form id="createTicketForm">
                        <div class="form-group">
                            <label for="ticketTitle">Título del Ticket</label>
                            <input type="text" class="form-control" id="ticketTitle" name="ticketTitle" required>
                        </div>
                        <div class="form-group">
                            <label for="ticketDescription">Descripción del Ticket</label>
                            <textarea class="form-control" id="ticketDescription" name="ticketDescription" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="ticketUserStory">Historia de Usuario</label>
                            <select class="form-control" aria-label="Selecciona tu historia de usuario" id="ticketUserStory">
                                <option disabled selected>Selecciona tu historia de usuario</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="ticketComments">Comentarios</label>
                            <textarea class="form-control" id="ticketComments" name="ticketComments" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="ticketStatus">Estado</label>
                            <select class="form-control" id="ticketStatus" name="ticketStatus" required>
                                <option value="Activo">Activo</option>
                                <option value="En Proceso">En Proceso</option>
                                <option value="Finalizado">Finalizado</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-dark btn-lg btn-block mt-3" id="createTicketButton">Crear Ticket</button>
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
            url: "../ajax/ticket_ajax.php",
            data: {
                type: "Consulta_historias_usuario"
            },
            dataType: "json",
            success: function(response) {
                response.forEach(function(historia) {
                    $("#ticketUserStory").append(
                        $("<option>", {
                            value: historia.id_historia,
                            text: historia.nom_historia,
                        })
                    );
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
            },
        });

        function getTicketIdFromUrl() {
            var urlParams = new URLSearchParams(window.location.search);
            return urlParams.has('id') ? urlParams.get('id') : null;
        }

        function loadTicketData() {
            var ticketId = getTicketIdFromUrl();
            if (ticketId) {
                $.ajax({
                    type: 'POST',
                    url: '../ajax/ticket_ajax.php',
                    data: {
                        ticketId: ticketId,
                        type: 'get_ticket_by_id'
                    },
                    success: function(response) {
                        var responseData = JSON.parse(response);
                        $('#ticketTitle').val(responseData.ticketTitle);
                        $('#ticketDescription').val(responseData.ticketDescription);
                        $('#ticketUserStory').val(responseData.ticketUserStoryId);
                        $('#ticketComments').val(responseData.ticketComments);
                        $('#ticketStatus').val(responseData.ticketStatus);

                        $('#createTicketForm').attr('data-ticket-id', ticketId);
                        $('#createTicketButton').text('Actualizar Ticket');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }
        }

        loadTicketData();

        $('#createTicketForm').submit(function(e) {
            e.preventDefault();

            var ticketTitle = $('#ticketTitle').val(); 
            var ticketDescription = $('#ticketDescription').val(); 
            var ticketUserStory = $('#ticketUserStory').val(); 
            var ticketComments = $('#ticketComments').val(); 
            var ticketStatus = $('#ticketStatus').val(); 
            var type = "create_ticket";
            var ticketId = $(this).attr('data-ticket-id');

            if (ticketId) {
                type = "update_ticket";
            }

            $.ajax({
                type: 'POST',
                url: '../ajax/ticket_ajax.php',
                data: {
                    ticketTitle: ticketTitle,
                    ticketId: ticketId,
                    ticketDescription: ticketDescription, 
                    ticketUserStory: ticketUserStory, 
                    ticketComments: ticketComments, 
                    ticketStatus: ticketStatus,
                    type: type
                },
                success: function(response) {
                    $('#success-message').text(response).show();
                    $('#createTicketForm')[0].reset();
                },
                error: function(xhr, status, error) {
                    $('#error-message').text('Error: ' + error).show();
                }
            });
        });
    });
</script>
