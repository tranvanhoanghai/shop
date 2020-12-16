@extends('layouts.themeAdmin')
@section('title', 'admin')

@section('content')
<!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Tổng quan</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ asset('dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Tổng quan</li>
                    </ol>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3 class="count">{{ $bill_order->total_bill }}</h3>

                            <p>Hoá đơn mới</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ asset('dashboard/orders') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3 class="count"><sup style="font-size: 20px">{{ visits('App\Models\Slider')->count() }}</sup></h3>
                            <p>Lượt truy cập</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3 class="count">{{ $customer->total_customer }}</h3>

                            <p>Khách hàng</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{ asset('dashboard/customers') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3 class="count">{{ $product->total_product }}</h3>

                            <p>Sản phẩm</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="{{ asset('dashboard/products') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <div class="row">
                <div class="col-lg-9">

                    <div class=" dash-kq">
                        <div class="row">
                            <div class="col-lg-12 kq">
                                KẾT QUẢ BÁN HÀNG HÔM NAY
                            </div>
                        </div>
                    </div>

                    <div class="dash">
                        <div class="row">

                            <div class="col-lg-6  dash-col">
                                <div class="total">
                                    <label class="dash-icon">
                                        <i class="fas fa-dollar-sign"></i>
                                    </label>

                                    <label class="dash-title">
                                        <span>{{ $bills }}</span> Hoá đơn
                                    </label>

                                    <span class="number">{{ $bills }}</span>
                                    <label class="dash-text">Doanh thu</label>
                                </div>
                            </div>

                            <div class="col-lg-6  dash-col">
                                <div class="return">
                                    <label class="dash-icon">
                                        <i class="fas fa-reply-all"></i>
                                    </label>

                                    <label class="dash-title">
                                        <span>{{ $bill_cancel }}</span> Phiếu
                                    </label>

                                    <span class="number">{{ $bill_cancel }}</span>
                                    <label class="dash-text">Trả hàng</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header ui-sortable-handle" style="cursor: move;">
                            <h3 class="card-title">DOANH THU</h3>
            
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                
                                <button type="button" class="btn btn-tool" data-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body" style="display: block;">
                            <div class="card">
                                <div class="card-header border-0">
                                    <div class="d-flex justify-content-between">
                                        <h3 class="card-title"></h3>
                                        <select class="form-control" id="revenues" style="width: auto">
                                            <option value="today">Hôm nay</option>
                                            <option value="yesterday">Hôm qua</option>
                                            <option value="lastWeek">7 ngày qua</option>
                                            <option value="thisMonth">Tháng này</option>
                                            <option value="lastMonth">Tháng trước</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="position-relative mb-4">
                                        <canvas id="chart" height="300"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                    <div class="card">
                        <div class="card-header ui-sortable-handle" style="cursor: move;">
                            <h3 class="card-title">TOP HÀNG HÓA BÁN CHẠY THEO SỐ LƯỢNG</h3>
            
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                
                                <button type="button" class="btn btn-tool" data-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body" style="display: block;">
                            <div class="card">
                                <div class="card-header border-0">
                                    <div class="d-flex justify-content-between">
                                        <h3 class="card-title"></h3>  
                                        <select class="form-control" id="best" style="width: auto">
                                            <option value="today">Hôm nay</option>
                                            <option value="yesterday">Hôm qua</option>
                                            <option value="lastWeek">7 ngày qua</option>
                                            <option value="thisMonth">Tháng này</option>
                                            <option value="lastMonth">Tháng trước</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="position-relative mb-4">
                                        <canvas id="bestSeller" ></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- /.col-lg-6 -->
                <div class="col-lg-3">
                    <div class="cart lists-right">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                <b>CÁC HOẠT ĐỘNG GẦN ĐÂY</b></h3>
                            <hr>
                        </div>
                        <div class="card-body" style="overflow: auto;">
                            <div class="lists">
                                <ul>
                                    @foreach($notices as $key => $notice)
                                        <li class="lists-li">
                                            <div class="lists-icon" @if($notice->icon == 'fa fa-share-square')style="background:#ef5f81" @endif>
                                                <i class="{{ $notice->icon }}"></i>
                                            </div>
                                            <div class="lists-text">
                                                <span>
                                                    @if(is_numeric($notice->value))
                                                        <b>{{ $notice->name }}</b>
                                                            {{ $notice->content }}
                                                        <b> {{ number_format($notice->value, 0, ',', '.') }} đ </b>
                                                    @else
                                                        <b>{{ $notice->name }}</b>
                                                            {{ $notice->content }}
                                                        <b> {{ $notice->value }}</b>
                                                    @endif
                                                </span>
                                                <br>
                                                <i class="lists-time">{{ $notice->created_at }}</i>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-3 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
@endsection

@section('js')
  <script>

    $('.a .nav-link').addClass('active');

    $('.count').each(function () {
        $(this).prop('Counter',0).animate({
            Counter: $(this).text()
        }, {
            duration: 1000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    });

    var ctx = document.getElementById('chart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [@foreach($revenues as $revenue)'{{ $revenue->dates }}/{{ $revenue->month }}',@endforeach],
            datasets: [{
                label: 'Tổng tiền',
                data: [@foreach($revenues as $revenue){{ $revenue->total }},@endforeach],
                backgroundColor: "rgba(255,99,132,0.2)",
                borderColor: "rgba(255,99,132,1)",
                borderWidth: 1,
                hoverBackgroundColor: "rgba(255,99,132,0.4)",
                hoverBorderColor: "rgba(255,99,132,1)",
            }]
        },
        options: {
            maintainAspectRatio: false,
            tooltips: { 
                mode: 'label', 
                label: 'mylabel', 
                callbacks: { 
                    label: function(tooltipItem, data) { 
                        return tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); 
                    }, 
                }, 
            },
            scales: {
                yAxes: [{
                    stacked: true,
                    gridLines: {
                        display: true,
                        color: "rgba(255,99,132,0.2)",
                        stepSize: 1
                    }
                }],
                xAxes: [{
                    gridLines: {
                        display: true
                    },
                    barThickness: 100,
                    maxBarThickness:50
                }]
            }
        }
    });

    $('#revenues').change(function(){
        var date = $('#revenues').val();
        $.ajax({
            url:'{{ asset("/dashboard/revenue") }}',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "get",
            dataType: "json",
            data: {
                date:date
            },
            success: function(data) {
                // console.log(data);
                var date = [];
                var total = [];
                $.each(data.revenue, function (index, value) {
                    var newLength = date.push(value.dates+'/'+value.month);
                    var newLength2 = total.push(value.total);
                });
              
                chart.data.labels = date;
                chart.data.datasets[0].data = total;
                chart.update();
            }
        });
    });


    var ctx = document.getElementById('bestSeller').getContext('2d');
    var myChart = new Chart(ctx, {
        
        type: 'horizontalBar',
        data: {
            labels: [@foreach($best_sellers as $best_seller)'{{ $best_seller->name_product }}',@endforeach],
            datasets: [{
                label: 'Số lượng đã  bán',
                fill: true,
                data: [@foreach($best_sellers as $best_seller){{ $best_seller->total_qty }},@endforeach],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)', 
                    'rgba(75, 192, 192, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                    },
                    barThickness: 100,
                    maxBarThickness:50
                }],
                xAxes: [{
                    gridLines: {
                        display: true
                    },
                    barThickness: 50,
                    ticks: {
                        padding: 15,
                        beginAtZero: true,
                        fontColor: "black",
                        fontStyle: "bold",
                        stepSize: 1
                    }
                }]
            }
        }
    });


    $('#best').change(function(){
        var date = $('#best').val();

        $.ajax({
            url:'{{ asset("/dashboard/best") }}',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "get",
            dataType: "json",
            data: {
                date:date
            },
            success: function(data) {
                // console.log(data);
                var name = [];
                var total = [];
                $.each(data.best_sellers, function (index, value) {
                    var newLength = name.push(value.name_product);
                    var newLength2 = total.push(value.total_qty);
                });
              
                myChart.data.labels = name;
                myChart.data.datasets[0].data = total;
                myChart.update();
            }
        });
    });
  </script>
@endsection
