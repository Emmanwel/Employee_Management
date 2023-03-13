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
                                <h3 class="box-title"> Fee Amount Details</h3>
                                <a href="{{ route('fee.amount.add') }}" style="float: right;"
                                    class="btn btn-rounded btn-success mb-5"> Add Fee Amount</a>

                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">

                                <h3 style="color:rgb(238, 146, 174); text-align: center;"><strong>Fee Category : </strong>{{ $detailsData['0']['fee_category']['name'] }} </h3>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="5%">SL</th>
                                                <th>Class Name</th>
                                                <th width="25%">Amount</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($detailsData as $key => $detail)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    {{-- joined student class table with fee category amount table in the Model using one to many relationship--}}
                                                    <td> {{ $detail['student_class']['name'] }}</td>
                                                    <td> {{ $detail->amount }}</td>

                                                </tr>
                                            @endforeach

                                        </tbody>
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

        </div>
    </div>
@endsection
