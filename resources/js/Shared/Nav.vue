<template>
    <div class="header navbar">
        <div class="header-container" id="sidebar-toggle" href="javascript:void(0);">

            <ul class="nav-left">
                <li>
                    <a id="sidebar-toggle" class="sidebar-toggle" href="javascript:void(0);" @click="toggleSidebar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="black" class="bi bi-list"
                            viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                        </svg>
                    </a>
                    <!-- {{ isActive }} -->
                </li>
                <li class="search-input">
                    <input class="form-control" type="text" placeholder="Search..." />
                </li>
            </ul>
            <!-- dsdasdasd {{ $page.props.auth.impersonating }} -->
            <ul class="nav-left" v-if="$page.props.auth.impersonating === 'yes'">
                <li>
                    <a id="sidebar-toggle" class="sidebar-toggle">
                        <span class="text-danger">You are impersonating <b><u>{{
                        $page.props.auth.user.name.employee_name
                    }}</u></b></span>
                    </a>

                </li>
            </ul>
            <!-- -->
            <!-- <ul class="nav-left" v-if="$page.props.auth.shoud_update_password === 'yes'">
                <li>
                    <a id="sidebar-toggle" class="sidebar-toggle">
                        <span class="text-danger">You are required update your password every six months.
                            <b>
                                <u>
                                    {{
                        $page.props.auth.user.name.shoud_update_password
                    }}
                                </u>
                            </b>
                            Type your current password as the "old password"
                        </span>
                    </a>

                </li>
            </ul> -->
            <ul class="nav-right">

                <!-- <li class="notifications dropdown">
                    <span class="counter bgc-blue">3</span>
                    <a href="" class="dropdown-toggle no-after" data-bs-toggle="dropdown"><svg
                            xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell"
                            viewBox="0 0 16 16">
                            <path
                                d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z" />
                        </svg></a>
                    <ul class="dropdown-menu">
                        <li class="pX-20 pY-15 bdB">
                            <i class="ti-email pR-10"></i>
                            <span class="fsz-sm fw-600 c-grey-900">Emails</span>
                        </li>
                        <li>
                            <ul class="
                                    ovY-a
                                    pos-r
                                    scrollable
                                    lis-n
                                    p-0
                                    m-0
                                    fsz-sm
                                ">
                                <li>
                                    <a href="" class="
                                            peers
                                            fxw-nw
                                            td-n
                                            p-20
                                            bdB
                                            c-grey-800
                                            cH-blue
                                            bgcH-grey-100
                                        ">
                                        <div class="peer mR-15">
                                            <img class="w-3r bdrs-50p" src="https://randomuser.me/api/portraits/men/1.jpg"
                                                alt="" />
                                        </div>
                                        <div class="peer peer-greed">
                                            <div>
                                                <div class="
                                                        peers
                                                        jc-sb
                                                        fxw-nw
                                                        mB-5
                                                    ">
                                                    <div class="peer">
                                                        <p class="
                                                                fw-500
                                                                mB-0
                                                            ">
                                                            John Doe
                                                        </p>
                                                    </div>
                                                    <div class="peer">
                                                        <small class="
                                                                fsz-xs
                                                            ">5 mins
                                                            ago</small>
                                                    </div>
                                                </div>
                                                <span class="
                                                        c-grey-600
                                                        fsz-sm
                                                    ">Want to create your
                                                    own customized data
                                                    generator for your
                                                    app...</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="" class="
                                            peers
                                            fxw-nw
                                            td-n
                                            p-20
                                            bdB
                                            c-grey-800
                                            cH-blue
                                            bgcH-grey-100
                                        ">
                                        <div class="peer mR-15">
                                            <img class="w-3r bdrs-50p" src="https://randomuser.me/api/portraits/men/2.jpg"
                                                alt="" />
                                        </div>
                                        <div class="peer peer-greed">
                                            <div>
                                                <div class="
                                                        peers
                                                        jc-sb
                                                        fxw-nw
                                                        mB-5
                                                    ">
                                                    <div class="peer">
                                                        <p class="
                                                                fw-500
                                                                mB-0
                                                            ">
                                                            Moo Doe
                                                        </p>
                                                    </div>
                                                    <div class="peer">
                                                        <small class="
                                                                fsz-xs
                                                            ">15 mins
                                                            ago</small>
                                                    </div>
                                                </div>
                                                <span class="
                                                        c-grey-600
                                                        fsz-sm
                                                    ">Want to create your
                                                    own customized data
                                                    generator for your
                                                    app...</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="" class="
                                            peers
                                            fxw-nw
                                            td-n
                                            p-20
                                            bdB
                                            c-grey-800
                                            cH-blue
                                            bgcH-grey-100
                                        ">
                                        <div class="peer mR-15">
                                            <img class="w-3r bdrs-50p" src="https://randomuser.me/api/portraits/men/3.jpg"
                                                alt="" />
                                        </div>
                                        <div class="peer peer-greed">
                                            <div>
                                                <div class="
                                                        peers
                                                        jc-sb
                                                        fxw-nw
                                                        mB-5
                                                    ">
                                                    <div class="peer">
                                                        <p class="
                                                                fw-500
                                                                mB-0
                                                            ">
                                                            Lee Doe
                                                        </p>
                                                    </div>
                                                    <div class="peer">
                                                        <small class="
                                                                fsz-xs
                                                            ">25 mins
                                                            ago</small>
                                                    </div>
                                                </div>
                                                <span class="
                                                        c-grey-600
                                                        fsz-sm
                                                    ">Want to create your
                                                    own customized data
                                                    generator for your
                                                    app...</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="pX-20 pY-15 ta-c bdT">
                            <span><a href="email.html" class="
                                        c-grey-600
                                        cH-blue
                                        fsz-sm
                                        td-n
                                    ">View All Email
                                    <i class="
                                            fs-xs
                                            ti-angle-right
                                            mL-10
                                        "></i></a></span>
                        </li>
                    </ul>
                </li> -->
                <!--*********************************************-->
                <!-- <li class="dropdown">
                    <a href="" class="
                            dropdown-toggle
                            no-after
                            peers
                            fxw-nw
                            ai-c
                            lh-1
                        " data-bs-toggle="dropdown">
                        <div class="peer mR-10">

                            <img class="w-2r bdrs-50p" :src="$page.props.auth.user.photo" alt="" />
                        </div>
                        <div class="peer">
                            <span class="fsz-sm c-grey-900">{{ $page.props.auth.user.name.employee_name }}</span>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor"
                            class="bi bi-caret-down-fill mL-5" viewBox="0 0 16 16">
                            <path
                                d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                        </svg>
                    </a>
                    <ul class="dropdown-menu fsz-sm dropdown-menu-c">
                        <li>
                            <Link href="/users/settings" class="
                                    d-b
                                    td-n
                                    pY-5
                                    bgcH-grey-100
                                    c-grey-700
                                "><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                class="bi bi-sliders2 mR-10" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M10.5 1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4H1.5a.5.5 0 0 1 0-1H10V1.5a.5.5 0 0 1 .5-.5ZM12 3.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-6.5 2A.5.5 0 0 1 6 6v1.5h8.5a.5.5 0 0 1 0 1H6V10a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5ZM1 8a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 1 8Zm9.5 2a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V13H1.5a.5.5 0 0 1 0-1H10v-1.5a.5.5 0 0 1 .5-.5Zm1.5 2.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Z" />
                            </svg>
                            <span>Setting</span></Link>
                        </li>
                        <li>
                            <Link href="/users/change-password" class="
                                    d-b
                                    td-n
                                    pY-5
                                    bgcH-grey-100
                                    c-grey-700
                                "><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                class="bi bi-person-bounding-box mR-10" viewBox="0 0 16 16">
                                <path
                                    d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1h-3zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5zM.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5z" />
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                            </svg>
                            <span> Change Password</span></Link>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li>
                            <a @click="logout()" href="" class="
                                    d-b
                                    td-n
                                    pY-5
                                    bgcH-grey-100
                                    c-grey-700
                                "><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                    class="bi bi-box-arrow-right mR-10" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z" />
                                    <path fill-rule="evenodd"
                                        d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
                                </svg>
                                <span> Logout</span></a>
                        </li>
                    </ul>
                </li> -->
                <!--*********************************************-->
                <!-- <li v-if="$page.props.auth.impersonating === 'yes'" class="dropdown">

                    <a href="/impersonate/leave" class="
                            dropdown-toggle
                            no-after
                            peers
                            fxw-nw
                            ai-c
                            lh-1
                        " data-bs-toggle="dropdown">

                        <h5>Leave</h5>

                    </a>
                </li> -->

                <li class="dropdown">
                    <a href="" class="
                            dropdown-toggle
                            no-after
                            peers
                            fxw-nw
                            ai-c
                            lh-1
                        " data-bs-toggle="dropdown">
                        <div class="peer mR-10">
                            <img class="w-2r bdrs-50p" :src="$page.props.auth.user.photo" alt="" />
                        </div>
                        <div class="peer">
                            <span class="fsz-sm c-grey-900">{{ $page.props.auth.user.name.employee_name }}</span>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor"
                            class="bi bi-caret-down-fill mL-5" viewBox="0 0 16 16">
                            <path
                                d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                        </svg>
                    </a>

                    <ul class="dropdown-menu fsz-sm dropdown-menu-c">
                        <li>
                            <Link href="/users/settings" class="
                                    d-b
                                    td-n
                                    pY-5
                                    bgcH-grey-100
                                    c-grey-700
                                "><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                class="bi bi-sliders2 mR-10" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M10.5 1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4H1.5a.5.5 0 0 1 0-1H10V1.5a.5.5 0 0 1 .5-.5ZM12 3.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-6.5 2A.5.5 0 0 1 6 6v1.5h8.5a.5.5 0 0 1 0 1H6V10a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5ZM1 8a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 1 8Zm9.5 2a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V13H1.5a.5.5 0 0 1 0-1H10v-1.5a.5.5 0 0 1 .5-.5Zm1.5 2.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Z" />
                            </svg>
                            <span> Setting</span></Link>
                        </li>
                        <li>
                            <Link href="/users/change-password" class="
                                    d-b
                                    td-n
                                    pY-5
                                    bgcH-grey-100
                                    c-grey-700
                                "><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                class="bi bi-person-bounding-box mR-10" viewBox="0 0 16 16">
                                <path
                                    d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1h-3zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5zM.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5z" />
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                            </svg>
                            <span> Change Password</span></Link>
                        </li>
                        <li>
                            <Link href="/email/change" class="
                                    d-b
                                    td-n
                                    pY-5
                                    bgcH-grey-100
                                    c-grey-700
                                ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                class="bi bi-envelope-at-fill" viewBox="0 0 16 16">
                                <path
                                    d="M2 2A2 2 0 0 0 .05 3.555L8 8.414l7.95-4.859A2 2 0 0 0 14 2zm-2 9.8V4.698l5.803 3.546zm6.761-2.97-6.57 4.026A2 2 0 0 0 2 14h6.256A4.5 4.5 0 0 1 8 12.5a4.49 4.49 0 0 1 1.606-3.446l-.367-.225L8 9.586zM16 9.671V4.697l-5.803 3.546.338.208A4.5 4.5 0 0 1 12.5 8c1.414 0 2.675.652 3.5 1.671" />
                                <path
                                    d="M15.834 12.244c0 1.168-.577 2.025-1.587 2.025-.503 0-1.002-.228-1.12-.648h-.043c-.118.416-.543.643-1.015.643-.77 0-1.259-.542-1.259-1.434v-.529c0-.844.481-1.4 1.26-1.4.585 0 .87.333.953.63h.03v-.568h.905v2.19c0 .272.18.42.411.42.315 0 .639-.415.639-1.39v-.118c0-1.277-.95-2.326-2.484-2.326h-.04c-1.582 0-2.64 1.067-2.64 2.724v.157c0 1.867 1.237 2.654 2.57 2.654h.045c.507 0 .935-.07 1.18-.18v.731c-.219.1-.643.175-1.237.175h-.044C10.438 16 9 14.82 9 12.646v-.214C9 10.36 10.421 9 12.485 9h.035c2.12 0 3.314 1.43 3.314 3.034zm-4.04.21v.227c0 .586.227.8.581.8.31 0 .564-.17.564-.743v-.367c0-.516-.275-.708-.572-.708-.346 0-.573.245-.573.791" />
                            </svg>
                            &nbsp;&nbsp;<span> Change Email</span>
                            </Link>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li>
                            <a @click="logout()" href="" class="
                                    d-b
                                    td-n
                                    pY-5
                                    bgcH-grey-100
                                    c-grey-700
                                "><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                    class="bi bi-box-arrow-right mR-10" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z" />
                                    <path fill-rule="evenodd"
                                        d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
                                </svg>
                                <span> Logout</span></a>
                        </li>

                    </ul>
                </li>
            </ul>
            <u class="nav-right" v-if="$page.props.auth.impersonating === 'yes'">
                <li>
                    <a id="sidebar-toggle" class="sidebar-toggled" href="javascript:void(0);" @click="impersonateLeave">
                        <span class="btn btn-danger text-white">LEAVE</span>
                    </a>
                    <!-- {{ isActive }} -->
                </li>
            </u>
        </div>
    </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';

export default {
    data() {
        return {
            isActive: true
        };
    },
    methods: {
        logout() {
            // this.update_verified();
            // this.$inertia.post('/logout')
            // location.href = '/'
            this.$inertia.post('/logout')
                .then(response => {
                    console.log(response.data.message); // Should log "Logged out"
                    location.href = '/';
                })
                .catch(error => {
                    console.error('Logout failed:', error);
                });
        },
        // this.$inertia.post('/logout', {}, {
        //     onFinish: () => {
        //         // Redirect to the homepage after the logout request completes
        //         window.location.href = '/';
        //     }
        // });
        update_verified() {
            //alert(auth.user.name);
            axios.patch('/users/update_verified_at')
        },
        toggleSidebar() {
            this.isActive = !this.isActive;
        },
        impersonateLeave() {
            // if (confirm("Are you sure you want to leave?")) {
            //     this.$inertia.get(`/impersonate/leave`)
            //         .then(() => {
            //             // Redirect or handle success response as needed
            //             window.location.reload(); // Optional: reload to apply changes
            //         })
            //         .catch(error => {
            //             console.error('Error during impersonation:', error);
            //         });
            // }
            this.$swal({
                title: "Leave impersonation",
                text: "Are you sure you want to leave?",
                type: "warning",
                // buttons: true,
                // dangerMode: true,
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: false
            })
                .then((result) => {
                    if (result.isConfirmed) {
                        this.$inertia.get(`/impersonate/leave`, {}, {
                            onSuccess: () => {
                                // Redirect or handle success response as needed
                                window.location.reload(); // Optional: reload to apply changes
                            },
                            onError: (errors) => {
                                console.error('Error during impersonation:', errors);
                            }
                        });
                    } else {
                        // this.$swal("Impersonation cancelled!", {
                        //     title: "Impersonation cancelled",
                        //     icon: "info",
                        // });
                    }
                });
            // if (confirm("Are you sure you want to leave?")) {
            //     this.$inertia.get(`/impersonate/leave`, {}, {
            //         onSuccess: () => {
            //             // Redirect or handle success response as needed
            //             window.location.reload(); // Optional: reload to apply changes
            //         },
            //         onError: (errors) => {
            //             console.error('Error during impersonation:', errors);
            //         }
            //     });
            // }
        }

    }
}
</script>
