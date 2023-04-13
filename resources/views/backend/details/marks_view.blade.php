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
                                <h3 class="box-title">Your Subjects</h3>


                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="5%">SL</th>
                                                <th>Admin No.</th>
                                                <th>Exam Type </th>
                                                <th>Marks </th>


                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($studentMarks as $key => $studentMark)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $studentMark->id_no }}</td>
                                                    <td> {{ $studentMark->assignSubject->subject->name }}</td>
                                                    <td> {{ $studentMark->marks }}</td>
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
