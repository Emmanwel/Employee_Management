@extends('admin.admin_master')
@section('admin')
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->

            <!-- Main content -->
            <section class="content">
                <div class="row">

                    <div class="col-12">

                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">You have (count) Fee Categories</h3>


                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="5%">SL</th>
                                                <th>Fee Type </th>
                                                <th>Amount </th>


                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($feeCategoryAmounts as $key => $feeCategoryAmount)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td> {{ $feeCategoryAmount->feeCategory->name }}</td>
                                                    <td>{{ $feeCategoryAmount->amount }}</td>

                                                </tr>
                                            @endforeach


                                        </tbody>

                                    </table>
                                    <h1 class="text-center">
                                           Total
                                        <a href="{{ route('pay.fees') }}">{{ $totalAmount }}
                                        </a>

                                    </h1>


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

        </div>
    </div>
@endsection
