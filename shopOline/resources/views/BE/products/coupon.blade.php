@extends('layouts.themeAdmin')
@section('title', 'Tums | Mã giảm giá')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/product.css') }}">
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Mã giảm giá</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ asset('dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Mã giảm giá</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8"></div>
                <div class="col-sm-4 act text-right">
                    <button class="btn btn-success" data-toggle="modal" data-target="#add">
                        <i class="fas fa-plus"></i>
                        <span>Thêm mới</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row" id="datatable">
                <div class="col-12">
                    <div class="right">
                        <table>
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên mã giảm giá</th>
                                    <th>Mã giảm giá</th>
                                    <th>Số lượng</th>
                                    <th>Điều kiện giảm</th>
                                    <th>Giá trị giảm</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @forelse ($coupons as $key => $coupon )
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{  $coupon->coupon_name }}</td>
                                        <td>{{  $coupon->coupon_code }}</td>
                                        <td>{{  $coupon->coupon_number }}</td>
                                        <td>
                                            @if($coupon->coupon_status == 0)
                                                Giảm theo %
                                            @else
                                                Giảm theo giá tiền
                                            @endif
                                        </td>
                                        <td>
                                            @if($coupon->coupon_status == 0)
                                            {{  $coupon->coupon_value }} %
                                            @else
                                                {{  number_format($coupon->coupon_value, 0, ',', '.') }} đ
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary edit" data-toggle="modal" data-target="#update" data-id="{{  $coupon->coupon_id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                
                                                <button type="button" class="btn btn-danger delete" data-toggle="modal" data-target="#delete" data-id="{{  $coupon->coupon_id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>                                    
                                @empty
                                    <tr>
                                        <td colspan="7" style="padding: 20px;text-align: center">
                                            <h4>
                                                Không tìm thấy kết quả phù hợp
                                            </h4>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $coupons->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->

    {{--  MODAL ADD  --}}
    <div class="modal" id="add" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm mã giảm giá</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ asset("/dashboard/coupon/add/") }}" method="POST">
                    @csrf
                    <div class="modal-body form-row">
                        <div class="form-group col-sm-6">
                            <label for="">Tên mã giảm giá</label>
                            <input type="text" class="form-control"  placeholder="Tên mã giảm giá" required name="name" autocomplete="off">
                            
                            <label for="">Giảm theo</label>
                            <select name="status" class="form-control status">
                                <option value="0">%</option>
                                <option value="1">đ</option>
                            </select>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="">Mã giảm giá</label>
                            <input type="text" class="form-control"  placeholder="Mã giảm giá" required name="code" autocomplete="off">
                            
                            
                            <label for="">Giá trị</label>
                            <input type="number" class="form-control value" placeholder="Giá trị" name="value" autocomplete="off" min="0" max="90">
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="">Số lượng</label>
                            <input type="number" class="form-control" placeholder="Số lượng" required name="number" autocomplete="off">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--  MODAL UPDATE  --}}
    <div class="modal" id="update" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">Sửa mã giảm giá</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                    @csrf</form>
                <form action="{{ asset("/dashboard/coupon/update/") }}" method="POST" id="form">
                    @csrf
                    <div class="modal-body form-row">
                        <div class="form-group col-sm-6">
                            <label for="">Tên mã giảm giá</label>
                            <input type="text" id="name" class="form-control"  placeholder="Mã giảm giá" required name="name" autocomplete="off">
                            
                            <label for="">Giảm theo</label>
                            <select name="status" id="status" class="form-control">
                                <option value="0">%</option>
                                <option value="1">đ</option>
                            </select>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="">Mã giảm giá</label>
                            <input type="text" id="code" class="form-control" placeholder="Mã giảm giá" required name="code" autocomplete="off">
                            
                            
                            <label for="">Giá trị</label>
                            <input type="number" id="value" class="form-control" placeholder="Giá trị" name="value" autocomplete="off">
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="">Số lượng</label>
                            <input type="number" id="number" class="form-control" placeholder="Số lượng" required name="number" autocomplete="off">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="delete">
        <div class="modal-dialog " role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xoá mã giảm giá</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post" id="formDelete">
                @csrf
                <div class="modal-body">
                    Bạn có muốn xoá mã giảm giá này?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-danger">Xoá</button>
                </div>
            </form>
          </div>
        </div>
    </div>

    <div class="modal fade" id="modal">
        <div class="modal-dialog " role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Error</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                        <strong>{{ $error }}</strong>
                    </div>
                @endforeach
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
          </div>
        </div>
    </div>

@endsection

@section('js')
     @if ($errors->any() || session()->has('success') )
        <script>
            $(document).ready(function(){
                $('#modal').modal({show: true});
            });
        </script>
    @endif 

    <script>
        $('.c ').addClass('menu-open');
        $('.c > .nav-link').addClass('active');
        $('.c .nav-treeview #coupon').addClass('active');

        // $('#key').keyup(function(){
        //     var key = $('#key').val();
        //     $('#formSearch').attr('action', '{{ asset("dashboard/prices/search=") }}'+key);
        // });

        $('.status').change(function(){
            alert($('.status').val());
            if($('.status').val() == '1'){
                $('.value').attr('max', '1000000');
            }
        });

        $('.edit').click(function(){
            var id = $(this).data('id');
            $('#form').attr('action','{{ asset("/dashboard/coupon/update") }}/'+ id);
   
            $.ajax({
                url :'{{ asset("/dashboard/coupon/edit") }}/'+id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "post",
                dataType: "json",
                success: function(data) {
                    $('#name').val(data.coupons.coupon_name);
                    $('#code').val(data.coupons.coupon_code);
                    $('#value').val(data.coupons.coupon_value);
                    $('#number').val(data.coupons.coupon_number);

                    $('#status').find('option').each(function(i,e){
                        if($(e).val() == data.coupons.coupon_status){
                            $('#status').prop('selectedIndex',i);
                        }
                    });
                }
            });
        });

        $('.delete').click(function(){
            var id = $(this).data('id');
            $('#formDelete').attr('action','{{ asset("/dashboard/coupon/delete") }}/'+ id);
        });

    </script>
@endsection
