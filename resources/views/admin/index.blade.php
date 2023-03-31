@extends('admin.admin_master')
@section('admin')


    <div class="content-wrapper">
        <div class="container-full">



            <h1>Dashboard content</h1>
            <!-- Main content -->
            <section class="content">
                <div class="row">

                    <div class="col-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Employee Salary List</h3>
                                <a href="{{ route('employee.registration.add') }}" style="float: right;"
                                    class="btn btn-rounded btn-success mb-5"> Add Employee Salary</a>

                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="5%">SL</th>
                                                <th>Name</th>
                                                <th>ID NO</th>
                                                <th>Mobile</th>
                                                <th>Gender</th>
                                                <th>Join Date</th>
                                                <th>Salary</th>

                                                <th width="20%">Action</th>

                                            </tr>
                                        </thead>

                                        <tfoot>

                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->


                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->

            <form method="POST" action="{{ route('deposit') }}">
                @csrf
                <h5 class="text-center mb-3">Make A Deposit</h5>
                <div class="row mb-3">
                    <label for="amount" class="col-md-4 col-form-label text-md-end">{{ __('Amount') }}</label>
                    <div class="col-md-6">
                        <input id="amount" type="number"
                            class="form-control @error('amount') is-invalid
            @enderror" name="amount"
                            value="{{ old('amount') }}" required autocomplete="amount" autofocus>
                        @error('amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Deposit') }}
                        </button>
                    </div>
                </div>
            </form>

            <!-- Main content -->
            {{-- <section class="content">
                <div class="row">
                    <div class="col-xl-3 col-6">
                        <div class="box overflow-hidden pull-up">
                            <div class="box-body">
                                <div class="icon bg-primary-light rounded w-60 h-60">
                                    <i class="text-primary mr-0 font-size-24 mdi mdi-account-multiple"></i>
                                </div>
                                <div>
                                    <p class="text-mute mt-20 mb-0 font-size-16">New Customers</p>
                                    <h3 class="text-white mb-0 font-weight-500">3400 <small class="text-success"><i
                                                class="fa fa-caret-up"></i> +2.5%</small></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-6">
                        <div class="box overflow-hidden pull-up">
                            <div class="box-body">
                                <div class="icon bg-warning-light rounded w-60 h-60">
                                    <i class="text-warning mr-0 font-size-24 mdi mdi-car"></i>
                                </div>
                                <div>
                                    <p class="text-mute mt-20 mb-0 font-size-16">Sold Cars</p>
                                    <h3 class="text-white mb-0 font-weight-500">3400 <small class="text-success"><i
                                                class="fa fa-caret-up"></i> +2.5%</small></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-6">
                        <div class="box overflow-hidden pull-up">
                            <div class="box-body">
                                <div class="icon bg-info-light rounded w-60 h-60">
                                    <i class="text-info mr-0 font-size-24 mdi mdi-sale"></i>
                                </div>
                                <div>
                                    <p class="text-mute mt-20 mb-0 font-size-16">Sales Lost</p>
                                    <h3 class="text-white mb-0 font-weight-500">$1,250 <small class="text-danger"><i
                                                class="fa fa-caret-down"></i> -0.5%</small></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-6">
                        <div class="box overflow-hidden pull-up">
                            <div class="box-body">
                                <div class="icon bg-danger-light rounded w-60 h-60">
                                    <i class="text-danger mr-0 font-size-24 mdi mdi-phone-incoming"></i>
                                </div>
                                <div>
                                    <p class="text-mute mt-20 mb-0 font-size-16">Inbound Call</p>
                                    <h3 class="text-white mb-0 font-weight-500">1,460 <small class="text-danger"><i
                                                class="fa fa-caret-up"></i> -1.5%</small></h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="box">
                            <div class="box-header">
                                <h4 class="box-title align-items-start flex-column">
                                    New Arrivals
                                    <small class="subtitle">More than 400+ new members</small>
                                </h4>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table no-border">
                                        <thead>
                                            <tr class="text-uppercase bg-lightest">
                                                <th style="min-width: 250px"><span class="text-white">products</span></th>
                                                <th style="min-width: 100px"><span class="text-fade">pruce</span></th>
                                                <th style="min-width: 100px"><span class="text-fade">deposit</span></th>
                                                <th style="min-width: 150px"><span class="text-fade">agent</span></th>
                                                <th style="min-width: 130px"><span class="text-fade">status</span></th>
                                                <th style="min-width: 120px"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="pl-0 py-8">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 mr-20">
                                                            <div class="bg-img h-50 w-50"
                                                                style="background-image: url(../images/gallery/creative/img-1.jpg)">
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <a href="#"
                                                                class="text-white font-weight-600 hover-primary mb-1 font-size-16">Vivamus
                                                                consectetur</a>
                                                            <span class="text-fade d-block">Pharetra, Nulla , Nec,
                                                                Aliquet</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-fade font-weight-600 d-block font-size-16">
                                                        Paid
                                                    </span>
                                                    <span class="text-white font-weight-600 d-block font-size-16">
                                                        $45,800k
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-fade font-weight-600 d-block font-size-16">
                                                        Paid
                                                    </span>
                                                    <span class="text-white font-weight-600 d-block font-size-16">
                                                        $45k
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-fade font-weight-600 d-block font-size-16">
                                                        Sophia
                                                    </span>
                                                    <span class="text-white font-weight-600 d-block font-size-16">
                                                        Pharetra
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-primary-light badge-lg">Approved</span>
                                                </td>
                                                <td class="text-right">
                                                    <a href="#"
                                                        class="waves-effect waves-light btn btn-info btn-circle mx-5"><span
                                                            class="mdi mdi-bookmark-plus"></span></a>
                                                    <a href="#"
                                                        class="waves-effect waves-light btn btn-info btn-circle mx-5"><span
                                                            class="mdi mdi-arrow-right"></span></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="pl-0 py-8">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 mr-20">
                                                            <div class="bg-img h-50 w-50"
                                                                style="background-image: url(../images/gallery/creative/img-2.jpg)">
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <a href="#"
                                                                class="text-white font-weight-600 hover-primary mb-1 font-size-16">Vivamus
                                                                consectetur</a>
                                                            <span class="text-fade d-block">Pharetra, Nulla , Nec,
                                                                Aliquet</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-fade font-weight-600 d-block font-size-16">
                                                        Paid
                                                    </span>
                                                    <span class="text-white font-weight-600 d-block font-size-16">
                                                        $45,800k
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-fade font-weight-600 d-block font-size-16">
                                                        Paid
                                                    </span>
                                                    <span class="text-white font-weight-600 d-block font-size-16">
                                                        $45k
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-fade font-weight-600 d-block font-size-16">
                                                        Sophia
                                                    </span>
                                                    <span class="text-white font-weight-600 d-block font-size-16">
                                                        Pharetra
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-warning-light badge-lg">In Progress</span>
                                                </td>
                                                <td class="text-right">
                                                    <a href="#"
                                                        class="waves-effect waves-light btn btn-info btn-circle mx-5"><span
                                                            class="mdi mdi-bookmark-plus"></span></a>
                                                    <a href="#"
                                                        class="waves-effect waves-light btn btn-info btn-circle mx-5"><span
                                                            class="mdi mdi-arrow-right"></span></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="pl-0 py-8">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 mr-20">
                                                            <div class="bg-img h-50 w-50"
                                                                style="background-image: url(../images/gallery/creative/img-3.jpg)">
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <a href="#"
                                                                class="text-white font-weight-600 hover-primary mb-1 font-size-16">Vivamus
                                                                consectetur</a>
                                                            <span class="text-fade d-block">Pharetra, Nulla , Nec,
                                                                Aliquet</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-fade font-weight-600 d-block font-size-16">
                                                        Paid
                                                    </span>
                                                    <span class="text-white font-weight-600 d-block font-size-16">
                                                        $45,800k
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-fade font-weight-600 d-block font-size-16">
                                                        Paid
                                                    </span>
                                                    <span class="text-white font-weight-600 d-block font-size-16">
                                                        $45k
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-fade font-weight-600 d-block font-size-16">
                                                        Sophia
                                                    </span>
                                                    <span class="text-white font-weight-600 d-block font-size-16">
                                                        Pharetra
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-success-light badge-lg">Success</span>
                                                </td>
                                                <td class="text-right">
                                                    <a href="#"
                                                        class="waves-effect waves-light btn btn-info btn-circle mx-5"><span
                                                            class="mdi mdi-bookmark-plus"></span></a>
                                                    <a href="#"
                                                        class="waves-effect waves-light btn btn-info btn-circle mx-5"><span
                                                            class="mdi mdi-arrow-right"></span></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="pl-0 py-8">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 mr-20">
                                                            <div class="bg-img h-50 w-50"
                                                                style="background-image: url(../images/gallery/creative/img-4.jpg)">
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <a href="#"
                                                                class="text-white font-weight-600 hover-primary mb-1 font-size-16">Vivamus
                                                                consectetur</a>
                                                            <span class="text-fade d-block">Pharetra, Nulla , Nec,
                                                                Aliquet</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-fade font-weight-600 d-block font-size-16">
                                                        Paid
                                                    </span>
                                                    <span class="text-white font-weight-600 d-block font-size-16">
                                                        $45,800k
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-fade font-weight-600 d-block font-size-16">
                                                        Paid
                                                    </span>
                                                    <span class="text-white font-weight-600 d-block font-size-16">
                                                        $45k
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-fade font-weight-600 d-block font-size-16">
                                                        Sophia
                                                    </span>
                                                    <span class="text-white font-weight-600 d-block font-size-16">
                                                        Pharetra
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-danger-light badge-lg">Rejected</span>
                                                </td>
                                                <td class="text-right">
                                                    <a href="#"
                                                        class="waves-effect waves-light btn btn-info btn-circle mx-5"><span
                                                            class="mdi mdi-bookmark-plus"></span></a>
                                                    <a href="#"
                                                        class="waves-effect waves-light btn btn-info btn-circle mx-5"><span
                                                            class="mdi mdi-arrow-right"></span></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="pl-0 py-8">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 mr-20">
                                                            <div class="bg-img h-50 w-50"
                                                                style="background-image: url(../images/gallery/creative/img-5.jpg)">
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <a href="#"
                                                                class="text-white font-weight-600 hover-primary mb-1 font-size-16">Vivamus
                                                                consectetur</a>
                                                            <span class="text-fade d-block">Pharetra, Nulla , Nec,
                                                                Aliquet</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-fade font-weight-600 d-block font-size-16">
                                                        Paid
                                                    </span>
                                                    <span class="text-white font-weight-600 d-block font-size-16">
                                                        $45,800k
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-fade font-weight-600 d-block font-size-16">
                                                        Paid
                                                    </span>
                                                    <span class="text-white font-weight-600 d-block font-size-16">
                                                        $45k
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-fade font-weight-600 d-block font-size-16">
                                                        Sophia
                                                    </span>
                                                    <span class="text-white font-weight-600 d-block font-size-16">
                                                        Pharetra
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-warning-light badge-lg">In Progress</span>
                                                </td>
                                                <td class="text-right">
                                                    <a href="#"
                                                        class="waves-effect waves-light btn btn-info btn-circle mx-5"><span
                                                            class="mdi mdi-bookmark-plus"></span></a>
                                                    <a href="#"
                                                        class="waves-effect waves-light btn btn-info btn-circle mx-5"><span
                                                            class="mdi mdi-arrow-right"></span></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content --> --}}
        </div>
    </div>
@endsection
