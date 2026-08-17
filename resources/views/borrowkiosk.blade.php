<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Borrow Books</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

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

        .student-input,
        .search-input,
        .barcode-input {
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
            box-shadow: 0 8px 25px rgba(25, 135, 84, 0.20);
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

        .book-info {
            font-size: 0.88rem;
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

        .selected-book {
            border: 1px solid #dddddd;
            border-radius: 15px;
            padding: 18px;
            background: #fafafa;
        }

        .btn-action {
            height: 65px;
            border-radius: 15px;
            font-size: 1.2rem;
            font-weight: 700;
        }

        .book-counter {
            font-size: 1rem;
            padding: 10px 15px;
        }

        @media(max-width: 768px) {
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

        <!-- =====================================================
             HEADER
        ====================================================== -->

        <div class="text-center mb-4">

            <img
                src="{{ asset('images/lclogo.png') }}"
                class="kiosk-logo mb-2"
                alt="Lourdes College Logo"
            >

            <h1 class="header-title">
                BORROW A BOOK
            </h1>

            <p class="subtitle">
                Select a book below or scan the book barcode.
            </p>

        </div>


        <!-- =====================================================
             SUCCESS MESSAGE
        ====================================================== -->

        @if(session('success'))

            <div class="alert alert-success alert-dismissible fade show shadow-sm">

                <strong>Success!</strong>

                {{ session('success') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        <!-- =====================================================
             ERROR MESSAGE
        ====================================================== -->

        @if(session('error'))

            <div class="alert alert-danger alert-dismissible fade show shadow-sm">

                <strong>Error!</strong>

                {{ session('error') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        <!-- =====================================================
             VALIDATION ERRORS
        ====================================================== -->

        @if($errors->any())

            <div class="alert alert-danger shadow-sm">

                <strong>
                    Please check the following:
                </strong>

                <ul class="mb-0 mt-2">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        <!-- =====================================================
             BORROW FORM
        ====================================================== -->

        <form
            action="{{ route('borrow.store') }}"
            method="POST"
            id="borrowForm"
        >

            @csrf


            <!-- =================================================
                 STUDENT INFORMATION
            ================================================== -->

            <div class="section-card mb-4">

                <h4 class="fw-bold mb-3">
                    Student Information
                </h4>

                <div class="row g-3">

                    <div class="col-lg-6">

                        <label
                            for="student_id"
                            class="form-label fw-bold"
                        >
                            Student ID
                        </label>

                        <input
                            type="text"
                            name="student_id"
                            id="student_id"
                            class="form-control student-input"
                            placeholder="Scan or enter Student ID"
                            value="{{ old('student_id') }}"
                            autocomplete="off"
                            required
                        >

                    </div>


                    <div class="col-lg-6">

                        <label
                            for="student_name"
                            class="form-label fw-bold"
                        >
                            Student Name
                        </label>

                        <input
                            type="text"
                            name="student_name"
                            id="student_name"
                            class="form-control student-input"
                            placeholder="Enter student name"
                            value="{{ old('student_name') }}"
                            required
                        >

                    </div>

                </div>

            </div>


            <!-- =================================================
                 FIND BOOK
            ================================================== -->

            <div class="section-card mb-4">

                <h4 class="fw-bold mb-3">
                    Find a Book
                </h4>

                <div class="row g-3">

                    <div class="col-lg-7">

                        <label
                            for="bookSearch"
                            class="form-label fw-bold"
                        >
                            Search Book
                        </label>

                        <input
                            type="text"
                            id="bookSearch"
                            class="form-control search-input"
                            placeholder="Search by title, author, ISBN, call number, or book code"
                            autocomplete="off"
                        >

                    </div>


                    <div class="col-lg-5">

                        <label
                            for="barcodeSearch"
                            class="form-label fw-bold"
                        >
                            Scan Book Barcode
                        </label>

                        <input
                            type="text"
                            id="barcodeSearch"
                            class="form-control barcode-input"
                            placeholder="Scan barcode here"
                            autocomplete="off"
                        >

                    </div>

                </div>

            </div>


            <!-- =================================================
                 AVAILABLE BOOKS FROM DATABASE
            ================================================== -->

            <div class="section-card mb-4">

                <div
                    class="d-flex flex-wrap justify-content-between align-items-center mb-4"
                >

                    <div>

                        <h4 class="fw-bold mb-1">
                            Available Books
                        </h4>

                        <small class="text-muted">
                            Choose the books you want to borrow.
                        </small>

                    </div>


                    <span
                        class="badge bg-dark book-counter mt-2 mt-md-0"
                    >

                        {{ $books->count() }}

                        {{ $books->count() == 1 ? 'Book' : 'Books' }}

                    </span>

                </div>


                <!-- NO SEARCH RESULTS -->

                <div
                    id="noSearchResults"
                    class="alert alert-warning text-center d-none"
                >
                    No books matched your search.
                </div>


                <!-- BOOKS -->

                <div
                    class="row g-4"
                    id="booksContainer"
                >

                    @forelse($books as $book)

                        <div
                            class="col-xl-3 col-lg-4 col-md-6 book-item"

                            data-id="{{ $book->id }}"

                            data-title="{{ strtolower($book->title ?? '') }}"

                            data-author="{{ strtolower($book->author ?? '') }}"

                            data-isbn="{{ strtolower($book->isbn ?? '') }}"

                            data-key="{{ strtolower($book->unique_key ?? '') }}"

                            data-call-number="{{ strtolower($book->call_number ?? '') }}"
                        >

                            <div
                                class="book-card"
                                id="book-card-{{ $book->id }}"
                            >

                                <!-- BOOK IMAGE PLACEHOLDER -->

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

                                    <div class="book-info mb-1">

                                        <span class="text-muted">
                                            ISBN:
                                        </span>

                                        <strong>
                                            {{ $book->isbn ?? 'N/A' }}
                                        </strong>

                                    </div>


                                    <!-- UNIQUE KEY -->

                                    <div class="book-info mb-1">

                                        <span class="text-muted">
                                            Book Code:
                                        </span>

                                        <strong>
                                            {{ $book->unique_key ?? 'N/A' }}
                                        </strong>

                                    </div>


                                    <!-- CALL NUMBER -->

                                    @if($book->call_number)

                                        <div class="book-info mb-1">

                                            <span class="text-muted">
                                                Call Number:
                                            </span>

                                            {{ $book->call_number }}

                                        </div>

                                    @endif


                                    <!-- SUBLOCATION -->

                                    @if($book->sublocation)

                                        <div class="book-info mb-1">

                                            <span class="text-muted">
                                                Location:
                                            </span>

                                            {{ $book->sublocation }}

                                        </div>

                                    @endif


                                    <!-- PUBLISHER -->

                                    @if($book->publisher)

                                        <div class="book-info mb-1">

                                            <span class="text-muted">
                                                Publisher:
                                            </span>

                                            {{ $book->publisher }}

                                        </div>

                                    @endif


                                    <!-- YEAR -->

                                    @if($book->year)

                                        <div class="book-info mb-1">

                                            <span class="text-muted">
                                                Year:
                                            </span>

                                            {{ $book->year }}

                                        </div>

                                    @endif


                                    <!-- EDITION -->

                                    @if($book->edition)

                                        <div class="book-info mb-1">

                                            <span class="text-muted">
                                                Edition:
                                            </span>

                                            {{ $book->edition }}

                                        </div>

                                    @endif


                                    <!-- STATUS -->

                                    <div
                                        class="availability text-success fw-bold mt-3 mb-3"
                                    >
                                        Available
                                    </div>


                                    <!-- SELECT BUTTON -->

                                    <button
                                        type="button"
                                        id="select-button-{{ $book->id }}"
                                        class="btn btn-dark w-100 btn-select"

                                        onclick='selectBook(
                                            {{ $book->id }},
                                            @json($book->title),
                                            @json($book->author),
                                            @json($book->isbn),
                                            @json($book->unique_key),
                                            @json($book->call_number),
                                            @json($book->sublocation),
                                            @json($book->publisher),
                                            @json($book->year),
                                            @json($book->edition)
                                        )'
                                    >
                                        Select Book
                                    </button>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="col-12">

                            <div class="text-center py-5 text-muted">

                                <div style="font-size:5rem;">
                                    📚
                                </div>

                                <h4 class="fw-bold mt-3">
                                    No books available
                                </h4>

                                <p class="mb-0">
                                    There are currently no available books in the database.
                                </p>

                            </div>

                        </div>

                    @endforelse

                </div>

            </div>


            <!-- =================================================
                 SELECTED BOOKS
            ================================================== -->

            <div class="section-card mb-4">

                <div
                    class="d-flex justify-content-between align-items-center mb-3"
                >

                    <div>

                        <h4 class="fw-bold mb-1">
                            Selected Books
                        </h4>

                        <p class="text-muted mb-0">
                            Books selected for borrowing will appear here.
                        </p>

                    </div>


                    <span
                        id="selectedCount"
                        class="badge bg-success fs-6"
                    >
                        0 Selected
                    </span>

                </div>


                <!--
                    JavaScript creates:

                    <input
                        type="hidden"
                        name="book_ids[]"
                        value="BOOK ID"
                    >
                -->

                <div id="selectedBookInputs"></div>


                <div
                    class="selected-area mt-4"
                    id="selectedBooksArea"
                >

                    <div class="text-center py-5 text-muted">

                        <div style="font-size:3rem;">
                            📚
                        </div>

                        <h5 class="mt-2">
                            No books selected
                        </h5>

                        <p class="mb-0">
                            Select a book above or scan its barcode.
                        </p>

                    </div>

                </div>

            </div>


            <!-- =================================================
                 ACTION BUTTONS
            ================================================== -->

            <div class="section-card">

                <div class="row justify-content-center g-3">

                    <div class="col-lg-4 col-md-6">

                        <button
                            type="submit"
                            class="btn btn-success w-100 btn-action"
                            id="confirmBorrowButton"
                        >
                            Confirm Borrow
                        </button>

                    </div>


                    <div class="col-lg-4 col-md-6">

                        <a
                            href="{{ url('/monitor') }}"
                            class="btn btn-secondary w-100 btn-action d-flex align-items-center justify-content-center"
                        >
                            Cancel
                        </a>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>


<!-- =============================================================
     BOOTSTRAP
============================================================== -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
></script>


<script>

    /*
    |--------------------------------------------------------------------------
    | SELECTED BOOKS
    |--------------------------------------------------------------------------
    */

    const selectedBooks = new Map();


    const bookSearch =
        document.getElementById('bookSearch');

    const barcodeSearch =
        document.getElementById('barcodeSearch');

    const selectedBooksArea =
        document.getElementById('selectedBooksArea');

    const selectedBookInputs =
        document.getElementById('selectedBookInputs');

    const selectedCount =
        document.getElementById('selectedCount');

    const borrowForm =
        document.getElementById('borrowForm');

    const noSearchResults =
        document.getElementById('noSearchResults');


    /*
    |--------------------------------------------------------------------------
    | SEARCH BOOKS
    |--------------------------------------------------------------------------
    */

    bookSearch.addEventListener(
        'input',
        function () {

            const search =
                this.value
                    .toLowerCase()
                    .trim();

            filterBooks(search);

        }
    );


    /*
    |--------------------------------------------------------------------------
    | FILTER BOOKS
    |--------------------------------------------------------------------------
    */

    function filterBooks(search) {

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
                title.includes(search) ||
                author.includes(search) ||
                isbn.includes(search) ||
                uniqueKey.includes(search) ||
                callNumber.includes(search);


            if (match) {

                book.style.display = '';

                visibleBooks++;

            } else {

                book.style.display = 'none';

            }

        });


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
    | USB barcode scanners normally act like a keyboard.
    | The scanner enters the barcode and then presses Enter.
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
                this.value
                    .toLowerCase()
                    .trim();


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


            if (!matchedBook) {

                alert(
                    'Book not found in the database.'
                );

                barcodeSearch.select();

                return;

            }


            const bookID =
                Number(matchedBook.dataset.id);


            const button =
                document.getElementById(
                    'select-button-' + bookID
                );


            if (
                button &&
                !selectedBooks.has(bookID)
            ) {

                button.click();

            }


            matchedBook.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });


            barcodeSearch.value = '';

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
        sublocation,
        publisher,
        year,
        edition
    ) {

        id = Number(id);


        /*
         * Clicking Selected again removes it.
         */

        if (selectedBooks.has(id)) {

            removeBook(id);

            return;

        }


        selectedBooks.set(id, {

            id: id,

            title: title,

            author: author,

            isbn: isbn,

            uniqueKey: uniqueKey,

            callNumber: callNumber,

            sublocation: sublocation,

            publisher: publisher,

            year: year,

            edition: edition

        });


        /*
         * Highlight card.
         */

        const card =
            document.getElementById(
                'book-card-' + id
            );


        if (card) {

            card.classList.add('selected');

        }


        /*
         * Change button.
         */

        const button =
            document.getElementById(
                'select-button-' + id
            );


        if (button) {

            button.classList.remove('btn-dark');

            button.classList.add('btn-success');

            button.textContent = 'Selected ✓';

        }


        renderSelectedBooks();

    }


    /*
    |--------------------------------------------------------------------------
    | REMOVE BOOK
    |--------------------------------------------------------------------------
    */

    function removeBook(id) {

        id = Number(id);


        selectedBooks.delete(id);


        /*
         * Remove selected border.
         */

        const card =
            document.getElementById(
                'book-card-' + id
            );


        if (card) {

            card.classList.remove('selected');

        }


        /*
         * Restore button.
         */

        const button =
            document.getElementById(
                'select-button-' + id
            );


        if (button) {

            button.classList.remove('btn-success');

            button.classList.add('btn-dark');

            button.textContent = 'Select Book';

        }


        renderSelectedBooks();

    }


    /*
    |--------------------------------------------------------------------------
    | RENDER SELECTED BOOKS
    |--------------------------------------------------------------------------
    */

    function renderSelectedBooks() {

        /*
         * Selected counter.
         */

        selectedCount.textContent =
            selectedBooks.size + ' Selected';


        /*
         * Clear old hidden inputs.
         */

        selectedBookInputs.innerHTML = '';


        /*
         * Generate book_ids[].
         */

        selectedBooks.forEach(function (book) {

            const input =
                document.createElement('input');


            input.type = 'hidden';

            input.name = 'book_ids[]';

            input.value = book.id;


            selectedBookInputs.appendChild(input);

        });


        /*
         * Empty selected books.
         */

        if (selectedBooks.size === 0) {

            selectedBooksArea.innerHTML = `

                <div class="text-center py-5 text-muted">

                    <div style="font-size:3rem;">
                        📚
                    </div>

                    <h5 class="mt-2">
                        No books selected
                    </h5>

                    <p class="mb-0">
                        Select a book above or scan its barcode.
                    </p>

                </div>

            `;

            return;

        }


        /*
         * Selected book list.
         */

        let html = '';


        selectedBooks.forEach(function (book) {

            html += `

                <div class="selected-book mb-3">

                    <div class="row align-items-center">

                        <div class="col">

                            <h5 class="fw-bold mb-1">

                                ${escapeHtml(
                                    book.title ||
                                    'Untitled Book'
                                )}

                            </h5>


                            <div class="text-muted mb-2">

                                ${escapeHtml(
                                    book.author ||
                                    'Unknown Author'
                                )}

                            </div>


                            <div class="row">


                                <div class="col-md-6">

                                    <small class="d-block mb-1">

                                        <strong>
                                            ISBN:
                                        </strong>

                                        ${escapeHtml(
                                            book.isbn ||
                                            'N/A'
                                        )}

                                    </small>


                                    <small class="d-block mb-1">

                                        <strong>
                                            Book Code:
                                        </strong>

                                        ${escapeHtml(
                                            book.uniqueKey ||
                                            'N/A'
                                        )}

                                    </small>


                                    <small class="d-block mb-1">

                                        <strong>
                                            Call Number:
                                        </strong>

                                        ${escapeHtml(
                                            book.callNumber ||
                                            'N/A'
                                        )}

                                    </small>

                                </div>


                                <div class="col-md-6">

                                    <small class="d-block mb-1">

                                        <strong>
                                            Location:
                                        </strong>

                                        ${escapeHtml(
                                            book.sublocation ||
                                            'N/A'
                                        )}

                                    </small>


                                    <small class="d-block mb-1">

                                        <strong>
                                            Publisher:
                                        </strong>

                                        ${escapeHtml(
                                            book.publisher ||
                                            'N/A'
                                        )}

                                    </small>


                                    <small class="d-block mb-1">

                                        <strong>
                                            Year:
                                        </strong>

                                        ${escapeHtml(
                                            book.year ||
                                            'N/A'
                                        )}

                                    </small>


                                    <small class="d-block mb-1">

                                        <strong>
                                            Edition:
                                        </strong>

                                        ${escapeHtml(
                                            book.edition ||
                                            'N/A'
                                        )}

                                    </small>

                                </div>

                            </div>

                        </div>


                        <div class="col-auto">

                            <button
                                type="button"
                                class="btn btn-outline-danger"
                                onclick="removeBook(${book.id})"
                            >
                                Remove
                            </button>

                        </div>

                    </div>

                </div>

            `;

        });


        selectedBooksArea.innerHTML = html;

    }


    /*
    |--------------------------------------------------------------------------
    | FORM VALIDATION
    |--------------------------------------------------------------------------
    */

    borrowForm.addEventListener(
        'submit',
        function (event) {

            /*
             * At least one book must be selected.
             */

            if (selectedBooks.size === 0) {

                event.preventDefault();


                alert(
                    'Please select at least one book before confirming the borrow.'
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
             * Student ID.
             */

            const studentID =
                document
                    .getElementById('student_id')
                    .value
                    .trim();


            if (!studentID) {

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
             * Student Name.
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

        }
    );


    /*
    |--------------------------------------------------------------------------
    | ESCAPE HTML
    |--------------------------------------------------------------------------
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

</script>

</body>
</html>
```
