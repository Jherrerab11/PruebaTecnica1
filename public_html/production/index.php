<?php include 'header.php'; ?>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Dashboard</h3>
      </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="dashboard_graph">
          <div class="row x_title">
            <div class="col-md-6">
              <h3>Project Overview <small>Activity Report</small></h3>
            </div>
          </div>
          <div class="col-md-9 col-sm-9">
            <div id="chart_plot_01" class="demo-placeholder"></div>
          </div>
          <div class="col-md-3 col-sm-3 bg-white">
            <div class="x_title">
              <h2>Top Projects</h2>
              <div class="clearfix"></div>
            </div>

            <div class="col-md-12 col-sm-12">
              <div>
                <p>Project 1</p>
                <div class="">
                  <div class="progress progress_sm" style="width: 76%;">
                    <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="80"></div>
                  </div>
                </div>
              </div>
              <div>
                <p>Project 2</p>
                <div class="">
                  <div class="progress progress_sm" style="width: 76%;">
                    <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="60"></div>
                  </div>
                </div>
              </div>
              <div>
                <p>Project 3</p>
                <div class="">
                  <div class="progress progress_sm" style="width: 76%;">
                    <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="40"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /Page Content -->

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