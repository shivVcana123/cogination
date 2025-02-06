@extends('layouts.guest')
@section('content')
<style>
   body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }
        #chartContainer {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        #newsletterChart {
            width: 90% !important;
            height: 460px !important
        }
</style>
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-4 col-6">
          <div class="small-box" style="background-color:#0377ce">
            <div class="inner">
              <h3 style="color:white">{{ $pageCount }}</h3>
              <p style="color:white">Total Pages</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-6">
          <div class="small-box" style="background-color:#0377ce">
            <div class="inner">
              <h3 style="color:white">{{ $newsLetterCount }}</h3>
              <p style="color:white">Total Newsletter Subscriptions</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-6">
          <div class="small-box" style="background-color:#0377ce">
            <div class="inner">
              <h3 style="color:white">{{ $totalServicesCount }}</h3>
              <p style="color:white">All Services</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 mt-3">
          <div class="d-flex align-items-center">
            <label for="filterType" class="mr-2">Filter by:</label>
            <select id="filterType" class="form-control" style="width: 150px;">
              <option value="week">This Week</option>
              <option value="month">This Month</option>
              <option value="year">This Year</option>
              <option value="all">All</option>
            </select>
          </div>
        </div>
      </div>
      <div class="row">
        <section class="col-lg-12 connectedSortable">
          <div class="card">
            <div class="card-header" style="background-color:#0377ce;color:white">
              <h3 class="card-title">
                <i class="fas fa-chart-bar mr-1"></i>
                Newsletter Subscriptions
              </h3>
            </div>
            <div class="card-body">
              <div class="tab-content p-0">
                <div class="chart tab-pane active" id="revenue-chart"
                >
                  <canvas id="newsletterChart" ></canvas>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </section>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src= "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  function fetchData(filterType = "week") { // Default value is "week"
    let baseUrl = "{{ route('newsletter-subscriptions-recent', ['filter' => 'PLACEHOLDER']) }}";
    let apiUrl = baseUrl.replace("PLACEHOLDER", filterType); // Replace placeholder with actual filter

    $.ajax({
      url: apiUrl,
      type: "GET",
      dataType: "json",
      success: function (data) {
        // Format labels as Month/Year
        const labels = data.map(item => `${item.month}/${item.year}`);
        const subscriptionCounts = data.map(item => item.count);

        const ctx = document.getElementById('newsletterChart').getContext('2d');
        new Chart(ctx, {
          type: "bar",
          data: {
            labels: labels,
            datasets: [{
              label: `${filterType.charAt(0).toUpperCase() + filterType.slice(1)} Subscriptions`,
              data: subscriptionCounts,
              backgroundColor: "rgba(3, 119, 206, 0.6)",
              borderColor: "#0377ce",
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                display: true,
                position: 'top'
              }
            },
            scales: {
              x: {
                title: {
                  display: true,
                  text: 'Month/Year'
                },
                ticks: {
                  autoSkip: false,  // Ensure all labels are shown
                  maxRotation: 45,  // Rotate labels to avoid overlapping
                  minRotation: 45
                }
              },
              y: {
                title: {
                  display: true,
                  text: 'Subscriptions'
                },
                beginAtZero: true
              }
            }
          }
        });
      },
      error: function (xhr, status, error) {
        console.error("Error fetching newsletter subscription data:", error);
      }
    });
  }

  $(document).ready(function() {
    $("#filterType").val("week"); // Set default value in the dropdown
    fetchData("week"); // Fetch data for "week" on page load
  });

  // Trigger when filter dropdown changes
  $("#filterType").change(function() {
    fetchData($(this).val());
  });
</script>


@endsection
