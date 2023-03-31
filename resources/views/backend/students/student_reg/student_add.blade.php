@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    {{-- <script src="jquery.js"></script>
    <script src="jquery-ui.js"></script> --}}


    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->

            <section class="content">

                <!-- Basic Forms -->
                <div class="box">
                    <div class="box-header with-border">
                        <h4 class="box-title">Add Student </h4>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col">

                                <form method="post" action="{{ route('store.student.registration') }}"
                                    enctype="multipart/form-data">

                                    @csrf

                                    <div class="row">
                                        <div class="col-12">

                                            <div class="row">
                                                <!-- 1st Row -->

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <h5>Students Name <span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <input type="text" name="name" class="form-control"
                                                                required="">
                                                        </div>
                                                    </div>
                                                </div> <!-- End Col md 4 -->

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <h5>Father's Name </span></h5>
                                                        <div class="controls">
                                                            <input type="text" name="fname" class="form-control"
                                                                ">
                                                        </div>
                                                    </div>

                                                </div> <!-- End Col md 4 -->

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <h5>Mother's Name </h5>
                                                        <div class="controls">
                                                            <input type="text" name="lname" class="form-control"
                                                               >
                                                        </div>
                                                    </div>
                                                </div> <!-- End Col md 4 -->

                                            </div> <!-- End 1stRow -->


                                            <div class="row">
                                                <!-- 2nd Row -->

                                                <div class="col-md-4">

                                                    <div class="form-group">
                                                        <h5>Mobile Number <span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <input type="text" name="mobile" class="form-control"
                                                                required="">
                                                        </div>
                                                    </div>

                                                </div> <!-- End Col md 4 -->


                                                <div class="col-md-4">

                                                    <div class="form-group">
                                                        <h5>Address </h5>
                                                        <div class="controls">
                                                            <input type="text" name="address" class="form-control"
                                                                >
                                                        </div>
                                                    </div>

                                                </div> <!-- End Col md 4 -->

                                                <div class="col-md-4">

                                                    <div class="form-group">
                                                        <h5>Gender <span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <select name="gender" id="gender" required=""
                                                                class="form-control">
                                                                <option value="" selected="" disabled="">Select
                                                                    Gender</option>
                                                                <option value="Male">Male</option>
                                                                <option value="Female">Female</option>
                                                                <option value="Others">Prefer Not To Say</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div> <!-- End Col md 4 -->
                                            </div> <!-- End 2nd Row -->

                                            <div class="row">

                                                <!-- 3rd Row -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <h5>Religion <span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <select name="religion" id="religion" required=""
                                                                class="form-control">
                                                                <option value="" selected="" disabled="">Select
                                                                    Religion</option>
                                                                <option value="Christian">Christian </option>
                                                                <option value="Pagan">Pagan</option>
                                                                <option value="Muslim">Muslim</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div> <!-- End Col md 4 -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <h5>Date of Birth <span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <input type="text" id="dob" class="form-control" value="" 
                                                                required="">
                                                        </div>
                                                    </div>
                                                </div> <!-- End Col md 4 -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <h5>Age </h5>
                                                        <div class="controls">
                                                            <input type="text" id="nokmobile" value="nokmobile"  class="form-control "
                                                                readonly>
                                                        </div>
                                                    </div>
                                                </div> <!-- End Col md 4 -->


                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <h5>Discount </span></h5>
                                                        <div class="controls">
                                                            <input type="text" name="discount" class="form-control">
                                                        </div>
                                                    </div>
                                                </div> <!-- End Col md 4 -->
                                            </div> <!-- End 3rd Row -->

                                            <div class="row">
                                                <!-- 4TH Row -->
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <h5>Year <span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <select name="year_id" required="" class="form-control">
                                                                <option value="" selected="" disabled="">
                                                                    Select Year</option>
                                                                @foreach ($years as $year)
                                                                    <option value="{{ $year->id }}">{{ $year->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div> <!-- End Col md 4 -->

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <h5>Class <span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <select name="class_id" required="" class="form-control">
                                                                <option value="" selected="" disabled="">
                                                                    Select Class</option>
                                                                @foreach ($classes as $class)
                                                                    <option value="{{ $class->id }}">{{ $class->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div> <!-- End Col md 4 -->

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <h5>Group <span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <select name="group_id" required="" class="form-control">
                                                                <option value="" selected="" disabled="">
                                                                    Select Group</option>
                                                                @foreach ($groups as $group)
                                                                    <option value="{{ $group->id }}">{{ $group->name }}
                                                                    </option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div> <!-- End Col md 4 -->
                                            </div> <!-- End 4TH Row -->

                                            <div class="row">
                                                <!-- 5TH Row -->
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <h5>Shift <span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <select name="shift_id" required="" class="form-control">
                                                                <option value="" selected="" disabled="">
                                                                    Select Shift</option>
                                                                @foreach ($shifts as $shift)
                                                                    <option value="{{ $shift->id }}">{{ $shift->name }}
                                                                    </option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div> <!-- End Col md 4 -->


                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <h5>Profile Image <span class="text-danger">*</span></h5>
                                                        <div class="controls">
                                                            <input type="file" name="image" class="form-control"
                                                                id="image">
                                                        </div>
                                                    </div>
                                                </div> <!-- End Col md 4 -->


                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <div class="controls">
                                                            <img id="showImage" src="{{ url('upload/no_image.jpg') }}"
                                                                style="width: 100px; width: 100px; border: 3px solid #360404;">
                                                        </div>
                                                    </div>
                                                </div> <!-- End Col md 4 -->
                                            </div> <!-- End 5TH Row -->

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
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });

            var nokmobile = "";
            $('#dob').datepicker({
                onSelect: function(value, ui) {
                    var today = new Date();
                    nokmobile = today.getFullYear() - ui.selectedYear;
                    $('#nokmobile').val(nokmobile);
                },
                changeMonth: true,
                changeYear: true,
                yearRange: "1960 : 2030",
                maxDate: "-6y",
                minDate: "-50y"
            });

        });
    </script>
@endsection
