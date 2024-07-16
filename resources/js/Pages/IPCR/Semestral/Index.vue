<template>

    <Head>
        <title>Home</title>
    </Head>

    <!--<p style="text-align: justify;">Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit amet consectetur.
    </p>-->
    <div class="row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <!--SEMESTRAL***************************************************************************************-->
            <h3>Individual Performance Commitment Review </h3>
            <div class="peers">
                <div class="peer">
                    <!-- /ipcrsemestral/create/{{ id }}/semestral {{ source }} -->
                    <Link class="btn btn-primary btn-sm" :href="`/ipcrsemestral/create/${id}/${source}`">Add IPCR
                    </Link>
                </div>
                <Link v-if="source !== 'direct'" :href="`/employees`">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-lg"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z" />
                    <path fill-rule="evenodd"
                        d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z" />
                </svg>
                </Link>
            </div>

        </div>
        <div>
            <!-- {{ emp }} -->
            <!-- {{ auth }} -->
            <div><b>Employee Name: </b><u>{{ emp.employee_name }}</u></div>
            <div><b>Position: </b><u>{{ emp.position_long_title }}</u></div>
        </div>

        <div class="masonry-sizer col-md-6"></div>
        <div class="masonry-item w-100">
            <div class="row gap-20"></div>
            <div class="bgc-white p-20 bd">
                <div class="table-responsive">
                    <table class="table table-sm table-borderless table-striped table-hover">
                        <thead>
                            <tr style="background-color: #B7DEE8;">
                                <th>Semester</th>
                                <th>Period</th>
                                <th>Status</th>
                                <th>Remarks</th>
                                <th>Additional Targets</th>
                                <th></th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="sem in   sem_data.data  ">

                                <tr>
                                    <td>
                                        {{ getSemester(sem.sem) }}
                                        <!-- {{ sem.imm }} -->
                                    </td>
                                    <td>
                                        {{ getPeriod(sem.sem, sem.year) }}
                                        <span v-if="sem.is_additional_target == 1">- Additional Target</span>
                                    </td>
                                    <td>
                                        <span :style="{ color: getColor(sem.status) }"
                                            v-if="sem.is_additional_target == null">
                                            <b>
                                                {{ getStatus(sem.status) }}<br />

                                            </b>
                                        </span>
                                        <span :style="{ color: getColor(sem.target_status) }"
                                            v-if="sem.is_additional_target == '1'">
                                            <b>
                                                {{ getStatus(sem.target_status) }}
                                                <!-- <span v-if="getStatus(sem.status) == 'Returned'">
                                                    <span v-if="sem.rem.remarks">Remarks: {{ sem.rem.remarks }}</span>
                                                </span> -->
                                            </b>
                                        </span>
                                    </td>
                                    <td>
                                        <!-- & sem.is_additional_target == null -->
                                        <!-- {{ sem }} -->
                                        <span v-if="sem.rem && sem.is_additional_target == null">
                                            {{ sem.rem.remarks }}
                                        </span>
                                        <!-- {{ sem.division }} -->
                                    </td>
                                    <td>
                                        <Link class="btn btn-primary btn-sm" v-if="sem.status > 1 &&
                        sem.is_additional_target == null"
                                            :href="`/ipcrtargets/create/${sem.ipcr_sem_id}/additional/ipcr/targets`">
                                        <!-- &&
                        isfifteenDaysLate(sem.year, sem.sem)" -->
                                        <!-- {{ sem.ipcr_sem_id }} -->
                                        Additional IPCR Targets

                                        </Link>&nbsp;
                                        <!-- <span v-if="!isfifteenDaysLate(sem.year, sem.sem)">
                                            Current date is 15 days or more than the last day of the semester. Additional
                                            Targets Forbidden
                                        </span> -->
                                        <!-- {{ lastDaySem(sem.year, sem.sem) }} -->
                                    </td>
                                    <td>
                                        <button v-if="sem.status < 0 && sem.is_additional_target == null"
                                            class="btn btn-primary btn-sm text-white"
                                            @click="submitIPCR(sem.ipcr_sem_id)">
                                            Submit
                                        </button>
                                    </td>
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
                                                <li
                                                    v-if="parseFloat(sem.status) < 1 && sem.is_additional_target == null">
                                                    <Link class="dropdown-item"
                                                        :href="`/ipcrtargets/${sem.ipcr_sem_id}`">
                                                    Set
                                                    Targets
                                                    </Link>
                                                </li>

                                                <li v-if="sem.is_additional_target == null">
                                                    <Button class="dropdown-item"
                                                        @click="showModal4(sem.ipcr_sem_id, sem.employee_code, sem.year, sem.sem, sem.status)">
                                                        <!-- target.employee_name, -->
                                                        View
                                                        Monthly Targets
                                                    </Button>
                                                </li>
                                                <li v-if="parseFloat(sem.status) < 1 &&
                        sem.is_additional_target == null">
                                                    <Button class="dropdown-item"
                                                        @click="showModal2(sem.ipcr_sem_id, 'from', 'to')">
                                                        Copy Targets
                                                    </Button>
                                                </li>
                                                <!-- parseFloat(sem.status) < 1 &&  -->
                                                <li v-if="sem.is_additional_target == null">
                                                    <Link class="dropdown-item"
                                                        :href="`/ipcrsemestral/edit/${sem.ipcr_sem_id}/${source}/ipcr`">
                                                    Edit
                                                    </Link>
                                                </li>
                                                <!-- <li><Link class="dropdown-item" :href="`/ipcrtargets/edit/${ifo.id}`">Edit</Link></li> -->
                                                <li
                                                    v-if="parseFloat(sem.status) < 0 && sem.is_additional_target == null">
                                                    <button class="dropdown-item"
                                                        @click="deleteIPCR(sem.ipcr_sem_id)">Delete</button>
                                                </li>
                                                <!-- <li v-if="sem.status < 0 && sem.is_additional_target == null">
                                                    <button class="dropdown-item" @click="submitIPCR(sem.ipcr_sem_id)">
                                                        Submit
                                                    </button>
                                                </li> -->
                                                <li v-if="sem.target_status < 0 && sem.is_additional_target == '1'">
                                                    <button class="dropdown-item"
                                                        @click="submitIPCRTarget(sem.ipcr_target_id, sem.ipcr_sem_id)">
                                                        Submit Additional Target
                                                    </button>
                                                </li>
                                                <li v-if="sem.target_status < 0 && sem.is_additional_target == '1'">
                                                    <button class="dropdown-item"
                                                        @click="deleteIPCRTarget(sem.ipcr_target_id, sem.ipcr_sem_id)">
                                                        Delete Additional Target
                                                    </button>
                                                </li>
                                                <li v-if="sem.is_additional_target == null">
                                                    <button class="dropdown-item" @click="showModal(sem.ipcr_sem_id,
                        sem.sem, sem.year,
                        sem.imm,
                        sem.next,
                        sem.status,
                        sem.division
                        // sem.next.first_name + ' ' + sem.next.middle_name[0] + '. ' + sem.next.last_name,
                        // sem.imm.first_name + ' ' + sem.imm.middle_name[0] + '. ' + sem.imm.last_name,

                    )">
                                                        Print Targets
                                                    </button>
                                                </li>
                                                <li v-if="sem.status == 0">
                                                    <button class="dropdown-item"
                                                        @click="recallIPCRTarget(sem.ipcr_sem_id)">
                                                        Recall
                                                    </button>
                                                </li>
                                                <li v-if="sem.target_status == '0' && sem.is_additional_target == '1'">
                                                    <button class="dropdown-item"
                                                        @click="recallAddIPCRTarget(sem.ipcr_target_id, sem.ipcr_sem_id)">
                                                        Recall Additional Target
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </template>

                        </tbody>
                    </table>
                    <pagination :next="sem_data.next_page_url" :prev="sem_data.prev_page_url" />
                </div>
            </div>
        </div>
        <Modal v-if="displayModal" @close-modal-event="hideModal">
            <div class="d-flex justify-content-center">
                <!-- my_link: {{ my_link }} -->
                <iframe :src="my_link" style="width:100%; height:500px" />
            </div>
        </Modal>
        <Modal2 v-if="displayModal2" @close-modal-event="hideModal2">
            <h3>Select IPCR to Copy</h3>
            <!-- {{ ipcr_id_copied }} - {{ ipcr_id_passed }} -->
            <select class="form-select" v-model="ipcr_id_copied">
                <option v-for="sem in filteredSemesters" :value="sem.ipcr_sem_id" :key="sem.ipcr_sem_id">
                    {{ getPeriod(sem.sem, sem.year) }} - {{ getSemester(sem.sem) }}
                </option>
            </select><br>
            <button class="btn btn-primary btn-sm text-white " @click="copyIPCR()">Done</button>&nbsp;
            <button class="btn btn-danger btn-sm text-white " @click="hideModal2">Cancel</button>
        </Modal2>

        <!--MODAL 3-->
        <Modal3 v-if="displayModal3" @close-modal-event="hideModal3">
            <div class="justify-content-center">
                <div style="text-align: center">
                    <h4>IPCR Targets</h4>
                </div>
                <br>
                <div>
                    <div><b>Employee Name: </b><u>{{ emp.employee_name }}</u></div>
                    <div><b>Position: </b><u>{{ emp.position_long_title }}</u></div>
                </div>
                <div>
                    <b>Semester/Period: </b>
                    <u>
                        <span v-if="emp_sem === '1'">First Semester -January to June, </span>
                        <span v-if="emp_sem === '2'">Second Semester -July to December, </span>
                        {{ emp_year }}
                    </u>
                </div>
                <div>
                    <b>Status: </b>
                    <u>
                        <span v-if="emp_status === '0'">Submitted</span>
                        <span v-if="emp_status === '1'">Reviewed</span>
                        <span v-if="emp_status === '2'">Approved</span>
                    </u>
                </div>
                <div class="masonry-item w-100">
                    <div class="bgc-white p-20 bd">

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered border-dark">
                                <tr class="text-dark" style="background-color: #B7DEE8;">
                                    <th rowspan="2" style="text-align: center; background-color: #edd29d !important;">
                                        IPCR
                                        Code</th>
                                    <th rowspan="2">Individual Final Output</th>
                                    <th rowspan="2">Performance Measure</th>
                                    <th colspan="6" rowspan="1" style="text-align: center">Monthly Targets</th>
                                    <th rowspan="2" style="text-align: center">Semestral Target</th>
                                </tr>
                                <tr class="text-dark" style="background-color: #B7DEE8;">
                                    <th>1</th>
                                    <th>2</th>
                                    <th>3</th>
                                    <th>4</th>
                                    <th>5</th>
                                    <th>6</th>
                                </tr>
                                <tr class="bg-secondary text-white">
                                    <td></td>
                                    <td colspan="9"><b>Core Function</b></td>
                                </tr>
                                <tr v-for="ipc in ipcr_targets">
                                    <td v-if="ipc.ipcr_type == 'Core Function'"
                                        style="text-align: center; background-color: #edd29d">{{ ipc.ipcr_code }}</td>
                                    <td v-if="ipc.ipcr_type == 'Core Function'">{{ ipc.individual_output }}</td>
                                    <td v-if="ipc.ipcr_type == 'Core Function'">{{ ipc.performance_measure }}</td>
                                    <td v-if="ipc.ipcr_type == 'Core Function'">
                                        <span v-if="ipc.month_1 > 0">{{
                        format_number_conv(ipc.month_1, 0, true) }}&nbsp;</span>
                                    </td>
                                    <td v-if="ipc.ipcr_type == 'Core Function'"><span v-if="ipc.month_2 > 0">{{
                        format_number_conv(ipc.month_2, 0, true) }}&nbsp;</span></td>
                                    <td v-if="ipc.ipcr_type == 'Core Function'"><span v-if="ipc.month_3 > 0">{{
                        format_number_conv(ipc.month_3, 0, true) }}&nbsp;</span></td>
                                    <td v-if="ipc.ipcr_type == 'Core Function'"><span v-if="ipc.month_4 > 0">{{
                        format_number_conv(ipc.month_4, 0, true) }}&nbsp;</span></td>
                                    <td v-if="ipc.ipcr_type == 'Core Function'"><span v-if="ipc.month_5 > 0">{{
                        format_number_conv(ipc.month_5, 0, true) }}&nbsp;</span></td>
                                    <td v-if="ipc.ipcr_type == 'Core Function'"><span v-if="ipc.month_6 > 0">{{
                        format_number_conv(ipc.month_6, 0, true) }}&nbsp;</span></td>

                                    <td v-if="ipc.ipcr_type == 'Core Function'" style="text-align: center">{{
                        format_number_conv(ipc.quantity_sem, 0, true)
                    }}</td>
                                </tr>
                                <tr class="bg-secondary text-white">
                                    <td></td>
                                    <td colspan="9"><b>Support Function</b></td>
                                </tr>
                                <tr v-for="ipc in ipcr_targets">
                                    <td v-if="ipc.ipcr_type == 'Support Function'"
                                        style="text-align: center; background-color: #edd29d">{{ ipc.ipcr_code }}</td>
                                    <td v-if="ipc.ipcr_type == 'Support Function'">{{ ipc.individual_output }}</td>
                                    <td v-if="ipc.ipcr_type == 'Support Function'">{{ ipc.performance_measure }}</td>
                                    <td v-if="ipc.ipcr_type == 'Support Function'"><span v-if="ipc.month_1 > 0">{{
                        format_number_conv(ipc.month_1, 0, true) }}&nbsp;</span></td>
                                    <td v-if="ipc.ipcr_type == 'Support Function'"><span v-if="ipc.month_2 > 0">{{
                        format_number_conv(ipc.month_2, 0, true) }}&nbsp;</span></td>
                                    <td v-if="ipc.ipcr_type == 'Support Function'"><span v-if="ipc.month_3 > 0">{{
                        format_number_conv(ipc.month_3, 0, true) }}&nbsp;</span></td>
                                    <td v-if="ipc.ipcr_type == 'Support Function'"><span v-if="ipc.month_4 > 0">{{
                        format_number_conv(ipc.month_4, 0, true) }}&nbsp;</span></td>
                                    <td v-if="ipc.ipcr_type == 'Support Function'"><span v-if="ipc.month_5 > 0">{{
                        format_number_conv(ipc.month_5, 0, true) }}&nbsp;</span></td>
                                    <td v-if="ipc.ipcr_type == 'Support Function'"><span v-if="ipc.month_6 > 0">{{
                                            format_number_conv(ipc.month_6, 0, true) }}&nbsp;</span></td>
                                    <td v-if="ipc.ipcr_type == 'Support Function'" style="text-align: center">{{
                                        ipc.quantity_sem }}</td>
                                </tr>
                            </table>

                        </div>

                    </div>

                </div>
            </div>
        </Modal3>
        <!-- PGHEAD: {{ pgHead }} -->
    </div>
</template>
<script>
import Filtering from "@/Shared/Filter";
import Pagination from "@/Shared/Pagination";
import Modal from "@/Shared/PrintModal";
import Modal2 from "@/Shared/PrintModal";
import Modal3 from "@/Shared/PrintModal";
export default {
    props: {
        auth: Object,
        data: Object,
        MOOE: String,
        PS: String,
        id: String,
        emp: Object,
        division: Object,
        source: String,
        sem_data: Object,
        office: Object,
        pgHead: Object,
    },
    data() {
        return {
            my_link: "",
            displayModal: false,
            displayModal2: false,
            displayModal3: false,
            modal_title: "Add",
            sem_id: "",
            period: "",
            sem: "",
            year: "",
            nxt: "",
            imm: "",
            status: "",
            ipcr_id_passed: "",
            ipcr_id_copied: "",
            ipcr_targets: [],
            emp_sem_id: "",
            emp_name: "",
            emp_year: "",
            emp_sem: "",
            emp_status: "",
            empl_id: "",
            my_div: "",
            //search: this.$props.filters.search,
        }
    },
    computed: {
        filteredSemesters() {
            return this.sem_data.data.filter((sem) => sem.is_additional_target === null && sem.ipcr_sem_id !== this.ipcr_id_passed);
        },
    },
    watch: {
        search: _.debounce(function (value) {
            this.$inertia.get(
                "/paps/" + this.idmfo,
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
        Pagination, Filtering, Modal, Modal2, Modal3
    },

    methods: {
        deleteIPCR(ipcr_id) {
            let text = "WARNING!\nAre you sure you want to delete this IPCR?";
            if (confirm(text) == true) {
                this.$inertia.delete("/ipcrsemestral/delete/" + ipcr_id + '/' + this.source);
            }
        },
        submitIPCR(ipcr_id) {
            // alert(ipcr_id);
            let text = "WARNING!\nAre you sure you want to submit this IPCR?";
            if (confirm(text) == true) {
                this.$inertia.post("/ipcrsemestral/submit/" + ipcr_id + '/' + this.source);
            }
        },
        submitIPCRTarget(id_target, ipcr_id) {
            let text = "WARNING\nAre you sure you want to submit this additional target?";
            if (confirm(text) == true) {
                this.$inertia.post("/ipcrtargetsreview/" + id_target + '/' + this.source
                    + '/' + ipcr_id);
            }
        },
        deleteIPCRTarget(id_target, ipcr_id) {
            let text = "WARNING\nAre you sure you want to delete this additional target?";
            if (confirm(text) == true) {
                this.$inertia.delete("/ipcrtargetsreview/delete/" + id_target + '/' + this.source
                    + '/' + ipcr_id);
            }
        },
        recallIPCRTarget(ipcr_id) {
            let text = "WARNING\nAre you sure you want to recall this target?";
            if (confirm(text) == true) {
                this.$inertia.post("/ipcrtargetsreview/recall/my/target/" + this.source
                    + '/' + ipcr_id);
            }
        },
        recallAddIPCRTarget(id_target, ipcr_id) {
            let text = "WARNING\nAre you sure you want to recall this additional target?";
            if (confirm(text) == true) {
                var url = "/ipcrtargets/recall/" + id_target + "/additional/ipcr/targets/" + this.source;
                this.$inertia.post(url);
                // this.$inertia.post("/ipcrtargetsreview/recall/my/target/" + this.source
                //     + '/' + ipcr_id);
            }
        },
        showCreate() {
            this.$inertia.get(
                "/targets/create",
                {
                    raao_id: this.raao_id
                },
                {
                    preserveScroll: true,
                    preserveState: true,
                    replace: true,
                }
            );
        },
        deletePAPS(id) {
            let text = "WARNING!\nAre you sure you want to delete the Program and Projects? " + id;
            if (confirm(text) == true) {
                this.$inertia.delete("/paps/" + id + "/" + this.idmfo);
            }
        },
        getToRep() {
            // alert(data[0].FFUNCCOD);
            // alert(this.pgHead)
            var linkt = "http://";
            var jasper_ip = this.jasper_ip;
            var jasper_link = 'jasperserver/flow.html?pp=u%3DJamshasadid%7Cr%3DManager%7Co%3DEMEA,Sales%7Cpa1%3DSweden&_flowId=viewReportFlow&reportUnit=%2Freports%2FIPCR%2FIPCR_Target&standAlone=true&ParentFolderUri=%2Freports%2FIPCR&standAlone=true&decorate=no&output=pdf';
            this.position_long_title = this.auth.user.name.position_long_title
            var div1 = "";
            if (this.division) {
                div1 = this.division;
            } else {
                div1 = this.my_div;
            }
            var params = '&id=' + this.sem_id +
                '&employee_name=' + this.emp.employee_name +
                '&emps_status=' + this.emp.employment_type_descr.toUpperCase() +
                '&office=' + this.office.FFUNCTION.toUpperCase() +
                '&division=' + div1 +
                '&immediate=' + this.imm +
                '&next_higher=' + this.nxt +
                '&sem=' + this.sem +
                '&year=' + this.year +
                '&position=' + this.position_long_title +
                '&period=' + this.period.toUpperCase() +
                '&pghead=' + this.pgHead +
                '&status=' + this.status;
            console.log(params);
            var link1 = linkt + jasper_ip + jasper_link + params;
            return link1;
        },

        showModal(my_sem_id, sem, my_year, immed, next, status, div) {
            //this.my_link = this.getToRep(ffunccod, ffunction, MOOE, PS);
            // sem.next.first_name + ' ' + sem.next.middle_name[0] + '. ' + sem.next.last_name,
            // sem.imm.first_name + ' ' + sem.imm.middle_name[0] + '. ' + sem.imm.last_name,
            console.log(next);
            this.sem_id = my_sem_id;
            this.period = this.getPeriod(sem, my_year);
            this.sem = this.getSemester(sem);
            this.year = my_year;
            this.my_div = div;
            if (next.middle_name[0] !== undefined) {
                this.nxt = next.first_name + ' ' + next.middle_name[0] + '. ' + next.last_name;
            } else {
                this.nxt = next.first_name + ' ' + next.last_name;
            }

            if (next.postfix_name !== undefined) {
                this.nxt = this.nxt + ', ' + next.postfix_name;
            }
            if (next.suffix_name[0] !== undefined) {
                this.nxt = this.nxt + ', ' + next.suffix_name;
            }

            if (immed.middle_name[0] !== undefined) {
                this.imm = immed.first_name + ' ' + immed.middle_name[0] + '. ' + immed.last_name;
            } else {
                this.imm = immed.first_name + ' ' + immed.last_name;
            }

            if (immed.postfix_name[0] !== undefined) {
                this.imm = this.imm + ', ' + immed.postfix_name;
            }
            if (immed.suffix_name[0] !== undefined) {
                this.imm = this.imm + ', ' + immed.suffix_name;
            }
            this.status = status;
            this.my_link = this.getToRep();
            this.displayModal = true;
        },

        hideModal() {
            this.displayModal = false;
        },

        showModal2(ipcr_id_passed_here, from, to) {
            // this.current_period = this.formatMonth(from) + " to " + this.formatMonthYear(to);
            // this.opcr_id_passed = opcr_id_passed_here;
            // this.my_link = this.viewlink(FFUNCCOD, total, ave, dept_head, opcr_date, mooe, ps, id);
            this.displayModal2 = true;
            this.ipcr_id_passed = ipcr_id_passed_here;
        },
        hideModal2() {
            this.displayModal2 = false;
        },
        copyIPCR() {
            // alert(" ipcr_id_copied: " + this.ipcr_id_copied + " ipcr_id_passed: " + this.ipcr_id_passed);
            if (this.ipcr_id_copied != this.ipcr_id_passed) {
                let text = "WARNING!\nAre you sure you want to copy target ?";
                if (confirm(text) == true) {
                    var url = "/ipcrsemestral/FROM/" + this.ipcr_id_copied + "/TO/" + this.ipcr_id_passed;
                    this.$inertia.post(url);
                }
            } else {
                alert("Select a different IPCR to copy!");
            }
        },
        isfifteenDaysLate(year, sem) {
            const currentDate = new Date();
            let lastDayOfSemester;
            var year2 = parseFloat(year) + 1;
            // Set the last day of the semester based on semester type
            if (sem == 1) { // First semester
                lastDayOfSemester = new Date(year, 6, 15); // June 30th
            } else if (sem == 2) { // Second semester
                lastDayOfSemester = new Date(year2, 0, 15); // December 31st
            }
            let cond = currentDate < lastDayOfSemester;
            let myReturn = "Current " + currentDate + " lastDay: " + lastDayOfSemester + " valuecond: " + cond;
            return cond;
        },
        lastDaySem(year, sem) {
            const currentDate = new Date();
            let lastDayOfSemester;
            var year2 = parseFloat(year) + 1;
            // Set the last day of the semester based on semester type
            if (sem == 1) { // First semester
                lastDayOfSemester = new Date(year, 6, 15); // June 30th
            } else if (sem == 2) { // Second semester
                lastDayOfSemester = new Date(year2, 0, 15); // December 31st
            }
            let cond = currentDate < lastDayOfSemester;
            let myReturn = "Current " + currentDate + " lastDay: " + lastDayOfSemester + " valuecond: " + cond;
            return cond;

        },
        hideModal3() {
            this.displayModal3 = false;
        },
        showModal4(my_id, empl_id, e_year, e_sem, e_stat) {
            // alert('my_id: '+my_id+" "+empl_id);
            // this.emp_name = e_name;
            this.emp_year = e_year;
            this.emp_sem = e_sem;
            this.emp_status = e_stat;
            this.emp_sem_id = my_id;
            this.empl_id = empl_id;
            axios.get("/ipcrtargets/get/ipcr/targets", {
                params: {
                    sem_id: my_id,
                    empl_id: empl_id
                }
            }).then((response) => {
                this.ipcr_targets = response.data;
            }).catch((error) => {
                console.error(error);
            });
            // this.displayModal = true;
            this.hideModal2()
            this.hideModal()
            // alert("ipcr_semestral_id: " + this.form.ipcr_semestral_id +
            //     " ipcr_semestral_id: " + this.form.ipcr_semestral_id +
            //     " ipcr_semestral_id: " + this.form.ipcr_semestral_id)
            this.displayModal3 = true

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
