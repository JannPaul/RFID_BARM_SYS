@include('layouts.header')

@include('layouts.css')

<link
    href="{{ asset('assets/plugins/tables/css/datatable/dataTables.bootstrap4.min.css') }}"
    rel="stylesheet"
>

<style>
    .user-card {
        border: none;
        border-radius: 18px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .user-card-header {
        background: #ffffff;
        padding: 25px;
        border-bottom: 1px solid #eeeeee;
    }

    .user-card-header h3 {
        margin: 0;
        font-weight: 700;
        color: #333;
    }

    .stat-card {
        border: none;
        border-radius: 18px;
        padding: 25px;
        background: #ffffff;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        height: 100%;
    }

    .stat-title {
        color: #777;
        font-size: 14px;
        font-weight: 600;
    }

    .stat-number {
        font-size: 30px;
        font-weight: 700;
        margin-top: 10px;
    }

    .form-control {
        border-radius: 10px;
        min-height: 45px;
    }

    .btn {
        border-radius: 10px;
    }

    .action-btn {
        width: 38px;
        height: 38px;
        padding: 0;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        margin: 1px;
    }

    .user-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: #f1f1f1;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 15px;
        font-weight: bold;
        color: #333;
    }

    .badge-status {
        padding: 7px 12px;
        border-radius: 20px;
        font-size: 12px;
    }

    .employee-badge {
        padding: 7px 10px;
        border-radius: 8px;
        font-size: 12px;
    }

    .modal-content {
        border: none;
        border-radius: 18px;
    }

    .modal-header {
        border-bottom: 1px solid #eeeeee;
    }

    .modal-footer {
        border-top: 1px solid #eeeeee;
    }

    .table thead th {
        white-space: nowrap;
        vertical-align: middle;
    }

    .table tbody td {
        vertical-align: middle;
    }
</style>

@include('layouts.top_navbar')

@include('layouts.left_sidebar')


<!--**********************************
    Content body start
***********************************-->

<div class="content-body">

    <div class="container-fluid">

        <!-- PAGE TITLE -->
        <div class="row page-titles mx-0">

            <div class="col-sm-6 p-md-0">

                <div class="welcome-text">

                    <h4>
                        User Management
                    </h4>

                    <span>
                        Manage staff and administrator accounts
                    </span>

                </div>

            </div>

            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">

                <ol class="breadcrumb">

                    <li class="breadcrumb-item">

                        <a href="{{ route('dashboard') }}">
                            Dashboard
                        </a>

                    </li>

                    <li class="breadcrumb-item active">
                        User Management
                    </li>

                </ol>

            </div>

        </div>


        <!-- SUCCESS MESSAGE -->
        @if(session('success'))

            <div class="alert alert-success alert-dismissible fade show">

                <i class="fa fa-check-circle mr-2"></i>

                {{ session('success') }}

                <button
                    type="button"
                    class="close"
                    data-dismiss="alert"
                >
                    <span>&times;</span>
                </button>

            </div>

        @endif


        <!-- ERROR MESSAGE -->
        @if(session('error'))

            <div class="alert alert-danger alert-dismissible fade show">

                {{ session('error') }}

                <button
                    type="button"
                    class="close"
                    data-dismiss="alert"
                >
                    <span>&times;</span>
                </button>

            </div>

        @endif


        <!-- VALIDATION ERRORS -->
        @if($errors->any())

            <div class="alert alert-danger">

                <strong>
                    Please check the following:
                </strong>

                <ul class="mb-0 mt-2">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        <!-- STATISTICS -->
        <div class="row mb-4">

            <!-- TOTAL STAFF -->
            <div class="col-xl-3 col-md-6 mb-3">

                <div class="stat-card">

                    <div class="stat-title">
                        Total Staff
                    </div>

                    <div class="stat-number text-primary">
                        {{ $totalStaff ?? 0 }}
                    </div>

                    <small class="text-muted">
                        Registered staff accounts
                    </small>

                </div>

            </div>


            <!-- ACTIVE STAFF -->
            <div class="col-xl-3 col-md-6 mb-3">

                <div class="stat-card">

                    <div class="stat-title">
                        Active Staff
                    </div>

                    <div class="stat-number text-success">
                        {{ $activeStaff ?? 0 }}
                    </div>

                    <small class="text-muted">
                        Active staff accounts
                    </small>

                </div>

            </div>


            <!-- INACTIVE STAFF -->
            <div class="col-xl-3 col-md-6 mb-3">

                <div class="stat-card">

                    <div class="stat-title">
                        Inactive Staff
                    </div>

                    <div class="stat-number text-danger">
                        {{ $inactiveStaff ?? 0 }}
                    </div>

                    <small class="text-muted">
                        Inactive staff accounts
                    </small>

                </div>

            </div>


            <!-- ADMINS -->
            <div class="col-xl-3 col-md-6 mb-3">

                <div class="stat-card">

                    <div class="stat-title">
                        Administrators
                    </div>

                    <div class="stat-number text-warning">
                        {{ $totalAdmins ?? 0 }}
                    </div>

                    <small class="text-muted">
                        Administrator accounts
                    </small>

                </div>

            </div>

        </div>


        <!-- USER TABLE -->
        <div class="card user-card">

            <div class="user-card-header">

                <div class="row align-items-center">

                    <div class="col-md-6">

                        <h3>

                            <i class="fa fa-users mr-2"></i>

                            Staff Accounts

                        </h3>

                        <small class="text-muted">
                            View and manage system users.
                        </small>

                    </div>


                    <div class="col-md-6 text-md-right mt-3 mt-md-0">

                        <button
                            type="button"
                            class="btn btn-primary"
                            data-toggle="modal"
                            data-target="#addStaffModal"
                        >

                            <i class="fa fa-user-plus mr-1"></i>

                            Add Staff

                        </button>

                    </div>

                </div>

            </div>


            <div class="card-body">

                <div class="table-responsive">

                    <table
                        id="staffTable"
                        class="table table-hover table-striped"
                    >

                        <thead>

                            <tr>

                                <th>#</th>

                                <th>User</th>

                                <th>Employee ID</th>

                                <th>Email</th>

                                <th>Access Level</th>

                                <th>Status</th>

                                <th>Date Added</th>

                                <th width="140">
                                    Actions
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($users as $user)

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>


                                    <!-- USER -->
                                    <td>

                                        <div class="d-flex align-items-center">

                                            <div class="user-avatar mr-3">

                                                {{
                                                    strtoupper(
                                                        substr(
                                                            $user->firstname,
                                                            0,
                                                            1
                                                        )
                                                    )
                                                }}

                                                {{
                                                    strtoupper(
                                                        substr(
                                                            $user->lastname,
                                                            0,
                                                            1
                                                        )
                                                    )
                                                }}

                                            </div>

                                            <div>

                                                <strong>

                                                    {{ $user->firstname }}

                                                    {{ $user->lastname }}

                                                </strong>

                                                <div class="small text-muted">

                                                    {{
                                                        ucfirst(
                                                            $user->access_level
                                                        )
                                                    }}

                                                    Account

                                                </div>

                                            </div>

                                        </div>

                                    </td>


                                    <!-- EMPLOYEE ID -->
                                    <td>

                                        <span class="badge badge-dark employee-badge">

                                            {{ $user->employeeid }}

                                        </span>

                                    </td>


                                    <!-- EMAIL -->
                                    <td>
                                        {{ $user->email }}
                                    </td>


                                    <!-- ACCESS LEVEL -->
                                    <td>

                                        @if($user->access_level === 'admin')

                                            <span class="badge badge-warning badge-status">
                                                Admin
                                            </span>

                                        @else

                                            <span class="badge badge-info badge-status">
                                                Staff
                                            </span>

                                        @endif

                                    </td>


                                    <!-- STATUS -->
                                    <td>

                                        @if($user->status === 'active')

                                            <span class="badge badge-success badge-status">
                                                Active
                                            </span>

                                        @else

                                            <span class="badge badge-danger badge-status">
                                                Inactive
                                            </span>

                                        @endif

                                    </td>


                                    <!-- DATE ADDED -->
                                    <td>

                                        {{
                                            $user->created_at
                                            ?
                                            $user->created_at->format('M d, Y')
                                            :
                                            '-'
                                        }}

                                    </td>


                                    <!-- ACTIONS -->
                                    <td>

                                        <!-- EDIT -->
                                        <button
                                            type="button"
                                            class="btn btn-warning action-btn"
                                            title="Edit User"
                                            data-toggle="modal"
                                            data-target="#editStaff{{ $user->id }}"
                                        >

                                            <i class="fa fa-pencil"></i>

                                        </button>


                                        <!-- DELETE -->
                                        @if(auth()->id() !== $user->id)

                                            <form
                                                action="{{ route('staff.destroy', $user->id) }}"
                                                method="POST"
                                                class="d-inline"
                                            >

                                                @csrf

                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-danger action-btn"
                                                    title="Delete User"
                                                    onclick="return confirm('Are you sure you want to delete this user account?')"
                                                >

                                                    <i class="fa fa-trash"></i>

                                                </button>

                                            </form>

                                        @endif

                                    </td>

                                </tr>


                                <!-- EDIT USER MODAL -->
                                <div
                                    class="modal fade"
                                    id="editStaff{{ $user->id }}"
                                    tabindex="-1"
                                >

                                    <div class="modal-dialog modal-lg">

                                        <div class="modal-content">


                                            <form
                                                action="{{ route('staff.update', $user->id) }}"
                                                method="POST"
                                            >

                                                @csrf

                                                @method('PUT')


                                                <div class="modal-header">

                                                    <h5 class="modal-title">

                                                        <i class="fa fa-pencil mr-2"></i>

                                                        Edit User

                                                    </h5>

                                                    <button
                                                        type="button"
                                                        class="close"
                                                        data-dismiss="modal"
                                                    >
                                                        <span>&times;</span>
                                                    </button>

                                                </div>


                                                <div class="modal-body">

                                                    <div class="row">


                                                        <!-- FIRST NAME -->
                                                        <div class="col-md-6 mb-3">

                                                            <label>
                                                                First Name
                                                            </label>

                                                            <input
                                                                type="text"
                                                                name="firstname"
                                                                value="{{ $user->firstname }}"
                                                                class="form-control"
                                                                required
                                                            >

                                                        </div>


                                                        <!-- LAST NAME -->
                                                        <div class="col-md-6 mb-3">

                                                            <label>
                                                                Last Name
                                                            </label>

                                                            <input
                                                                type="text"
                                                                name="lastname"
                                                                value="{{ $user->lastname }}"
                                                                class="form-control"
                                                                required
                                                            >

                                                        </div>


                                                        <!-- EMPLOYEE ID -->
                                                        <div class="col-md-6 mb-3">

                                                            <label>
                                                                Employee ID
                                                            </label>

                                                            <input
                                                                type="text"
                                                                name="employeeid"
                                                                value="{{ $user->employeeid }}"
                                                                class="form-control"
                                                                required
                                                            >

                                                        </div>


                                                        <!-- EMAIL -->
                                                        <div class="col-md-6 mb-3">

                                                            <label>
                                                                Email
                                                            </label>

                                                            <input
                                                                type="email"
                                                                name="email"
                                                                value="{{ $user->email }}"
                                                                class="form-control"
                                                                required
                                                            >

                                                        </div>


                                                        <!-- ACCESS LEVEL -->
                                                        <div class="col-md-6 mb-3">

                                                            <label>
                                                                Access Level
                                                            </label>

                                                            <select
                                                                name="access_level"
                                                                class="form-control"
                                                                required
                                                            >

                                                                <option
                                                                    value="staff"
                                                                    {{ $user->access_level === 'staff' ? 'selected' : '' }}
                                                                >
                                                                    Staff
                                                                </option>

                                                                <option
                                                                    value="admin"
                                                                    {{ $user->access_level === 'admin' ? 'selected' : '' }}
                                                                >
                                                                    Admin
                                                                </option>

                                                            </select>

                                                        </div>


                                                        <!-- STATUS -->
                                                        <div class="col-md-6 mb-3">

                                                            <label>
                                                                Status
                                                            </label>

                                                            <select
                                                                name="status"
                                                                class="form-control"
                                                                required
                                                            >

                                                                <option
                                                                    value="active"
                                                                    {{ $user->status === 'active' ? 'selected' : '' }}
                                                                >
                                                                    Active
                                                                </option>

                                                                <option
                                                                    value="inactive"
                                                                    {{ $user->status === 'inactive' ? 'selected' : '' }}
                                                                >
                                                                    Inactive
                                                                </option>

                                                            </select>

                                                        </div>


                                                        <!-- PASSWORD -->
                                                        <div class="col-md-6 mb-3">

                                                            <label>
                                                                New Password
                                                            </label>

                                                            <input
                                                                type="password"
                                                                name="password"
                                                                class="form-control"
                                                                placeholder="Leave blank to keep current password"
                                                            >

                                                        </div>


                                                        <!-- CONFIRM PASSWORD -->
                                                        <div class="col-md-6 mb-3">

                                                            <label>
                                                                Confirm New Password
                                                            </label>

                                                            <input
                                                                type="password"
                                                                name="password_confirmation"
                                                                class="form-control"
                                                                placeholder="Confirm new password"
                                                            >

                                                        </div>


                                                    </div>

                                                </div>


                                                <div class="modal-footer">

                                                    <button
                                                        type="button"
                                                        class="btn btn-secondary"
                                                        data-dismiss="modal"
                                                    >
                                                        Cancel
                                                    </button>

                                                    <button
                                                        type="submit"
                                                        class="btn btn-primary"
                                                    >

                                                        <i class="fa fa-save mr-1"></i>

                                                        Save Changes

                                                    </button>

                                                </div>


                                            </form>

                                        </div>

                                    </div>

                                </div>


                            @empty

                                <tr>

                                    <td
                                        colspan="8"
                                        class="text-center py-5"
                                    >

                                        <i
                                            class="fa fa-users"
                                            style="font-size:50px;color:#ccc;"
                                        ></i>

                                        <h5 class="mt-3">
                                            No users found
                                        </h5>

                                        <p class="text-muted">
                                            Add a staff account to get started.
                                        </p>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

<!--**********************************
    Content body end
***********************************-->


<!-- =====================================================
     ADD STAFF MODAL
====================================================== -->

<div
    class="modal fade"
    id="addStaffModal"
    tabindex="-1"
>

    <div class="modal-dialog modal-lg">

        <div class="modal-content">


            <form
                action="{{ route('staff.store') }}"
                method="POST"
            >

                @csrf


                <div class="modal-header">

                    <h5 class="modal-title">

                        <i class="fa fa-user-plus mr-2"></i>

                        Add Staff

                    </h5>


                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                    >
                        <span>&times;</span>
                    </button>

                </div>


                <div class="modal-body">

                    <div class="row">


                        <!-- FIRST NAME -->
                        <div class="col-md-6 mb-3">

                            <label>

                                First Name

                                <span class="text-danger">
                                    *
                                </span>

                            </label>

                            <input
                                type="text"
                                name="firstname"
                                value="{{ old('firstname') }}"
                                class="form-control"
                                required
                            >

                        </div>


                        <!-- LAST NAME -->
                        <div class="col-md-6 mb-3">

                            <label>

                                Last Name

                                <span class="text-danger">
                                    *
                                </span>

                            </label>

                            <input
                                type="text"
                                name="lastname"
                                value="{{ old('lastname') }}"
                                class="form-control"
                                required
                            >

                        </div>


                        <!-- EMPLOYEE ID -->
                        <div class="col-md-6 mb-3">

                            <label>

                                Employee ID

                                <span class="text-danger">
                                    *
                                </span>

                            </label>

                            <input
                                type="text"
                                name="employeeid"
                                value="{{ old('employeeid') }}"
                                class="form-control"
                                placeholder="Example: EMP-001"
                                required
                            >

                        </div>


                        <!-- EMAIL -->
                        <div class="col-md-6 mb-3">

                            <label>

                                Email

                                <span class="text-danger">
                                    *
                                </span>

                            </label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control"
                                placeholder="staff@example.com"
                                required
                            >

                        </div>


                        <!-- PASSWORD -->
                        <div class="col-md-6 mb-3">

                            <label>

                                Password

                                <span class="text-danger">
                                    *
                                </span>

                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                minlength="6"
                                required
                            >

                        </div>


                        <!-- CONFIRM PASSWORD -->
                        <div class="col-md-6 mb-3">

                            <label>

                                Confirm Password

                                <span class="text-danger">
                                    *
                                </span>

                            </label>

                            <input
                                type="password"
                                name="password_confirmation"
                                class="form-control"
                                minlength="6"
                                required
                            >

                        </div>


                        <!-- ACCESS LEVEL -->
                        <div class="col-md-6 mb-3">

                            <label>
                                Access Level
                            </label>

                            <select
                                name="access_level"
                                class="form-control"
                                required
                            >

                                <option
                                    value="staff"
                                    {{ old('access_level', 'staff') === 'staff' ? 'selected' : '' }}
                                >
                                    Staff
                                </option>

                                <option
                                    value="admin"
                                    {{ old('access_level') === 'admin' ? 'selected' : '' }}
                                >
                                    Admin
                                </option>

                            </select>

                        </div>


                        <!-- STATUS -->
                        <div class="col-md-6 mb-3">

                            <label>
                                Status
                            </label>

                            <select
                                name="status"
                                class="form-control"
                                required
                            >

                                <option
                                    value="active"
                                    {{ old('status', 'active') === 'active' ? 'selected' : '' }}
                                >
                                    Active
                                </option>

                                <option
                                    value="inactive"
                                    {{ old('status') === 'inactive' ? 'selected' : '' }}
                                >
                                    Inactive
                                </option>

                            </select>

                        </div>


                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i class="fa fa-save mr-1"></i>

                        Add Staff

                    </button>

                </div>


            </form>

        </div>

    </div>

</div>


@include('layouts.footer')


<script src="{{ asset('assets/plugins/tables/js/jquery.dataTables.min.js') }}"></script>

<script src="{{ asset('assets/plugins/tables/js/datatable/dataTables.bootstrap4.min.js') }}"></script>


<script>
    $(document).ready(function () {

        if ($.fn.DataTable) {

            $('#staffTable').DataTable({

                pageLength: 10,

                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],

                order: [
                    [0, 'desc']
                ]

            });

        }


        /*
         * If Add Staff validation fails,
         * automatically reopen the Add Staff modal.
         */
        @if(
            $errors->any() &&
            old('firstname') !== null
        )

            $('#addStaffModal').modal('show');

        @endif

    });
</script>