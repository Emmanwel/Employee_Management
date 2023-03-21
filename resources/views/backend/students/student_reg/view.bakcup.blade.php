@extends('admin.admin_master')
@section('admin')
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->


            <!-- Main content -->
            <section class="content">
                <div class="row">

                    <div class="col-12">
                        <div class="box bb-3 border-warning">
                            <div class="box-header">
                                <h4 class="box-title">Student <strong>Search</strong></h4>
                            </div>
                            <div class="box-body">

                                <form method="GET" action="{{ route('student.year.class.search') }}">

                                    <div class="row">

                                        <div class="col-md-4">

                                            <div class="form-group">
                                                <h5>Year <span class="text-danger"> </span></h5>
                                                <div class="controls">
                                                    <select name="year_id" required="" class="form-control">
                                                        <option value="" selected="" disabled="">Select Year
                                                        </option>
                                                        @foreach ($years as $year)
                                                            <option value="{{ $year->id }}"
                                                                {{ @$year_id == $year->id ? 'selected' : '' }}>
                                                                {{ $year->name }}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>
                                        </div> <!-- End Col md 4 -->


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h5>Class <span class="text-danger"> </span></h5>
                                                <div class="controls">
                                                    <select name="class_id" required="" class="form-control">
                                                        <option value="" selected="" disabled="">
                                                            Select Class</option>
                                                        @foreach ($classes as $class)
                                                            <option value="{{ $class->id }}"
                                                                {{ @$class_id == $class->id ? 'selected' : '' }}>
                                                                {{ $class->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                        </div> <!-- End Col md 4 -->


                                        <div class="col-md-4" style="padding-top: 25px;">
                                            <input type="submit" class="btn btn-rounded btn-dark mb-5" name="search"
                                                value="Search">
                                        </div> <!-- End Col md 4 -->
                                    </div><!--  end row -->
                                </form>


                            </div>
                        </div>
                    </div> <!-- // end first col 12 -->



                    <div class="col-12">

                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Student Group List</h3>
                                <a href="{{ route('student.registration.add') }}" style="float: right;"
                                    class="btn btn-rounded btn-success mb-5"> Register Student </a>

                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="table-responsive">

                                    {{-- if is not search display all oif the fileds  --}}

                                    @if (!@search)
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th width="5%">SL</th>
                                                    <th>Name</th>
                                                    <th>ID No</th>
                                                    <th>Gender</th>
                                                    <th>Role</th>
                                                    <th>Year</th>
                                                    <th>Grade</th>
                                                    <th>Image</th>
                                                    @if (Auth::user()->role == 'Admin')
                                                        <th>PassCode</th>
                                                        <th width="25%">Action</th>
                                                    @endif

                                                </tr>
                                            </thead>
                                            <tbody>

                                                {{-- Create table relationship from the model where student_id should match with the users table class_id should fetch details from the class table.
                                            Create relationship from the Model Registers   --}}
                                                @foreach ($allData as $key => $value)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td> {{ $value['student']['name'] }}</td>
                                                        <td> {{ $value['student']['id_no'] }}</td>
                                                        <td> {{ $value['student']['gender'] }}</td>
                                                        <td> {{ $value->roll }}</td>
                                                        <td> {{ $value['student_year']['name'] }}</td>
                                                        <td> {{ $value['student_class']['name'] }}</td>
                                                        <td>
                                                            <img class="rounded-circle"
                                                                src="{{ !empty($value['student']['image']) ? url('upload/student_images/' . $value['student']['image']) : url('upload/no_image.jpg') }} "
                                                                alt="User Avatar">
                                                        </td>

                                                        <td> {{ $value['student']['code'] }}</td>

                                                        <td>
                                                            <a href="" class="btn btn-info">Edit</a>
                                                            <a href="" class="btn btn-danger"
                                                                id="delete">Delete</a>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                            <tfoot>

                                            </tfoot>
                                        </table>
                                    @else
                                        {{-- display the fields as per to the search parameter --}}

                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th width="5%">SL</th>
                                                    <th>Name</th>
                                                    <th>ID No</th>
                                                    <th>Gender</th>
                                                    <th>Role</th>
                                                    <th>Year</th>
                                                    <th>Grade</th>
                                                    <th>Image</th>
                                                    @if (Auth::user()->role == 'Admin')
                                                        <th>PassCode</th>
                                                        <th width="25%">Action</th>
                                                    @endif

                                                </tr>
                                            </thead>
                                            <tbody>

                                                {{-- Create table relationship from the model where student_id should match with the users table class_id should fetch details from the class table.
                                            Create relationship from the Model Registers   --}}
                                                @foreach ($allData as $key => $value)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td> {{ $value['student']['name'] }}</td>
                                                        <td> {{ $value['student']['id_no'] }}</td>
                                                        <td> {{ $value['student']['gender'] }}</td>
                                                        <td> {{ $value->roll }}</td>
                                                        <td> {{ $value['student_year']['name'] }}</td>
                                                        <td> {{ $value['student_class']['name'] }}</td>
                                                        <td>
                                                            <img class="rounded-circle"
                                                                src="{{ !empty($value['student']['image']) ? url('upload/student_images/' . $value['student']['image']) : url('upload/no_image.jpg') }} "
                                                                alt="User Avatar">
                                                        </td>

                                                        <td> {{ $value['student']['code'] }}</td>

                                                        <td>
                                                            <a href="" class="btn btn-info">Edit</a>
                                                            <a href="" class="btn btn-danger"
                                                                id="delete">Delete</a>
                                                        </td>

                                                    </tr>
                                                @endforeach

                                            </tbody>
                                            <tfoot>

                                            </tfoot>
                                        </table>
                                    @endif

                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div> <!-- /.box -->

                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
        </div>
    </div>
@endsection
