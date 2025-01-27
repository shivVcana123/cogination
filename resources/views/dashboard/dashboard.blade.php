@extends('layouts.guest')
@section('content')
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
        <div class="col-md-12 mb-3">
          <div class="d-flex align-items-center">
            <label for="filterType" class="mr-2">Filter by:</label>
            <select id="filterType" class="form-control" style="width: 150px;">
              <option value="week">This Week</option>
              <option value="month">This Month</option>
              <option value="year">This Year</option>
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
                  style="position: relative; height: 300px;">
                  <canvas id="newsletterChart" style="width:100%;max-width:600px"></canvas>
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
<script>
  function fetchData(filterType) {
    fetch(`http://127.0.0.1:8000/cognition/newsletter-subscriptions/recent?filter=${filterType}`)
      .then(response => response.json())
      .then(data => {
        const labels = data.map(item => `${item.month}/${item.year}`);
        const subscriptionCounts = data.map(item => item.count);

        const ctx = document.getElementById('newsletterChart').getContext('2d');
        new Chart(ctx, {
          type: "bar",
          data: {
            labels: labels,
            datasets: [{
              label: 'Monthly Subscriptions',
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
      })
      .catch(error => {
        console.error('Error fetching newsletter subscription data:', error);
      });
  }

  document.getElementById('filterType').addEventListener('change', function() {
    fetchData(this.value);
  });

  // Trigger initial load
  document.getElementById('filterType').dispatchEvent(new Event('change'));
</script>
@endsection
