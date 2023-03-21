@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->


            <section class="content">

                <!-- Basic Forms -->
                <div class="box">
                    <div class="box-header with-border">
                        <h4 class="box-title">Employee Leave</h4>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col">

                                <form method="post" action="{{ route('store.employee.leave') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">

                                            <div class="row">
                                                <div class="col-md-4">

                                                    <div class="form-group">
                                                        <h5>Employee Name <span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <select name="employee_id" required="" class="form-control">
                                                                <option value="" selected="" disabled="">Select
                                                                    Employee Name</option>

                                                                @foreach ($employees as $employee)
                                                                    <option value="{{ $employee->id }}">
                                                                        {{ $employee->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>


                                                </div> <!-- // end col md-6 -->



                                                {{-- <div class="col-md-4">

                                                    <div class="form-group">
                                                        <h5>Leave Type <span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <select name="leave_purpose_id" id="leave_purpose_id"
                                                                required="" class="form-control">
                                                                <option value="" selected="" disabled="">Select
                                                                    Employee Leave Type</option>

                                                                @foreach ($leave_type as $type)
                                                                    <option value="{{ $type->id }}">{{ $type->name }}
                                                                    </option>
                                                                @endforeach
                                                               
                                                            </select>

                                                        </div>
                                                    </div>


                                                </div> <!-- // end col md-6 --> --}}

                                                <div class="col-md-4">

                                                    <div class="form-group">
                                                        <h5>Leave Purpose <span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <select name="leave_purpose_id" id="leave_purpose_id"
                                                                required="" class="form-control">
                                                                <option value="" selected="" disabled="">Select
                                                                    Employee Purpose</option>

                                                                @foreach ($leave_purpose as $leave)
                                                                    <option value="{{ $leave->id }}">{{ $leave->name }}
                                                                    </option>
                                                                @endforeach
                                                                <button>
                                                                    <option value="0">New Purpose</option>
                                                                </button>
                                                            </select>
                                                            <input type="text" name="name" id="add_another"
                                                                class="form-control" placeholder="Write Purpose"
                                                                style="background-color:rgb(11, 4, 56); display:none;">
                                                        </div>
                                                    </div>


                                                </div> <!-- // end col md-6 -->

                                                <div class="col-md-4">

                                                    <div class="form-group">
                                                        <h5>Start Date <span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <input type="date" name="start_date" class="form-control">
                                                        </div>

                                                    </div>


                                                </div> <!-- // end col md-6 -->

                                                <div class="col-md-4">

                                                    <div class="form-group">
                                                        <h5>End Dates <span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <input type="date" name="end_date" class="form-control">
                                                        </div>

                                                    </div>

                                                </div> <!-- // end col md-6 -->

                                                <div class="col-md-4">

                                                    <div class="form-group">
                                                        <h5>Number of Days <span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <input type="number" name="number_of_days"
                                                                class="form-control">
                                                        </div>

                                                    </div>


                                                </div> <!-- // end col md-6 -->


                                                <div class="col-md-5">

                                                    <div class="form-group">
                                                        <h5>Leave Status <span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <input type="text" placeholder="Active" name="status"
                                                                class="form-control">

                                                        </div>
                                                    </div>


                                                </div> <!-- // end col md-6 -->

                                                <div class="col-md-4">

                                                    <div class="form-group">
                                                        <h5>Attachments <span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <input type="file" name="attachment" class="form-control"
                                                                id="attachment">
                                                        </div>
                                                    </div>


                                                </div> <!-- End Col md 3 -->


                                                <div class="col-md-3">

                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <img id="showImage" src="{{ url('upload/no_image.jpg') }}"
                                                                style="width: 100px; width: 100px; border: 1px solid #000000;">

                                                        </div>
                                                    </div>

                                                </div> <!-- End Col md 3 -->


                                            </div> <!-- // end row -->



                                            <div class="text-xs-right">
                                                <input type="submit" class="btn btn-rounded btn-info mb-5"
                                                    value="Submit">
                                            </div>
                                </form>

                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

            </section>





        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('change', '#leave_purpose_id', function() {
                var leave_purpose_id = $(this).val();
                if (leave_purpose_id == '0') {
                    $('#add_another').show();
                } else {
                    $('#add_another').hide();
                }
            });
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });

        });


       
    </script>
@endsection
