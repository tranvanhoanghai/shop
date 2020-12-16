@extends('layouts.themeAdmin')
@section('title', 'Tums | Tổng quan báo cáo')

@section('css')
    
@endsection
@section('content') 
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Tổng quan báo cáo</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <form action="{{ asset('dashboard/report/overview/') }}" method="post" id="formYear">
                        @csrf
                        <select class="form-control" id="year" name="years" style="width: auto">
                            @if ($year == 'thisYear')
                                <option value="thisYear" selected>Năm nay</option>
                                <option value="lastYear">Năm trước</option>
                            @else
                                <option value="thisYear" >Năm nay</option>
                                <option value="lastYear" selected>Năm trước</option>
                            @endif
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card-body" style="display: block;">
                        <div class="card">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">DOANH THU CHI TIẾT</h3>  
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="position-relative mb-4">
                                    <canvas id="profit" height="100"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card-body" style="display: block;">
                        <div class="card">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">SẢN PHẨM BÁN CHẠY THEO DANH THU</h3>  
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="position-relative mb-4">
                                    <canvas id="bestSeller" height="100"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card-body" style="display: block;">
                        <div class="card">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">TOP NHÂN VIÊN KHINH DOANH</h3>  
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="position-relative mb-4">
                                    <table class="table">
                                        <thead>
                                            <th>Tên nhân viên</th>
                                            <th>Số điện thoại</th>
                                            <th>Lượng sản phẩm đã bán</th>
                                            <th>Doanh thu</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($top_staffs as $value)
                                                <tr>
                                                    @foreach($users as $user)
                                                        @if($user->id == $value->seller)
                                                            <td>{{ $user ->full_name }}</td>
                                                            <td>{{ $user ->phone }}</td>
                                                        @endif
                                                    @endforeach

                                                    @foreach($top_qtys as $top_qty)
                                                        @if($value->seller == $top_qty->seller)
                                                            <td>{{ $top_qty->total_qty }}</td>
                                                        @endif
                                                    @endforeach
                                                    @php
                                                        // Tổng doanh thu = danh thu bán lẻ + doanh thu đặt hàng (doanh thu đặt hàng - 30k tiền ship)
                                                        $total = $value ->total_price + ( $total_ship->total_ship - (30000*$total_ship->count))
                                                    @endphp
                                                    <td>{{ number_format($total,0, ',', '.') }} đ</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card-body" style="display: block;">
                        <div class="card">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">TOP KHÁCH HÀNG MUA NHIỀU</h3>  
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="position-relative mb-4">
                                    <table class="table">
                                        <thead>
                                            <th>Tên khách hàng</th>
                                            <th>Số điện thoại</th>
                                            <th>Lượng sản phẩm đã mua</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($top_customers as $value)
                                                <tr>
                                                    <td>{{ $value ->full_name }}</td>
                                                    <td>{{ $value ->phone }}</td>
                                                    <td>{{ $value ->total_qty }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <p id="nhap" class="d-none">{{ $total_import->total_import }}</p>
    <p id="ban" class="d-none">{{ $total_sell->total_sell }}</p>

    <p id="ship" class="d-none">{{ $total_ship->total_ship }}</p>
    <p id="count" class="d-none">{{ $total_ship->count }}</p>

@endsection 

@section('js')
    <script>
        $('.g ').addClass('menu-open');
        $('.g > .nav-link').addClass('active');
        $('.g .nav-treeview #overview').addClass('active');

        $('#year').change(function(){
            var year = $('#year').val();
            $('#formYear').attr('action', '{{ asset("dashboard/report/overview/") }}/'+year);
            $('#formYear').submit();
        });



        var ctx = document.getElementById('profit').getContext('2d');
        var nhap = $('#nhap').text();
        var ban = Number($('#ban').text()) + (Number($('#ship').text()) - (30000*Number($('#count').text()))) ;
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Tiền nhập', 'Doanh thu'],
                datasets: [{
                    label: '# of data',
                    data: [nhap, ban],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                    ],
                    borderWidth: 1
                }]
                
            },
            options: {
                legend: {
                    display: false
                },
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
                        ticks: {
                            beginAtZero: true,
                        }, 
                    }],
                    xAxes: [{
                        gridLines: {
                            display: true
                        },
                        barThickness: 50,
                    }]
                }
            }
        });


    var ctx = document.getElementById('bestSeller').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels: [@foreach($best_sellers as $best_seller)'{{ $best_seller->name_product }}',@endforeach],
            datasets: [{
                label: 'Số lượng đã  bán',
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
                        beginAtZero: true
                    },
                }],
                xAxes: [{
                    gridLines: {
                        // display: true,
                        // color: "#cccccc",
                        // zeroLineColor: "#cccccc"
                    },
                    ticks: {
                        padding: 15,
                        beginAtZero: true,
                        fontColor: "black",
                        fontStyle: "bold",
                        maxTicksLimit: 20,
                        stepSize: 1
                    }
                }]
            }
        }
    });

        
    </script>
@endsection
