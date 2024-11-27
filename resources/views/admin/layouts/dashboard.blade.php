@extends('admin.layouts.app')

@section('content')

<!-- Style Css -->
<link rel="stylesheet" href="{{ asset('public/dashboard-assets/css/pages-css/index.css') }}" />
<!-- Style Css -->
<script src="https://code.highcharts.com/highcharts.js"></script>

<div class="dash-home-cards">
  <div class="row row-cols-xxl-4 row-cols-xl-3 row-cols-md-2 row-cols-1 top-cards">
    <div class="col-md-6 col-lg-4 col-xl-3 mb-25 mb-lg-45">
      <div class="card">
        <a class="card-body" href="{{url('logActivity')}}">
          <p class="cart-title">Login History</p>
          <div class="card-results">
            <h5 class="main-results">{{\App\Models\LogActivity::count()}}</h5>
            <p class="perstant-result text-success"><i class=""></i> </p>
          </div>
        </a>
      </div>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3 mb-25 mb-lg-45">
      <div class="card">
        <a class="card-body" href="{{url('totalusers')}}">
          <p class="cart-title">Total Users</p>
          <div class="card-results">

            <h5 class="main-results">{{ \App\Models\User::count() }}</h5>

            <p class="perstant-result text-success"><i class=""></i> </p>
          </div>
        </a>
      </div>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3 mb-25 mb-lg-45">
      <div class="card">
        <a class="card-body" href="javascript:void(0);">
          <p class="cart-title">Email log</p>
          <div class="card-results">
            <h5 class="main-results"></h5>
            <p class="perstant-result text-success"></p>
          </div>
        </a>
      </div>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3 mb-25 mb-lg-45">
      <div class="card">
        <a class="card-body" href="javascript:void(0);">
          <p class="cart-title"></p>
          <div class="card-results">
            <h5 class="main-results"></h5>
            <p class="perstant-result text-success"> </p>

          </div>
        </a>
      </div>
    </div>
    </div>

  <div class="row">
    <div class="col-md-6 mb-25 mb-lg-45">
      <div class="card">
        <div class="card-body">
          <figure class="highcharts-figure">
            <div id="container-pie"></div>
          </figure>
        </div>
      </div>
    </div>
    <div class="col-md-6 mb-25 mb-lg-45">
      <div class="card">
        <div class="card-body">
          <figure class="highcharts-figure">
            <div id="container-line"></div>
          </figure>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive grid-wrapper">
            <table class="table table-bordered table-hover">
              <thead class="">
                <tr class="filter-header">
                  <th>
                    <a href="#">ID</a>
                  </th>
                  <th>
                    <a href="#">Name</a>
                  </th>
                  <th>
                    <a href="#">Email</a>
                  </th>
                  <th>
                    <a href="#">Created At</a>
                  </th>
                  <th>
                    <a href="#">Actions</a>
                  </th>
                </tr>
                <tr>
                  <th>
                    <input type="text" name="id" class="form-control" placeholder="filter by id">
                  </th>
                  <th>
                    <input type="text" name="name" class="form-control" placeholder="filter by name">
                  </th>
                  <th>
                    <input type="text" name="email" class="form-control" placeholder="filter by email">
                  </th>
                  <th>
                    <input type="text" name="created_at" class="form-control" placeholder="filter by created_at">
                  </th>
                  <th class="">
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr class="">
                  <td class="">
                    1952
                  </td>
                  <td class="">
                    Kuro
                  </td>
                  <td class="">
                    kuroisback@gmail.com
                  </td>
                  <td class="">
                    2022-03-07
                  </td>
                  <td>
                    <div class="pull-right d-flex">
                      <a href="" title="view record" class=" btn-success btn mr-2">
                        <i class="fa fa-eye"></i>
                      </a>
                      <a href="" title="delete record" class="btn-danger btn" data-method="DELETE" data-trigger-confirm="1" data-pjax-target="#user-grid">
                        <i class="fa fa-trash"></i>
                      </a>
                    </div>
                  </td>
                </tr>
                <tr class="">
                  <td class="">
                    1952
                  </td>
                  <td class="">
                    Kuro
                  </td>
                  <td class="">
                    kuroisback@gmail.com
                  </td>
                  <td class="">
                    2022-03-07
                  </td>
                  <td>
                    <div class="pull-right d-flex">
                      <a href="" title="view record" class=" btn-success btn mr-2">
                        <i class="fa fa-eye"></i>
                      </a>
                      <a href="" title="delete record" class="btn-danger btn" data-method="DELETE" data-trigger-confirm="1" data-pjax-target="#user-grid">
                        <i class="fa fa-trash"></i>
                      </a>
                    </div>
                  </td>
                </tr>
                <tr class="">
                  <td class="">
                    1952
                  </td>
                  <td class="">
                    Kuro
                  </td>
                  <td class="">
                    kuroisback@gmail.com
                  </td>
                  <td class="">
                    2022-03-07
                  </td>
                  <td>
                    <div class="pull-right d-flex">
                      <a href="" title="view record" class=" btn-success btn mr-2">
                        <i class="fa fa-eye"></i>
                      </a>
                      <a href="" title="delete record" class="btn-danger btn" data-method="DELETE" data-trigger-confirm="1" data-pjax-target="#user-grid">
                        <i class="fa fa-trash"></i>
                      </a>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
Highcharts.chart('container-pie', {
  chart: {
    plotBackgroundColor: null,
    plotBorderWidth: null,
    plotShadow: false,
    type: 'pie'
  },
  title: {
    text: 'Total Sales, 2022'
  },
  tooltip: {
    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
  },
  accessibility: {
    point: {
      valueSuffix: '%'
    }
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      dataLabels: {
        enabled: true,
        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
      }
    }
  },
  series: [{
    name: 'Brands',
    colorByPoint: true,
    data: [{
      name: 'Sale 01',
      y: 61.41,
      sliced: true,
      selected: true
    }, {
      name: 'Sale 01',
      y: 11.84
    }, {
      name: 'Sale 01',
      y: 10.85
    }, {
      name: 'Sale 01',
      y: 4.67
    }, {
      name: 'Sale 01',
      y: 4.18
    }, {
      name: 'Sale 01',
      y: 1.64
    }, {
      name: 'Sale 01',
      y: 1.6
    }, {
      name: 'Sale 01',
      y: 1.2
    }, {
      name: 'Sale 01',
      y: 2.61
    }]
  }]
});

Highcharts.chart('container-line', {
  title: {
    text: 'Total Users'
  },
  subtitle: {
    text: '2021 - 2022'
  },
  yAxis: {
    title: {
      text: 'Number of Employees'
    }
  },
  xAxis: {
    accessibility: {
      rangeDescription: 'Range: 2010 to 2017'
    }
  },
  legend: {
    layout: 'vertical',
    align: 'right',
    verticalAlign: 'middle'
  },
  plotOptions: {
    series: {
      label: {
        connectorAllowed: false
      },
      pointStart: 2010
    }
  },

  series: [{
    name: 'Sale 01',
    data: [43934, 52503, 57177, 69658, 97031, 1131, 137133, 154175]
  }, {
    name: 'Sale 02',
    data: [24916, 24064, 29742, 29851, 32490, 30282, 38121, 40434]
  }, {
    name: 'Sale 03',
    data: [11744, 17722, 16005, 19771, 20185, 24377, 32147, 39387]
  }, {
    name: 'Sale 04',
    data: [null, null, 7988, 12169, 15112, 22452, 34400, 34227]
  }, {
    name: 'Sale 05',
    data: [12908, 5948, 8105, 11248, 8989, 11816, 18274, 18111]
  }],

  responsive: {
    rules: [{
      condition: {
        maxWidth: 500
      },
      chartOptions: {
        legend: {
          layout: 'horizontal',
          align: 'center',
          verticalAlign: 'bottom'
        }
      }
    }]
  }

});
</script>
@endsection
