<!--**********************************
    Nav header start
***********************************-->

<div class="nav-header">

    <!-- ============================================================
         BRAND / LOGO - NOT CLICKABLE
    ============================================================= -->

    <div
        class="brand-logo"
        style="
            cursor: default;
            user-select: none;
            display: flex;
            align-items: center;
            height: 100%;
            text-decoration: none;
        "
    >

        <!-- LOGO -->

        <img
            class="logo-abbr"
            src="{{ asset('assets/images/logo.png') }}"
            alt="RFID-BARM Logo"
            style="
                pointer-events: none;
            "
        >


        <!-- BRAND NAME -->

        <span
            class="brand-title"
            style="
                font-size: 26px;
                font-weight: 700;
                letter-spacing: 0.5px;
                line-height: 1;
                white-space: nowrap;
                color: #000000;
                cursor: default;
                pointer-events: none;
                margin-left: 30px;
            "
        >
            RFID-BARM
        </span>

    </div>


    <!-- ============================================================
         SIDEBAR TOGGLE
    ============================================================= -->

    <div class="nav-control">

        <div class="hamburger">

            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>

        </div>

    </div>

</div>

<!--**********************************
    Nav header end
***********************************-->



<!--**********************************
    Header start
***********************************-->

<div class="header">

    <div class="header-content">

        <nav class="navbar navbar-expand">

            <div class="collapse navbar-collapse justify-content-between">


                <!-- ====================================================
                     LEFT SIDE
                ===================================================== -->

                <div class="header-left">

                    <!-- Add other header items here if needed -->

                </div>


                <!-- ====================================================
                     RIGHT SIDE
                ===================================================== -->

                <ul class="navbar-nav header-right">


                    @auth


                        <!-- =============================================
                             PROFILE DROPDOWN
                        ============================================== -->

                        <li class="nav-item dropdown header-profile">


                            <!-- =========================================
                                 PROFILE BUTTON
                            ========================================== -->

                            <a
                                class="nav-link"
                                href="javascript:void(0);"
                                role="button"
                                data-toggle="dropdown"
                                aria-expanded="false"
                            >

                                <div
                                    style="
                                        display: flex;
                                        align-items: center;
                                        gap: 10px;
                                    "
                                >


                                    <!-- PROFILE ICON -->

                                    <div
                                        style="
                                            width: 42px;
                                            height: 42px;
                                            min-width: 42px;
                                            border-radius: 50%;
                                            background: #f1f1f1;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                        "
                                    >

                                        <i
                                            class="fa fa-user"
                                            style="
                                                font-size: 21px;
                                                color: #555;
                                            "
                                        ></i>

                                    </div>


                                    <!-- NAME + ACCESS LEVEL -->

                                    <div
                                        class="d-none d-md-block"
                                        style="
                                            text-align: left;
                                            line-height: 1.2;
                                        "
                                    >

                                        <!-- FIRST NAME -->

                                        <span
                                            style="
                                                display: block;
                                                font-weight: 600;
                                                color: #333;
                                            "
                                        >

                                            {{ auth()->user()->firstname }}

                                        </span>


                                        <!-- ACCESS LEVEL -->

                                        <small
                                            class="text-muted"
                                            style="
                                                text-transform: capitalize;
                                            "
                                        >

                                            {{ auth()->user()->access_level }}

                                        </small>

                                    </div>


                                    <!-- DROPDOWN ARROW -->

                                    <i
                                        class="fa fa-angle-down d-none d-md-inline"
                                        style="
                                            color: #777;
                                            font-size: 14px;
                                        "
                                    ></i>


                                </div>

                            </a>



                            <!-- =========================================
                                 PROFILE DROPDOWN MENU
                            ========================================== -->

                            <div
                                class="dropdown-menu dropdown-menu-right"
                                style="
                                    width: 280px;
                                    padding: 0;
                                    border: none;
                                    border-radius: 15px;
                                    overflow: hidden;
                                    box-shadow:
                                        0 6px 25px rgba(0,0,0,0.15);
                                "
                            >


                                <!-- =====================================
                                     USER INFORMATION
                                ====================================== -->

                                <div
                                    style="
                                        padding: 20px;
                                        background: #f8f9fa;
                                        border-bottom: 1px solid #eeeeee;
                                    "
                                >

                                    <div
                                        style="
                                            display: flex;
                                            align-items: center;
                                        "
                                    >


                                        <!-- LARGE PROFILE ICON -->

                                        <div
                                            style="
                                                width: 55px;
                                                height: 55px;
                                                min-width: 55px;
                                                border-radius: 50%;
                                                background: #ffffff;
                                                display: flex;
                                                align-items: center;
                                                justify-content: center;
                                                box-shadow:
                                                    0 2px 8px
                                                    rgba(0,0,0,0.10);
                                            "
                                        >

                                            <i
                                                class="fa fa-user"
                                                style="
                                                    font-size: 27px;
                                                    color: #555;
                                                "
                                            ></i>

                                        </div>


                                        <!-- USER DETAILS -->

                                        <div
                                            style="
                                                margin-left: 12px;
                                                overflow: hidden;
                                            "
                                        >


                                            <!-- FULL NAME -->

                                            <strong
                                                style="
                                                    display: block;
                                                    font-size: 15px;
                                                    color: #333;
                                                "
                                            >

                                                {{ auth()->user()->firstname }}
                                                {{ auth()->user()->lastname }}

                                            </strong>


                                            <!-- EMPLOYEE ID -->

                                            <small
                                                style="
                                                    display: block;
                                                    color: #777;
                                                    margin-top: 2px;
                                                "
                                            >

                                                Employee ID:
                                                {{ auth()->user()->employeeid }}

                                            </small>


                                            <!-- EMAIL -->

                                            <small
                                                title="{{ auth()->user()->email }}"
                                                style="
                                                    display: block;
                                                    color: #777;
                                                    margin-top: 2px;
                                                    white-space: nowrap;
                                                    overflow: hidden;
                                                    text-overflow: ellipsis;
                                                    max-width: 175px;
                                                "
                                            >

                                                {{ auth()->user()->email }}

                                            </small>


                                        </div>

                                    </div>



                                    <!-- =================================
                                         ACCESS LEVEL + STATUS
                                    ================================== -->

                                    <div
                                        style="
                                            margin-top: 14px;
                                            display: flex;
                                            gap: 6px;
                                            flex-wrap: wrap;
                                        "
                                    >


                                        <!-- ACCESS LEVEL -->

                                        @if(
                                            auth()->user()->access_level
                                            === 'admin'
                                        )

                                            <span
                                                class="badge badge-danger"
                                                style="
                                                    padding: 6px 10px;
                                                    border-radius: 15px;
                                                "
                                            >

                                                <i
                                                    class="fa fa-shield mr-1"
                                                ></i>

                                                Admin

                                            </span>

                                        @else

                                            <span
                                                class="badge badge-primary"
                                                style="
                                                    padding: 6px 10px;
                                                    border-radius: 15px;
                                                "
                                            >

                                                <i
                                                    class="fa fa-user mr-1"
                                                ></i>

                                                Staff

                                            </span>

                                        @endif



                                        <!-- ACCOUNT STATUS -->

                                        @if(
                                            auth()->user()->status
                                            === 'active'
                                        )

                                            <span
                                                class="badge badge-success"
                                                style="
                                                    padding: 6px 10px;
                                                    border-radius: 15px;
                                                "
                                            >

                                                <i
                                                    class="fa fa-check-circle mr-1"
                                                ></i>

                                                Active

                                            </span>

                                        @else

                                            <span
                                                class="badge badge-secondary"
                                                style="
                                                    padding: 6px 10px;
                                                    border-radius: 15px;
                                                "
                                            >

                                                <i
                                                    class="fa fa-times-circle mr-1"
                                                ></i>

                                                Inactive

                                            </span>

                                        @endif


                                    </div>

                                </div>



                                <!-- =====================================
                                     MY PROFILE
                                ====================================== -->

                                <a
                                    href="{{ route('profile') }}"
                                    class="dropdown-item"
                                    style="
                                        padding: 14px 20px;
                                        font-size: 14px;
                                    "
                                >

                                    <i
                                        class="fa fa-user mr-3"
                                        style="
                                            width: 18px;
                                            text-align: center;
                                        "
                                    ></i>

                                    My Profile

                                </a>



                                <!-- DIVIDER -->

                                <div
                                    class="dropdown-divider"
                                    style="
                                        margin: 0;
                                    "
                                ></div>



                                <!-- =====================================
                                     LOGOUT
                                ====================================== -->

                                <form
                                    action="{{ route('logout') }}"
                                    method="POST"
                                    style="
                                        margin: 0;
                                    "
                                >

                                    @csrf


                                    <button
                                        type="submit"
                                        class="dropdown-item text-danger"
                                        style="
                                            border: none;
                                            background: white;
                                            padding: 14px 20px;
                                            width: 100%;
                                            text-align: left;
                                            cursor: pointer;
                                            font-size: 14px;
                                        "
                                    >

                                        <i
                                            class="fa fa-sign-out mr-3"
                                            style="
                                                width: 18px;
                                                text-align: center;
                                            "
                                        ></i>

                                        Logout

                                    </button>

                                </form>


                            </div>

                        </li>


                    @endauth


                </ul>

            </div>

        </nav>

    </div>

</div>

<!--**********************************
    Header end
***********************************-->