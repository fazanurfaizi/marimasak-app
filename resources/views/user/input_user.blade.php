<!DOCTYPE html>
    <html lang="en">

    <head>
    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Marimasak</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css')}}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Tempusdominus Bootstrap 4 -->
        <link rel="stylesheet" href=" {{ asset('lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
        <!-- iCheck -->
        <link rel="stylesheet" href=" {{ asset('lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
        <!-- JQVMap -->
        <link rel="stylesheet" href=" {{ asset('lte/plugins/jqvmap/jqvmap.min.css')}}">
        <!-- Theme style -->
        <link rel="stylesheet" href=" {{ asset('lte/dist/css/adminlte.min.css')}}">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href=" {{ asset('lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
        <!-- Daterange picker -->
        <link rel="stylesheet" href=" {{ asset('lte/plugins/daterangepicker/daterangepicker.css')}}">
        <!-- summernote -->
        <link rel="stylesheet" href=" {{ asset('lte/plugins/summernote/summernote-bs4.min.css')}}">
    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">


        <!-- Navbar -->
        @include('./component/header')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('./component/sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    <h1 class="m-0">Tambah User</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">TambahUser</li>
                    </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-10">
                        <form>
                            <div class="card-body">
                            <div class="form-group">
                                <label for="nameuser">Nama </label>
                                <input type="text" class="form-control" id="nameuser" placeholder="Nama User">
                            </div>
                            <div class="form-group">
                                <label for="emailuser">Email </label>
                                <input type="text" class="form-control" id="emailuser" placeholder="Email User">
                            </div>
                            <div class="row">
                                <div class="col-6">
                                <div class="form-group">
                                    <label for="phonenumber">No Handphone </label>
                                    <input type="text" class="form-control" id="phonenumber" placeholder="No Handphone User">
                                </div>
                            </div>
                            <div class="col-6">
                                <!-- select -->
                                <div class="form-group">
                                    <label>Role User</label>
                                    <select class="form-control">
                                    <option>option 1</option>
                                    <option>option 2</option>
                                    <option>option 3</option>
                                    <option>option 4</option>
                                    <option>option 5</option>
                                    </select>
                                </div>
                            </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="permissionuser">Permission </label>
                                <p>
                                    <button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#collapsePermission" aria-expanded="false" aria-controls="collapseExample">
                                    Set Permission
                                    </button>
                                </p>
                                <div class="collapse" id="collapsePermission">
                                <div class="card card-body p-0 ">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                            <th style="width: 30%">Permission</th>
                                            <th>Admin</th>
                                            <th>Sales</th>
                                            <th>Maintenance</th>
                                            <th>Accounting</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>View  User</td>
                                                <td>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary pl-3">
                                                            <input type="checkbox" id="checkboxViewUser1" >
                                                            <label for="checkboxViewUser1">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary pl-3">
                                                            <input type="checkbox" id="checkboxViewUser2" >
                                                            <label for="checkboxViewUser2">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary pl-3">
                                                            <input type="checkbox" id="checkboxViewUser3" >
                                                            <label for="checkboxViewUser3">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary pl-3">
                                                            <input type="checkbox" id="checkboxViewUser4" >
                                                            <label for="checkboxViewUser4">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>                                       
                                            </tr>
                                            <tr>
                                                <td>Create User</td>
                                                <td>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary pl-3">
                                                            <input type="checkbox" id="checkboxCreateUser1" >
                                                            <label for="checkboxCreateUser1">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary pl-3">
                                                        <input type="checkbox" id="checkboxCreateUser2" >
                                                            <label for="checkboxCreateUser2">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary pl-3">
                                                            <input type="checkbox" id="checkboxCreateUser3" >
                                                            <label for="checkboxCreateUser3">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary pl-3">
                                                            <input type="checkbox" id="checkboxCreateUser4" >
                                                            <label for="checkboxCreateUser4">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                            
                                            </tr>
                                            <tr>
                                                <td>Remove Users</td>
                                                <td>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary pl-3">
                                                            <input type="checkbox" id="checkboxRemoveUser1" >
                                                            <label for="checkboxRemoveUser1">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary pl-3">
                                                            <input type="checkbox" id="checkboxRemoveUser2" >
                                                            <label for="checkboxRemoveUser2">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary pl-3">
                                                            <input type="checkbox" id="checkboxRemoveUser3" >
                                                            <label for="checkboxRemoveUser3">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary pl-3">
                                                            <input type="checkbox" id="checkboxRemoveUser4" >
                                                            <label for="checkboxRemoveUser4">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                                
                                            </tr>
                                            <tr>
                                                <td>Modify Users</td>
                                                <td>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary pl-3">
                                                            <input type="checkbox" id="checkboxModifyUser1" >
                                                            <label for="checkboxModifyUser1">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary pl-3">
                                                            <input type="checkbox" id="checkboxModifyUser2" >
                                                            <label for="checkboxModifyUser2">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary pl-3">
                                                            <input type="checkbox" id="checkboxModifyUser3" >
                                                            <label for="checkboxModifyUser3">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary pl-3">
                                                            <input type="checkbox" id="checkboxModifyUser4" >
                                                            <label for="checkboxModifyUser4">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                                
                                            </tr>
                                            <tr>
                                                <td>Assign Users To Rules</td>
                                                <td>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary pl-3">
                                                            <input type="checkbox" id="checkboxAssignUser1" >
                                                            <label for="checkboxAssignUser1">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary pl-3">
                                                            <input type="checkbox" id="checkboxAssignUser2" >
                                                            <label for="checkboxAssignUser2">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary pl-3">
                                                            <input type="checkbox" id="checkboxAssignUser3" >
                                                            <label for="checkboxAssignUser3">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary pl-3">
                                                            <input type="checkbox" id="checkboxAssignUser4" >
                                                            <label for="checkboxAssignUser4">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                            
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                                
                            </div>
                            
                            </div>
                            <!-- /.card-body -->

                            <div class="card-body ">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                        </div>
                        
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        
        @include('./component/footer')
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->


    </html>
