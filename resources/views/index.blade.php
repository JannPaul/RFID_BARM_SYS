@include('layouts.header')
@include('layouts.css')

<link
    href="{{ asset('assets/plugins/tables/css/datatable/dataTables.bootstrap4.min.css') }}"
    rel="stylesheet"
>

<style>
    .dashboard-panel {
        height: 100%;
        border: none;
        border-radius: 12px;
        overflow: hidden;
    }

    .dashboard-panel .card-body {
        padding: 25px;
    }

    .summary-card {
        min-height: 170px;
        border: none;
        border-radius: 12px;
        overflow: hidden;
    }

    .summary-card .card-body {
        position: relative;
        padding: 25px;
    }

    .summary-icon {
        position: absolute;
        right: 20px;
        bottom: 20px;
        font-size: 45px;
        opacity: 0.35;
    }

    .analytics-card {
        border: none;
        border-radius: 12px;
        min-height: 145px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .analytics-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

    .analytics-number {
        font-size: 32px;
        font-weight: 700;
        color: #333;
    }

    .analytics-label {
        color: #6c757d;
        font-size: 14px;
    }

    .analytics-icon {
        width: 55px;
        height: 55px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 24px;
        background: rgba(117, 113, 249, 0.12);
        color: #7571f9;
    }

    .section-title {
        font-weight: 700;
        color: #333;
        margin-bottom: 5px;
    }

    .section-description {
        color: #6c757d;
        margin-bottom: 0;
    }

    .top-borrower-avatar {
        width: 95px;
        height: 95px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0 auto 20px;
        background: rgba(117, 113, 249, 0.12);
        color: #7571f9;
        font-size: 40px;
    }

    .borrow-count {
        font-size: 42px;
        font-weight: 700;
        color: #7571f9;
        line-height: 1;
    }

    .borrower-table th {
        border-top: none;
        color: #555;
        font-weight: 700;
        white-space: nowrap;
    }

    .borrower-table td {
        vertical-align: middle;
    }

    .rank-number {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        font-weight: 700;
        background: #f1f1f1;
    }

    .rank-one {
        background: #ffc107;
        color: white;
    }

    .rank-two {
        background: #6c757d;
        color: white;
    }

    .rank-three {
        background: #cd7f32;
        color: white;
    }

    .chart-container {
        position: relative;
        height: 350px;
        width: 100%;
    }

    .trend-chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }

    .popular-book {
        padding: 13px 0;
        border-bottom: 1px solid #eeeeee;
    }

    .popular-book:last-child {
        border-bottom: none;
    }

    .book-rank {
        width: 35px;
        height: 35px;
        background: rgba(117, 113, 249, 0.12);
        color: #7571f9;
        border-radius: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: bold;
        margin-right: 12px;
        flex-shrink: 0;
    }

    @media (max-width: 991px) {
        .chart-container {
            height: 300px;
        }

        .trend-chart-container {
            height: 280px;
        }
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

            <div class="col p-md-0">

                <ol class="breadcrumb">

                    <li class="breadcrumb-item">
                        <a href="javascript:void(0)">
                            Dashboard
                        </a>
                    </li>

                </ol>

            </div>

        </div>


        <!-- SESSION MESSAGE -->

        @if(Session::has('success'))

            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>

        @endif


        @if(Session::has('fail'))

            <div class="alert alert-danger">
                {{ Session::get('fail') }}
            </div>

        @endif


        <!-- ==================================================
             SUMMARY CARDS
        =================================================== -->

        <div class="row">

            <!-- BORROWED BOOKS -->

            <div class="col-lg-3 col-sm-6 mb-3">

                <div class="card gradient-1 summary-card">

                    <div class="card-body">

                        <h3 class="card-title text-white">
                            Borrowed Books
                        </h3>

                        <div class="d-inline-block">

                            <h2 class="text-white">
                                {{ $borrowedToday ?? 0 }}
                            </h2>

                            <p class="text-white mb-0">
                                {{ date('F j, Y') }}
                            </p>

                        </div>

                        <span class="summary-icon text-white">
                            <i class="fa fa-book"></i>
                        </span>

                    </div>

                </div>

            </div>


            <!-- RETURNED BOOKS -->

            <div class="col-lg-3 col-sm-6 mb-3">

                <div class="card gradient-2 summary-card">

                    <div class="card-body">

                        <h3 class="card-title text-white">
                            Returned Books
                        </h3>

                        <div class="d-inline-block">

                            <h2 class="text-white">
                                {{ $returnedToday ?? 0 }}
                            </h2>

                            <p class="text-white mb-0">
                                {{ date('F j, Y') }}
                            </p>

                        </div>

                        <span class="summary-icon text-white">
                            <i class="fa fa-undo"></i>
                        </span>

                    </div>

                </div>

            </div>


            <!-- CURRENTLY BORROWED -->

            <div class="col-lg-3 col-sm-6 mb-3">

                <div class="card gradient-3 summary-card">

                    <div class="card-body">

                        <h3 class="card-title text-white">
                            Currently Borrowed
                        </h3>

                        <div class="d-inline-block">

                            <h2 class="text-white">
                                {{ $currentlyBorrowed ?? 0 }}
                            </h2>

                            <p class="text-white mb-0">
                                Active Borrowings
                            </p>

                        </div>

                        <span class="summary-icon text-white">
                            <i class="fa fa-bookmark"></i>
                        </span>

                    </div>

                </div>

            </div>


            <!-- OVERDUE BOOKS -->

            <div class="col-lg-3 col-sm-6 mb-3">

                <div class="card gradient-4 summary-card">

                    <div class="card-body">

                        <h3 class="card-title text-white">
                            Overdue Books
                        </h3>

                        <div class="d-inline-block">

                            <h2 class="text-white">
                                {{ $overdueBooks ?? 0 }}
                            </h2>

                            <p class="text-white mb-0">
                                Need Attention
                            </p>

                        </div>

                        <span class="summary-icon text-white">
                            <i class="fa fa-exclamation-triangle"></i>
                        </span>

                    </div>

                </div>

            </div>

        </div>


        <!-- ==================================================
             BORROWING ANALYTICS TITLE
        =================================================== -->

        <div class="row mt-4 mb-3">

            <div class="col-12">

                <h3 class="section-title">

                    <i class="fa fa-line-chart"></i>
                    Borrowing Analytics

                </h3>

                <p class="section-description">
                    Monitor students and personnel who frequently borrow books.
                </p>

            </div>

        </div>


        <!-- ==================================================
             ANALYTICS CARDS
        =================================================== -->

        <div class="row">

            <!-- TOTAL BORROWINGS -->

            <div class="col-xl-3 col-md-6 mb-4">

                <div class="card analytics-card shadow-sm">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="analytics-number">
                                    {{ $totalBorrowings ?? 0 }}
                                </div>

                                <div class="analytics-label">
                                    Total Borrowings
                                </div>

                            </div>

                            <div class="analytics-icon">
                                <i class="fa fa-book"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- UNIQUE BORROWERS -->

            <div class="col-xl-3 col-md-6 mb-4">

                <div class="card analytics-card shadow-sm">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="analytics-number">
                                    {{ $uniqueBorrowers ?? 0 }}
                                </div>

                                <div class="analytics-label">
                                    Unique Borrowers
                                </div>

                            </div>

                            <div class="analytics-icon">
                                <i class="fa fa-users"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- STUDENT BORROWINGS -->

            <div class="col-xl-3 col-md-6 mb-4">

                <div class="card analytics-card shadow-sm">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="analytics-number">
                                    {{ $studentBorrowings ?? 0 }}
                                </div>

                                <div class="analytics-label">
                                    Student Borrowings
                                </div>

                                <small class="text-muted">
                                    {{ $uniqueStudents ?? 0 }} student(s)
                                </small>

                            </div>

                            <div class="analytics-icon">
                                <i class="fa fa-graduation-cap"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- PERSONNEL BORROWINGS -->

            <div class="col-xl-3 col-md-6 mb-4">

                <div class="card analytics-card shadow-sm">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="analytics-number">
                                    {{ $personnelBorrowings ?? 0 }}
                                </div>

                                <div class="analytics-label">
                                    Personnel Borrowings
                                </div>

                                <small class="text-muted">
                                    {{ $uniquePersonnel ?? 0 }} personnel
                                </small>

                            </div>

                            <div class="analytics-icon">
                                <i class="fa fa-briefcase"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- ==================================================
             TOP BORROWER ANALYTICS
        =================================================== -->

        <div class="row">

            <!-- MOST FREQUENT BORROWERS -->

            <div class="col-lg-8 mb-4">

                <div class="card dashboard-panel shadow-sm">

                    <div class="card-body">

                        <h4 class="section-title">
                            <i class="fa fa-bar-chart"></i>
                            Most Frequent Borrowers
                        </h4>

                        <p class="section-description mb-4">
                            Top 10 students or personnel based on total borrowing transactions.
                        </p>

                        @if(isset($topBorrowers) && $topBorrowers->count() > 0)

                            <div class="chart-container">
                                <canvas id="borrowerChart"></canvas>
                            </div>

                        @else

                            <div class="text-center text-muted py-5">

                                <i
                                    class="fa fa-bar-chart"
                                    style="font-size:45px;"
                                ></i>

                                <p class="mt-3 mb-0">
                                    No borrowing records yet.
                                </p>

                            </div>

                        @endif

                    </div>

                </div>

            </div>


            <!-- TOP BORROWER -->

            <div class="col-lg-4 mb-4">

                <div class="card dashboard-panel shadow-sm">

                    <div class="card-body">

                        <h4 class="section-title">
                            <i class="fa fa-trophy"></i>
                            Top Borrower
                        </h4>

                        <p class="section-description mb-4">
                            Most active library borrower.
                        </p>

                        @if(isset($topBorrower) && $topBorrower)

                            <div class="text-center">

                                <div class="top-borrower-avatar">
                                    <i class="fa fa-user"></i>
                                </div>

                                <h3 class="mb-2">
                                    {{ $topBorrower->borrower_name }}
                                </h3>

                                @if($topBorrower->borrower_type === 'student')

                                    <span class="badge badge-primary p-2">
                                        Student
                                    </span>

                                @else

                                    <span class="badge badge-success p-2">
                                        Personnel
                                    </span>

                                @endif

                                <hr>

                                <div class="borrow-count">
                                    {{ $topBorrower->total_borrowed }}
                                </div>

                                <div class="text-muted mt-2">
                                    Total Books Borrowed
                                </div>

                            </div>

                        @else

                            <div class="text-center text-muted py-5">

                                <i
                                    class="fa fa-user"
                                    style="font-size:45px;"
                                ></i>

                                <p class="mt-3 mb-0">
                                    No borrower data yet.
                                </p>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>


        <!-- ==================================================
             7 DAY CHART + MOST BORROWED BOOK
        =================================================== -->

        <div class="row">

            <!-- 7 DAY BORROWING ACTIVITY -->

            <div class="col-lg-8 mb-4">

                <div class="card dashboard-panel shadow-sm">

                    <div class="card-body">

                        <h4 class="section-title">
                            <i class="fa fa-line-chart"></i>
                            7-Day Borrowing Activity
                        </h4>

                        <p class="section-description mb-4">
                            Number of books borrowed during the last seven days.
                        </p>

                        <div class="trend-chart-container">
                            <canvas id="dailyBorrowChart"></canvas>
                        </div>

                    </div>

                </div>

            </div>


            <!-- MOST BORROWED BOOKS -->

            <div class="col-lg-4 mb-4">

                <div class="card dashboard-panel shadow-sm">

                    <div class="card-body">

                        <h4 class="section-title">
                            <i class="fa fa-book"></i>
                            Most Borrowed Books
                        </h4>

                        <p class="section-description mb-3">
                            Top books based on borrowing transactions.
                        </p>

                        @if(isset($mostBorrowedBooks))

                            @forelse($mostBorrowedBooks as $index => $book)

                                <div class="popular-book d-flex align-items-center">

                                    <div class="book-rank">
                                        {{ $index + 1 }}
                                    </div>

                                    <div class="flex-grow-1">

                                        <strong>
                                            {{ $book->book_title ?? 'Unknown Book' }}
                                        </strong>

                                        <div class="text-muted">
                                            {{ $book->total_borrowed }} borrowing(s)
                                        </div>

                                    </div>

                                </div>

                            @empty

                                <div class="text-center text-muted py-4">
                                    No book records yet.
                                </div>

                            @endforelse

                        @else

                            <div class="text-center text-muted py-4">
                                No book records yet.
                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>


        <!-- ==================================================
             BORROWING LEADERBOARD
        =================================================== -->

        <div class="row">

            <div class="col-12 mb-4">

                <div class="card dashboard-panel shadow-sm">

                    <div class="card-body">

                        <h4 class="section-title">
                            <i class="fa fa-users"></i>
                            Borrowing Leaderboard
                        </h4>

                        <p class="section-description mb-4">
                            Students and personnel with the highest borrowing activity.
                        </p>


                        <div class="table-responsive">

                            <table class="table table-hover borrower-table">

                                <thead>

                                    <tr>

                                        <th>Rank</th>

                                        <th>Borrower</th>

                                        <th>Type</th>

                                        <th>Total Borrowed</th>

                                        <th>Activity</th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @if(isset($topBorrowers))

                                        @forelse($topBorrowers as $index => $borrower)

                                            <tr>

                                                <!-- RANK -->

                                                <td>

                                                    @if($index === 0)

                                                        <span class="rank-number rank-one">
                                                            1
                                                        </span>

                                                    @elseif($index === 1)

                                                        <span class="rank-number rank-two">
                                                            2
                                                        </span>

                                                    @elseif($index === 2)

                                                        <span class="rank-number rank-three">
                                                            3
                                                        </span>

                                                    @else

                                                        <span class="rank-number">
                                                            {{ $index + 1 }}
                                                        </span>

                                                    @endif

                                                </td>


                                                <!-- BORROWER -->

                                                <td>

                                                    <strong>
                                                        {{ $borrower->borrower_name }}
                                                    </strong>

                                                </td>


                                                <!-- TYPE -->

                                                <td>

                                                    @if($borrower->borrower_type === 'student')

                                                        <span class="badge badge-primary">
                                                            Student
                                                        </span>

                                                    @else

                                                        <span class="badge badge-success">
                                                            Personnel
                                                        </span>

                                                    @endif

                                                </td>


                                                <!-- TOTAL BORROWED -->

                                                <td>

                                                    <strong>
                                                        {{ $borrower->total_borrowed }}
                                                    </strong>

                                                </td>


                                                <!-- ACTIVITY -->

                                                <td>

                                                    @if($borrower->total_borrowed >= 10)

                                                        <span class="badge badge-success">
                                                            Very Active
                                                        </span>

                                                    @elseif($borrower->total_borrowed >= 5)

                                                        <span class="badge badge-primary">
                                                            Active
                                                        </span>

                                                    @else

                                                        <span class="badge badge-secondary">
                                                            Regular
                                                        </span>

                                                    @endif

                                                </td>

                                            </tr>

                                        @empty

                                            <tr>

                                                <td
                                                    colspan="5"
                                                    class="text-center text-muted py-5"
                                                >

                                                    <i
                                                        class="fa fa-users"
                                                        style="font-size:40px;"
                                                    ></i>

                                                    <p class="mt-3 mb-0">
                                                        No borrowing records found.
                                                    </p>

                                                </td>

                                            </tr>

                                        @endforelse

                                    @else

                                        <tr>

                                            <td
                                                colspan="5"
                                                class="text-center text-muted py-5"
                                            >
                                                No borrowing records found.
                                            </td>

                                        </tr>

                                    @endif

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<!--**********************************
    Content body end
***********************************-->


@include('layouts.footer')


<!-- Chart.js -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>

    /*
    |--------------------------------------------------------------------------
    | LOAD DASHBOARD CHARTS
    |--------------------------------------------------------------------------
    */

    document.addEventListener('DOMContentLoaded', function () {

        createBorrowerChart();

        createDailyBorrowChart();

    });


    /*
    |--------------------------------------------------------------------------
    | TOP BORROWERS CHART
    |--------------------------------------------------------------------------
    */

    function createBorrowerChart() {

        const canvas =
            document.getElementById('borrowerChart');

        if (!canvas) {
            return;
        }


        const names =
            @json($borrowerNames ?? []);

        const counts =
            @json($borrowerCounts ?? []);


        if (names.length === 0) {
            return;
        }


        new Chart(canvas, {

            type: 'bar',

            data: {

                labels: names,

                datasets: [

                    {

                        label:
                            'Books Borrowed',

                        data:
                            counts,

                        backgroundColor:
                            'rgba(117, 113, 249, 0.75)',

                        borderColor:
                            'rgba(117, 113, 249, 1)',

                        borderWidth:
                            1,

                        borderRadius:
                            6

                    }

                ]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {
                        display: false
                    }

                },

                scales: {

                    y: {

                        beginAtZero: true,

                        ticks: {
                            precision: 0
                        },

                        title: {
                            display: true,
                            text: 'Total Borrowings'
                        }

                    },

                    x: {

                        title: {
                            display: true,
                            text: 'Borrower'
                        }

                    }

                }

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | SEVEN DAY BORROWING CHART
    |--------------------------------------------------------------------------
    */

    function createDailyBorrowChart() {

        const canvas =
            document.getElementById('dailyBorrowChart');

        if (!canvas) {
            return;
        }


        const labels =
            @json($dailyLabels ?? []);

        const values =
            @json($dailyValues ?? []);


        new Chart(canvas, {

            type: 'line',

            data: {

                labels: labels,

                datasets: [

                    {

                        label:
                            'Books Borrowed',

                        data:
                            values,

                        backgroundColor:
                            'rgba(117, 113, 249, 0.12)',

                        borderColor:
                            'rgba(117, 113, 249, 1)',

                        borderWidth:
                            3,

                        fill:
                            true,

                        tension:
                            0.35,

                        pointRadius:
                            4,

                        pointHoverRadius:
                            6

                    }

                ]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {
                        display: false
                    }

                },

                scales: {

                    y: {

                        beginAtZero: true,

                        ticks: {
                            precision: 0
                        },

                        title: {
                            display: true,
                            text: 'Books Borrowed'
                        }

                    },

                    x: {

                        title: {
                            display: true,
                            text: 'Date'
                        }

                    }

                }

            }

        });

    }

</script>