<template>

    <Head>
        <title>Home</title>
    </Head>

    <!--<p style="text-align: justify;">Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit amet consectetur.
    </p>-->
    <div class="row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <!--SEMESTRAL***************************************************************************************-->
            <h3>Review/Approve Semestral Accomplishment</h3>
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
                                    {{ getPeriod(accomp.sem, accomp.year) }}
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
                                                    @click="showModals(accomp.id, accomp.empl_id, accomp.a_status, accomp.imm_id, accomp.next_higher_id)">
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
                <div>
                    <div><b>Employee Name: </b><u>{{ ipcr_accomplishments_review.sem.user_employee.first_name + " " +
                        ipcr_accomplishments_review.sem.user_employee.last_name }}</u>
                    </div>
                    <div><b>Position: </b><u>{{ ipcr_accomplishments_review.sem.user_employee.position_title1 }}</u>
                    </div>
                </div>
                <div>
                    <b>Semester/Period: </b>
                    <u>
                        {{ sem(ipcr_accomplishments_review.sem.sem) }}
                    </u>
                </div>
                <div>
                    <b>Status: <u>{{ Status(ipcr_accomplishments_review.sem_data.status_accomplishment) }}</u></b>

                </div>
                <div class="masonry-item w-100">
                    <div class="bgc-white p-20 bd">

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered border-dark">
                                <thead>
                                    <tr style="background-color: #B7DEE8;" class="text-center table-bordered">
                                        <th style="width: 5%;" rowspan="2" colspan="1">IPCR Code</th>
                                        <th style="width: 15%;" rowspan="2" colspan="1">Major Final Output</th>
                                        <th style="width: 30%;" rowspan="2" colspan="1">Success Indicator</th>
                                        <th style="width: 20%;" colspan="4">Rating</th>
                                        <th style="width: 20%;" rowspan="2" colspan="1">Remarks</th>
                                    </tr>
                                    <tr style="background-color: #B7DEE8;" class="text-center">
                                        <th style="width: 5%;">Quantity Rating</th>
                                        <th style="width: 5%;">Quality Rating</th>
                                        <th style="width: 5%;">Timeliness Rating</th>
                                        <th style="width: 5%;">Average</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="9">
                                            <b>CORE FUNCTION</b>
                                        </td>
                                    </tr>
                                    <template v-for="dat in ipcr_accomplishments_review.data">
                                        <tr v-if="dat.ipcr_type === 'Core Function'" class="text-center">
                                            <td style="text-align: center; background-color: #edd29d">{{ dat.ipcr_code
                                                }}</td>
                                            <td>{{ dat.mfo_desc }}</td>
                                            <td>{{ dat.success_indicator }}</td>
                                            <td>
                                                {{ dat.result.length == 0 ? 0 : QuantityRate(dat.quantity_type,
                        GetSumQuantity(dat.result), dat.quantity_sem)
                                                }}
                                            </td>
                                            <td>
                                                {{ dat.result.length == 0 ? 0 : QualityRating(dat.quality_error,
                        QualityTypes(dat.quality_error,
                            GetSumQuality(dat.result), CountMonth(dat.result))) }}
                                            </td>
                                            <td>
                                                {{ TimeRatings(AveTime(TotalTime(dat.result),
                        GetSumQuantity(dat.result)),
                        dat.indi_output.time_ranges, dat.time_range_code) }}
                                            </td>
                                            <td>
                                                {{ AverageRate(dat.result.length == 0 ? 0 :
                        QuantityRate(dat.quantity_type, GetSumQuantity(dat.result),
                            dat.quantity_sem),
                        dat.result.length == 0 ? 0 : QualityRating(dat.quality_error,
                            QualityTypes(dat.quality_error,
                                GetSumQuality(dat.result), CountMonth(dat.result))),
                        TimeRatings(AveTime(TotalTime(dat.result),
                            GetSumQuantity(dat.result)),
                            dat.indi_output.time_ranges, dat.time_range_code)) }}
                                            </td>
                                            <td>{{ dat.remarks }}</td>
                                        </tr>
                                    </template>
                                    <tr>
                                        <td colspan="7">
                                            <b style="float:right">Average Point Score - Core Function</b>
                                        </td>
                                        <td>
                                            {{ calculateAverageCore() }}
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
                                        <td colspan="9">
                                            <b>SUPPORT FUNCTION</b>
                                        </td>
                                    </tr>
                                    <template v-for="dat in ipcr_accomplishments_review.data">
                                        <tr v-if="dat.ipcr_type === 'Support Function'" class="text-center">
                                            <td style="text-align: center; background-color: #edd29d">{{ dat.ipcr_code
                                                }}</td>
                                            <td>{{ dat.mfo_desc }}</td>
                                            <td>{{ dat.success_indicator }}</td>
                                            <td>
                                                {{ dat.result.length == 0 ? 0 : QuantityRate(dat.quantity_type,
                        GetSumQuantity(dat.result), dat.quantity_sem) }}

                                            </td>
                                            <td>
                                                {{ dat.result.length == 0 ? 0 : QualityRating(dat.quality_error,
                        QualityTypes(dat.quality_error,
                            GetSumQuality(dat.result), CountMonth(dat.result))) }}
                                            </td>
                                            <td>{{ TimeRatings(AveTime(TotalTime(dat.result),
                        GetSumQuantity(dat.result)),
                        dat.indi_output.time_ranges, dat.time_range_code) }}
                                            </td>
                                            <td>
                                                {{ AverageRate(dat.result.length == 0 ? 0 :
                        QuantityRate(dat.quantity_type,
                            GetSumQuantity(dat.result),
                            dat.quantity_sem), dat.result.length == 0 ? 0 :
                        QualityRating(dat.quality_error,
                            QualityTypes(dat.quality_error,
                                GetSumQuality(dat.result), CountMonth(dat.result))),
                        TimeRatings(AveTime(TotalTime(dat.result), GetSumQuantity(dat.result)),
                            dat.indi_output.time_ranges, dat.time_range_code)) }}
                                            </td>

                                            <td>{{ dat.remarks }}</td>

                                        </tr>
                                    </template>
                                    <tr>
                                        <td colspan="7">
                                            <b style="float:right">Average Point Score - Support Function</b>
                                        </td>
                                        <td>
                                            {{ calculateAverageSupport() }}
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
                                            {{ ((Average_Point_Core * 0.70) + (Average_Point_Support * 0.30)).toFixed(2)
                                            }}
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
                                            <b>{{ ((Average_Point_Core * 0.70) + (Average_Point_Support *
                                                0.30)).toFixed(2)
                                                }}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">
                                            <b style="float:right">Final Adjectival Rating</b>
                                        </td>
                                        <td style="background-color: yellow">
                                            <b>{{ getAdjectivalRating(((Average_Point_Core * 0.70) +
                                                (Average_Point_Support *
                                                0.30)).toFixed(2)) }}</b>
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
                                            {{ ipcr_accomplishments_review.sem.latest_return_remark.remarks }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                        <div>
                            <b>Remarks:</b>
                            <input type="text" v-model="form.remarks" class="form-control"
                                autocomplete="chrome-off"><br>
                        </div>
                        <!-- {{ imm_id_loc }} &nbsp; {{ nxt_id_loc }} -->
                        <div style="align: center">
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
                            <button style="float: right;" class="btn btn-danger text-white"
                                @click="submitAction('-2', ipcr_accomplishments_review.sem_data.id.toString())">
                                Return
                            </button>
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
        this.calculateAverageSupport()
        this.calculateAverageCore()
    },
    methods: {
        sem(sem) {
            var result = ""
            if (sem == "1") {
                result = "January to June"
            } else if (sem == 2) {
                result = "July to December"
            }
            return result;
        },
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
        getAdjectivalRating(Score) {
            var result = ""
            if (Score >= 4.51 && Score <= 5.00) {
                result = "Outstanding"
            } else if (Score >= 3.51 && Score <= 4.50) {
                result = "Very Satisfactory"
            } else if (Score >= 2.51 && Score <= 3.50) {
                result = "Satisfactory"
            } else if (Score >= 1.51 && Score <= 2.50) {
                result = "Unsatisfactory"
            } else if (Score >= 1.00 && Score <= 1.50) {
                result = "Poor"
            }

            return result;
        },
        QualityRate(id, total) {
            var result;
            if (id == 1) {
                if (total == 0) {
                    result = "5"
                } else if (total >= .01 && total <= 2.99) {
                    result = "4"
                } else if (total >= 3 && total <= 4.99) {
                    result = "3"
                } else if (total >= 5 && total <= 6.99) {
                    result = "2"
                } else if (total >= 7) {
                    result = "1"
                } else {
                    result = "0"
                }
            } else if (id == 2) {
                if (total == 5) {
                    result = "5"
                } else if (total >= 4 && total <= 4.99) {
                    result = "4"
                } else if (total >= 3 && total <= 3.99) {
                    result = "3"
                } else if (total >= 2 && total <= 2.99) {
                    result = "2"
                } else if (total >= 1 && total <= 1.99) {
                    result = "1"
                } else {
                    result = "0"
                }
            } else if (id == 3) {
                result = "0"
            } else if (id == 4) {
                if (total >= 1) {
                    result = "2"
                } else {
                    result = "5"
                }
            }
            return result;
        },
        GetSumQuantity(Item) {
            var result = _.sumBy(Item.slice(0, 6), (o) => {
                return Number(o.quantity)
            });
            // console.log(result)
            return result;
        },

        QualityRating(quality_type, quality_score) {
            var result;
            if (quality_type == 1) {
                if (quality_score == 0) {
                    result = "5"
                } else if (quality_score >= .01 && quality_score <= 2.99) {
                    result = "4"
                } else if (quality_score >= 3 && quality_score <= 4.99) {
                    result = "3"
                } else if (quality_score >= 5 && quality_score <= 6.99) {
                    result = "2"
                } else if (quality_score >= 7) {
                    result = "1"
                } else {
                    result = "0"
                }
            } else if (quality_type == 2) {
                if (quality_score == 5) {
                    result = "5"
                } else if (quality_score >= 4 && quality_score <= 4.99) {
                    result = "4"
                } else if (quality_score >= 3 && quality_score <= 3.99) {
                    result = "3"
                } else if (quality_score >= 2 && quality_score <= 2.99) {
                    result = "2"
                } else if (quality_score >= 1 && quality_score <= 1.99) {
                    result = "1"
                } else {
                    result = "0"
                }
            } else if (quality_type == 3) {
                result = "0"
            } else if (quality_type == 4) {
                if (quality_score >= 1) {
                    result = "2"
                } else {
                    result = "5"
                }
            }

            return result;
        },
        QualityTypes(quality_type, score, length) {
            var result;
            if (quality_type == 1) {
                result = score;

                if (score == 0) {
                    result = 0;
                } else if (score >= 0.01 && score <= 1) {
                    result = 1;
                } else if (score >= 1.01 && score <= 2) {
                    result = 2;
                } else if (score >= 2.01 && score <= 3) {
                    result = 3;
                } else if (score >= 3.01 && score <= 4) {
                    result = 4;
                } else if (score >= 4.01 && score <= 5) {
                    result = 5;
                } else if (score >= 5.01 && score <= 6) {
                    result = 6;
                } else if (score >= 6.01 && score <= 7) {
                    result = 7;
                }
                return result;
            } else if (quality_type == 2) {
                if (length == 0) {
                    result = 0;
                } else {
                    result = Math.round(score / length);
                }
            } else if (quality_type == 3) {
                result = score;
            } else if (quality_type == 4) {
                result = score;
            }
            return result;
        },
        GetSumQuality(Item) {
            var result = _.sumBy(Item, (o) => {
                return Number(o.average_quality)
            });

            return result;
        },
        CountMonth(Item) {
            var result = Item.length
            return result;
        },
        TimeRatings(Ave_Time, Range, Time_Code) {
            // alert(Range);
            var result;
            var EQ;

            if (Time_Code == 56) {
                result = " ";
            } else {
                try {

                    Range.map(Item => {
                        if (Ave_Time <= Item.equivalent_time_from && Item.rating == 5) {
                            result = 5;
                            EQ = Item.equivalent_time_from;
                        } else if (Ave_Time >= Item.equivalent_time_from && Ave_Time <= Item.equivalent_time_to && Item.rating == 4) {
                            result = 4;
                            EQ = Item.equivalent_time_from;
                        } else if (Ave_Time == Item.equivalent_time_from && Item.rating == 3) {
                            result = 3;
                            EQ = Item.equivalent_time_from;
                        } else if (Ave_Time >= Item.equivalent_time_from && Ave_Time <= Item.equivalent_time_to && Item.rating == 2) {
                            result = 2;
                            EQ = Item.equivalent_time_from;
                        } else if (Ave_Time >= Item.equivalent_time_from && Item.rating == 1) {
                            result = 1;
                            EQ = Item.equivalent_time_from;
                        } else if (Ave_Time == 0) {
                            result = 0;
                        }
                    })
                } catch (error) {

                }
            }
            return result;
        },
        TotalTime(Item) {
            var result = _.sumBy(Item, obj => {
                return obj.average_time ? obj.average_time * obj.quantity : 0;
            })

            return result;
        },
        AveTime(Time, TotalQuantity) {
            var Time = Time
            var TotalQuantity = TotalQuantity
            var Result
            if (Time == 0 && TotalQuantity == 0) {
                Result = 0
            } else {
                Result = Math.round(Number(Time /
                    TotalQuantity))
            }
            return Result;
        },
        AverageRate(QuantityRating, QualityRating, TimeRating) {
            // alert(TimeRating)
            if (TimeRating == " ") {
                TimeRating = 0;
            }
            if (TimeRating == "") {
                TimeRating = 0;
            }
            if (isNaN(TimeRating)) {
                TimeRating = 0;
            }
            var ratings = [parseFloat(QuantityRating), parseFloat(QualityRating), parseFloat(TimeRating)];

            var NotZero = ratings.filter(rating => rating !== 0);

            if (NotZero.length === 0) {
                return 0; // or any default value when all ratings are zero
            }

            const average = NotZero.reduce((sum, rating) => sum + rating, 0) / NotZero.length;

            return this.format_number_conv(average, 2, true)
        },
        calculateAverageCore() {
            let sum = 0;
            let num_of_data = 0;
            let average = 0;

            // console.log(result + " sample");
            // setTimeout(() => {

            //     console.log(this.ipcr_accomplishments_review.data, "Test")
            // }, 2000);
            if (Array.isArray(this.ipcr_accomplishments_review.data)) {
                // console.log(this.ipcr_accomplishments_review.data)
                this.ipcr_accomplishments_review.data.forEach(item => {
                    if (item.ipcr_type === 'Core Function') {
                        var val = this.AverageRate(item.result == 0 ? 0 : this.QuantityRate(item.quantity_type, this.GetSumQuantity(item.result),
                            item.quantity_sem), item.result == 0 ? 0 : this.QualityRating(item.quality_error, this.QualityTypes(item.quality_error,
                                this.GetSumQuality(item.result), this.CountMonth(item.result))),
                            this.TimeRatings(this.AveTime(this.TotalTime(item.result), this.GetSumQuantity(item.result)), item.indi_output.time_ranges, item.time_range_code));
                        // alert(val);
                        // alert(this.TimeRatings(this.AveTime(this.TotalTime(item.result), this.GetSumQuantity(item.result)), item.TimeRange, item.time_range_code));
                        if (val !== 0) {
                            num_of_data += 1;
                            sum += parseFloat(val);
                            average = sum / num_of_data
                        }

                    }
                    // console.log(num_of_data);
                    // console.log(average)
                });
            }

            this.Average_Point_Core = average.toFixed(2);
            return this.Average_Point_Core;
            // alert(this.Average_Point_Core);
        },
        calculateAverageSupport() {
            let sum = 0;
            let num_of_data = 0;
            let average = 0;
            if (Array.isArray(this.ipcr_accomplishments_review.data)) {
                this.ipcr_accomplishments_review.data.forEach(item => {
                    if (item.ipcr_type === 'Support Function') {
                        var val = this.AverageRate(item.result == 0 ? 0 : this.QuantityRate(item.quantity_type, this.GetSumQuantity(item.result),
                            item.quantity_sem), item.result == 0 ? 0 : this.QualityRating(item.quality_error, this.QualityTypes(item.quality_error,
                                this.GetSumQuality(item.result), this.CountMonth(item.result))),
                            this.TimeRatings(this.AveTime(this.TotalTime(item.result), this.GetSumQuantity(item.result)), item.indi_output.time_ranges, item.time_range_code));
                        // alert(val);

                        if (val !== 0) {
                            num_of_data += 1;
                            sum += parseFloat(val);
                            average = sum / num_of_data
                        }
                    }
                });
            }

            this.Average_Point_Support = average.toFixed(2);
            return this.Average_Point_Support;
        },
        showModals(e_sem_id, empl_id, a_status, immid, nxtid) {
            this.emp_sem_id = e_sem_id;
            this.emp_status = a_status;
            this.imm_id_loc = immid;
            this.nxt_id_loc = nxtid;
            axios.get("/semester-accomplishment/get/semestralAccomplishment", {
                params: {
                    sem_id: e_sem_id,
                    empl_id: empl_id,
                }
            }).then((response) => {
                this.ipcr_accomplishments_review = response.data
                console.log(this.ipcr_accomplishments_review);
            }).catch((error) => {
                console.error(error);
            });
            this.hideModal2()
            this.hideModal()
            this.displayModal4 = true
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
            // alert("empl_id: " + this.empl_id + " id: " + this.id_accomp_selected + " e_sem: " + this.emp_sem);

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
        QuantityRate(id, quantity, target) {

            var result;
            if (id == 1) {
                var total = Math.round(quantity / target * 100)
                if (total >= 130) {
                    result = "5"
                } else if (total <= 129 && total >= 115) {
                    result = "4"
                } else if (total <= 114 && total >= 90) {
                    result = "3"
                } else if (total <= 89 && total >= 51) {
                    result = "2"
                } else if (total <= 50) {
                    result = "1"
                } else
                    result = ""
            } else if (id == 2) {
                var total = Math.round(quantity / target * 100)
                if (total == 100) {
                    result = 5
                } else {
                    result = 2
                }

            }
            // console.log(target);
            return result;
        },
        QualityRate(id, quality, total) {
            var result;
            if (id == 1) {
                if (total == 0) {
                    result = "5"
                } else if (total >= .01 && total <= 2.99) {
                    result = "4"
                } else if (total >= 3 && total <= 4.99) {
                    result = "3"
                } else if (total >= 5 && total <= 6.99) {
                    result = "2"
                } else if (total >= 7) {
                    result = "1"
                }
            } else if (id == 2) {
                if (total == 5) {
                    result = "5"
                } else if (total >= 4 && total <= 4.99) {
                    result = "4"
                } else if (total >= 3 && total <= 3.99) {
                    result = "3"
                } else if (total >= 2 && total <= 2.99) {
                    result = "2"
                } else if (total >= 1 && total <= 1.99) {
                    result = "1"
                } else {
                    result = "0"
                }
            }
            return result;
        },
        QuantityType(id) {
            var result;
            if (id == 1) {
                result = "TO BE RATED"
            } else {
                result = "ACCURACY RULE (100%=5,2 if less than 100%)"
            }
            return result;
        },
        QualityType(id) {
            var result;
            if (id == 1) {
                result = "NO. OF ERROR"
            } else if (id == 2) {
                result = "AVE. FEEDBACK"
            } else if (id == 3) {
                result = "NOT TO BE RATED"
            } else if (id == 4) {
                result = "ACCURACY RULE"
            }
            return result;
        },
        // AverageRate(QuantityID, QualityID, quantity, target, total, quality) {
        //     var Quantity = this.QuantityRate(QuantityID, quantity, target)
        //     var Quality = this.QualityRate(QualityID, quality, total)
        //     var Timeliness = 0
        //     var Average = (parseFloat(Quantity) + parseFloat(Quality) + parseFloat(Timeliness)) / 3
        //     return this.format_number_conv(Average, 2, true)
        //     // return this.format_number_conv
        // },
        getPercentQuantity(total_quantity, monthly_target) {
            var score = 0;
            var my_score = "";
            if (monthly_target == 0) {
                my_score = "0";
            } else {
                score = total_quantity / monthly_target;
                score = score * 100;
                my_score = this.format_number_conv(score, 2, true);
            }
            return my_score;
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
