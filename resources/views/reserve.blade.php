<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reserve Book</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #FDECEC, #F7C8D0);
            font-family: Arial, Helvetica, sans-serif;
        }

        .main-container {
            max-width: 1500px;
        }

        .header-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .subtitle {
            font-size: 1.2rem;
            color: #6c757d;
        }

        .section-card {
            background: #ffffff;
            border: none;
            border-radius: 25px;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        .kiosk-logo {
            width: 100px;
            height: auto;
        }

        .form-control-custom,
        .form-select-custom {
            height: 65px;
            font-size: 1.2rem;
            border-radius: 15px;
        }

        .book-card {
            border: 2px solid #eeeeee;
            border-radius: 20px;
            overflow: hidden;
            transition: 0.2s;
            height: 100%;
            background: #ffffff;
        }

        .book-card:hover {
            border-color: #212529;
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        .book-card.selected {
            border: 3px solid #198754;
            box-shadow: 0 8px 25px rgba(25, 135, 84, 0.25);
        }

        .book-placeholder {
            height: 220px;
            width: 100%;
            background: #eeeeee;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 5rem;
        }

        .book-title {
            font-size: 1.15rem;
            font-weight: 700;
            min-height: 55px;
        }

        .book-author {
            color: #6c757d;
            font-size: 0.95rem;
        }

        .availability {
            font-size: 0.9rem;
        }

        .btn-select {
            height: 48px;
            border-radius: 12px;
            font-weight: 700;
        }

        .selected-area {
            min-height: 180px;
        }

        .selected-book-card {
            background: #f8f9fa;
            border: 2px solid #198754;
            border-radius: 20px;
            padding: 25px;
        }

        .schedule-box {
            background: #f8f9fa;
            border-radius: 20px;
            padding: 25px;
        }

        .btn-action {
            height: 65px;
            border-radius: 15px;
            font-size: 1.2rem;
            font-weight: 700;
        }

        .no-books {
            padding: 60px 20px;
            text-align: center;
            color: #6c757d;
        }

        .no-books-icon {
            font-size: 5rem;
        }

        .book-details-small {
            font-size: 0.88rem;
        }

        @media(max-width:768px) {
            .header-title {
                font-size: 2rem;
            }

            .section-card {
                padding: 20px;
            }

            .book-placeholder {
                height: 180px;
            }
        }
    </style>

</head>

<body>

<div class="container-fluid py-4">

    <div class="main-container mx-auto">

        <!-- ============================================================
             HEADER
        ============================================================= -->

        <div class="text-center mb-4">

            <img
                src="{{ asset('images/lclogo.png') }}"
                class="kiosk-logo mb-2"
                alt="Lourdes College Logo"
            >

            <h1 class="header-title">
                RESERVE A BOOK
            </h1>

            <p class="subtitle">
                Select a book and choose when you want to borrow it.
            </p>

        </div>


        <!-- ============================================================
             SUCCESS MESSAGE
        ============================================================= -->

        @if(session('success'))

            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">

                <strong>Success!</strong>

                {{ session('success') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        <!-- ============================================================
             ERROR MESSAGE
        ============================================================= -->

        @if(session('error'))

            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">

                <strong>Error!</strong>

                {{ session('error') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        <!-- ============================================================
             VALIDATION ERRORS
        ============================================================= -->

        @if($errors->any())

            <div class="alert alert-danger shadow-sm">

                <strong>Please check the following:</strong>

                <ul class="mb-0 mt-2">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        <!-- ============================================================
             RESERVATION FORM
        ============================================================= -->

        <form
            action="{{ route('reserve.store') }}"
            method="POST"
            id="reservationForm">

            @csrf


            <!-- ========================================================
                 STUDENT INFORMATION
            ========================================================= -->

            <div class="section-card mb-4">

                <h4 class="fw-bold mb-3">
                    Student Information
                </h4>

                <div class="row g-3">

                    <!-- STUDENT ID -->

                    <div class="col-lg-6">

                        <label
                            for="student_id"
                            class="form-label fw-bold">

                            Student ID

                        </label>

                        <input
                            type="text"
                            name="student_id"
                            id="student_id"
                            class="form-control form-control-custom"
                            placeholder="Scan or enter Student ID"
                            value="{{ old('student_id') }}"
                            autocomplete="off"
                            required
                        >

                    </div>


                    <!-- STUDENT NAME -->

                    <div class="col-lg-6">

                        <label
                            for="student_name"
                            class="form-label fw-bold">

                            Student Name

                        </label>

                        <input
                            type="text"
                            name="student_name"
                            id="student_name"
                            class="form-control form-control-custom"
                            placeholder="Enter student name"
                            value="{{ old('student_name') }}"
                            required
                        >

                    </div>

                </div>

            </div>


            <!-- ========================================================
                 FIND BOOK
            ========================================================= -->

            <div class="section-card mb-4">

                <h4 class="fw-bold mb-3">
                    Find a Book
                </h4>

                <div class="row g-3">

                    <!-- SEARCH -->

                    <div class="col-lg-7">

                        <label
                            for="bookSearch"
                            class="form-label fw-bold">

                            Search Book

                        </label>

                        <input
                            type="text"
                            id="bookSearch"
                            class="form-control form-control-custom"
                            placeholder="Search by title, author, ISBN, or call number"
                            autocomplete="off"
                        >

                    </div>


                    <!-- BARCODE -->

                    <div class="col-lg-5">

                        <label
                            for="barcodeSearch"
                            class="form-label fw-bold">

                            Scan Book Barcode

                        </label>

                        <input
                            type="text"
                            id="barcodeSearch"
                            class="form-control form-control-custom"
                            placeholder="Scan barcode here"
                            autocomplete="off"
                        >

                    </div>

                </div>

            </div>


            <!-- ========================================================
                 AVAILABLE BOOKS
            ========================================================= -->

            <div class="section-card mb-4">

                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">

                    <div>

                        <h4 class="fw-bold mb-1">
                            Books Available for Reservation
                        </h4>

                        <small class="text-muted">
                            Select the book you want to reserve.
                        </small>

                    </div>

                    <div class="mt-2 mt-md-0">

                        <span class="badge bg-dark fs-6">

                            {{ $books->count() }}
                            {{ $books->count() == 1 ? 'Book' : 'Books' }}

                        </span>

                    </div>

                </div>


                <!-- SEARCH RESULT MESSAGE -->

                <div
                    id="noSearchResults"
                    class="alert alert-warning text-center d-none">

                    No books matched your search.

                </div>


                <div class="row g-4" id="booksContainer">

                    @forelse($books as $book)

                        <div
                            class="col-xl-3 col-lg-4 col-md-6 book-item"

                            data-id="{{ $book->id }}"

                            data-title="{{ strtolower($book->title ?? '') }}"

                            data-author="{{ strtolower($book->author ?? '') }}"

                            data-isbn="{{ strtolower($book->isbn ?? '') }}"

                            data-key="{{ strtolower($book->unique_key ?? '') }}"

                            data-call-number="{{ strtolower($book->call_number ?? '') }}"

                            id="book-item-{{ $book->id }}"
                        >

                            <div
                                class="book-card"
                                id="book-card-{{ $book->id }}">

                                <!-- BOOK ICON -->

                                <div class="book-placeholder">
                                    📘
                                </div>


                                <div class="p-3">

                                    <!-- TITLE -->

                                    <div class="book-title">

                                        {{ $book->title ?? 'Untitled Book' }}

                                    </div>


                                    <!-- AUTHOR -->

                                    <div class="book-author mb-2">

                                        {{ $book->author ?? 'Unknown Author' }}

                                    </div>


                                    <!-- ISBN -->

                                    <div class="book-details-small mb-1">

                                        <span class="text-muted">
                                            ISBN:
                                        </span>

                                        <strong>
                                            {{ $book->isbn ?? 'N/A' }}
                                        </strong>

                                    </div>


                                    <!-- CALL NUMBER -->

                                    @if($book->call_number)

                                        <div class="book-details-small mb-1">

                                            <span class="text-muted">
                                                Call No:
                                            </span>

                                            <strong>
                                                {{ $book->call_number }}
                                            </strong>

                                        </div>

                                    @endif


                                    <!-- YEAR -->

                                    @if($book->year)

                                        <div class="book-details-small mb-1">

                                            <span class="text-muted">
                                                Year:
                                            </span>

                                            {{ $book->year }}

                                        </div>

                                    @endif


                                    <!-- EDITION -->

                                    @if($book->edition)

                                        <div class="book-details-small mb-2">

                                            <span class="text-muted">
                                                Edition:
                                            </span>

                                            {{ $book->edition }}

                                        </div>

                                    @endif


                                    <!-- STATUS -->

                                    <div class="availability text-warning fw-bold mt-3 mb-3">

                                        For Reservation

                                    </div>


                                    <!-- SELECT BUTTON -->

                                    <button
                                        type="button"
                                        class="btn btn-dark w-100 btn-select"
                                        id="select-button-{{ $book->id }}"

                                        onclick='selectBook(
                                            {{ $book->id }},
                                            @json($book->title),
                                            @json($book->author),
                                            @json($book->isbn),
                                            @json($book->unique_key),
                                            @json($book->call_number),
                                            @json($book->publisher),
                                            @json($book->year),
                                            @json($book->edition)
                                        )'>

                                        Select Book

                                    </button>

                                </div>

                            </div>

                        </div>


                    @empty

                        <!-- NO BOOKS IN DATABASE -->

                        <div class="col-12">

                            <div class="no-books">

                                <div class="no-books-icon">
                                    📚
                                </div>

                                <h4 class="fw-bold mt-3">
                                    No books available
                                </h4>

                                <p class="mb-0">

                                    There are currently no books in the
                                    books database.

                                </p>

                            </div>

                        </div>

                    @endforelse

                </div>

            </div>


            <!-- ========================================================
                 SELECTED BOOK
            ========================================================= -->

            <div class="section-card mb-4">

                <h4 class="fw-bold mb-1">
                    Selected Book
                </h4>

                <p class="text-muted mb-4">
                    The book selected for reservation will appear here.
                </p>


                <!-- HIDDEN BOOK ID -->

                <input
                    type="hidden"
                    name="book_id"
                    id="selected_book_id"
                    value="{{ old('book_id') }}"
                >


                <div
                    class="selected-area"
                    id="selectedBookArea">

                    <div class="text-center py-5 text-muted">

                        <div style="font-size:3rem;">
                            📚
                        </div>

                        <h5 class="mt-2">
                            No book selected
                        </h5>

                        <p class="mb-0">
                            Select a book above or scan its barcode.
                        </p>

                    </div>

                </div>

            </div>


            <!-- ========================================================
                 RESERVATION SCHEDULE
            ========================================================= -->

            <div class="section-card mb-4">

                <h4 class="fw-bold mb-3">
                    Reservation Schedule
                </h4>

                <div class="schedule-box">

                    <div class="row g-3">


                        <!-- BORROW DATE -->

                        <div class="col-lg-6">

                            <label
                                for="borrow_date"
                                class="form-label fw-bold">

                                Borrow Date

                            </label>

                            <input
                                type="date"
                                name="borrow_date"
                                id="borrow_date"
                                class="form-control form-control-custom"
                                value="{{ old('borrow_date') }}"
                                min="{{ date('Y-m-d') }}"
                                required
                            >

                        </div>


                        <!-- PICKUP TIME -->

                        <div class="col-lg-6">

                            <label
                                for="pickup_time"
                                class="form-label fw-bold">

                                Pickup Time

                            </label>

                            <select
                                name="pickup_time"
                                id="pickup_time"
                                class="form-select form-select-custom"
                                required>

                                <option value="" disabled
                                    {{ old('pickup_time') ? '' : 'selected' }}>

                                    Select pickup time

                                </option>


                                <option
                                    value="8:00 AM - 10:00 AM"
                                    {{ old('pickup_time') == '8:00 AM - 10:00 AM' ? 'selected' : '' }}>

                                    8:00 AM - 10:00 AM

                                </option>


                                <option
                                    value="10:00 AM - 12:00 PM"
                                    {{ old('pickup_time') == '10:00 AM - 12:00 PM' ? 'selected' : '' }}>

                                    10:00 AM - 12:00 PM

                                </option>


                                <option
                                    value="1:00 PM - 3:00 PM"
                                    {{ old('pickup_time') == '1:00 PM - 3:00 PM' ? 'selected' : '' }}>

                                    1:00 PM - 3:00 PM

                                </option>


                                <option
                                    value="3:00 PM - 5:00 PM"
                                    {{ old('pickup_time') == '3:00 PM - 5:00 PM' ? 'selected' : '' }}>

                                    3:00 PM - 5:00 PM

                                </option>

                            </select>

                        </div>

                    </div>

                </div>

            </div>


            <!-- ========================================================
                 ACTION BUTTONS
            ========================================================= -->

            <div class="section-card">

                <div class="row justify-content-center g-3">

                    <!-- CONFIRM -->

                    <div class="col-lg-4 col-md-6">

                        <button
                            type="submit"
                            class="btn btn-success w-100 btn-action"
                            id="confirmReservationButton">

                            Confirm Reservation

                        </button>

                    </div>


                    <!-- CANCEL -->

                    <div class="col-lg-4 col-md-6">

                        <a
                            href="{{ url('/monitor') }}"
                            class="btn btn-secondary w-100 btn-action d-flex align-items-center justify-content-center">

                            Cancel

                        </a>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>


<!-- ================================================================
     BOOTSTRAP
================================================================= -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>


<script>

    /*
    |--------------------------------------------------------------------------
    | VARIABLES
    |--------------------------------------------------------------------------
    */

    const bookSearch =
        document.getElementById('bookSearch');

    const barcodeSearch =
        document.getElementById('barcodeSearch');

    const selectedBookId =
        document.getElementById('selected_book_id');

    const selectedBookArea =
        document.getElementById('selectedBookArea');

    const reservationForm =
        document.getElementById('reservationForm');

    const noSearchResults =
        document.getElementById('noSearchResults');


    /*
    |--------------------------------------------------------------------------
    | SEARCH BOOK
    |--------------------------------------------------------------------------
    */

    bookSearch.addEventListener('input', function () {

        const searchValue =
            this.value.toLowerCase().trim();

        filterBooks(searchValue);

    });


    /*
    |--------------------------------------------------------------------------
    | FILTER BOOKS
    |--------------------------------------------------------------------------
    */

    function filterBooks(searchValue) {

        const books =
            document.querySelectorAll('.book-item');

        let visibleBooks = 0;


        books.forEach(function (book) {

            const title =
                book.dataset.title || '';

            const author =
                book.dataset.author || '';

            const isbn =
                book.dataset.isbn || '';

            const uniqueKey =
                book.dataset.key || '';

            const callNumber =
                book.dataset.callNumber || '';


            const match =

                title.includes(searchValue) ||

                author.includes(searchValue) ||

                isbn.includes(searchValue) ||

                uniqueKey.includes(searchValue) ||

                callNumber.includes(searchValue);


            if (match) {

                book.style.display = '';

                visibleBooks++;

            } else {

                book.style.display = 'none';

            }

        });


        /*
         * Show message if nothing is found.
         */

        if (
            visibleBooks === 0 &&
            books.length > 0
        ) {

            noSearchResults.classList.remove('d-none');

        } else {

            noSearchResults.classList.add('d-none');

        }

    }


    /*
    |--------------------------------------------------------------------------
    | BARCODE SCANNER
    |--------------------------------------------------------------------------
    |
    | USB barcode scanners usually behave like a keyboard.
    |
    | They type the barcode and send ENTER afterwards.
    |
    */

    barcodeSearch.addEventListener(
        'keydown',
        function (event) {

            if (event.key !== 'Enter') {
                return;
            }


            event.preventDefault();


            const scannedCode =
                this.value.toLowerCase().trim();


            if (!scannedCode) {
                return;
            }


            const books =
                document.querySelectorAll('.book-item');


            let matchedBook = null;


            books.forEach(function (book) {

                const isbn =
                    (book.dataset.isbn || '').trim();

                const uniqueKey =
                    (book.dataset.key || '').trim();


                if (
                    isbn === scannedCode ||
                    uniqueKey === scannedCode
                ) {

                    matchedBook = book;

                }

            });


            if (matchedBook) {

                /*
                 * Show only scanned book.
                 */

                books.forEach(function (book) {

                    if (book === matchedBook) {

                        book.style.display = '';

                    } else {

                        book.style.display = 'none';

                    }

                });


                noSearchResults.classList.add('d-none');


                /*
                 * Scroll to scanned book.
                 */

                matchedBook.scrollIntoView({

                    behavior: 'smooth',

                    block: 'center'

                });


                /*
                 * Automatically click Select Book.
                 */

                const bookID =
                    matchedBook.dataset.id;


                const selectButton =
                    document.getElementById(
                        'select-button-' + bookID
                    );


                if (selectButton) {

                    selectButton.click();

                }


                barcodeSearch.value = '';

            } else {

                alert(
                    'Book not found. Please check the barcode and try again.'
                );

                barcodeSearch.select();

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | SELECT BOOK
    |--------------------------------------------------------------------------
    */

    function selectBook(
        id,
        title,
        author,
        isbn,
        uniqueKey,
        callNumber,
        publisher,
        year,
        edition
    ) {

        /*
         * Save selected book ID.
         */

        selectedBookId.value = id;


        /*
         * Remove selected border from all books.
         */

        document
            .querySelectorAll('.book-card')
            .forEach(function (card) {

                card.classList.remove('selected');

            });


        /*
         * Reset all select buttons.
         */

        document
            .querySelectorAll('.btn-select')
            .forEach(function (button) {

                button.classList.remove(
                    'btn-success'
                );

                button.classList.add(
                    'btn-dark'
                );

                button.innerText =
                    'Select Book';

            });


        /*
         * Highlight selected book.
         */

        const selectedCard =
            document.getElementById(
                'book-card-' + id
            );


        if (selectedCard) {

            selectedCard.classList.add(
                'selected'
            );

        }


        /*
         * Change button.
         */

        const selectedButton =
            document.getElementById(
                'select-button-' + id
            );


        if (selectedButton) {

            selectedButton.classList.remove(
                'btn-dark'
            );

            selectedButton.classList.add(
                'btn-success'
            );

            selectedButton.innerText =
                'Selected ✓';

        }


        /*
         * Display selected book information.
         */

        selectedBookArea.innerHTML = `

            <div class="selected-book-card">

                <div class="row align-items-center">

                    <div class="col-md-auto text-center mb-3 mb-md-0">

                        <div style="font-size:5rem;">
                            📘
                        </div>

                    </div>


                    <div class="col">

                        <h3 class="fw-bold mb-2">

                            ${escapeHtml(
                                title ||
                                'Untitled Book'
                            )}

                        </h3>


                        <p class="mb-1">

                            <strong>
                                Author:
                            </strong>

                            ${escapeHtml(
                                author ||
                                'Unknown Author'
                            )}

                        </p>


                        <p class="mb-1">

                            <strong>
                                ISBN:
                            </strong>

                            ${escapeHtml(
                                isbn ||
                                'N/A'
                            )}

                        </p>


                        <p class="mb-1">

                            <strong>
                                Book Code:
                            </strong>

                            ${escapeHtml(
                                uniqueKey ||
                                'N/A'
                            )}

                        </p>


                        <p class="mb-1">

                            <strong>
                                Call Number:
                            </strong>

                            ${escapeHtml(
                                callNumber ||
                                'N/A'
                            )}

                        </p>


                        <p class="mb-1">

                            <strong>
                                Publisher:
                            </strong>

                            ${escapeHtml(
                                publisher ||
                                'N/A'
                            )}

                        </p>


                        <p class="mb-1">

                            <strong>
                                Year:
                            </strong>

                            ${escapeHtml(
                                year ||
                                'N/A'
                            )}

                        </p>


                        <p class="mb-0">

                            <strong>
                                Edition:
                            </strong>

                            ${escapeHtml(
                                edition ||
                                'N/A'
                            )}

                        </p>


                        <div class="mt-3">

                            <span class="badge bg-success fs-6">

                                Selected for Reservation

                            </span>

                        </div>

                    </div>

                </div>

            </div>

        `;


        /*
         * Scroll to selected book section.
         */

        selectedBookArea.scrollIntoView({

            behavior: 'smooth',

            block: 'center'

        });

    }


    /*
    |--------------------------------------------------------------------------
    | ESCAPE HTML
    |--------------------------------------------------------------------------
    |
    | Prevent book data from being interpreted as HTML.
    |
    */

    function escapeHtml(value) {

        if (
            value === null ||
            value === undefined
        ) {

            return '';

        }


        const div =
            document.createElement('div');


        div.textContent =
            String(value);


        return div.innerHTML;

    }


    /*
    |--------------------------------------------------------------------------
    | FORM VALIDATION
    |--------------------------------------------------------------------------
    */

    reservationForm.addEventListener(
        'submit',
        function (event) {

            /*
             * Make sure a book was selected.
             */

            if (!selectedBookId.value) {

                event.preventDefault();

                alert(
                    'Please select a book before confirming your reservation.'
                );

                document
                    .getElementById('booksContainer')
                    .scrollIntoView({

                        behavior: 'smooth',

                        block: 'start'

                    });

                return;

            }


            /*
             * Student ID
             */

            const studentId =
                document
                    .getElementById('student_id')
                    .value
                    .trim();


            if (!studentId) {

                event.preventDefault();

                alert(
                    'Please enter or scan the Student ID.'
                );

                document
                    .getElementById('student_id')
                    .focus();

                return;

            }


            /*
             * Student name
             */

            const studentName =
                document
                    .getElementById('student_name')
                    .value
                    .trim();


            if (!studentName) {

                event.preventDefault();

                alert(
                    'Please enter the student name.'
                );

                document
                    .getElementById('student_name')
                    .focus();

                return;

            }


            /*
             * Borrow date
             */

            const borrowDate =
                document
                    .getElementById('borrow_date')
                    .value;


            if (!borrowDate) {

                event.preventDefault();

                alert(
                    'Please select a borrow date.'
                );

                return;

            }


            /*
             * Pickup time
             */

            const pickupTime =
                document
                    .getElementById('pickup_time')
                    .value;


            if (!pickupTime) {

                event.preventDefault();

                alert(
                    'Please select a pickup time.'
                );

                return;

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | RESTORE OLD SELECTED BOOK
    |--------------------------------------------------------------------------
    |
    | If Laravel validation fails, old('book_id') will still contain
    | the selected book.
    |
    */

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            const oldBookId =
                selectedBookId.value;


            if (oldBookId) {

                const button =
                    document.getElementById(
                        'select-button-' +
                        oldBookId
                    );


                if (button) {

                    button.click();

                }

            }

        }
    );

</script>

</body>

</html>