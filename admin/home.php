<style>
  .info-tooltip,.info-tooltip:focus,.info-tooltip:hover{
    background:unset;
    border:unset;
    padding:unset;
  }
</style>
<h1>Welcome to <?php echo $_settings->info('name') ?></h1>
<hr>
<div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-money-bill-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Current Overall Budget</span>
                <span class="info-box-number text-right">
                  <?php 
                    $cur_bul = $conn->query("SELECT sum(balance) as total FROM `categories` where status = 1 ")->fetch_assoc()['total'];
                    echo number_format($cur_bul);
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-calendar-day"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Today's Budget Entries</span>
                <span class="info-box-number text-right">
                  <?php 
                    $today_budget = $conn->query("SELECT sum(amount) as total FROM `running_balance` where category_id in (SELECT id FROM categories where status =1) and date(date_created) = '".(date("Y-m-d"))."' and balance_type = 1 ")->fetch_assoc()['total'];
                    // echo number_format($today_budget);
                    echo ($today_budget !== null) ? number_format($today_budget) : 0;
                  ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-calendar-day"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Today's Budget Expenses</span>
                <span class="info-box-number text-right">
                <?php 
                    $today_expense = $conn->query("SELECT sum(amount) as total FROM `running_balance` where category_id in (SELECT id FROM categories where status =1) and date(date_created) = '".(date("Y-m-d"))."' and balance_type = 2 ")->fetch_assoc()['total'];
                    // echo number_format($today_expense);
                    echo ($today_expense !== null) ? number_format($today_expense) : 0;
                  ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
        </div>
<div class="row">
  <div class="col-lg-12">
    <h4>Current Budget in each Categories</h4>
    <hr>
  </div>
</div>
<div class="col-md-12 d-flex justify-content-center">
  <div class="input-group mb-3 col-md-5">
    <input type="text" class="form-control" id="search" placeholder="Search Category">
    <div class="input-group-append">
      <span class="input-group-text"><i class="fa fa-search"></i></span>
    </div>
  </div>
</div>
<div class="row row-cols-4 row-cols-sm-1 row-cols-md-4 row-cols-lg-4">
  <?php 
  $categories = $conn->query("SELECT * FROM `categories` where status = 1 order by `category` asc ");
    while($row = $categories->fetch_assoc()):
  ?>
  <div class="col p-2 cat-items">
    <div class="callout callout-info">
      <span class="float-right ml-1">
        <button type="button" class="btn btn-secondary info-tooltip" data-toggle="tooltip" data-html="true" title='<?php echo (html_entity_decode($row['description'])) ?>'>
          <span class="fa fa-info-circle text-info"></span>
        </button>
      </span>
      <h5 class="mr-4"><b><?php echo $row['category'] ?></b></h5>
      <div class="d-flex justify-content-end">
        <b><?php echo number_format($row['balance']) ?></b>
      </div>
    </div>
  </div>
  <?php endwhile; ?>
</div>

<div class="col-md-12">
  <h3 class="text-center" id="noData" style="display:none">No Data to display.</h3>
</div>


<?php 
// Query to fetch balance data from categories table
$sql = "SELECT Category, Balance FROM categories where status='1' ";
$result = $conn->query($sql);

$categories = array();
$balances = array();

// Fetch data and store it in arrays
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row['Category'];
        $balances[] = $row['Balance'];
    }
}
?>
 <h2>Charts Displays</h2> <hr> <br>
<div class="row">
 
<div class="col-md-5 p-2 m-4" style = "border: 1px solid black" >
  <!-- <h2>chart display of budget</h2><hr> --> 
  <br>
<canvas id="myChart" width="400" height="400"></canvas>

</div>
<div class="col-md-5 p-2 m-4" style = "border: 1px solid black" >
  <!-- <h2> Pie-chart display of budget</h2><hr> -->
  <br>
<canvas id="myChart1" width="400" height="400"></canvas>
</div>
</div>

<script>
// PHP data passed to JavaScript
        var categories = <?php echo json_encode($categories); ?>;
        var balances = <?php echo json_encode($balances); ?>;

        //Create chart using Chart.js
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: categories,
                datasets: [{
                    label: 'Balance',
                    data: balances,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

         // Create chart using Chart.js
        var ctx1 = document.getElementById('myChart1').getContext('2d');
        var myChart1 = new Chart(ctx1, {
            type: 'pie',
            data: {
                labels: categories,
                datasets: [{
                    label: 'Balance',
                    data: balances,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                        'rgba(255, 159, 64, 0.5)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Category Balances'
                    }
                }
            }
        });

</script>

<script>
  function check_cats(){
    if($('.cat-items:visible').length > 0){
      $('#noData').hide('slow')
    }else{
      $('#noData').show('slow')
    }
  }
  $(function(){
    $('[data-toggle="tooltip"]').tooltip({
      html:true
    })
    check_cats()
    $('#search').on('input',function(){
      var _f = $(this).val().toLowerCase()
      $('.cat-items').each(function(){
        var _c = $(this).text().toLowerCase()
        if(_c.includes(_f) == true)
          $(this).toggle(true);
        else
          $(this).toggle(false);
      })
    check_cats()
    })
  })


</script>
