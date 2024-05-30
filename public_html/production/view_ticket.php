<?php include 'header.php'; ?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Ver Tickets</h3>
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
                  <th style="width: 20%">Título del Ticket</th>
                  <th style="width: 20%">Descripción</th>
                  <th style="width: 20%">Estado</th>
                  <th style="width: 20%">Comentarios</th>
                  <th style="width: 20%">Historia de Usuario</th>
                  <th style="width: 10%">Acciones</th>
                </tr>
              </thead>
              <tbody id="ticketTableBody">
                <!-- Las filas de tickets se agregarán aquí dinámicamente -->
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
    var type = "get_tickets_dt";
    $.ajax({
      type: 'POST',
      url: '../ajax/ticket_ajax.php',
      data: {
        type: type
      },
      success: function(response) {
        var ticketTableBody = $('#ticketTableBody');
        ticketTableBody.empty();

        try {
          var tickets = JSON.parse(response);
          $.each(tickets, function(index, ticket) {
            var row = $('<tr>');
            row.append($('<td>').text(ticket.id_ticket));
            row.append($('<td>').text(ticket.titulo_ticket));
            row.append($('<td>').text(ticket.descr_ticket));
            row.append($('<td>').text(ticket.estado_ticket));
            row.append($('<td>').text(ticket.comentarios_ticket));
            row.append($('<td>').text(ticket.nom_historia));
            row.append($('<td>').html(`
                  <a href="#" class="btn btn-outline-primary btn-sm edit-ticket" data-id="${ticket.id_ticket}">
                    <i class="fa fa-pencil"></i> Editar
                  </a>

                  <a href="#" class="btn btn-outline-danger btn-sm delete-ticket" data-id="${ticket.id_ticket}">
                    <i class="fa fa-trash"></i> Eliminar
                  </a>
                  `));
            ticketTableBody.append(row);
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

    $(document).on('click', '.edit-ticket', function(e) {
      e.preventDefault();
      var ticketId = $(this).data('id');
      console.log("Edit ticket with ID:", ticketId);
      window.location.href = 'create_ticket.php?id=' + ticketId;
    });

    $(document).on('click', '.delete-ticket', function(e) {
      e.preventDefault();
      var ticketId = $(this).data('id');
      if (confirm("¿Estás seguro de que deseas eliminar este ticket?")) {
        $.ajax({
          type: 'POST',
          url: '../ajax/ticket_ajax.php',
          data: {
            ticketId: ticketId,
            type: 'delete_ticket'
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
        console.log("Eliminación del ticket cancelada.");
      }
      console.log("Delete ticket with ID:", ticketId);
    });
  });
</script>
</body>
</html>
