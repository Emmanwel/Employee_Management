 {{-- Admin and User Priviledges modules in the sidebar to be accessed by Users and Admin (Roles)  --}}

 @php
     $prefix = Request::route()->getPrefix();
     $route = Route::current()->getName();

 @endphp


 <aside class="main-sidebar">
     <!-- sidebar-->
     <section class="sidebar">

         <div class="user-profile">
             <div class="ulogo">
                 <a href="/">
                     <!-- logo for regular state and mobile devices -->
                     <div class="d-flex align-items-center justify-content-center">
                         <img src="{{ asset('backend/images/logo-dark.png') }}" alt="">
                         <h3><b>ES </b> Mukhebi</h3>
                     </div>
                 </a>
             </div>
         </div>

         <!-- sidebar menu-->
         <ul class="sidebar-menu" data-widget="tree">
             <li class="{{ $route == 'dashboard' ? 'active' : '' }}">
                 <a href="{{ route('dashboard') }}">
                     <i data-feather="pie-chart"></i>
                     <span>Dashboard</span>
                 </a>
             </li>

             @if (Auth::user()->role == 'Admin')
                 {{-- fetch only the users from the users web route to be active and display it as active --}}
                 <li class="treeview {{ $prefix == '/users' ? 'active' : '' }}">

                     <a href="">
                         <i data-feather="message-circle"></i>
                         <span>Manage User</span>
                         <span class="pull-right-container">
                             <i class="fa fa-angle-right pull-right"></i>
                         </span>
                     </a>
                     <ul class="treeview-menu">
                         <li><a href="{{ route('users.view') }}"><i class="ti-more"></i>View User</a></li>
                         <li><a href="{{ route('users.add') }}"><i class="ti-more"></i>Add User</a></li>

                     </ul>
                 </li>
             @endif

             {{-- When the prefix is as /profile display it as being active --}}

             <li class="treeview {{ $prefix == '/profile' ? 'active' : '' }}">
                 <a href="#">
                     <i data-feather="grid"></i> <span>Manage Profile</span>
                     <span class="pull-right-container">
                         <i class="fa fa-angle-right pull-right"></i>
                     </span>
                 </a>
                 <ul class="treeview-menu">
                     <li><a href="{{ route('profile.view') }}"><i class="ti-more"></i>Your Profile</a></li>
                     <li><a href="{{ route('password.view') }}"><i class="ti-more"></i>Change Password</a></li>


                 </ul>
             </li>
             <li class="treeview {{ $prefix == '/setups' ? 'active' : '' }}">
                 <a href="#">
                     <i data-feather="credit-card"></i> <span>Setup Management</span>
                     <span class="pull-right-container">
                         <i class="fa fa-angle-right pull-right"></i>
                     </span>
                 </a>
                 <ul class="treeview-menu">
                     <li class="{{ $route == 'student.class.view' ? 'active' : '' }}"><a href="{{ route('student.class.view') }}"><i class="ti-more"></i>Student Grade</a></li>
                     <li class="{{ $route == 'student.year.view' ? 'active' : '' }}"><a href="{{ route('student.year.view') }}"><i class="ti-more"></i>Student Year</a></li>
                     <li class="{{ $route == 'student.group.view' ? 'active' : '' }}"><a href="{{ route('student.group.view') }}"><i class="ti-more"></i>Student Group</a></li>
                     <li class="{{ $route == 'student.shift.view' ? 'active' : '' }}"><a href="{{ route('student.shift.view') }}"><i class="ti-more"></i>Student Shift</a></li>
                     <li class="{{ $route == 'fee.category.view' ? 'active' : '' }}"><a href="{{ route('fee.category.view') }}"><i class="ti-more"></i>Fee Category</a></li>
                     <li class="{{ $route == 'fee.amount.view' ? 'active' : '' }}"><a href="{{ route('fee.amount.view') }}"><i class="ti-more"></i>Fee Category Amount</a></li>
                     <li class="{{ $route == 'exam.type.view' ? 'active' : '' }}"><a href="{{ route('exam.type.view') }}"><i class="ti-more"></i>Examp Type</a></li>
                     <li class="{{ $route == 'school.subject.view' ? 'active' : '' }}"><a href="{{ route('school.subject.view') }}"><i class="ti-more"></i>School Subjects</a></li>
                     <li class="{{ $route == 'assign.subject.view' ? 'active' : '' }}"><a href="{{ route('assign.subject.view') }}"><i class="ti-more"></i>Assign Subject Marks </a></li>
                     <li class="{{ $route == 'designation.view' ? 'active' : '' }}"><a href="{{ route('designation.view') }}"><i class="ti-more"></i>Designation </a></li>
                     <li class="{{ $route == 'leave.type.view' ? 'active' : '' }}"><a href="{{ route('leave.type.view') }}"><i class="ti-more"></i>Leave Type </a></li>

                 </ul>
             </li>


             <li class="treeview {{ $prefix == '/students' ? 'active' : '' }}">

                 <a href="#">
                     <i data-feather="hard-drive"></i></i> <span>Student Management</span>
                     <span class="pull-right-container">
                         <i class="fa fa-angle-right pull-right"></i>
                     </span>
                 </a>
                 <ul class="treeview-menu">
                     <li class="{{ $route == 'student.registration.view' ? 'active' : '' }}"><a
                             href="{{ route('student.registration.view') }}"><i class="ti-more"></i>Student
                             Registration</a></li>

                     <li class="{{ $route == 'view.generated.roll' ? 'active' : '' }}"><a
                             href="{{ route('view.generated.roll') }}"><i class="ti-more"></i>Genarate Roll Call</a>
                     </li>
                     <li class="{{ $route == 'registration.fee.view' ? 'active' : '' }}"><a
                             href="{{ route('registration.fee.view') }}"><i class="ti-more"></i>Registration Fee </a>

                     </li>
                     <li class="{{ $route == 'monthly.fee.view' ? 'active' : '' }}"><a
                             href="{{ route('monthly.fee.view') }}"><i class="ti-more"></i>Monthly Fee </a></li>

                     <li class="{{ $route == 'exam.fee.view' ? 'active' : '' }}"><a
                             href="{{ route('exam.fee.view') }}"><i class="ti-more"></i>Exam Fee </a></li>


                 </ul>
             </li>

               <li class="treeview {{ $prefix == '/marks' ? 'active' : '' }}">

                 <a href="#">
                     <i data-feather="edit-2"></i> <span> Marks Management</span>
                     <span class="pull-right-container">
                         <i class="fa fa-angle-right pull-right"></i>
                     </span>
                 </a>
                 <ul class="treeview-menu">
                     <li class="{{ $route == 'marks.entry.add' ? 'active' : '' }}"><a
                             href="{{ route('marks.entry.add') }}"><i class="ti-more"></i>Marks Entry</a></li>
                     <li class="{{ $route == 'marks.entry.edit' ? 'active' : '' }}"><a
                             href="{{ route('marks.entry.edit') }}"><i class="ti-more"></i>Marks Edit</a></li>
                     <li class="{{ $route == 'marks.entry.grade' ? 'active' : '' }}"><a
                             href="{{ route('marks.entry.grade') }}"><i class="ti-more"></i>Marks Grade</a></li>


                 </ul>
             </li>

                <li class="treeview {{ $prefix == '/fetch' ? 'active' : '' }}">

                 <a href="#">
                     <i data-feather="edit-2"></i> <span>Fetch Details</span>
                     <span class="pull-right-container">
                         <i class="fa fa-angle-right pull-right"></i>
                     </span>
                 </a>
                 <ul class="treeview-menu">
                     <li class="{{ $route == 'marks.view' ? 'active' : '' }}"><a
                             href="{{ route('marks.view') }}"><i class="ti-more"></i>Marks </a></li>
                     <li class="{{ $route == 'fees.view' ? 'active' : '' }}"><a
                             href="{{ route('fees.view') }}"><i class="ti-more"></i>Fee Details</a></li>



                 </ul>
             </li>


             <li class="treeview {{ $prefix == '/employees' ? 'active' : '' }}">

                 <a href="#">
                     <i data-feather="package"></i> <span>Employee Management</span>
                     <span class="pull-right-container">
                         <i class="fa fa-angle-right pull-right"></i>
                     </span>
                 </a>
                 <ul class="treeview-menu">
                     <li class="{{ $route == 'employee.registration.view' ? 'active' : '' }}"><a
                             href="{{ route('employee.registration.view') }}"><i class="ti-more"></i>Employee
                             Registration</a></li>

                     <li class="{{ $route == 'employee.salary.view' ? 'active' : '' }}"><a
                             href="{{ route('employee.salary.view') }}"><i class="ti-more"></i>Employee
                             Salary</a></li>
                     <li class="{{ $route == 'employee.leave.view' ? 'active' : '' }}"><a
                             href="{{ route('employee.leave.view') }}"><i class="ti-more"></i>Employee Leave</a></li>

                     <li class="{{ $route == 'employee.attendance.view' ? 'active' : '' }}"><a
                             href="{{ route('employee.attendance.view') }}"><i class="ti-more"></i>Employee
                             Attendance</a></li>

                     <li class="{{ $route == 'employee.monthly.view' ? 'active' : '' }}"><a
                             href="{{ route('employee.monthly.salary') }}"><i class="ti-more"></i>Employee Monthly
                             Salary</a></li>

                 </ul>
             </li>




             <li class="treeview {{ $prefix == '/accounts' ? 'active' : '' }}">

                 <a href="#">
                     <i data-feather="inbox"></i> <span> Accounts Management</span>
                     <span class="pull-right-container">
                         <i class="fa fa-angle-right pull-right"></i>
                     </span>
                 </a>
                 <ul class="treeview-menu">
                     <li class="{{ $route == 'student.fee.view' ? 'active' : '' }}"><a
                             href="{{ route('student.fee.view') }}"><i class="ti-more"></i>Student Fee</a></li>

                     <li class="{{ $route == 'account.salary.view' ? 'active' : '' }}"><a
                             href=" {{ route('account.salary.view') }} "><i class="ti-more"></i>Employee Salary</a>
                     </li>

                     <li class="{{ $route == 'other.cost.view' ? 'active' : '' }}"><a
                             href="{{ route('other.cost.view') }} "><i class="ti-more"></i>Other Cost</a></li>

                 </ul>
             </li>


             <li class="header nav-small-cap">Reports</li>

             {{-- <li class="treeview "> --}}
             {{-- {{ $prefix == '/reports' ? 'active' : '' }} --}}
             {{-- <a href="#">
                     <i data-feather="server"></i></i> <span> Reports Management</span>
                     <span class="pull-right-container">
                         <i class="fa fa-angle-right pull-right"></i>
                     </span>
                 </a> --}}
             {{-- <ul class="treeview-menu">
                     <li class=""><a href=""><i class="ti-more"></i>Monthly-Yearly
                             Profite</a></li> --}}
             {{-- {{ $route == 'monthly.profit.view' ? 'active' : '' }} --}}
             {{-- {{ route('monthly.profit.view') }} --}}

             {{-- <li class=""><a href=""><i class="ti-more"></i>MarkSheet Generate</a></li> --}}
             {{-- {{ $route == 'marksheet.generate.view' ? 'active' : '' }} --}}
             {{-- {{ route('marksheet.generate.view') }} --}}

             {{-- <li class="}"><a href=""><i class="ti-more"></i>Attendance
                             Report</a></li> --}}
             {{-- {{ $route == 'attendance.report.view' ? 'active' : '' } --}}
             {{-- {{ route('attendance.report.view') }} --}}

             {{-- <li class=""><a href=""><i class="ti-more"></i>Student Result </a>
                     </li> --}}
             {{-- {{ $route == 'student.result.view' ? 'active' : '' }} --}}
             {{-- {{ route('student.result.view') }} --}}

             {{-- <li class=""><a href="}"><i class="ti-more"></i>Student ID Card </a>
                     </li> --}}
             {{-- {{ $route == 'student.idcard.view' ? 'active' : '' }} --}}
             {{-- {{ route('student.idcard.view') } --}}


             {{-- </ul>
             </li>  --}}

         </ul>
     </section>

     <div class="sidebar-footer">
         <!-- item-->
         <a href="javascript:void(0)" class="link" data-toggle="tooltip" title=""
             data-original-title="Settings" aria-describedby="tooltip92529"><i class="ti-settings"></i></a>
         <!-- item-->
         <a href="" class="link" data-toggle="tooltip" title=""
             data-original-title="Email"><i class="ti-email"></i></a>
             {{-- mailbox_inbox.html --}}
         <!-- item-->
         <a href="javascript:void(0)" class="link" data-toggle="tooltip" title=""
             data-original-title="Logout"><i class="ti-lock"></i></a>
     </div>
 </aside>
