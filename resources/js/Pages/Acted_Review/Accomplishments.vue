<template>

    <Head>
        <title>Home</title>
    </Head>

    <!--<p style="text-align: justify;">Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit amet consectetur.
    </p>-->
    <div class="row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <!--SEMESTRAL***************************************************************************************-->
            <h3>Acted Semestral Accomplishments</h3>
            <div class="peers">
                <div class="peer mR-10">
                    <input v-model="search" type="text" class="form-control form-control-sm" placeholder="Search...">
                </div>
            </div>

        </div>


        <div class="masonry-sizer col-md-6"></div>
        <div class="masonry-item w-100">
            <div class="row gap-20"></div>
            <div class="bgc-white p-20 bd">
                <div class="table-responsive">
                    <table class="table table-sm table-borderless table-striped table-hover">
                        <thead>
                            <tr class="bg-secondary text-white">
                                <th style="width:15%">Name</th>
                                <th style="width:10%">Period</th>
                                <th style="width:18%">Status</th>
                                <th style="width:35%">Remarks</th>
                                <th style="width:15%">Date Acted</th>
                                <!-- <th style="width:50%">Type</th> -->
                                <th style="width:7%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--  -->
                            <template v-for="dat in data.data">
                                <tr :style="{ backgroundColor: getRowColorActed(dat.type) }">
                                    <td>
                                        {{ dat.employee_name }}
                                    </td>
                                    <td>
                                        <div v-if="dat.ipcr_monthly_accomplishment_id !== null">
                                            {{ getMonthName(dat.month) }}, {{ dat.year }}
                                        </div>
                                        <div v-if="dat.ipcr_monthly_accomplishment_id == null">
                                            {{ getPeriod(dat.sem, dat.year) }}
                                        </div>
                                    </td>
                                    <td>
                                        {{ Status(dat.a_status) }} <br>
                                        (<b>Action:&nbsp;</b>{{ getActivityType(dat.type) }})
                                    </td>
                                    <td>
                                        {{ dat.remarks }}
                                        <!-- {{ dat.immediate }} -->
                                    </td>
                                    <td>{{ formatDateTimeDTS(dat.created_at) }}</td>
                                    <td>
                                        <div class="dropdown dropstart">
                                            <button class="btn btn-secondary btn-sm action-btn" type="button"
                                                id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                                    <path
                                                        d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                                                </svg>
                                            </button>
                                            <ul class="dropdown-menu action-dropdown"
                                                aria-labelledby="dropdownMenuButton1">
                                                <li>
                                                    <button class="dropdown-item" @click="showModal(dat.ipcr_semestral_id,
                        dat.empl_id,
                        dat.employee_name,
                        dat.year,
                        dat.sem,
                        dat.a_status,
                        dat.accomp_id,
                        dat.month,
                        dat.position,
                        dat.office,
                        dat.division,
                        dat.immediate,
                        dat.next_higher,
                        dat.ipcr_semestral_id,
                        dat.employment_type_descr,
                        dat.type,
                        dat.pgHead
                    )">
                                                        View Submission
                                                    </button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item"
                                                        @click="viewDailyAccomplishments(dat.empl_id, dat.sem, dat.year)">
                                                        View Daily Accomplishments
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </template>

                        </tbody>
                    </table>
                    <pagination :next="data.next_page_url" :prev="data.prev_page_url" />
                </div>
            </div>
        </div>

        <LoadingOverlay
            :active="isLoading"
            :is-full-page="true"
            :can-cancel="false"
            loader="bars"
            />
        <Modal v-if="displayModal" @close-modal-event="hideModal" >

            <div class="justify-content-center">

                <!-- ********************************************** -->
                <div class="justify-content-center">
                    <div style="text-align: center">
                        <h4>IPCR Accomplishment Modal</h4>
                    </div>
                    <br>
                    <div><b>Employee Name: </b><u>{{ emp_name }}</u></div>
                    <div>
                        <b>Semester/Period: </b>
                        <u>
                            <span v-if="emp_sem === '1'">First Semester -January to June, </span>
                            <span v-if="emp_sem === '2'">Second Semester -July to December, </span>
                            {{ emp_year }}
                            <!-- {{ emp_status }} -->
                        </u>
                    </div>
                    <div>
                        <b>Status: </b>
                        <u>
                            <span v-if="emp_status.toString() === '0'">Submitted</span>
                            <span v-if="emp_status.toString() === '1'">Reviewed</span>
                        </u>
                    </div>
                    <!-- {{ ipcr_accomplishments_review }} -->
                    <div class="masonry-item w-100" >

                        <div class="row gap-20"></div>
                        <div class="bgc-white p-20 bd">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered border-dark table-hover">
                                    <thead>
                                        <tr style="background-color: #B7DEE8;" class="text-center table-bordered">
                                            <th style="width: 15%;" rowspan="2" colspan="1">
                                                {{ ipcr_accomplishments_review.form_type }}
                                                <span v-if="ipcr_accomplishments_review.form_type=='emp' || ipcr_accomplishments_review.form_type=='emp'">Individual Output</span>
                                                <span>Division Output</span>
                                                <span>Section Output</span>
                                                <span>Section Output</span>
                                            </th>
                                            <th style="width: 30%;" rowspan="2" colspan="1">Success Indicator</th>
                                            <th style="width: 20%;" colspan="4">Rating</th>
                                            <th style="width: 20%;" rowspan="2" colspan="1">Remarks</th>
                                            <th rowspan="2" colspan="1"></th>
                                        </tr>
                                        <tr style="background-color: #B7DEE8;" class="text-center">
                                            <th style="width: 5%;">Quality Rating</th>
                                            <th style="width: 5%;">Efficiency Rating</th>
                                            <th style="width: 5%;">Timeliness Rating</th>
                                            <th style="width: 5%;">Average</th>
                                        </tr>
                                        <tr>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="8">
                                                <b>CORE FUNCTION</b>
                                            </td>
                                        </tr>
                                        <template v-for="(dat, index) in ipcr_accomplishments_review.data" :key="index">
                                            <tr v-if="dat.ipcr_type === 'Core Function'"
                                            :class="{ opened: opened.includes(dat.individual_output) }" class="text-center">
                                                <td @click="toggle(dat.individual_output, index)"
                                                style="cursor: pointer; background-color: lightblue">{{ dat.individual_output }}</td>
                                                <td>{{ dat.efficiency1 == "Yes"? dat.performance_measure + " " + dat.individual_output + " with a satisfactory rating for quality/effectiveness and satisfactory in efficiency within " + dat.prescribed_period : dat.performance_measure + " " + dat.individual_output + " with a satisfactory rating for quality/effectiveness and satisfactory in efficiency on or before " + dat.timeliness }}</td>
                                                <td>
                                                    {{ QualityRateSem(dat.avg_q1, dat.avg_q2, dat.avg_q3) }}
                                                </td>
                                                <td>
                                                    {{ EfficiencyRateSem(dat.avg_e1, dat.avg_e2, dat.avg_e3)}}
                                                </td>

                                                <td>{{ dat.timeliness == "No" ? "Not to be Rated" : dat.avg_t1}}
                                                </td>
                                                <td>{{ AverageComputationSem(QualityRateSem(dat.avg_q1, dat.avg_q2, dat.avg_q3), EfficiencyRateSem(dat.avg_e1, dat.avg_e2, dat.avg_e3), dat.timeliness == "No" ? 0 : dat.avg_t1 ) }}
                                                </td>
                                                <td v-html="dat.target_remarks ? dat.target_remarks + '<br>' + dat.remarks : dat.remarks"></td>
                                                <td><button v-if="dat.remarks == ''" class="btn btn-primary btn-sm mL-2 text-white"
                                                        @click="showModal2(dat.individual_output_id, dat.sem_id, dat.result[0].year)">Add
                                                        Remarks</button>
                                                    <button v-else class="btn btn-primary btn-sm mL-2 text-white"
                                                        @click="showModal3(dat.individual_output_id, dat.sem_id, dat.remarks, dat.remarks_id)">Edit/Delete
                                                        Remarks</button>
                                                </td>

                                            </tr>
                                            <tr v-if="opened.includes(dat.individual_output) && dat.ipcr_type === 'Core Function'">
                                                <td colspan="8" class="background-white">
                                                    <Transition name="bounce">
                                                        <p v-if="show[index]">
                                                        <table
                                                            class="table-responsive full-width table-bordered border-dark text-center">
                                                            <tbody>
                                                                <tr>
                                                                    <th class="text-white text-center "
                                                                        style="background-color: #727272;" colspan="31">
                                                                        <h6>&nbsp;&nbsp;Accomplishment</h6>
                                                                    </th>
                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr>
                                                                    <th colspan="3" style="text-align: center;">Quality/Effectiveness</th>
                                                                    <th colspan="3" style="text-align: center;">Efficiency</th>
                                                                    <th rowspan="1" style="text-align: center;">Timeliness</th>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding: 0;">
                                                                        <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                            <tr>
                                                                                <td colspan="6" style="border: 1px solid #000;">{{ dat.quality1 }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[0].q1 == null ? 0 : dat.result[0].q1}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[1].q1 == null ? 0 : dat.result[1].q1}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[2].q1 == null ? 0 : dat.result[2].q1}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[3].q1 == null ? 0 : dat.result[3].q1}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[4].q1 == null ? 0 : dat.result[4].q1}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[5].q1 == null ? 0 : dat.result[5].q1}}</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td style="padding: 0;">
                                                                        <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                            <tr>
                                                                                <td colspan="6" style="border: 1px solid #000;">{{ dat.quality2 }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[0].q2 == null ? 0 : dat.result[0].q2}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[1].q2 == null ? 0 : dat.result[1].q2}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[2].q2 == null ? 0 : dat.result[2].q2}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[3].q2 == null ? 0 : dat.result[3].q2}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[4].q2 == null ? 0 : dat.result[4].q2}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[5].q2 == null ? 0 : dat.result[5].q2}}</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td style="padding: 0;">
                                                                        <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                            <tr>
                                                                                <td colspan="6" style="border: 1px solid #000;">{{ dat.quality3 }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[0].q3 == null ? 0 : dat.result[0].q3}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[1].q3 == null ? 0 : dat.result[1].q3}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[2].q3 == null ? 0 : dat.result[2].q3}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[3].q3 == null ? 0 : dat.result[3].q3}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[4].q3 == null ? 0 : dat.result[4].q3}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[5].q3 == null ? 0 : dat.result[5].q3}}</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td style="padding: 0;">
                                                                        <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                            <tr>
                                                                                <td colspan="6" style="border: 1px solid #000;">{{ "Standard Response Time" }}</td>
                                                                            </tr>
                                                                            <tr v-if="dat.efficiency1 === 'No'">
                                                                                <td colspan="6" style="border: 1px solid #000; text-align: center;">Not to be Rated</td>
                                                                            </tr>

                                                                            <tr v-else>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[1].e1 == null ? 0 : dat.result[1].e1}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[0].e1 == null ? 0 : dat.result[0].e1}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[2].e1 == null ? 0 : dat.result[2].e1}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[3].e1 == null ? 0 : dat.result[3].e1}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[4].e1 == null ? 0 : dat.result[4].e1}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[5].e1 == null ? 0 : dat.result[5].e1}}</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td style="padding: 0;">
                                                                        <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                            <tr>
                                                                                <td colspan="6" style="border: 1px solid #000;">{{ "Quantity Based" }}</td>
                                                                            </tr>
                                                                            <tr v-if="dat.efficiency2 === 'No'">
                                                                                <td colspan="6" style="border: 1px solid #000; text-align: center;">Not to be Rated</td>
                                                                            </tr>

                                                                            <tr v-else>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[1].e2 == null ? 0 : dat.result[1].e2}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[0].e2 == null ? 0 : dat.result[0].e2}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[2].e2 == null ? 0 : dat.result[2].e2}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[3].e2 == null ? 0 : dat.result[3].e2}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[4].e2 == null ? 0 : dat.result[4].e2}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[5].e2 == null ? 0 : dat.result[5].e2}}</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td style="padding: 0;">
                                                                        <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                            <tr>
                                                                                <td colspan="6" style="border: 1px solid #000;">{{ "Optimum use of resources" }}</td>
                                                                            </tr>
                                                                            <tr v-if="dat.efficiency3 === 'No'">
                                                                                <td colspan="6" style="border: 1px solid #000; text-align: center;">Not to be Rated</td>
                                                                            </tr>

                                                                            <tr v-else>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[1].e3 == null ? 0 : dat.result[1].e3}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[0].e3 == null ? 0 : dat.result[0].e3}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[2].e3 == null ? 0 : dat.result[2].e3}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[3].e3 == null ? 0 : dat.result[3].e3}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[4].e3 == null ? 0 : dat.result[4].e3}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[5].e3 == null ? 0 : dat.result[5].e3}}</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td style="padding: 0;">
                                                                        <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                            <tr>
                                                                                <td colspan="6" style="border: 1px solid #000;">{{ "Timeliness" }}</td>
                                                                            </tr>
                                                                            <tr v-if="dat.timeliness === 'No'">
                                                                                <td colspan="6" style="border: 1px solid #000; text-align: center;">Not to be Rated</td>
                                                                            </tr>

                                                                            <tr v-else>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[1].time == null ? 0 : dat.result[1].time}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[0].time == null ? 0 : dat.result[0].time}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[2].time == null ? 0 : dat.result[2].time}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[3].time == null ? 0 : dat.result[3].time}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[4].time == null ? 0 : dat.result[4].time}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[5].time == null ? 0 : dat.result[5].time}}</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                        </p>
                                                    </Transition>
                                                </td>
                                            </tr>

                                        </template>
                                        <tr>
                                            <td colspan="7">
                                                <b style="float:right">Average Point Score - Core Function</b>
                                            </td>
                                            <td>
                                                {{ Average_Point_Core }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7">
                                                <b style="float:right">Multiply by Weighted Allocation</b>
                                            </td>
                                            <td>
                                                70%
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7">
                                                <b style="float:right">Weighted Average Score - Core Function</b>
                                            </td>
                                            <td>
                                                {{ (Average_Point_Core * .70).toFixed(2) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">
                                                <b>Support FUNCTION </b>
                                            </td>
                                        </tr>
                                        <template v-for="(dat, index) in ipcr_accomplishments_review.data" :key="index">
                                            <tr v-if="dat.ipcr_type === 'Support Function'"
                                            :class="{ opened: opened.includes(dat.individual_output) }" class="text-center">
                                                <td @click="toggle(dat.individual_output, index)"
                                                style="cursor: pointer; background-color: lightblue">{{ dat.individual_output }}</td>
                                                <td>{{ dat.efficiency1 == "Yes"? dat.performance_measure + " " + dat.individual_output + " with a satisfactory rating for quality/effectiveness and satisfactory in efficiency within " + dat.prescribed_period : dat.performance_measure + " " + dat.individual_output + " with a satisfactory rating for quality/effectiveness and satisfactory in efficiency on or before " + dat.timeliness }}</td>
                                                <td>
                                                    {{ QualityRateSem(dat.avg_q1, dat.avg_q2, dat.avg_q3) }}
                                                </td>
                                                <td>
                                                    {{ EfficiencyRateSem(dat.avg_e1, dat.avg_e2, dat.avg_e3)}}
                                                </td>

                                                <td>{{ dat.timeliness == "No" ? "Not to be Rated" : dat.avg_t1 }}
                                                </td>
                                                <td>{{ AverageComputationSem(QualityRateSem(dat.avg_q1, dat.avg_q2, dat.avg_q3), EfficiencyRateSem(dat.avg_e1, dat.avg_e2, dat.avg_e3), dat.timeliness == "No" ? 0 : dat.avg_t1 )}}
                                                </td>
                                                <td v-html="dat.target_remarks ? dat.target_remarks + '<br>' + dat.remarks : dat.remarks"></td>
                                                <td><button v-if="dat.remarks == ''" class="btn btn-primary btn-sm mL-2 text-white"
                                                        @click="showModal2(dat.ipcr_code, dat.sem_id, dat.result[0].year)">Add
                                                        Remarks</button>
                                                    <button v-else class="btn btn-primary btn-sm mL-2 text-white"
                                                        @click="showModal3(dat.ipcr_code, dat.sem_id, dat.remarks, dat.remarks_id)">Edit/Delete
                                                        Remarks</button>
                                                </td>

                                            </tr>
                                            <tr v-if="opened.includes(dat.individual_output) && dat.ipcr_type === 'Support Function'">
                                                <td colspan="8" class="background-white">
                                                    <Transition name="bounce">
                                                        <p v-if="show[index]">
                                                        <table
                                                            class="table-responsive full-width table-bordered border-dark text-center">
                                                            <tbody>
                                                                <tr>
                                                                    <th class="text-white text-center "
                                                                        style="background-color: #727272;" colspan="31">
                                                                        <h6>&nbsp;&nbsp;Accomplishment</h6>
                                                                    </th>
                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr>
                                                                    <th colspan="3" style="text-align: center;">Quality/Effectiveness</th>
                                                                    <th colspan="3" style="text-align: center;">Efficiency</th>
                                                                    <th rowspan="1" style="text-align: center;">Timeliness</th>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding: 0;">
                                                                        <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                            <tr>
                                                                                <td colspan="6" style="border: 1px solid #000;">{{ dat.quality1 }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[0].q1 == null ? 0 : dat.result[0].q1}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[1].q1 == null ? 0 : dat.result[1].q1}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[2].q1 == null ? 0 : dat.result[2].q1}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[3].q1 == null ? 0 : dat.result[3].q1}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[4].q1 == null ? 0 : dat.result[4].q1}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[5].q1 == null ? 0 : dat.result[5].q1}}</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td style="padding: 0;">
                                                                        <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                            <tr>
                                                                                <td colspan="6" style="border: 1px solid #000;">{{ dat.quality2 }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[0].q2 == null ? 0 : dat.result[0].q2}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[1].q2 == null ? 0 : dat.result[1].q2}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[2].q2 == null ? 0 : dat.result[2].q2}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[3].q2 == null ? 0 : dat.result[3].q2}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[4].q2 == null ? 0 : dat.result[4].q2}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[5].q2 == null ? 0 : dat.result[5].q2}}</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td style="padding: 0;">
                                                                        <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                            <tr>
                                                                                <td colspan="6" style="border: 1px solid #000;">{{ dat.quality3 }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[0].q3 == null ? 0 : dat.result[0].q3}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[1].q3 == null ? 0 : dat.result[1].q3}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[2].q3 == null ? 0 : dat.result[2].q3}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[3].q3 == null ? 0 : dat.result[3].q3}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[4].q3 == null ? 0 : dat.result[4].q3}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[5].q3 == null ? 0 : dat.result[5].q3}}</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td style="padding: 0;">
                                                                        <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                            <tr>
                                                                                <td colspan="6" style="border: 1px solid #000;">{{ "Standard Response Time" }}</td>
                                                                            </tr>
                                                                            <tr v-if="dat.efficiency1 === 'No'">
                                                                                <td colspan="6" style="border: 1px solid #000; text-align: center;">Not to be Rated</td>
                                                                            </tr>

                                                                            <tr v-else>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[1].e1 == null ? 0 : dat.result[1].e1 }}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[0].e1 == null ? 0 : dat.result[0].e1 }}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[2].e1 == null ? 0 : dat.result[2].e1 }}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[3].e1 == null ? 0 : dat.result[3].e1 }}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[4].e1 == null ? 0 : dat.result[4].e1 }}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[5].e1 == null ? 0 : dat.result[5].e1 }}</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td style="padding: 0;">
                                                                        <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                            <tr>
                                                                                <td colspan="6" style="border: 1px solid #000;">{{ "Quantity Based" }}</td>
                                                                            </tr>
                                                                            <tr v-if="dat.efficiency2 === 'No'">
                                                                                <td colspan="6" style="border: 1px solid #000; text-align: center;">Not to be Rated</td>
                                                                            </tr>

                                                                            <tr v-else>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[1].e2 == null ? 0 : dat.result[1].e2}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[0].e2 == null ? 0 : dat.result[0].e2}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[2].e2 == null ? 0 : dat.result[2].e2}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[3].e2 == null ? 0 : dat.result[3].e2}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[4].e2 == null ? 0 : dat.result[4].e2}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[5].e2 == null ? 0 : dat.result[5].e2}}</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td style="padding: 0;">
                                                                        <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                            <tr>
                                                                                <td colspan="6" style="border: 1px solid #000;">{{ "Optimum use of resources" }}</td>
                                                                            </tr>
                                                                            <tr v-if="dat.efficiency3 === 'No'">
                                                                                <td colspan="6" style="border: 1px solid #000; text-align: center;">Not to be Rated</td>
                                                                            </tr>

                                                                            <tr v-else>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[1].e3 == null ? 0 : dat.result[1].e3}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[0].e3 == null ? 0 : dat.result[0].e3}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[2].e3 == null ? 0 : dat.result[2].e3}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[3].e3 == null ? 0 : dat.result[3].e3}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[4].e3 == null ? 0 : dat.result[4].e3}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[5].e3 == null ? 0 : dat.result[5].e3}}</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td style="padding: 0;">
                                                                        <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                            <tr>
                                                                                <td colspan="6" style="border: 1px solid #000;">{{ "Timeliness" }}</td>
                                                                            </tr>
                                                                            <tr v-if="dat.timeliness === 'No'">
                                                                                <td colspan="6" style="border: 1px solid #000; text-align: center;">Not to be Rated</td>
                                                                            </tr>

                                                                            <tr v-else>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[1].time == null ? 0 : dat.result[1].time}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[0].time == null ? 0 : dat.result[0].time}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[2].time == null ? 0 : dat.result[2].time}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[3].time == null ? 0 : dat.result[3].time}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[4].time == null ? 0 : dat.result[4].time}}</td>
                                                                                <td style="border: 1px solid #000;">{{ dat.result[5].time == null ? 0 : dat.result[5].time}}</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                        </p>
                                                    </Transition>
                                                </td>
                                            </tr>
                                        </template>

                                        <tr>
                                            <td colspan="7">
                                                <b style="float:right">Average Point Score - Support Function</b>
                                            </td>
                                            <td>
                                                {{ Average_Point_Support }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7">
                                                <b style="float:right">Multiply by Weighted Allocation</b>
                                            </td>
                                            <td>
                                                30%
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7">
                                                <b style="float:right">Weighted Average Score - Support Function</b>
                                            </td>
                                            <td>
                                                {{ (Average_Point_Support * .30).toFixed(2) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7">
                                                <b style="float:right">Total Average Score</b>
                                            </td>
                                            <td>
                                                {{ getAdjectivalScoreSemestral(Average_Point_Core * 0.70, Average_Point_Support * 0.30)}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7">
                                                <b style="float:right">Additional Point Intervening Factor - if applicable -
                                                    Maximum: 0.5 pts</b>
                                            </td>
                                            <td>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7">
                                                <b style="float:right">Total Final Average Rating</b>
                                            </td>
                                            <td style="background-color: yellow">
                                                <b>{{
                                                    getAdjectivalScoreSemestral(Average_Point_Core * 0.70, Average_Point_Support * 0.30)
                                                    }}</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7">
                                                <b style="float:right">Final Adjectival Rating</b>
                                            </td>
                                            <td style="background-color: yellow">
                                                <b>{{ getAdjectivalRatingSem(getAdjectivalScoreSemestral(Average_Point_Core * 0.70,
                                                    Average_Point_Support * 0.30)) }}</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">
                                                <b>Supervisor's comments and recommendations for development purposes or
                                                    Rewards/Promotion</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">
                                                <!-- {{ sem_data.remarks }}<br>{{ sem_data.remarkshigher }} -->
                                                <span v-if="sem_data.remarks">{{ sem_data.remarks.remarks }}</span>
                                                <br>
                                                <span v-if="sem_data.remarkshigher">{{ sem_data.remarkshigher.remarks }}</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- <div>
                                <b>Remarks:</b>
                                <input type="text" v-model="form.remarks" class="form-control" autocomplete="chrome-off"><br>
                            </div> -->
                            <!-- <div style="align: center">
                                <span v-if="imm_id_loc === nxt_id_loc">
                                    <button class="btn btn-primary text-white" @click="submitAction('2')">
                                        Approve
                                    </button>&nbsp;
                                </span>
                                <span v-else>
                                    <button class="btn btn-primary text-white" @click="submitAction('1')"
                                        v-if="emp_status.toString() === '0'">
                                        Review
                                    </button>
                                    <button class="btn btn-primary text-white" @click="submitAction('2')"
                                        v-if="emp_status.toString() === '1'">
                                        Approve
                                    </button>&nbsp;
                                    <button class="btn btn-primary text-white" @click="submitAction('3')"
                                        v-if="emp_status.toString() === '2'">
                                        Final Approve
                                    </button>&nbsp;
                                </span>


                                <button style="float: right" class="btn btn-danger text-white" @click="submitAction('-2')">
                                    Return
                                </button>
                            </div> -->
                        </div>
                    </div>
                </div>
                <!-- ******************************************** -->
                <div>
                    <b>Remarks:</b>
                    <input type="text" v-model="form.remarks" class="form-control" autocomplete="chrome-off"><br>
                </div>
                <div style="align: center">
                    <!-- <button class="btn btn-primary text-white" @click="submitAction('1')"
                        v-if="emp_status.toString() === '0'">
                        Review
                    </button>
                    <button class="btn btn-primary text-white" @click="submitAction('2')"
                        v-if="emp_status.toString() === '1'">
                        Approve
                    </button>&nbsp;
                    <button class="btn btn-primary text-white" @click="submitAction('3')"
                        v-if="emp_status.toString() === '2'">
                        Final Approve
                    </button>&nbsp; -->

                    <button class="btn btn-danger text-white" @click="submitAction('-2')"
                        v-if="type_selected !== 'return semestral accomplishment'">
                        Return
                    </button>
                </div>
            </div>
        </Modal>
        <ModalDaily v-if="displayModalDaily" @close-modal-event="hideModalDaily">
            <div class="d-flex justify-content-center">
                <iframe :src="my_link" style="width:100%; height:450px" />
            </div>
        </ModalDaily>
        <!-- {{ data }} -->
    </div>
</template>
<script>
import { useForm } from "@inertiajs/inertia-vue3";
import Filtering from "@/Shared/Filter";
import Pagination from "@/Shared/Pagination";
import Modal from "@/Shared/PrintModal";
import Modal2 from "@/Shared/PrintModal";
import Modal3 from "@/Shared/PrintModal";
import ModalDaily from "@/Shared/PrintModal";
import { inject } from 'vue';


export default {
    props: {
        data: Object,
        targets: Object,
        pghead: Object,
        filters: Object,
    },
    computed: {
        quantityArray() {
            // Parse the quantity values as arrays
            const allArrays = this.ipcr_targets.map(target => JSON.parse(target.quantity));
            const mergedArray = [].concat(...allArrays);
            var quant = JSON.parse(this.ipcr_targets[0].quantity)
            // const cleanedString = this.ipcr_targets[0].quantity.replace(/[\[\]]/g, '');
            // const numberArray = cleanedString.split(',').map(Number);
            // this.length = this.ipcr_targets[0].length
            // return Array.from(new Set(mergedArray));
            return mergedArray
        },
    },
    data() {
        return {
            my_link: "",
            displayModal: false,
            modal_title: "Add",
            ipcr_targets: [],
            ipcr_accomplishments: [],
            ipcr_accomplishments_review: [],
            sem_data: [],
            core_support: [],

            emp_sem_id: "",
            emp_name: "",
            emp_year: "",
            emp_sem: "",
            emp_status: "",
            empl_id: "",
            displayModal2: false,
            displayModal3: false,
            displayModalDaily: false,
            length: 0,
            type_selected: "",
            pg_head: "",
            form: useForm({
                type: "",
                remarks: "",
                ipcr_semestral_id: "",
                employee_code: ""
            }),
            search: this.$props.filters.search,

            // FOR MODAL
            opened: [],
            show: [],
            isLoading: false,
        }
    },
    watch: {
        search: _.debounce(function (value) {
            this.$inertia.get(
                "/acted/particulars/accomp/lishments/",
                { search: value },
                {
                    preserveScroll: true,
                    preserveState: true,
                    replace: true,
                }
            );
        }, 300),
    },
    components: {
        Pagination, Filtering, Modal, Modal2, Modal3, ModalDaily
    },
    inject: ['showLoading', 'hideLoading'],
    methods: {

        toggle(id, i) {
            // alert(this.data.length);
            // for (var x = 0; x < this.data.length; x++) {
            //     this.$('#collapse-b' + x).removeClass('show');
            // }
            const index = this.opened.indexOf(id);
            if (index > -1) {
                // this.opened.splice(index, 1)
            } else {
                this.opened = [];
                this.opened.push(id)
            }
            // alert(this.show);
            setTimeout(() => {
                // alert(this.show);
                for (var t = 0; t < this.ipcr_accomplishments_review.data.length; t++) {
                    if (i != t) {
                        this.show[t] = false
                    }

                }
                this.show[i] = !this.show[i];
            }, 100);
        },
        Status(status) {
            var result = "";
            if (status == -2) {
                result = "Returned"
            } else if (status == 0) {
                result = "Submitted"
            } else if (status == 1) {
                result = "Reviewed"
            } else if (status == 2) {
                result = "Approved"
            }
            return result;
        },
        /*
        async showModal(my_id, empl_id, e_name, e_year, e_sem, e_stat, accomp_id, month, position, office, division, immediate, next_higher, idsemestral, employment_type_descr, type_sel, pghead_this) {
            this.emp_name = e_name;
            this.emp_year = e_year;
            this.emp_sem = e_sem;
            this.emp_status = e_stat;
            this.emp_sem_id = my_id;
            this.empl_id = empl_id;
            this.id_accomp_selected = idsemestral;
            this.form.ipcr_monthly_accomplishment_id = idsemestral;
            this.type_selected = type_sel;
            this.pg_head = pghead_this;

            let url = '/calculate-total/accomplishments/' + idsemestral + '/' + empl_id;
            await axios.get(url).then((response) => {
                this.core_support = response.data;
                console.log(response.data);
            });
            var per = this.getMonthName(month)
            var period = this.getPeriod(e_sem, e_year)
            this.viewlink1(empl_id, e_name, employment_type_descr, position, office, division, immediate, next_higher, e_sem, e_year, idsemestral, period)
            this.displayModal = true;
        },
        e_sem_id, empl_id, e_name, e_year, e_sem, e_stat, accomp_id, month, position, office, division, immediate, next_higher, idsemestral, employment_type_descr, type_sel, pghead_this
        */

        showModal(e_sem_id, empl_id, e_name, e_year, e_sem, e_stat, accomp_id, month, position, office, division, immediate, next_higher, idsemestral, employment_type_descr, type_sel, pghead_this) {
            this.isLoading = true

            this.imm_id_loc = immediate;
            this.nxt_id_loc = next_higher;

            this.emp_name = e_name;
            this.emp_year = e_year;
            this.emp_sem = e_sem;
            this.emp_status = e_stat;
            this.emp_sem_id = e_sem_id;
            this.empl_id = empl_id;
            this.id_accomp_selected = idsemestral;
            this.form.ipcr_monthly_accomplishment_id = idsemestral;
            this.type_selected = type_sel;
            this.pg_head = pghead_this;
            axios.get("/semester-accomplishment/get/semestralAccomplishment", {
                params: {
                    sem_id: e_sem_id,
                    empl_id: empl_id,
                }
            }).then((response) => {
                this.ipcr_accomplishments_review = response.data
                console.log(this.ipcr_accomplishments_review);
                this.sem_data = this.ipcr_accomplishments_review.sem_data;
                this.Average_Point_Core = this.calculateAverageCoreSem(this.ipcr_accomplishments_review.data);
                this.Average_Point_Support = this.calculateAverageSupportSem(this.ipcr_accomplishments_review.data);
                this.displayModal = true;
            }).catch((error) => {
                console.error(error);
            }).finally(() => {
                this.isLoading = false
            });

        },
        viewlink1(emp_code, employee_name, emp_status, position, office, division, immediate, next_higher, sem, year, idsemestral, period) {
            var linkt = "http://";
            var jasper_ip = this.jasper_ip;
            var jasper_link = 'jasperserver/flow.html?pp=u%3DJamshasadid%7Cr%3DManager%7Co%3DEMEA%2CSales%7Cpa1%3DSweden&_flowId=viewReportFlow&_flowId=viewReportFlow&ParentFolderUri=%2Freports%2FIPCR%2FIPCR_Semester&reportUnit=%2Freports%2FIPCR%2FIPCR_Semester%2FSemester_Accomplishment_part1&standAlone=true&decorate=no&output=pdf';
            var params = '&emp_code=' + emp_code + '&employee_name=' + employee_name +
                '&emp_status=' + emp_status + '&position=' + position +
                '&office=' + office + '&division=' + division + '&immediate=' + immediate +
                '&next_higher=' + next_higher + '&sem=' + sem + '&year=' + year +
                '&idsemestral=' + idsemestral + '&period=' + period + '&pghead=' + this.pg_head +
                '&Average_Point_Core=' + this.core_support.average_core +
                '&Average_Point_Support=' + this.core_support.average_support;
            var linkl = linkt + jasper_ip + jasper_link + params;
            this.report_link = linkl;
            // alert('viewlink1');
            return linkl;
        },
        hideModal() {
            this.displayModal = false;
        },
        hideModal2() {
            this.displayModal2 = false;
        },
        submitAction(stat) {
            //alert(stat);
            var acc = "";
            if (stat < 1) {
                acc = "return";
                this.form.type = "return target";
            } else if (stat < 2) {
                acc = "review";
                this.form.type = "review target";
            } else if (stat < 3) {
                acc = "approve";
                this.form.type = "approve target";
            }

            let text = "Are you sure you want to " + acc + " the IPCR Target?";
            this.form.ipcr_semestral_id = this.emp_sem_id
            this.form.employee_code = this.empl_id

            // alert("/ipcrtargets/" + ipcr_id + "/"+ this.id+"/delete")
            if (confirm(text) == true) {
                this.$inertia.post("/review/approve/" + stat + "/" + this.emp_sem_id + "/from/acted/semestrals", this.form);
            }
            this.hideModal();
        },

        async showModal2(my_id, empl_id, e_name, e_year, e_sem, e_stat) {
            this.emp_name = e_name;
            this.emp_year = e_year;
            this.emp_sem = e_sem;
            this.emp_status = e_stat;
            this.emp_sem_id = my_id;
            this.empl_id = empl_id;
            // alert('ipcr_sem: '+my_id+' emp_code: '+empl_id)
            await axios.get("/ipcrtargets/get/ipcr/targets/2", {
                params: {
                    sem_id: my_id,
                    empl_id: empl_id
                }
            }).then((response) => {
                this.ipcr_targets = response.data;
            }).catch((error) => {
                console.error(error);
            });
            this.displayModal2 = true;
        },
        parseQuantity(quantarr) {
            // Remove brackets and split by commas, then convert to numbers
            const cleanedString = quantarr.replace(/[\[\]]/g, '');
            const numberArray = cleanedString.split(',').map(Number);
            //this.length = numberArray[0].quantity.length
            return numberArray;
        },
        submitActionProb(stat) {
            //alert(stat);
            var acc = "";
            if (stat < 2) {
                acc = "review";
            } else {
                acc = "approve";
            }
            let text = "Are you sure you want to " + acc + " the IPCR Target?";
            // alert("/ipcrtargets/" + ipcr_id + "/"+ this.id+"/delete")
            if (confirm(text) == true) {
                this.$inertia.post("/review/approve/" + stat + "/" + this.emp_sem_id + "/probationary");
            }
            this.hideModal2();
        },
        showModal3() {
            // alert("empl_id: " + this.empl_id + " id: " + this.emp_sem_id + " e_sem: " + this.emp_sem);
            //if(this.sem==="1" || this.e)
            //this.form.type
            //this.form.remarks
            if (this.emp_sem === "1" || this.emp_sem === "2") {
                this.form.type = "ipcr_semestrals";
            } else {
                this.form.type = "probationary/temporary"
            }
            this.form.ipcr_semestral_id = this.emp_sem_id
            this.form.employee_code = this.empl_id
            this.hideModal2()
            this.hideModal()
            // alert("ipcr_semestral_id: " + this.form.ipcr_semestral_id +
            //     " ipcr_semestral_id: " + this.form.ipcr_semestral_id +
            //     " ipcr_semestral_id: " + this.form.ipcr_semestral_id)
            this.displayModal3 = true
        },
        hideModal3() {
            this.displayModal3 = false;
        },
        submitReturnReason() {
            // alert("Type: " + this.form.type + "; ipcr_semestral_id: " +
            //     this.form.ipcr_semestral_id + "; employee_code: " +
            //     this.form.employee_code + "; remarks: " +
            //     this.form.remarks)
            let text = "Are you sure you want to return this IPCR?";

            if (confirm(text) == true) {
                if (this.form.remarks) {
                    //this.$inertia.post("/return/remarks" + id+"/"+this.idmfo);
                    this.form.post("/return/remarks", this.form);
                } else {
                    alert("Input remarks!")
                }
            }
            this.hideModal()
            this.hideModal2()
            this.cancelReason()

        },
        cancelReason() {
            this.hideModal3()
            this.form.remarks = "";
            this.form.type = "";
            this.form.ipcr_semestral_id = "";
            this.form.employee_code = "";
        },
        reviewAdditionalTarget(id_target, target_status) {
            // alert(target_status);
            var act = "";
            if (target_status == 0) {
                act = "review";
            } else if (target_status == 1) {
                act = "approve";
            } else {
                act = "return";
            }
            // alert(act);
            let text = "WARNING!\nAre you sure you want to " + act + " this IPCR?";
            if (confirm(text) == true) {
                this.$inertia.post("/ipcrtargetsreview/targetid/" + id_target + '/status/' + target_status);
            }
        },
        showModalDaily() {
            this.displayModalDaily = true;
        },
        hideModalDaily() {
            this.displayModalDaily = false;
        },
        viewDailyAccomplishments(emp_code, sem, yval) {
            // alert(this.emp_code);
            //var office_ind = document.getElementById("selectOffice").selectedIndex;

            // this.office =this.auth.user.office.office;
            // var pg_head = this.functions.DEPTHEAD;
            // var forFFUNCCOD = this.auth.user.office.department_code;
            this.my_link = this.viewlink(emp_code, sem, yval);

            this.showModalDaily();
        },
        viewlink(username, sem, yval) {
            //var linkt ="abcdefghijklo534gdmoivndfigudfhgdyfugdhfugidhfuigdhfiugmccxcxcxzczczxczxczxcxzc5fghjkliuhghghghaaa555l&&&&-";
            // var date_from =
            var moval_beg = 1;
            var moval_lst = 6;
            if (sem > 1) {
                moval_beg = 7;
                moval_lst = 12;
            }
            var linkt = "http://";
            var date_from = new Date(yval, moval_beg - 1, 1).toISOString().split('T')[0];
            var date_to = new Date(yval, moval_lst, 0).toISOString().split('T')[0];
            var jasper_ip = this.jasper_ip;
            var jasper_link = 'jasperserver/flow.html?pp=u%3DJamshasadid%7Cr%3DManager%7Co%3DEMEA%2CSales%7Cpa1%3DSweden&_flowId=viewReportFlow&_flowId=viewReportFlow&ParentFolderUri=%2Freports%2FIPCR%2FDaily_Accomplishment&reportUnit=%2Freports%2FIPCR%2FDaily_Accomplishment%2FIPCR_Daily&standAlone=true&decorate=no&output=pdf';
            var params = '&username=' + username + '&date_from=' + date_from + '&date_to=' + date_to;
            var linkl = linkt + jasper_ip + jasper_link + params;

            return linkl;
        },
    }
};
</script>
<style>
.row-centered {
    text-align: center;
}

.col-centered {
    display: inline-block;
    float: none;
    text-align: left;
    margin-right: -4px;
}

.pos {
    position: top;
    top: 240px;
}
</style>
