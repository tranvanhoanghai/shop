@extends('layouts.themeAdmin')
@section('title', 'Tums | Contact')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Contact</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ asset('dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Contact</li>
                    </ol>
                </div>
            </div>
        </div>
        <br>
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row" id="datatable">
                
                <div class="col-lg-12">
                    <div class="right">
                        <table class="">
                            <thead>
                                <tr>
                                    <th class="text-center">STT</th>
                                    <th>Họ và tên</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Nội dung</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                               @forelse($contacts as $key => $contact)
                                   <tr>
                                        <td class="text-center">{{ $key+1 }}</td>
                                        <td>{{ $contact->name }}</td>
                                        <td>{{ $contact->email }}</td>
                                        <td>{{ $contact->phone }}</td>
                                        <td>{{ $contact->content }}</td>
                                        <td>
                                            <button class="btn btn-danger delete" data-toggle="modal" data-target="#delete" data-id="{{ $contact->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                   </tr>
                               @empty
                                   <tr>
                                       <td colspan="6" class="text-center">Không có kết quả hiển thị</td>
                                   </tr>
                               @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{  $contacts->links()}}
                </div>
                <!-- /.col-md-10 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->


    {{-- MODAL DELETE --}}
    <div class="modal" id="delete" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Xoá Contact</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ asset('dashboard/contacts/delete') }}" method="post" id="formDelete">
                @csrf
                <div class="modal-body">
                    Bạn có muốn xoá contact này không ? Thao tác này không phục hồi
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ</button>
                    <button type="submit" class="btn btn-danger">Xoá</button>
                </div>
            </form>
          </div>
        </div>
    </div>
    

    {{-- MODAL MESSAGE --}}
    <div class="modal" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
     @if ($errors->any() || session()->has('success') )
        <script>
            $(document).ready(function(){
                $('#modal').modal({show: true});
            });
        
        </script>
    @endif 
    <script>
        $('.f ').addClass('menu-open');
        $('.f > .nav-link').addClass('active');
        $('.f .nav-treeview #contacts').addClass('active');
        
    

        $('.delete').click(function(){
            var id = $(this).data('id');
            $('#formDelete').attr('action', '{{ asset("dashboard/contacts/delete") }}/'+id);
        });
       

       

    </script>
@endsection
