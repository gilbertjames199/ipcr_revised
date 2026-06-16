<template>

    <Head>
        <title>Home</title>
    </Head>

    <!--<p style="text-align: justify;">Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit amet consectetur.
    </p>-->
    <div class="row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <!--SEMESTRAL***************************************************************************************-->
            <h3>Review/Approve Semestral Accomplishment </h3>
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
                                <th></th>
                                <th>Name</th>
                                <th>Period</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="accomp in accomplishments.data">
                                <td><!--{{ accomp }} - {{ accomp }}--> </td>
                                <td>{{ accomp.employee_name }} </td>
                                <td>
                                    <!-- {{accomp.submission_basis}} -->
                                    <!-- {{ accomp.prob_temp_employee }} -->
                                    <!-- {{accomp.prob_type}} -->
                                    <span v-if="accomp.prob_type==='s'">{{ getPeriod(accomp.sem, accomp.year) }}</span>
                                    <span v-else>
                                        <!-- {{accomp.submission_basis }} -->
                                        <span v-if="accomp.submission_basis=='status_accomplishment '">
                                            {{ getPeriod(accomp.sem, accomp.year) }}
                                            <b >({{ accomp.prob_type }})</b>
                                        </span>
                                        <span v-else>
                                            {{ probationPeriod(accomp.prob_temp_employee, accomp.submission_basis)}}
                                            <b >({{ accomp.prob_type }})</b>
                                        </span>

                                    </span>
                                    <!-- {{ accomp }} -->
                                    <!-- {{ getPeriod(accomp.sem, accomp.year) }} -->
                                </td>
                                <!-- {{ getStatus(accomp.employment_type_descr) }}  -->
                                <!-- <td>{{ accomp.employment_type_descr }}
                                    -- sem: {{ accomp.sem }}</td> -->
                                <td>{{ getStatus(accomp.a_status.toString()) }} </td>
                                <td>
                                    <div class="dropdown dropstart">
                                        <button class="btn btn-secondary btn-sm action-btn" type="button"
                                            id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                                <path
                                                    d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                                            </svg>
                                        </button>
                                        <ul class="dropdown-menu action-dropdown" aria-labelledby="dropdownMenuButton1">
                                            <li v-if="accomp.sem === '1' || accomp.sem === '2'">
                                                <button class="dropdown-item"
                                                    @click="showModals(accomp.id, accomp.empl_id, accomp.a_status, accomp.imm_id, accomp.next_higher_id, accomp)">
                                                    View Submission
                                                </button>
                                            </li>
                                            <li v-else>
                                                <button class="dropdown-item"
                                                    @click="showModal2(accomp.empl_id, accomp.employee_name, accomp.year, accomp.sem, accomp.status)">
                                                    View Submission 2
                                                </button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item"
                                                    @click="viewDailyAccomplishments(accomp.empl_id, accomp.sem, accomp.year)">
                                                    View Daily Accomplishments
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- <pagination :next="data.next_page_url" :prev="data.prev_page_url" /> -->
        <pagination :next="accomplishments.next_page_url" :prev="accomplishments.prev_page_url" />
        <LoadingOverlay
            :active="isLoading"
            :is-full-page="true"
            :can-cancel="false"
            loader="bars"
            />
        <Modal v-if="displayModal" @close-modal-event="hideModal">
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
                <div class="masonry-item w-100">
                    <div class="bgc-white p-20 bd">
                        <!-- {{ report_link }} -->
                        <div class="table-responsive">

                            <iframe :src="report_link" style="width:100%; height:450px" />
                        </div>
                    </div>
                </div>
                <div>
                    <b>Remarks:</b>
                    <input type="text" v-model="form.remarks" class="form-control" autocomplete="chrome-off"><br>
                </div>
                <div style="align: center">
                    <!-- imm_id_loc
                    nxt_id_loc -->
                    <!-- {{ imm_id_loc }} - {{ nxt_id_loc }} -->
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
                </div>
            </div>
        </Modal>
        <Modal2 v-if="displayModal2" @close-modal-event="hideModal2">
            <div class="justify-content-center">
                <div style="text-align: center">
                    <h4>IPCR Targets Modal2</h4>
                </div>
                <br>
                <div><b>Employee Name: </b><u>{{ emp_name }}</u></div>
                <!-- lendsgth: {{ length }}
                ipcr_targets: {{ ipcr_targets[0].quantity }} -->
                <!-- quantityArray : {{ quantityArray() }} -->
                <div class="masonry-item w-100">
                    <div class="bgc-white p-20 bd">
                        <div class="table-responsive">

                            <div v-if="ipcr_targets && ipcr_targets.length > 0">
                                <table class="table table-hover table-bordered border-dark">
                                    <!-- v-if="ipcr_targets[0].quantity" -->
                                     <tbody>
                                        <tr class="text-dark" style="background-color: #B7DEE8;">
                                        <th>IPCR Code</th>
                                        <th>Individual Final Output
                                            {{ ipcr_targets[0].quantity }}
                                        </th>

                                        <th v-for="(item, index) in parseQuantity(ipcr_targets[0].quantity)"
                                            :key="index">
                                            Month {{ index + 1 }}
                                        </th>
                                    </tr>
                                    <tr class="bg-secondary text-white">
                                        <td>{{ }}</td>
                                        <td :colspan="9 + parseFloat(parseQuantity(ipcr_targets[0].quantity).length)">
                                            <b>Core Function</b>
                                        </td>
                                    </tr>
                                    <tr v-for="target in ipcr_targets">
                                        <td v-if="target.ipcr_type == 'Core Function'"
                                            style="text-align: center; background-color: #edd29d">{{ target.ipcr_code }}
                                        </td>
                                        <td v-if="target.ipcr_type == 'Core Function'">{{ target.individual_output }}
                                        </td>
                                        <td v-if="target.ipcr_type == 'Core Function'"
                                            v-for="(quant, index) in parseQuantity(target.quantity)" :key="index">{{
                        quant
                    }}</td>
                                    </tr>
                                    <tr class="bg-secondary text-white">
                                        <td>{{ }}</td>
                                        <td :colspan="9 + parseFloat(parseQuantity(ipcr_targets[0].quantity).length)">
                                            <b>Support Function</b>
                                        </td>
                                    </tr>
                                    <tr v-for="target in ipcr_targets">
                                        <td v-if="target.ipcr_type == 'Support Function'"
                                            style="text-align: center; background-color: #edd29d">{{ target.ipcr_code }}
                                        </td>
                                        <td v-if="target.ipcr_type == 'Support Function'">{{ target.individual_output }}
                                        </td>
                                        <td v-if="target.ipcr_type == 'Support Function'"
                                            v-for="(quant, index) in parseQuantity(target.quantity)" :key="index">{{
                        quant
                    }}</td>
                                    </tr>
                                     </tbody>

                                </table>
                            </div>

                        </div>
                        <div style="align: center">
                            <button class="btn btn-primary text-white" @click="submitActionProb('1')"
                                v-if="emp_status === '0'">
                                Review
                            </button>
                            <button class="btn btn-primary text-white" @click="submitActionProb('2')"
                                v-if="emp_status === '1'">
                                Approve
                            </button>&nbsp;
                            <button class="btn btn-danger text-white" @click="showModal3()">
                                Return
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </Modal2>
        <Modal3 v-if="displayModal3" @close-modal-event="hideModal3">
            <h3>Remarks Modal3</h3>
            <h5>State the reason for not reviewing/approving IPCR</h5>
            <input type="text" v-model="form.remarks" class="form-control" autocomplete="chrome-off"><br>
            <button class="btn btn-primary text-white" @click="submitReturnReason()">
                Done
            </button>&nbsp;
            <button class="btn btn-danger text-white" @click="cancelReason()">
                Cancel
            </button>
        </Modal3>
        <ModalDaily v-if="displayModalDaily" @close-modal-event="hideModalDaily">
            <div class="d-flex justify-content-center">
                <iframe :src="my_link" style="width:100%; height:450px" />
            </div>
        </ModalDaily>
        <Modal4 v-if="displayModal4" @close-modal-event="hideModal4">
            <div class="justify-content-center">
                <div style="text-align: center">
                    <h4>IPCR Accomplishment</h4>
                </div>
                <br>
                <!-- {{ ipcr_accomplishments_review.sem }} -->
                <div>
                    <div><b>Employee Name: </b><u>{{ ipcr_accomplishments_review.sem.employee_name }}</u>
                    </div>
                    <div><b>Position: </b><u>{{ ipcr_accomplishments_review.sem.position }}</u>
                    </div>
                </div>
                <div>
                    <b>Semester/Period: </b>
                    <span v-if="prob_type!=='s'">
                        <u>
                            {{ current_period }}
                            <!-- {{ accomp_current_param }} -->
                            <!-- {{ probationPeriod(accomp_current_param.prob_tempo_employee)}} -->
                        </u>
                    </span>
                    <span v-else>{{ sem(ipcr_accomplishments_review.sem.sem) }}</span>
                </div>
                <div>
                    <b>Status: </b><u>{{ Status(ipcr_accomplishments_review.sem_data.status_accomplishment) }}</u>

                </div>
                <div class="masonry-item w-100">
                    <div class="row gap-20"></div>
                    <div class="bgc-white p-20 bd">
                        <div class="table-responsive">
                            <!-- {{ ipcr_accomplishments_review.data }} -->
                            <table class="table table-sm table-bordered border-dark table-hover">
                                <thead>
                                    <tr style="background-color: #B7DEE8;" class="text-center table-bordered">
                                        <!-- <th style="width: 5%;" rowspan="2" colspan="1">IPCR Code</th> -->
                                        <th style="width: 15%;" rowspan="2" colspan="1">
                                              <!-- {{ ipcr_accomplishments_review[0].Accomplishment_type == "ipcr"? "Individual Output": ipcr_accomplishments_review[0].Accomplishment_type == "dpcr"? "Division Output" : "" }} -->
                                              {{ ipcr_accomplishments_review.form_type }}
                                              <!--
                                                div
                                                emp
                                                hemp
                                                hdiv
                                                hos
                                                hsec
                                              -->

                                              <span v-if="ipcr_accomplishments_review.form_type=='emp' || ipcr_accomplishments_review.form_type=='hemp'">Individual Output</span>
                                              <span v-if="ipcr_accomplishments_review.form_type=='div' || ipcr_accomplishments_review.form_type=='hdiv'">Division Output</span>
                                              <span v-if="ipcr_accomplishments_review.form_type=='hsec'">Section Output</span>
                                              <span v-if="ipcr_accomplishments_review.form_type=='hos'">Hospital Output</span>
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
                                    <!--CORE FUNCTION-->
                                    <tr>
                                        <!-- <td colspan="9">
                                                <b>CORE FUNCTION</b> -->
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
                                                    <span v-if="show[index]">
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
                                                                        <tbody>
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
                                                                        </tbody>

                                                                    </table>
                                                                </td>
                                                                <td style="padding: 0;">
                                                                    <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                        <tbody>
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
                                                                        </tbody>

                                                                    </table>
                                                                </td>
                                                                <td style="padding: 0;">
                                                                    <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                        <tbody>
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
                                                                        </tbody>

                                                                    </table>
                                                                </td>
                                                                <td style="padding: 0;">
                                                                    <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                        <tbody>
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
                                                                        </tbody>

                                                                    </table>
                                                                </td>
                                                                <td style="padding: 0;">
                                                                    <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                        <tbody>
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
                                                                        </tbody>

                                                                    </table>
                                                                </td>
                                                                <td style="padding: 0;">
                                                                    <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                        <tbody>
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
                                                                        </tbody>

                                                                    </table>
                                                                </td>
                                                                <td style="padding: 0;">
                                                                    <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                        <tbody>
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
                                                                        </tbody>

                                                                    </table>
                                                                </td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                    </span>
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
                                    <!-- //SUPPORT -->
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
                                                    <span v-if="show[index]">
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
                                                                        <tbody>
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
                                                                        </tbody>

                                                                    </table>
                                                                </td>
                                                                <td style="padding: 0;">
                                                                    <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                        <tbody>
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
                                                                        </tbody>

                                                                    </table>
                                                                </td>
                                                                <td style="padding: 0;">
                                                                    <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                        <tbody>
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
                                                                        </tbody>

                                                                    </table>
                                                                </td>
                                                                <td style="padding: 0;">
                                                                    <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                        <tbody>
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
                                                                        </tbody>

                                                                    </table>
                                                                </td>
                                                                <td style="padding: 0;">
                                                                    <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                        <tbody>
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
                                                                        </tbody>

                                                                    </table>
                                                                </td>
                                                                <td style="padding: 0;">
                                                                    <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                        <tbody>
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
                                                                        </tbody>

                                                                    </table>
                                                                </td>
                                                                <td style="padding: 0;">
                                                                    <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                        <tbody>
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
                                                                        </tbody>

                                                                    </table>
                                                                </td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                    </span>
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
                                            <span v-if="sem_data.remarks">{{ sem_data.remarks.remarks }}</span>
                                            <br>
                                            <span v-if="sem_data.remarkshigher">{{ sem_data.remarkshigher.remarks }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <b>Remarks:</b>
                            <input type="text" v-model="form.remarks" class="form-control" autocomplete="chrome-off"><br>
                        </div>
                        <div style="align: center" v-if="prob_type==='s'">
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
                        </div>
                        <div style="align: center" v-if="prob_type!=='s'">
                            <!-- {{ prob_type }}
                            {{ submission_basis }}
                            {{ emp_status.toString() }} -->
                            <!-- If submission_basis is NOT 'status_accomplishment', use period status buttons -->
                            <div v-if="submission_basis !== 'status_accomplishment'">
                                <span v-if="imm_id_loc === nxt_id_loc">
                                    <button class="btn btn-primary text-white" @click="submitPeriodAction('2')">
                                        Approve Period
                                    </button>&nbsp;
                                </span>
                                <span v-else>
                                    <button class="btn btn-primary text-white" @click="submitPeriodAction('1')"
                                        v-if="emp_status.toString() === '0'">
                                        Review Period
                                    </button>
                                    <button class="btn btn-primary text-white" @click="submitPeriodAction('2')"
                                        v-if="emp_status.toString() === '1'">
                                        Approve Period
                                    </button>&nbsp;
                                    <button class="btn btn-primary text-white" @click="submitPeriodAction('3')"
                                        v-if="emp_status.toString() === '2'">
                                        Final Approve Period
                                    </button>&nbsp;
                                </span>
                                <button style="float: right" class="btn btn-danger text-white" @click="submitPeriodAction('-2')">
                                    Return Period
                                </button>
                            </div>

                            <!-- Original buttons for normal status_accomplishment flow -->
                            <div v-else>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Modal4>
    </div>
</template>
<script>
import { useForm } from "@inertiajs/inertia-vue3";
import Filtering from "@/Shared/Filter";
import Pagination from "@/Shared/Pagination";
import Modal from "@/Shared/PrintModal";
import Modal2 from "@/Shared/PrintModal";
import Modal3 from "@/Shared/PrintModal";
import Modal4 from "@/Shared/PrintModal";
import ModalDaily from "@/Shared/PrintModal";
import { Inertia } from '@inertiajs/inertia';

export default {
    props: {
        accomplishments: Object,
        pghead: Object,
        filters: Object,

    },
    computed: {
        quantityArray() {
            const allArrays = this.ipcr_targets.map(target => JSON.parse(target.quantity));
            const mergedArray = [].concat(...allArrays);
            var quant = JSON.parse(this.ipcr_targets[0].quantity)
            return mergedArray
        },
    },
    data() {
        return {
            report_link: "",
            my_link: "",
            displayModal: false,
            modal_title: "Add",
            ipcr_targets: [],
            ipcr_accomplishments: [],
            ipcr_accomplishments_review: [],
            core_support: [],
            emp_sem_id: "",
            emp_name: "",
            emp_year: "",
            emp_sem: "",
            emp_status: "",
            empl_id: "",
            imm_id_loc: "",
            nxt_id_loc: "",
            accomp_current_param: [],
            current_period: "",
            prob_type: "",
            Average_Point_Core: 0,
            Average_Point_Support: 0,
            displayModal2: false,
            displayModal3: false,
            displayModal4: false,
            displayModalDaily: false,
            length: 0,
            id_accomp_selected: "",
            pg_head: "",
            form: useForm({
                type: "",
                remarks: "",
                ipcr_semestral_id: "",
                employee_code: "",
                ipcr_monthly_accomplishment_id: "",
            }),
            search: this.$props.filters.search,
            //FOR MODAL
            opened: [],
            show: [],
            submission_basis: '',
            // LOADING
            isLoading: false,
        }
    },
    watch: {
        search: _.debounce(function (value) {
            this.$inertia.get(
                "/approve/semestral-accomplishments",
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
        Pagination, Filtering, Modal, Modal2, Modal3, Modal4, ModalDaily
    },
    mounted() {
        this.Average_Point_Core=this.calculateAverageCoreSem(this.ipcr_accomplishments_review.data)
        this.Average_Point_Support=this.calculateAverageSupportSem(this.ipcr_accomplishments_review.data)
    },
    methods: {

        Status(status) {
            var result = ""
            if (status == "0") {
                result = "Submitted"
            } else if (status == 1) {
                result = "Reviewed"
            } else if (status == 2) {
                result = "Approved"
            }

            return result;
        },

        showModals(e_sem_id, empl_id, a_status, immid, nxtid, accomp_current_param) {
            this.emp_sem_id = e_sem_id;
            this.emp_status = a_status;
            this.imm_id_loc = immid;
            this.accomp_current = accomp_current_param;
            this.prob_type=accomp_current_param.prob_type;

            this.submission_basis = accomp_current_param.submission_basis; // add this line
            this.current_period= this.probationPeriod(accomp_current_param.prob_temp_employee, this.submission_basis)
            // alert(this.immid_id_loc)
            this.isLoading =true;
            this.nxt_id_loc = nxtid;
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
                this.hideModal2()
                this.hideModal()
                this.displayModal4 = true

            }).catch((error) => {
                console.error(error);
            }).finally(() => {
                this.isLoading = false;
            });

        },
        hideModal4() {
            this.displayModal4 = false
        },
        showModal1() {
            this.displayModal = true;
        },
        hideModal() {
            this.displayModal = false;
        },
        hideModal2() {
            this.displayModal2 = false;
        },
        // async
        submitAction(stat, sem_id) {
            // alert(stat);
            var acc = "";
            if (stat < 0) {
                acc = "return";
            } else if (stat < 2) {
                acc = "review";
            } else if (stat < 3) {
                acc = "approve";
            } else {
                acc = "final approve";
            }
            console.log(this.ipcr_accomplishments_review.sem)
            let text = "Are you sure you want to " + acc + " this accomplishment?";
            // alert(this.id_accomp_selected)
            // alert("/ipcrtargets/" + ipcr_id + "/"+ this.id+"/delete")/review/approve/
            if (confirm(text) == true) {
                //'/approve/semestral-accomplishments/up/stat/acc/{status}/{acc_id}'
                // /approve/semestral-accomplishments/{status}/{acc_id}
                var myurl = "/approve/semestral-accomplishments/up/stat/acc/" + stat + "/" + this.emp_sem_id
                // alert(myurl)
                // alert(this.form.remarks);
                // alert(this.empl_id)
                this.form.employee_code = this.ipcr_accomplishments_review.sem.employee_code;
                // await axios
                this.$inertia.post(myurl, {
                    params: {
                        remarks: this.form.remarks,
                        employee_code: this.form.employee_code,
                        Average_Point_Core: this.Average_Point_Core,
                        Average_Point_Support: this.Average_Point_Support,
                    }
                });
            }
            this.hideModal4();
            this.form.remarks="";
        },
        submitPeriodAction(stat) {
            let actionText = '';
            if (stat == 1) actionText = 'review';
            else if (stat == 2) actionText = 'approve';
            else if (stat == -2) actionText = 'return';
            else actionText = 'process';

            let confirmMsg = `Are you sure you want to ${actionText} this period's accomplishment?`;
            if (!confirm(confirmMsg)) return;

            const url = `/approve/semestral-accomplishments/update-period-status/${stat}/${this.emp_sem_id}`;

            // Send remarks and any other required data (like calculated scores)
            const payload = {
                remarks: this.form.remarks,
                employee_code: this.ipcr_accomplishments_review.sem?.employee_code,
                submission_basis: this.submission_basis,
                Average_Point_Core: this.Average_Point_Core,
                Average_Point_Support: this.Average_Point_Support,
            };

            this.$inertia.post(url, payload, {
                preserveScroll: true,
                onSuccess: () => {
                    this.hideModal4();
                    this.form.remarks = '';
                    window.location.reload()
                },
                onError: (errors) => {
                    console.error(errors);
                    alert('An error occurred while updating period status.');
                }
            });
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
            // this.displayModal3 = true
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
                    this.form.post("/return/accomplishments/remarks", this.form);
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
            this.my_link = this.viewlinkaa(emp_code, sem, yval);

            this.showModalDaily();
        },
        viewlinkaa(username, sem, yval) {
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
        toggleVisibility(value) {
            // alert(value)
            this.accomp_visible=value
            this.form.monthly_ratings.forEach(row => {
                // alert(row.visible)
                row.visible = value;
            });
        },
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
