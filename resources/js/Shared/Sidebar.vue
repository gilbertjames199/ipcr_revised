<template>
    <div class="sidebar">
        <div class="sidebar-inner">
            <!-- ### $Sidebar Header ### -->
            <div class="sidebar-logo">
                <div class="peers ai-c fxw-nw">
                    <div class="peer peer-greed">
                        <a class="sidebar-link td-n" href="/">
                            <div class="peers ai-c fxw-nw">
                                <div class="peer">
                                    <div class="logo">
                                        <img src="/images/logo.png" alt="" class="img-fluid p-5" />
                                    </div>
                                </div>
                                <div class="peer peer-greed">
                                    <h5 class="lh-1 mB-0 logo-text">
                                        <span style="color: #FFF; font-size:medium;">
                                            &nbsp;Performance Management
                                            <!-- {{ $page.props.auth.user.name.position_long_title }} -->
                                        </span>
                                    </h5>
                                </div>

                            </div>
                        </a>
                    </div>
                    <div class="peer">
                        <div class="mobile-toggle sidebar-toggle">
                            <a href="" class="td-n">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="black"
                                    class="bi bi-list" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                                </svg>
                            </a>
                            <!-- <div class="text-white">gfgdgdfg</div> -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- ### $Sidebar Menu ### -->
            <ul class="sidebar-menu scrollable pos-r">
                <li class="nav-item mT-30 actived">
                    <Link class="sidebar-link" href="/"><span class="icon-holder"><svg
                            xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-house-door" viewBox="0 0 16 16">
                            <path
                                d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z" />
                        </svg>
                    </span><span class="title">Dashboard</span></Link>
                </li>
                <!--TARGETS-->
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-bullseye" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                <path d="M8 13A5 5 0 1 1 8 3a5 5 0 0 1 0 10m0 1A6 6 0 1 0 8 2a6 6 0 0 0 0 12" />
                                <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6m0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8" />
                                <path d="M9.5 8a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                            </svg>
                        </span>
                        <span class="title">Targets</span>

                        <span class="arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-chevron-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
                            </svg>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <Link class="sidebar-link" :href="`/ipcrsemestral/${$page.props.auth.user.name.id}/direct`"
                                :class="{ 'active': $page.url === `/ipcrsemestral/${$page.props.auth.user.name.id}/direct` }">
                            <span class="title">IPCR Targets</span>
                            </Link>
                        </li>
                        <li>
                            <Link class="sidebar-link" href="/probationary/temporary/individual/targets/list"
                                :class="{ 'active': $page.url === '/probationary/temporary/individual/targets/list' }">
                            <span class="title">Probationary/Temporary</span>
                            </Link>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <Link class="sidebar-link" href="/Daily_Accomplishment"
                        :class="{ 'active': $page.url === `/Daily_Accomplishment` }">
                    <span></span>
                    <span class="icon-holder">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-calendar-event-fill" viewBox="0 0 16 16">
                            <path
                                d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2zm-3.5-7h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5z" />
                        </svg>
                    </span>
                    <span class="title">Daily Accomplishment</span>
                    </Link>
                </li>

                <li class="nav-item">
                    <Link class="sidebar-link" :class="{ 'active': $page.url === `/monthly-accomplishment` }"
                        href="/monthly-accomplishment">
                    <span></span>
                    <span class="icon-holder">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-clipboard-check-fill" viewBox="0 0 16 16">
                            <path
                                d="M6.5 0A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3Zm3 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3Z" />
                            <path
                                d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1A2.5 2.5 0 0 1 9.5 5h-3A2.5 2.5 0 0 1 4 2.5v-1Zm6.854 7.354-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708Z" />
                        </svg>
                    </span>
                    <span class="title">Accomplishment</span>
                    </Link>
                </li>
                <!-- $page.props.auth.user.salary_grade >= 18 -->
                <li class="nav-item" v-if="$page.props.auth.user.ao_status == '1' || ($page.props.auth.user.name.empl_id == '2960' || $page.props.auth.user.name.empl_id == '2730') || ($page.props.auth.user.name.empl_id == '8510' || $page.props.auth.user.name.empl_id == '8354'
                                || $page.props.auth.user.name.empl_id == '2003' || $page.props.auth.user.name.empl_id == '8447' || $page.props.auth.user.name.empl_id == '8753' || $page.props.auth.user.name.empl_id == '11159'
                            )">
                    <Link class="sidebar-link" :class="{ 'active': $page.url === `/summary-rating` }"
                        href="/summary-rating">
                    <span></span>
                    <span class="icon-holder">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-bar-chart-line-fill" viewBox="0 0 16 16">
                            <path
                                d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1z" />
                        </svg>
                    </span>
                    <span class="title">Summary of Ratings</span>
                    </Link>
                </li>


                <li class="nav-item"
                    v-if="$page.props.auth.user.name.empl_id == '2960' || $page.props.auth.user.name.empl_id == '2730' ||
                                $page.props.auth.user.name.empl_id == '2013' || $page.props.auth.user.name.empl_id == '9985'">
                    <Link class="sidebar-link" :class="{ 'active': $page.url === `/offices` }" href="/offices">
                    <span></span>
                    <span class="icon-holder">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-bank2" viewBox="0 0 16 16">
                            <path
                                d="M8.277.084a.5.5 0 0 0-.554 0l-7.5 5A.5.5 0 0 0 .5 6h1.875v7H1.5a.5.5 0 0 0 0 1h13a.5.5 0 1 0 0-1h-.875V6H15.5a.5.5 0 0 0 .277-.916zM12.375 6v7h-1.25V6zm-2.5 0v7h-1.25V6zm-2.5 0v7h-1.25V6zm-2.5 0v7h-1.25V6zM8 4a1 1 0 1 1 0-2 1 1 0 0 1 0 2M.5 15a.5.5 0 0 0 0 1h15a.5.5 0 1 0 0-1z" />
                        </svg>
                    </span>
                    <span class="title">Offices</span>
                    </Link>
                </li>
                <!-- <li class="nav-item">
                    <Link class="sidebar-link" :href="`/probationary/temporary`">
                        <span></span>
                        <span class="icon-holder">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard-check-fill" viewBox="0 0 16 16">
                            <path d="M6.5 0A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3Zm3 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3Z"/>
                            <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1A2.5 2.5 0 0 1 9.5 5h-3A2.5 2.5 0 0 1 4 2.5v-1Zm6.854 7.354-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708Z"/>
                            </svg>
                        </span>
                        <span class="title">Probationary/Temporary</span>
                    </Link>
                </li> -->

                <li class="nav-item"
                    v-if="$page.props.auth.user.name.department_code == '26' || $page.props.auth.user.name.department_code == '03'">
                    <Link class="sidebar-link" :href="`/probationary/`"
                        :class="{ 'active': $page.url === '/probationary/' }">
                    <span></span>
                    <span class="icon-holder">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-send-check-fill" viewBox="0 0 16 16">
                            <path
                                d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 1.59 2.498C8 14 8 13 8 12.5a4.5 4.5 0 0 1 5.026-4.47zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471z" />
                            <path
                                d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0m-1.993-1.679a.5.5 0 0 0-.686.172l-1.17 1.95-.547-.547a.5.5 0 0 0-.708.708l.774.773a.75.75 0 0 0 1.174-.144l1.335-2.226a.5.5 0 0 0-.172-.686" />
                        </svg>
                    </span>
                    <span class="title"> Probationary/Temporary </span>
                    </Link>
                </li>
                <!--
                <li class="nav-item mT-30 actived">
                    <Link class="sidebar-link" href="/"
                        ><span class="icon-holder">

                        </span
                        >
                        <span class="title">Personnel</span></Link
                    >
                </li>
                -->
                <!--
                <li class="nav-item">
                    <Link class="sidebar-link" href="/posts"
                        ><span class="icon-holder"
                            ><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-file-earmark-post" viewBox="0 0 16 16">
                              <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/>
                              <path d="M4 6.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-7zm0-3a.5.5 0 0 1 .5-.5H7a.5.5 0 0 1 0 1H4.5a.5.5 0 0 1-.5-.5z"/>
                            </svg>
                        </span
                        ><span class="title">Posts</span></Link
                    >
                </li>-->

                <!--ALL REPORTS-->


                <!--Users  -->
                <li class="nav-item" v-if="$page.props.auth.user.salary_grade >= 18">
                    <Link class="sidebar-link" href="/employees" :class="{ 'active': $page.url === '/employees' }">
                    <span></span>
                    <span class="icon-holder">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-people" viewBox="0 0 16 16">
                            <path
                                d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z" />
                        </svg>
                    </span>
                    <!-- {{ $page.props.auth.user.salary_grade }} -->
                    <span class="title">Employees </span>
                    </Link>
                </li>
                <!--Review/Approve-->
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-hand-thumbs-up-fill" viewBox="0 0 16 16">
                                <path
                                    d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z" />
                            </svg>
                        </span>
                        <span class="title">Review/Approve</span>
                        <span class="text-danger strong"
                            v-if="$page.props.auth.targets >= 1 || $page.props.auth.sem >= 1 || $page.props.auth.month >= 1">
                            <b>&nbsp;({{ $page.props.auth.targets + $page.props.auth.sem + $page.props.auth.month
                                }})</b>
                        </span>
                        <span class="arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-chevron-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
                            </svg>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="nav-item dropdown">
                            <a class="dropdown-toggle" href="javascript:void(0);">
                                <span class="title">Targets
                                    <span v-if="$page.props.auth.targets" class="text-danger strong"> <b>({{
                                $page.props.auth.targets }})</b> </span>
                                </span>
                                <span class="arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-chevron-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
                                    </svg>
                                </span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <Link class="sidebar-link" :href="`/review/approve`"
                                        :class="{ 'active': $page.url === `/review/approve` }">
                                    <span class="title">&nbsp;&nbsp;For Approval</span>
                                    </Link>
                                </li>
                                <li>
                                    <Link class="sidebar-link" :href="`/acted/particulars/targets`"
                                        :class="{ 'active': $page.url === `/acted/particulars/targets` }">
                                    <span class="title">&nbsp;&nbsp;Acted Target</span>
                                    </Link>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="dropdown-toggle" href="javascript:void(0);">
                                <span class="title">Accomplishment
                                    <span class="text-danger strong"
                                        v-if="$page.props.auth.sem >= 1 || $page.props.auth.month >= 1">
                                        <b>&nbsp;({{ $page.props.auth.sem +
                                $page.props.auth.month
                                            }})</b>
                                    </span>
                                </span>
                                <span class="arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-chevron-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
                                    </svg>
                                </span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <Link class="sidebar-link" :href="`/approve/accomplishments`"
                                        :class="{ 'active': $page.url === `/approve/accomplishments` }">
                                    <span class="title">&nbsp;&nbsp;Monthly
                                        <span v-if="$page.props.auth.month" class="text-danger strong"> <b>({{
                                $page.props.auth.month }})</b> </span>
                                    </span>
                                    </Link>
                                </li>
                                <li>
                                    <Link class="sidebar-link" :href="`/acted/particulars/accomp/lishments/monthly`"
                                        :class="{ 'active': $page.url === `/acted/particulars/accomp/lishments/monthly` }">
                                    <span class="title">&nbsp;&nbsp;Acted (monthly)</span>
                                    </Link>
                                </li>
                                <li>
                                    <Link class="sidebar-link" :href="`/approve/semestral-accomplishments`"
                                        :class="{ 'active': $page.url === `/approve/semestral-accomplishments` }">
                                    <span class="title">&nbsp;&nbsp;Semestral
                                        <span v-if="$page.props.auth.sem" class="text-danger strong"> <b>({{
                                $page.props.auth.sem }})</b> </span>
                                    </span>
                                    </Link>
                                </li>
                                <li>
                                    <Link class="sidebar-link" :href="`/acted/particulars/accomp/lishments`"
                                        :class="{ 'active': $page.url === `/acted/particulars/accomp/lishments` }">
                                    <span class="title">&nbsp;&nbsp;Acted (semestral)</span>
                                    </Link>8753
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <!--PERFORMANCE STANDARD-->
                <!--    -->
                <li class="nav-item dropdown" v-if="($page.props.auth.user.name.empl_id == '2960' || $page.props.auth.user.name.empl_id == '2730') || ($page.props.auth.user.name.empl_id == '8510' || $page.props.auth.user.name.empl_id == '8354'
                                || $page.props.auth.user.name.empl_id == '2003' || $page.props.auth.user.name.empl_id == '8447' || $page.props.auth.user.name.empl_id == '8753'|| $page.props.auth.user.name.empl_id == '2089'
                            )">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-menu-button-wide-fill" viewBox="0 0 16 16">
                                <path
                                    d="M1.5 0A1.5 1.5 0 0 0 0 1.5v2A1.5 1.5 0 0 0 1.5 5h13A1.5 1.5 0 0 0 16 3.5v-2A1.5 1.5 0 0 0 14.5 0zm1 2h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1 0-1m9.927.427A.25.25 0 0 1 12.604 2h.792a.25.25 0 0 1 .177.427l-.396.396a.25.25 0 0 1-.354 0zM0 8a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm1 3v2a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2zm14-1V8a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v2zM2 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0 4a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5" />
                            </svg>
                        </span>
                        <span class="title">Utilities</span>

                        <span class="arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-chevron-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
                            </svg>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- v-if="$page.props.auth.user.name.empl_id==='2960' || $page.props.auth.user.name.empl_id==='2730'
                            $page.props.auth.user.name.empl_id==='8510' || $page.props.auth.user.name.empl_id==='8354'" -->
                        <li
                            v-if="$page.props.auth.user.name.empl_id != '2003' && $page.props.auth.user.name.empl_id != '8447' && $page.props.auth.user.name.empl_id != '8753'">
                            <Link class="sidebar-link" :href="`/imports/performance/standard`"
                                :class="{ 'active': $page.url === `/imports/performance/standard` }">
                            <span class="title">Performance Standard </span>
                            </Link>
                        </li>
                        <li
                            v-if="$page.props.auth.user.name.empl_id != '2003' && $page.props.auth.user.name.empl_id != '8447' && $page.props.auth.user.name.empl_id != '8753'">
                            <Link class="sidebar-link" :href="`/ipcr/score`"
                                :class="{ 'active': $page.url === `/ipcr/score` }">
                            <span class="title">Ratings</span>
                            </Link>
                        </li>
                        <li
                            v-if="$page.props.auth.user.name.empl_id != '2003' && $page.props.auth.user.name.empl_id != '8447' && $page.props.auth.user.name.empl_id != '8753'">
                            <Link class="sidebar-link" :href="`/individual-final-output-crud`"
                                :class="{ 'active': $page.url === `/individual-final-output-crud` }">
                            <span class="title">Individual Final Outputs</span>
                            </Link>
                        </li>
                        <!-- $usn = '2960' || $usn = '2730' -->
                        <li
                            v-if="$page.props.auth.user.name.empl_id != '2003' && $page.props.auth.user.name.empl_id != '8447' && $page.props.auth.user.name.empl_id != '8753'">
                            <Link class="sidebar-link" :href="`/employee/special/department`"
                                :class="{ 'active': $page.url === `/employee/special/department` }">
                            <span class=" title">Employees Special Department</span>
                            </Link>
                        </li>
                        <li v-if="$page.props.auth.user.name.empl_id == '8510' || $page.props.auth.user.name.empl_id == '8354' ||
                        $page.props.auth.user.name.empl_id == '2960' || $page.props.auth.user.name.empl_id == '2730'
                                || $page.props.auth.user.name.empl_id == '2003' || $page.props.auth.user.name.empl_id == '8447' || $page.props.auth.user.name.empl_id == '8753' || $page.props.auth.user.name.empl_id == '2089'
                                ">
                            <Link class="sidebar-link" :href="`/employees/all`"
                                :class="{ 'active': $page.url === `/employees/all` }">
                            <span class="title">Employees</span>
                            </Link>
                        </li>
                        <!-- <li v-if="$page.props.auth.user.name.empl_id == '8510' || $page.props.auth.user.name.empl_id == '8354' ||
                        $page.props.auth.user.name.empl_id == '2960' || $page.props.auth.user.name.empl_id == '2730'
                                || $page.props.auth.user.name.empl_id == '2003' || $page.props.auth.user.name.empl_id == '8447' || $page.props.auth.user.name.empl_id == '8753' || $page.props.auth.user.name.empl_id == '2089'
                                ">
                            <Link @click="gotoemp" class="sidebar-link clickable" :href="`/employees/all`"
                                :class="{ 'active': $page.url === `/employees/all` }"
                                ><span class="title">Employees</span></Link>
                        </li> -->
                        <li >
                            <Link class="sidebar-link" :href="`/password/change/log`"
                                :class="{ 'active': $page.url === `/password/change/log` }"
                                v-if="$page.props.auth.user.name.empl_id == '8510' || $page.props.auth.user.name.empl_id == '8354' ">
                            <!-- || $page.props.auth.user.name.empl_id == '2003' || $page.props.auth.user.name.empl_id == -->
                            <!-- '8447' || $page.props.auth.user.name.empl_id == '8753' -->
                            <span class="title">Password Change Log</span>
                            </Link>
                        </li>
                        <li>
                            <Link class="sidebar-link" :href="`/email/log`"
                                :class="{ 'active': $page.url === `/email/log` }"
                                v-if="$page.props.auth.user.name.empl_id == '8510' || $page.props.auth.user.name.empl_id == '8354'">
                            <!-- || $page.props.auth.user.name.empl_id == '2003' || $page.props.auth.user.name.empl_id == -->
                            <!-- '8447' || $page.props.auth.user.name.empl_id == '8753' -->
                            <span class="title">Email Change Log</span>
                            </Link>
                        </li>
                        <li v-if="$page.props.auth.user.name.empl_id == '8510' || $page.props.auth.user.name.empl_id == '8354'
                                || $page.props.auth.user.name.empl_id == '2003' || $page.props.auth.user.name.empl_id == '8447' || $page.props.auth.user.name.empl_id == '8753'
                                ">
                            <Link class="sidebar-link" :href="`/offices`"
                                :class="{ 'active': $page.url === `/offices` }">
                            <span class="title">Offices</span>
                            </Link>
                        </li>
                    </ul>


                </li>
                <li class="nav-item">
                    <Link class="sidebar-link" href="/IPCR_Tracking"
                        :class="{ 'active': $page.url === `/IPCR_Tracking` }">
                    <span></span>
                    <span class="icon-holder">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-list-check" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3.854 2.146a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 3.293l1.146-1.147a.5.5 0 0 1 .708 0m0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 7.293l1.146-1.147a.5.5 0 0 1 .708 0m0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0" />
                        </svg>
                    </span>
                    <span class="title">IPCR Tracking</span>
                    </Link>
                </li>
                <!--************-->
            </ul>
        </div>
    </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';


export default {
    mounted() {
        $(function () {
            $(".sidebar .sidebar-menu li a").on("click", function () {
                const $this = $(this);

                if ($this.parent().hasClass("open")) {
                    $this
                        .parent()
                        .children(".dropdown-menu")
                        .slideUp(200, () => {
                            $this.parent().removeClass("open");
                        });
                } else {
                    $this
                        .parent()
                        .parent()
                        .children("li.open")
                        .children(".dropdown-menu")
                        .slideUp(200);

                    $this
                        .parent()
                        .parent()
                        .children("li.open")
                        .children("a")
                        .removeClass("open");

                    $this
                        .parent()
                        .parent()
                        .children("li.open")
                        .removeClass("open");

                    $this
                        .parent()
                        .children(".dropdown-menu")
                        .slideDown(200, () => {
                            $this.parent().addClass("open");
                        });
                }
            });

            // Sidebar Activity Class
            const sidebarLinks = $(".sidebar").find(".sidebar-link");

            sidebarLinks
                .each((index, el) => {
                    $(el).removeClass("active");
                })
                .filter(function () {
                    const href = $(this).attr("href");
                    const pattern = href[0] === "/" ? href.substr(1) : href;
                    return pattern === window.location.pathname.substr(1);
                })
                .addClass("active");

            // ٍSidebar Toggle
            $(".sidebar-toggle").on("click", (e) => {
                $("body").toggleClass("is-collapsed");
                e.preventDefault();
            });

        });
    },
    methods: {
        gotoemp() {
            // alert('my_id: '+my_id+" "+empl_id);
            // alert("go to")
            Inertia.get("/employees/a/l/l")
            // {
                // params: {
                //     sem_id: my_id,
                //     empl_id: empl_id
                // }
            // }).then((response) => {
            //     // this.ipcr_targets = response.data;
            // }).catch((error) => {
            //     // console.error(error);
            // });
            // this.displayModal = true;

        },
    }
}
</script>
<style scoped>
.clickable {
  display: inline-block;
  padding: 10px 20px;
  background-color: #007bff;
  color: white;
  text-align: center;
  border-radius: 5px;
  cursor: pointer;
  user-select: none; /* Prevent text selection */
}
/* .clickable:hover {
  background-color: #0056b3;
} */
</style>
