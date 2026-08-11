@include('layouts.header')
@include('layouts.css')

<link href="{{ asset('assets/plugins/tables/css/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

@include('layouts.top_navbar')
@include('layouts.left_sidebar')

<div class="content-body">

    <div class="container-fluid">

        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Borrowed Books/Returned Books</h4>
                    <span>Monitor borrowed books,returned books and deadlines</span>
                </div>
            </div>

            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Borrowed Books
                    </li>
                </ol>
            </div>
        </div>


        <!-- SUMMARY CARDS -->
        <div class="row">

            <div class="col-lg-4 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5>Total Borrowed</h5>

                        <h2>
                            {{ $borrows->where('status', 'borrowed')->count() }}
                        </h2>

                        <span class="text-muted">
                            Currently borrowed books
                        </span>
                    </div>
                </div>
            </div>


            <div class="col-lg-4 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5>Overdue</h5>

                        <h2 class="text-danger">
                            {{ $borrows->filter(function($borrow) {
                                return $borrow->status !== 'returned'
                                    && \Carbon\Carbon::parse($borrow->due_date)->isPast();
                            })->count() }}
                        </h2>

                        <span class="text-muted">
                            Books past their deadline
                        </span>
                    </div>
                </div>
            </div>


            <div class="col-lg-4 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5>Returned</h5>

                        <h2 class="text-success">
                            {{ $borrows->where('status', 'returned')->count() }}
                        </h2>

                        <span class="text-muted">
                            Successfully returned books
                        </span>
                    </div>
                </div>
            </div>

        </div>


        <!-- BORROWED BOOKS TABLE -->
        <div class="card">

            <div class="card-header">
                <h4 class="card-title">
                    Borrowed Book Records
                </h4>
            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table id="borrowTable"
                           class="table table-striped table-hover">

                        <thead>

                            <tr>
                                <th>#</th>
                                <th>Book</th>
                                <th>Borrower</th>
                                <th>Date Borrowed</th>
                                <th>Deadline</th>
                                <th>Days Remaining</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($borrows as $borrow)

                                @php

                                    $today = \Carbon\Carbon::today();

                                    $deadline = \Carbon\Carbon::parse(
                                        $borrow->due_date
                                    );

                                    $isOverdue =
                                        $borrow->status !== 'returned'
                                        && $deadline->isPast();

                                    $days = $today->diffInDays(
                                        $deadline,
                                        false
                                    );

                                @endphp

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>


                                    <td>

                                        <strong>
                                            {{ $borrow->book->title ?? 'Unknown Book' }}
                                        </strong>

                                        <br>

                                        <small class="text-muted">
                                            {{ $borrow->book->author ?? '' }}
                                        </small>

                                        <br>

                                        <small>
                                            Call No:
                                            {{ $borrow->book->call_number ?? '-' }}
                                        </small>

                                    </td>


                                    <td>

                                        {{ $borrow->borrower->name ?? 'Unknown Borrower' }}

                                    </td>


                                    <td>

                                        {{ \Carbon\Carbon::parse(
                                            $borrow->borrowed_at
                                        )->format('M d, Y') }}

                                    </td>


                                    <td>

                                        <strong class="{{ $isOverdue ? 'text-danger' : '' }}">

                                            {{ $deadline->format('M d, Y') }}

                                        </strong>

                                    </td>


                                    <td>

                                        @if($borrow->status === 'returned')

                                            <span class="text-muted">
                                                Completed
                                            </span>

                                        @elseif($isOverdue)

                                            <span class="text-danger">

                                                {{ abs($days) }}
                                                day(s) overdue

                                            </span>

                                        @elseif($days == 0)

                                            <span class="text-warning">
                                                Due Today
                                            </span>

                                        @else

                                            <span class="text-success">

                                                {{ $days }}
                                                day(s) remaining

                                            </span>

                                        @endif

                                    </td>


                                    <td>

                                        @if($borrow->status === 'returned')

                                            <span class="badge badge-success">
                                                Returned
                                            </span>

                                        @elseif($isOverdue)

                                            <span class="badge badge-danger">
                                                Overdue
                                            </span>

                                        @else

                                            <span class="badge badge-warning">
                                                Borrowed
                                            </span>

                                        @endif

                                    </td>


                                    <td>

                                        @if($borrow->status !== 'returned')

                                            <form
                                                action="{{ route('bookborrow.return', $borrow->id) }}"
                                                method="POST">

                                                @csrf
                                                @method('PUT')

                                                <button
                                                    type="submit"
                                                    class="btn btn-success btn-sm"
                                                    onclick="return confirm('Mark this book as returned?')">

                                                    <i class="fa fa-check"></i>
                                                    Return

                                                </button>

                                            </form>

                                        @else

                                            <span class="text-success">
                                                Returned
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="8"
                                        class="text-center py-4">

                                        No borrowing records found.

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

@include('layouts.footer')

<script src="{{ asset('assets/plugins/tables/js/jquery.dataTables.min.js') }}"></script>

<script src="{{ asset('assets/plugins/tables/js/datatable/dataTables.bootstrap4.min.js') }}"></script>

<script>

$(document).ready(function () {

    $('#borrowTable').DataTable({
        pageLength: 10,
        order: [[4, 'asc']]
    });

});

</script>