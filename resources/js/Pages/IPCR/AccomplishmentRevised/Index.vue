<template>

    <Head>
        <title>Home</title>
    </Head>

    <!--<p style="text-align: justify;">Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit amet consectetur.
    </p>-->
    <div class="row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <!--SEMESTRAL***************************************************************************************-->
            <h3>Accomplishment</h3>
            <div class="peers">
                <!-- <div class="peer mR-10">
                    <input v-model="search" type="text" class="form-control form-control-sm" placeholder="Search...">
                </div> -->
                <!-- <div class="peer"> -->
                <!-- /ipcrsemestral/create/{{ id }}/semestral {{ source }} -->
                <!-- <Link class="btn btn-primary btn-sm" :href="`/ipcrsemestral/create/${id}/${source}`">Add IPCR </Link>
                </div> -->
                <Link v-if="source !== 'direct'" :href="`/employees`">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-lg"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z" />
                    <path fill-rule="evenodd"
                        d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z" />
                </svg>
                </Link>
                <!-- <button class='btn btn-primary text-white' @click="generateIPCR()">Generate IPCR</button> -->
            </div>

        </div>
        <div>
            <div><b>Employee Name: </b><u>{{ emp.employee_name }}</u></div>
            <div><b>Position: </b><u>{{ emp.position_long_title }}</u></div>
            <div><b>Division: </b><u>{{ division }}</u></div>
        </div>

        <div class="masonry-sizer col-md-6"></div>
        <div class="masonry-item w-100">
            <div class="row gap-20"></div>
            <div class="bgc-white p-20 bd">
                <div class="table-responsive">
                    <!--table-borderless table-striped -->
                    <table class="table table-sm table-hover table-borderless table-striped">
                        <thead>
                            <tr style="background-color: #B7DEE8;">
                                <th>&nbsp;&nbsp;</th>
                                <th>Semester</th>
                                <th>Period</th>
                                <th>Status</th>
                                <!-- <th>Actions</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(sem, index) in sem_data" :key="index">
                                <!-- MAIN BODY************************************************************************************** -->
                                <tr :class="{ opened: opened.includes(sem.id) }" @click="toggle(sem.id, index)"
                                    style="cursor: pointer">
                                    <td>

                                        <a class="dropdown-toggle" href="javascript:void(0);">
                                            <span class="icon-holder">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-clipboard-check-fill"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M6.5 0A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3Zm3 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3Z" />
                                                    <path
                                                        d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1A2.5 2.5 0 0 1 9.5 5h-3A2.5 2.5 0 0 1 4 2.5v-1Zm6.854 7.354-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708Z" />
                                                </svg>
                                            </span>
                                            <span class="arrow">
                                            </span>
                                        </a>
                                    </td>
                                    <td>
                                        <span v-if="sem.prob_type=='s'">
                                            {{ getSemester(sem.sem) }}
                                        </span>
                                        <span v-else>
                                            <i>Not Applicable ({{ sem.prob_type }})</i>
                                            <!-- {{sem.prob_type}}
                                            {{ sem.probationary_temporary_employee }} -->
                                            <!-- {{ getMonthRange(sem.probationary_temporary_employee.date_from, sem.probationary_temporary_employee.date_to) }} -->
                                        </span>
                                    </td>
                                    <td>
                                        <span v-if="sem.prob_type=='s'">{{ getPeriod(sem.sem, sem.year) }}</span>
                                        <span v-else>

                                            <!-- {{sem.prob_type}}
                                            {{ sem.probationary_temporary_employee }} -->
                                            {{ getMonthRange(sem.probationary_temporary_employee.date_from, sem.probationary_temporary_employee.date_to) }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ getStatus(sem.status_accomplishment.toString()) }}
                                    </td>
                                </tr>
                                <!-- TRANSITION BODY************************************************************************************** -->
                                <tr v-if="opened.includes(sem.id)">
                                    <td colspan="6" class="background-white">
                                        <!---->
                                        <Transition name="bounce">
                                            <!-- v-if="show" -->
                                            <p v-if="show[index]">
                                            <table class="table-responsive full-width">
                                                <!-- HEADING ************************************************************************** -->
                                                <tbody>
                                                    <tr>
                                                        <th></th>
                                                        <th class="text-white text-center "
                                                            style="background-color: #727272;" colspan="3">
                                                            <h6>&nbsp;&nbsp;MONTHLY ACCOMPLISHMENT</h6>
                                                        </th>
                                                        <th></th>
                                                    </tr>
                                                </tbody>
                                                <!-- PERIOD ************************************************************************** -->
                                                <tbody>
                                                    <tr>
                                                        <td rowspan="2"></td>
                                                        <th class="my-td text-center text-white"
                                                            style="background-color: #92a2a2;" rowspan="2">
                                                            &nbsp;&nbsp;PERIOD
                                                        </th>
                                                        <th class="my-td text-center text-white"
                                                            style="background-color: #92a2a2;" rowspan="2">STATUS</th>
                                                        <th class="my-td text-center text-white"
                                                            style="background-color: #92a2a2;" colspan="1">ACTIONS</th>
                                                        <td rowspan="2"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="my-td text-center text-white"
                                                            style="background-color: #727272;">VIEW</th>
                                                    </tr>
                                                </tbody>
                                                <!-- DATA ************************************************************************** -->
                                                <tbody>
                                                    <!-- {{ sem.monthly_accomplishment }} -->
                                                    <!-- MONTHLY **********************************************************************-->
                                                    <tr v-for="my_sem in sem.monthly_accomplishment">
                                                        <td>&nbsp;&nbsp;&nbsp;
                                                            <!-- {{ sem.id }} -->

                                                        </td>
                                                        <td class="my-td text-center">&nbsp;&nbsp;
                                                            <span v-if="sem.prob_type=='s'">
                                                                {{ getMonthName(my_sem.month) }} {{ my_sem.year }}
                                                                <!-- <p>allow_month_backtrack: {{ my_sem.allow_month_backtrack }}</p>
                                                                <p>deadline: {{ my_sem.deadline.deadline }}</p> -->
                                                            </span>
                                                            <span v-else>
                                                                <!-- {{sem.prob_type}}
                                                                {{ sem.probationary_temporary_employee }} -->

                                                                {{ getDateToByMonth(sem.probationary_temporary_employee.date_from, my_sem.month) }}
                                                                to
                                                                {{ getDateToByMonth(sem.probationary_temporary_employee.date_to, my_sem.month) }}
                                                            </span>
                                                        </td>
                                                        <td class="my-td text-center">
                                                            {{ getStatus(my_sem.status) }}
                                                            <!-- - {{ my_sem.status }} -->
                                                            <p v-if="getStatus(my_sem.status) == 'Returned'">
                                                                Remarks:
                                                                <span v-if="my_sem.return_remarks">{{ my_sem.return_remarks.remarks }}</span>
                                                            </p>
                                                        </td>
                                                        <td class="my-td text-center">
                                                            <!-- {{ my_sem.status==0?'z':'a' }} -->
                                                            <!-- COMMON SEMESTRAL TARGETS***************************************** -->
                                                            <span v-if="sem.prob_type=='s'">

                                                                <span v-if="isPastDate(sem.sem, my_sem.month, my_sem.year) && my_sem.status<0 && (String(my_sem.allow_month_backtrack) === '1' || !isPastDeadline(my_sem.deadline.deadline))">
                                                                    <button
                                                                        class="btn btn-success text-white"
                                                                        @click="submitAccomplishmentFOrThisMonth(sem.id, my_sem.month, my_sem.year, my_sem.status)"
                                                                        >
                                                                        Submit
                                                                    </button> &nbsp;
                                                                </span>
                                                            </span>
                                                            <!-- PROBATIONARY/TEMPORARY ***************************************** -->
                                                            <span v-else>
                                                                <!-- {{ sem.probationary_temporary_employee }} -- -->
                                                                <!-- {{ isPastDateToProbTempo(sem.probationary_temporary_employee.date_to, my_sem.month) }} -- -->
                                                                <button v-if="parseFloat(my_sem.status) < 0 && isPastDateToProbTempo(sem.probationary_temporary_employee.date_to, my_sem.month)"
                                                                    class="btn btn-success text-white"
                                                                    @click="submitAccomplishmentFOrThisMonth(sem.id, my_sem.month, my_sem.year, my_sem.status)"
                                                                    >
                                                                    Submit
                                                                </button> &nbsp;
                                                            </span>
                                                            <!-- RECALL********************************************************** -->
                                                            <span v-if="parseFloat(my_sem.status) == 0">
                                                                <button class="btn btn-info text-white"
                                                                    @click="recallAccomplishmentFOrThisMonth(sem.id, my_sem.month, my_sem.year)"
                                                                >
                                                                    Recall
                                                                </button> &nbsp;
                                                            </span>
                                                            <!-- v-if="parseFloat(my_sem.status) == 2" -->
                                                            <!-- VIEW *********************************************************** -->
                                                            <span >
                                                                <!-- {{ getMonthName(my_sem.month) }}
                                                                {{ getMonthName(getMonthNumberFromDateFrom(sem.probationary_temporary_employee.date_from, my_sem.month)) }} -->
                                                                <button
                                                                    @click="JanuaryAccomplishment(
                                                                        sem.prob_type === 's'
                                                                            ? getMonthName(my_sem.month)
                                                                            : getMonthName(getMonthNumberFromDateFrom(sem.probationary_temporary_employee.date_from, my_sem.month)),
                                                                        sem.year,
                                                                        my_sem.ipcr_semestral_id
                                                                    )"
                                                                    class="btn btn-primary text-white">
                                                                    View
                                                                </button>
                                                            </span>
                                                        </td>
                                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                    </tr>
                                                    <!-- FIRST HALF **********************************************************************-->
                                                    <tr v-if="sem.prob_type!='s'">
                                                        <td></td>
                                                        <td class="my-td text-center">
                                                            <b>{{ getHalfPeriodRange(sem.prob_type, '1', sem.probationary_temporary_employee) }}</b>
                                                            <!-- {{sem.prob_type}} -->
                                                            <div v-if="sem.prob_type=='Temporary'">(<i>First half of the temporary period</i>)</div>
                                                            <div v-else>(First three months)</div>
                                                        </td>
                                                        <td class="my-td text-center">
                                                            <!-- {{ sem.probationary_temporary_employee.half_indicator }} -->
                                                            {{ getStatus(sem.period_1_status) }}
                                                        </td>
                                                        <td class="my-td text-center">
                                                            <span v-if="parseFloat(sem.period_1_status)<0">
                                                                <!-- {{ sem.monthly_accomplishment }} -- PROBTYPE: {{ sem.prob_type }} -->
                                                                <button
                                                                    class="btn btn-success text-white"
                                                                    v-if="parseFloat(sem.status_accomplishment)<0 && sem.prob_type=='Probationary'"
                                                                    @click="submitSemestralHalfAccomplishment(sem.id, '1')"
                                                                    :disabled="!areAllMonthsApprovedInHalf(sem.prob_type, '1', sem.monthly_accomplishment) ||
                                                                        parseFloat(sem.period_1_status)>=0"
                                                                >
                                                                    Submit
                                                                </button> &nbsp;
                                                                <!-- {{ formatStringToDateArray(sem.probationary_temporary_employee.date_from) }}
                                                                {{ formatStringToDateArray(sem.probationary_temporary_employee.date_to) }}
                                                                {{ sem.probationary_temporary_employee.date_from }} -->
                                                                <button
                                                                    class="btn btn-success text-white"
                                                                    v-if="parseFloat(sem.status_accomplishment)<0 && sem.prob_type=='Temporary'"
                                                                    @click="submitSemestralHalfAccomplishment(sem.id, '1')"
                                                                    :disabled="!areAllMonthsApprovedInHalfDynamic(
                                                                        sem.prob_type,
                                                                        '1',
                                                                        sem.monthly_accomplishment,
                                                                        sem.probationary_temporary_employee.half_indicator,
                                                                        formatStringToDateArray(sem.probationary_temporary_employee.date_to
                                                                    )
                                                                    ) ||
                                                                        parseFloat(sem.period_1_status)>=0"
                                                                >
                                                                    Submit
                                                                </button> &nbsp;
                                                            </span>
                                                            <span>
                                                                <button class="btn btn-info text-white"
                                                                    v-if="parseFloat(sem.period_1_status)==0"
                                                                    @click="submitSemestralAccomplishment(sem.id, sem.sem, sem.year,-1)"
                                                                    >
                                                                    Recall
                                                                </button> &nbsp;
                                                            </span>
                                                            <Link
                                                                :href="`/semester-accomplishment/semestral/accomplishment/${sem.id}/half/1`"
                                                                class="btn btn-primary text-white"
                                                            >
                                                                View
                                                            </Link>
                                                        </td>
                                                    </tr>
                                                    <!-- SECOND HALF **********************************************************************-->
                                                    <tr v-if="sem.prob_type!='s'">
                                                        <td></td>
                                                        <td class="my-td text-center">
                                                            <b>{{ getHalfPeriodRange(sem.prob_type, '2', sem.probationary_temporary_employee) }}</b>
                                                            <!-- (Second Three Months) -->
                                                            <div v-if="sem.prob_type=='Temporary'">(<i>Second half of the temporary period</i>)</div>
                                                            <div v-else>(Second three months)</div>
                                                        </td>
                                                        <td class="my-td text-center">
                                                            {{ getStatus(sem.period_2_status) }}</td>
                                                        <td class="my-td text-center">
                                                            <span v-if="parseFloat(sem.period_2_status)<0">
                                                                <button
                                                                    class="btn btn-success text-white"
                                                                    v-if="parseFloat(sem.status_accomplishment)<0 && sem.prob_type=='Probationary'"
                                                                    @click="submitSemestralHalfAccomplishment(sem.id, '2')"
                                                                    :disabled="!areAllMonthsApprovedInHalf(sem.prob_type, '2', sem.monthly_accomplishment)"
                                                                    >
                                                                    Submit
                                                                </button> &nbsp;
                                                                <button
                                                                    class="btn btn-success text-white"
                                                                    v-if="parseFloat(sem.status_accomplishment)<0 && sem.prob_type=='Temporary'"
                                                                    @click="submitSemestralHalfAccomplishment(sem.id, '2')"
                                                                    :disabled="!areAllMonthsApprovedInHalfDynamic(
                                                                        sem.prob_type,
                                                                        '2',
                                                                        sem.monthly_accomplishment,
                                                                        sem.probationary_temporary_employee.half_indicator,
                                                                        formatStringToDateArray(sem.probationary_temporary_employee.date_to)
                                                                    )"
                                                                    >
                                                                    Submit
                                                                </button>
                                                            </span>
                                                            <span>
                                                                <button class="btn btn-info text-white"
                                                                    v-if="parseFloat(sem.status_accomplishment)==0"
                                                                    @click="submitSemestralAccomplishment(sem.id, sem.sem, sem.year,-1)"
                                                                    >
                                                                    Recall
                                                                </button> &nbsp;
                                                            </span>
                                                            <Link
                                                                :href="`/semester-accomplishment/semestral/accomplishment/${sem.id}/half/2`"
                                                                class="btn btn-primary text-white"
                                                            >
                                                                View
                                                            </Link>
                                                        </td>
                                                    </tr>
                                                    <!-- SEMESTRAL *********************************************************************-->
                                                    <tr v-if="sem.prob_type=='s'">
                                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                                        <td class="my-td text-center">&nbsp;&nbsp;
                                                            <!-- {{ getPeriod(sem.sem, sem.year) }} -->
                                                            <strong>
                                                                <span v-if="sem.prob_type=='s'">{{ getPeriod(sem.sem, sem.year) }}</span>
                                                                <span v-else>
                                                                    {{ getMonthRange(sem.probationary_temporary_employee.date_from, sem.probationary_temporary_employee.date_to) }}
                                                                </span>
                                                            </strong>
                                                        </td>
                                                        <td class="my-td text-center">
                                                            <!-- {{ sem.status_accomplishment }} -->
                                                            <!-- {{ getStatus(sem.status_accomplishment.toString()) }} -->
                                                        </td>
                                                        <td class="my-td text-center">
                                                            <!-- period_2_status: {{ sem.period_2_status }} -->
                                                            <!-- allStatusAccomplishmentAreTwo: {{ allStatusAccomplishmentAreTwo(sem_data) }} -->
                                                            <span>
                                                                <button
                                                                    class="btn btn-success text-white"
                                                                    v-if="parseFloat(sem.status_accomplishment)<0"
                                                                    @click="submitSemestralAccomplishment(sem.id, sem.sem, sem.year,0)"
                                                                    :disabled="!allStatusAccomplishmentAreTwo(sem.monthly_accomplishment)"
                                                                    >
                                                                    Submit
                                                                </button> &nbsp;
                                                                <!-- {{ sem.monthly_accomplishment }} -->
                                                            </span>
                                                            <span>
                                                                <button class="btn btn-info text-white"
                                                                    v-if="parseFloat(sem.status_accomplishment)==0"
                                                                    @click="submitSemestralAccomplishment(sem.id, sem.sem, sem.year,-1)"
                                                                    >
                                                                    Recall
                                                                </button> &nbsp;
                                                            </span>
                                                            <!-- v-if="parseFloat(sem.status_accomplishment)==2"  -->
                                                            <Link
                                                                :href="`/semester-accomplishment/semestral/accomplishment/${sem.id}`"
                                                                class="btn btn-primary text-white"
                                                            >
                                                                View
                                                            </Link>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            </p>
                                        </Transition>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                    <!-- <pagination :next="sem_data.next_page_url" :prev="sem_data.prev_page_url" /> -->
                </div>
            </div>
        </div>
        <Modal v-if="displayModal" @close-modal-event="hideModal">
            <div class="d-flex justify-content-center">
                <h4>{{ modal_title }}</h4>
            </div>
        </Modal>
        <!-- {{ sem_data[0].monthly_accomplishment }} -->
        <!-- <div v-if="show">show</div> -->
    </div>
</template>
<script>
import Filtering from "@/Shared/Filter";
import Pagination from "@/Shared/Pagination";
import Modal from "@/Shared/PrintModal";
export default {
    props: {
        data: Object,
        MOOE: String,
        PS: String,
        id: String,
        emp: Object,
        division: Object,
        source: String,
        sem_data: Object,
        shown_id: String
    },
    mounted() {
        // alert(this.shown_id)
    },
    data() {
        return {
            my_link: "",
            displayModal: false,
            modal_title: "Add",
            opened: [],
            sem1: ['January', 'February', 'March', 'April', 'May', 'June'],
            sem2: ['July', 'August', 'September', 'October', 'November', 'December'],
            // show: false,
            show: [],
            //search: this.$props.filters.search,
        }
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
        Pagination, Filtering, Modal,
    },
    mounted() {

        this.setShow()
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
        submitIPCRAccomplishment(ipcr_id, period) {
            // alert(ipcr_id);
            let text = "WARNING!\nAre you sure you want to submit your IPCR accomplishment for the period of "+period +"?";
            if (confirm(text) == true) {
                this.$inertia.post("/ipcrsemestral/accomplishment/submit/" + ipcr_id + '/' + this.source);
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
        getToRep(ffunccod, ffunction, MOOE, PS) {
            // alert(data[0].FFUNCCOD);
            var linkt = "http://";
            var jasper_ip = this.jasper_ip;
            var jasper_link = 'jasperserver/flow.html?pp=u%3DJamshasadid%7Cr%3DManager%7Co%3DEMEA,Sales%7Cpa1%3DSweden&_flowId=viewReportFlow&_flowId=viewReportFlow&_flowId=viewReportFlow&ParentFolderUri=%2Freports%2Fplanning_system%2FOPCR_Standard&reportUnit=%2Freports%2Fplanning_system%2FOPCR_Standard%2FOPCR&standAlone=true&decorate=no&output=pdf';
            var params = '&id=' + ffunccod + '&FUNCTION=' + ffunction + '&MOOE=' + MOOE + '&PS=' + PS;
            var link1 = linkt + jasper_ip + jasper_link + params;
            return link1;
        },
        showModal(title_pass, emp_id) {
            //this.my_link = this.getToRep(ffunccod, ffunction, MOOE, PS);
            if (title_pass === "add") {
                this.modal_title = "Add";
            } else {
                this.modal_title = "Edit";
            }
            this.displayModal = true;

        },
        hideModal() {
            this.displayModal = false;
        },
        JanuaryAccomplishment(month, year, ipcr_semestral_id) {
            this.$inertia.get(
                "/Accomplishment",
                {
                    month: month,
                    year: year,
                    ipcr_semestral_id: ipcr_semestral_id
                },
                {
                    preserveScroll: true,
                    preserveState: true,
                    replace: true,
                }
            );
        },
        setShow() {
            for (var x = 0; x < this.sem_data.length; x++) {
                this.show.push(false);
            }
        },
        toggle(id, i) {
            // alert(this.sem_data.length)
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
                // this.show = !this.show;
                for (var t = 0; t < this.sem_data.length; t++) {
                    if (i != t) {
                        this.show[t] = false
                    }
                }
                this.show[i] = !this.show[i];
            }, 100);
        },
        submitMonthlyAccomplishment(my_id, id_shown) {
            // alert(id)
            let text = "WARNING!\nAre you sure you want to submit this Monthly Accomplishment? ";
            if (confirm(text) == true) {
                const params = {
                    id_shown: id_shown
                };
                const url = '/monthly-accomplishment/submit/monthly/accomplishment/' + my_id;
                // axios.get(url);
                this.$inertia.get(url, params, {
                    preserveState: true,
                });
            }

        },
        generateIPCR() {
            const url = '/monthly-accomplishment/generate/monthly';
            axios.get(url);
        },
        submitAccomplishmentFOrThisMonth(id_shown, month_s, year_s, month_status) {
            // my_id, id_shown
            // , month_s, year_s, month_s
            // alert("submitAccomplishmentFOrThisMonth");
            let text = "WARNING!\nAre you sure you want to submit this Monthly Accomplishment? ";
            const url = '/new-submission/accomplishment/monthly';
            // alert(url);
            if (confirm(text) == true) {
                const params = {
                    id: id_shown,
                    month: this.getMonthName(month_s),
                    year: year_s,
                    status: month_status
                };
                // axios.get(url);
                this.$inertia.get(url, params, {
                    preserveState: true,
                });
            }
        },
        recallAccomplishmentFOrThisMonth(id_shown, month_s, year_s) {
            let text = "WARNING!\nAre you sure you want to recall this Monthly Accomplishment? ";
            const url = '/new-submission/accomplishment/monthly/recall';
            // alert(url);
            if (confirm(text) == true) {
                const params = {
                    id: id_shown,
                    month: this.getMonthName(month_s),
                    year: year_s
                };
                // axios.get(url);
                this.$inertia.post(url, params, {
                    preserveState: true,
                });
            }
        },
        submitSemestralAccomplishment(id, sem, year,status) {
            let text = "WARNING!\nAre you sure you want to submit this Semestral Accomplishment? ";
            const url = '/ipcrsemestral/submit/accomplishment/'+id+'/sem';
            // alert(url);
            if (confirm(text) == true) {
                const params = {
                    id: id,
                    sem: sem,
                    year: year,
                    status: status
                };
                // axios.get(url);
                this.$inertia.post(url, params, {
                    preserveState: true,
                });
            }

        },
        submitSemestralHalfAccomplishment(id, period) {
            let text = "WARNING!\nAre you sure you want to submit this Semestral Accomplishment half? ";
            const url = `/ipcrsemestral/submit/accomplishment/half/${id}/${period}`;
            if (confirm(text) == true) {
                this.$inertia.post(url, { period: period }, {
                    preserveState: true,
                });
            }
        },
        allStatusAccomplishmentAreTwo(sem_data) {
            var stat = true;
            // for (let i = 0; i < sem_data.length; i++) {
            //     let monthly = sem_data[i].monthly_accomplishment;

            //     for (let j = 0; j < monthly.length; j++) {
            //         if (parseFloat(monthly[j].status) !== 2) {
            //             console.log(
            //                 "Fail at sem_data[${"+i+"}].monthly_accomplishment[${"+j+"}]:",
            //                 monthly[j].status, monthly[j]
            //             );
            //             stat=false;
            //         }
            //     }
            // }
            for(let i=0; i<sem_data.length; i++){
                if(parseFloat(sem_data[i].status) !== 2){
                    stat=false;
                    console.log("Fail at sem_data[${"+i+"}]:", sem_data[i].status, sem_data[i]);

                }
            }
            // return sem_data.every(item => item.status_accomplishment == 2);
            return stat;
        },

        areAllMonthsApprovedInHalf(prob_type, half_period, monthly_accomplishments) {
            let splitIndex = prob_type === 'Probationary' ? 3 : 5;
            let start, end;
            var is_enabled= true;
            if (half_period === '1') {
                start = 0;
                end = splitIndex - 1;
            } else if (half_period === '2') {
                start = splitIndex;
                end = monthly_accomplishments.length - 1;
            } else {
                is_enabled = false;
            }
            console.log(`Checking months for ${half_period} half of a ${prob_type} employee:`);
            console.log('Start: ', start, 'End: ', end);
            console.log(monthly_accomplishments);
            for (let i = start; i <= end; i++) {
                if (parseFloat(monthly_accomplishments[i].status) !== 2) {
                    console.log(`Fail at monthly_accomplishments[${i}]:`, monthly_accomplishments[i].status, monthly_accomplishments[i]);
                    is_enabled = false;
                }
            }
            return is_enabled;
        },
        areAllMonthsApprovedInHalfDynamic(prob_type, half_period, monthly_accomplishments, half_indicator, date_to_array) {
            // prob_type: 'Probationary' or 'Temporary'
            // half_period: '1' for first half, '2' for second half
            // monthly_accomplishments: array of monthly accomplishment records
            // half_indicator: the end date of the first half period
            // date_to_array: array of month-end dates used to determine the split index
            let splitIndex;
            let start, end;
            let is_enabled = true;

            const dates = Array.isArray(date_to_array) ? date_to_array : this.parseArray(date_to_array);
            const indicator = half_indicator ? String(half_indicator).trim() : '';

            if (indicator && Array.isArray(dates) && dates.length) {
                const indicatorIndex = dates.findIndex(date => String(date).trim() === indicator);
                if (indicatorIndex !== -1) {
                    splitIndex = indicatorIndex + 1;
                }
            }
            console.log(date_to_array, half_indicator)
            console.log('Determined splitIndex:', splitIndex, half_period);
            if (splitIndex === undefined || splitIndex === null || isNaN(splitIndex)) {
                splitIndex = prob_type === 'Probationary' ? 3 : 5;
            }

            if (half_period === '1') {
                start = 0;
                end = splitIndex - 1;
            } else if (half_period === '2') {
                start = splitIndex;
                end = monthly_accomplishments.length - 1;
            } else {
                is_enabled = false;
            }

            console.log(`Checking months for ${half_period} half of a ${prob_type} employee:`);
            console.log('Start: ', start, 'End: ', end);
            console.log(monthly_accomplishments);
            for (let i = start; i <= end; i++) {
                if (parseFloat(monthly_accomplishments[i].status) !== 2) {
                    console.log(`Fail at monthly_accomplishments[${i}]:`, monthly_accomplishments[i].status, monthly_accomplishments[i]);
                    is_enabled = false;
                }
            }
            return is_enabled;
        },
        getMonthNumberFromDateFrom(dateFrom, monthIndex) {
            const dates = Array.isArray(dateFrom) ? dateFrom : this.parseArray(dateFrom);
            const index = parseInt(monthIndex, 10) - 1;
            if (!Array.isArray(dates) || dates.length === 0 || isNaN(index) || index < 0 || index >= dates.length) {
                return null;
            }
            const dateObj = new Date(dates[index]);
            if (isNaN(dateObj)) {
                return null;
            }
            return dateObj.getMonth() + 1;
        },

        isPastDeadline(deadlineStr) {
            if (!deadlineStr) return false;
            const d = new Date(deadlineStr);
            if (isNaN(d.getTime())) return false;
            const now = new Date();
            return now > d;
        },



        getMonthRange(dateFromStr, dateToStr) {
            const dateFrom = this.parseArray(dateFromStr);
            const dateTo = this.parseArray(dateToStr);

            if (!dateFrom.length || !dateTo.length) return null;

            const first = new Date(dateFrom[0]);
            const last = new Date(dateTo[dateTo.length - 1]);

            const fromMonth = first.toLocaleString('default', { month: 'long' });
            const fromYear = first.getFullYear();

            const toMonth = last.toLocaleString('default', { month: 'long' });
            const toYear = last.getFullYear();

            return `${fromMonth} ${fromYear} to ${toMonth} ${toYear}`;
        },

        // getDateFromByMonth(dateFromStr, month) {
        //     const dateFrom = this.parseArray(dateFromStr);
        //     return dateFrom[month - 1] ?? null;
        // },

        // getDateToByMonth(dateToStr, month) {
        //     const dateTo = this.parseArray(dateToStr);
        //     return dateTo[month - 1] ?? null;
        // }


        getHalfPeriodRange(prob_type, half_period, employee) {
            if (!employee || !employee.date_from || !employee.date_to) return '';

            let dateFrom = [];
            let dateTo = [];

            try {
                dateFrom = JSON.parse(employee.date_from);
                dateTo = JSON.parse(employee.date_to);
            } catch (e) {
                return '';
            }

            if (!dateFrom.length || !dateTo.length) return '';

            // Determine split index
            let splitIndex = prob_type === 'Probationary' ? 3 : 5;

            let startDate = '';
            let endDate = '';

            if (half_period === '1') {
                startDate = dateFrom[0];
                endDate = dateTo[splitIndex - 1]; // 3rd or 5th element
            } else {
                startDate = dateFrom[splitIndex];
                endDate = dateTo[dateTo.length - 1];
            }

            if (!startDate || !endDate) return '';

            // Format: Month Year
            const formatDate = (dateStr) => {
                const d = new Date(dateStr);
                return d.toLocaleString('en-US', {
                    month: 'long',
                    day: 'numeric',
                    year: 'numeric'
                });
            };

            return `${formatDate(startDate)} to ${formatDate(endDate)}`;
        }

    }
};
</script>
<style>
/***TABLE FULL WIDTH */
.full-width {
    width: 100%;
}

/**ACCORDION BEGIN*********************/
.my-table {
    width: 100%;
    border: 1px solid #ccc;
}

.my-td {
    padding: 2px;
    border: 1px solid #ccc;
}

.opened {
    background-color: rgb(2, 255, 251);
}

/**ACCORDION END*********************/
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

/*TOGGLE FADE TRANSITION*/
.v-enter-active,
.v-leave-active {
    transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}

/* transition */
.bounce-enter-active {
    animation: bounce-in 0.5s;
}

.bounce-leave-active {
    animation: bounce-in 0.5s reverse;
}

@keyframes bounce-in {
    0% {
        transform: scale(0);
    }

    50% {
        transform: scale(1.1);
    }

    100% {
        transform: scale(1);
    }


}
</style>
