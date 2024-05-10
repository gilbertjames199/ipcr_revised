<template>

    <Head>
        <title>Home</title>
    </Head>

    <!--<p style="text-align: justify;">Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit amet consectetur.
    </p>-->
    <div class="row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <!--SEMESTRAL***************************************************************************************-->
            <h3>Review/Approve Monthly Accomplishment</h3>
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
                                <th>Month</th>
                                <th>Status</th>
                                <!-- <th>Sem ID</th> -->
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="accomp in accomplishments.data">
                                <td></td>
                                <td>{{ accomp.employee_name }}</td>

                                <td>
                                    {{ getPeriod(accomp.sem, accomp.year) }}
                                </td>
                                <td>{{ getMonthName(accomp.month) }}</td>
                                <!-- <td>{{ accomp.id }} - {{ accomp.accomp_id }}</td> -->
                                <td>
                                    {{ getStatus(accomp.a_status) }}
                                    <!-- --- {{ accomp }} -->
                                </td>
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
                                                <button class="dropdown-item" @click="showModal(accomp.id,
                        accomp.empl_id,
                        accomp.employee_name,
                        accomp.year,
                        accomp.sem,
                        accomp.a_status,
                        accomp.accomp_id,
                        accomp.month,
                        accomp.position,
                        accomp.office,
                        accomp.division,
                        accomp.immediate,
                        accomp.next_higher,
                        accomp.id,
                        accomp.employment_type_descr
                    )">
                                                    View Submission
                                                </button>
                                            </li>
                                            <li v-else>
                                                <button class="dropdown-item"
                                                    @click="showModal2(accomp.id, accomp.empl_id, accomp.employee_name, accomp.year, accomp.sem, accomp.status)">
                                                    View Submission
                                                </button>
                                            </li>
                                            <li v-if="accomp.status === '1'">
                                                <Link class="dropdown-item" :href="`/ipcrtargets/${accomp.id}`">Approve
                                                </Link>
                                            </li>
                                            <li v-if="accomp.status === '0'">
                                                <Link class="dropdown-item" :href="`/ipcrtargets/${accomp.id}`">Review
                                                </Link>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination :next="accomplishments.next_page_url" :prev="accomplishments.prev_page_url" />
                    Page {{ accomplishments.current_page }}
                </div>
            </div>
        </div>

        <!-- <table class="table table-hover table-bordered border-dark">
                <thead>
                    <tr class="text-dark" style="background-color: #ffffff;">
                        <th rowspan="2" style="text-align: center; background-color: #f70505 !important;">
                            IPCR
                            Code </th>
                        <th rowspan="2">MFO</th>
                        <th rowspan="2">Success Indicator</th>
                        <th rowspan="2"></th>
                        <th rowspan="2"></th>
                        <th rowspan="2">Targets</th>
                        <th rowspan="2">Quantity</th>
                        <th colspan="2">Rating </th>
                        <th rowspan="2">Quality Rate Based On</th>
                        <th rowspan="2">Quality</th>
                        <th rowspan="2">TOT ERROR/AVE FB</th>
                        <th rowspan="2">Prescribed Period</th>
                        <th rowspan="2">Timeliness</th>
                        <th rowspan="2">ave time per doc/activity</th>
                        <th rowspan="2">Remarks</th>
                    </tr>
                    <tr>
                        <th>Score</th>
                        <th>%</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-secondary text-white">
                        <td style="background-color: #f70505;"></td>
                        <td colspan="15"><b>Core Function</b></td>
                    </tr>
                    <template v-for="ipc in ipcr_accomplishments">
                        <tr v-if="ipc.ipcr_type == 'Core Function'">
                            <td style="background-color: #f1c19b;">{{ ipc.ipcr_code }}</td>
                            <td>{{ ipc.mfo_desc }}</td>
                            <td>{{ ipc.success_indicator }}</td>
                            <td style="border-color: #f70505;">{{ ipc.quantity_type }}</td>
                            <td style="border-color: #f70505;">{{ QuantityType(ipc.quantity_type) }}</td>
                            <td style="border-color: #f70505;">{{ ipc.monthly_target }}</td>
                            <td style="border-color: #f70505;">{{ ipc.total_quantity }}</td>
                            <td style="border-color: #f70505;">
                                {{ QuantityRate(ipc.quantity_type, ipc.total_quantity, ipc.month) }} -
                            </td>
                            <td style="border-color: #f70505;">
                                {{ getPercentQuantity(ipc.total_quantity, ipc.monthly_target) }}
                            </td>
                            <td style="border-color: #f70505;">{{ QualityType(ipc.quality_error) }}</td>
                            <td style="border-color: #f70505;">{{ ipc.total_quality }}</td>
                            <td style="border-color: #f70505;">
                                <p v-if="isNaN(ipc.total_quality_avg) || ipc.total_quality_avg == null">0
                                </p>
                                <p v-else> {{
                                    format_number_conv(ipc.total_quality_avg, 2, true) }}
                                </p>
                            </td>
                            <td style="border-color: #f70505;">{{ ipc.prescribed_period }} {{ ipc.time_unit
                            }}</td>
                            <td>{{ ipc.ave_time }}</td>
                            <td style="border-color: #f70505;">
                                <span v-if="ipc.monthly_target > 0">
                                    {{ format_number_conv(((ipc.total_quantity / ipc.monthly_target) *
                                        100), 2, true) }} %
                                </span>
                                <span v-else>
                                    0.00%
                                </span>
                            </td>
                        </tr>
                    </template>
<tr class="bg-secondary text-white">
    <td style="background-color: #f70505;"></td>
    <td colspan="15"><b>Support Function</b></td>
</tr>
<template v-for="ipc in ipcr_accomplishments">
                        <tr v-if="ipc.ipcr_type == 'Support Function'">
                            <td style="background-color: #f1c19b;">{{ ipc.ipcr_code }}</td>
                            <td>{{ ipc.mfo_desc }}</td>
                            <td>{{ ipc.success_indicator }}</td>
                            <td style="border-color: #f70505;">{{ ipc.quantity_type }}</td>
                            <td style="border-color: #f70505;">{{ QuantityType(ipc.quantity_type) }}</td>
                            <td style="border-color: #f70505;">{{ ipc.monthly_target }}</td>
                            <td style="border-color: #f70505;">{{ ipc.total_quantity }}</td>
                            <td style="border-color: #f70505;">
                                {{ QuantityRate(ipc.quantity_type, ipc.total_quantity, ipc.month) }} -
                            </td>
                            <td style="border-color: #f70505;">
                                {{ getPercentQuantity(ipc.total_quantity, ipc.monthly_target) }}
                            </td>
                            <td style="border-color: #f70505;">{{ QualityType(ipc.quality_error) }}</td>
                            <td style="border-color: #f70505;">{{ ipc.total_quality }}</td>
                            <td style="border-color: #f70505;">
                                <p v-if="isNaN(ipc.total_quality_avg) || ipc.total_quality_avg == null">0
                                </p>
                                <p v-else> {{
                                    format_number_conv(ipc.total_quality_avg, 2, true) }}
                                </p>
                            </td>
                            <td style="border-color: #f70505;">{{ ipc.prescribed_period }} {{ ipc.time_unit
                            }}</td>
                            <td>{{ ipc.ave_time }}</td>
                            <td style="border-color: #f70505;">
                                <span v-if="ipc.monthly_target > 0">
                                    {{ format_number_conv(((ipc.total_quantity / ipc.monthly_target) *
                                        100), 2, true) }} %
                                </span>
                                <span v-else>
                                    0.00%
                                </span>
                            </td>
                        </tr>
                    </template>
</tbody>

</table>
-->
        <!-- {{ report_link }} -->
        <Modal v-if="displayModal" @close-modal-event="hideModal">
            <div class="justify-content-center">
                <!-- {{ report_link }} -->
                <div style="text-align: center">
                    <h4>IPCR Accomplishment</h4>
                </div>
                <br>
                <div><b>Employee Name: </b><u>{{ emp_name }}</u></div>
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
                    <button class="btn btn-primary text-white" @click="submitAction('1')" v-if="emp_status === '0'">
                        Review
                    </button>
                    <button class="btn btn-primary text-white" @click="submitAction('2')" v-if="emp_status === '1'">
                        Approve
                    </button>&nbsp;
                    <button class="btn btn-primary text-white" @click="submitAction('3')" v-if="emp_status === '2'">
                        Final Approve
                    </button>&nbsp;

                    <button class="btn btn-danger text-white" @click="submitAction('-2')">
                        Return
                    </button>
                </div>
            </div>
        </Modal>
        <Modal2 v-if="displayModal2" @close-modal-event="hideModal2">
            <div class="justify-content-center">
                <div style="text-align: center">
                    <h4>IPCR Targets</h4>
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
            <h3>Remarks</h3>
            <h5>State the reason for not reviewing/approving IPCR</h5>
            <input type="text" v-model="form.remarks" class="form-control" autocomplete="chrome-off"><br>
            <button class="btn btn-primary text-white" @click="submitReturnReason()">
                Done
            </button>&nbsp;
            <button class="btn btn-danger text-white" @click="cancelReason()">
                Cancel
            </button>
        </Modal3>
    </div>
</template>
<script>
import { useForm } from "@inertiajs/inertia-vue3";
import Filtering from "@/Shared/Filter";
import Pagination from "@/Shared/Pagination";
import Modal from "@/Shared/PrintModal";
import Modal2 from "@/Shared/PrintModal";
import Modal3 from "@/Shared/PrintModal";
export default {
    props: {
        accomplishments: Object,
        pghead: String
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
            core_support: [],
            emp_sem_id: "",
            emp_name: "",
            emp_year: "",
            emp_sem: "",
            emp_status: "",
            empl_id: "",
            employment_type_descr: "",
            displayModal2: false,
            displayModal3: false,
            length: 0,
            id_accomp_selected: "",
            form: useForm({
                type: "",
                remarks: "",
                ipcr_semestral_id: "",
                employee_code: "",
                ipcr_monthly_accomplishment_id: "",
            })
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
        Pagination, Filtering, Modal, Modal2, Modal3
    },

    methods: {
        deleteIPCR(ipcr_id) {
            // let text = "WARNING!\nAre you sure you want to delete the Research Agenda?";
            // // alert("/ipcrtargets/" + ipcr_id + "/"+ this.id+"/delete")
            // if (confirm(text) == true) {
            //     this.$inertia.delete("/ipcrtargets/" + ipcr_id + "/"+ this.id+"/delete");
            // }
        },
        showCreate() {
            // this.$inertia.get(
            //     "/targets/create",
            //     {
            //         raao_id: this.raao_id
            //     },
            //     {
            //         preserveScroll: true,
            //         preserveState: true,
            //         replace: true,
            //     }
            // );
        },
        deletePAPS(id) {
            // let text = "Are you sure you want to delete the Program and Projects? "+id;
            //   if (confirm(text) == true) {
            //     this.$inertia.delete("/paps/" + id+"/"+this.idmfo);
            // }
        },
        getToRep(ffunccod, ffunction, MOOE, PS) {
            // alert(data[0].FFUNCCOD);
            // var linkt="http://";
            // var jasper_ip = this.jasper_ip;
            // var jasper_link = 'jasperserver/flow.html?pp=u%3DJamshasadid%7Cr%3DManager%7Co%3DEMEA,Sales%7Cpa1%3DSweden&_flowId=viewReportFlow&_flowId=viewReportFlow&_flowId=viewReportFlow&ParentFolderUri=%2Freports%2Fplanning_system%2FOPCR_Standard&reportUnit=%2Freports%2Fplanning_system%2FOPCR_Standard%2FOPCR&standAlone=true&decorate=no&output=pdf';
            // var params = '&id=' + ffunccod + '&FUNCTION=' + ffunction + '&MOOE=' + MOOE + '&PS=' + PS;
            // var link1 = linkt + jasper_ip +jasper_link + params;
            // return link1;
        },

        async showModal(my_id, empl_id, e_name, e_year, e_sem, e_stat, accomp_id, month, position, office, division, immediate, next_higher, idsemestral, employment_type_descr) {
            this.emp_name = e_name;
            this.emp_year = e_year;
            this.emp_sem = e_sem;
            this.emp_status = e_stat;
            this.employment_type_descr = employment_type_descr;
            this.emp_sem_id = my_id;
            this.empl_id = empl_id;
            this.id_accomp_selected = accomp_id;
            this.form.ipcr_monthly_accomplishment_id = accomp_id;
            let my_month = this.getMonthName(month)
            this.form.employee_code = empl_id;
            let url = '/calculate-total/accomplishments/monthly/' + my_month + '/' + e_year + '/' + empl_id;
            // alert(empl_id);
            await axios.get(url).then((response) => {
                this.core_support = response.data;
                // console.log(this.core_support.ave_core);
            });

            var per = this.getMonthName(month)

            this.viewlink1(empl_id, e_name, e_stat, position, office, division, immediate, next_higher, e_sem, e_year, idsemestral, per, this.pghead, '33')
            this.displayModal = true;

        },
        viewlink1(emp_code, employee_name, emp_status, position, office, division, immediate, next_higher, sem, year, idsemestral, period, pghead, Average_Score) {

            var linkt = "http://";
            var jasper_ip = this.jasper_ip;
            var jasper_link = 'jasperserver/flow.html?pp=u%3DJamshasadid%7Cr%3DManager%7Co%3DEMEA%2CSales%7Cpa1%3DSweden&_flowId=viewReportFlow&_flowId=viewReportFlow&ParentFolderUri=%2Freports%2FIPCR%2FIPCR_Part1&reportUnit=%2Freports%2FIPCR%2FIPCR_Part1%2FAccomplishment_Part1&standAlone=true&decorate=no&output=pdf';
            var params = '&emp_code=' + emp_code + '&employee_name=' + employee_name + '&emp_status=' + this.employment_type_descr + '&position=' + position +
                '&office=' + office + '&division=' + division + '&immediate=' + immediate +
                '&next_higher=' + next_higher + '&sem=' + sem + '&year=' + year +
                '&idsemestral=' + idsemestral + '&period=' + period + '&pghead=' + pghead +
                '&Average_Point_Core=' + this.core_support.ave_core +
                '&Average_Point_Support=' + this.core_support.ave_support;
            var linkl = linkt + jasper_ip + jasper_link + params;
            this.report_link = linkl;
            return linkl;
        },
        viewlink(emp_code, employee_name, emp_status, position, office, division, immediate, next_higher, sem, year, idsemestral, period,) {
            //var linkt ="abcdefghijklo534gdmoivndfigudfhgdyfugdhfugidhfuigdhfiugmccxcxcxzczczxczxczxcxzc5fghjkliuhghghghaaa555l&&&&-";
            var linkt = "http://";
            var jasper_ip = this.jasper_ip;
            var jasper_link = 'jasperserver/flow.html?pp=u%3DJamshasadid%7Cr%3DManager%7Co%3DEMEA%2CSales%7Cpa1%3DSweden&_flowId=viewReportFlow&_flowId=viewReportFlow&ParentFolderUri=%2Freports%2FIPCR%2FIPCR_Monthly&reportUnit=%2Freports%2FIPCR%2FIPCR_Monthly%2FMonthly_IPCR&standAlone=true&decorate=no&output=pdf';
            var params = '&emp_code=' + emp_code + '&employee_name=' + employee_name + '&emp_status=' + emp_status + '&position=' + position + '&office=' + office + '&division=' + division + '&immediate=' + immediate + '&next_higher=' + next_higher + '&sem=' + sem + '&year=' + year + '&idsemestral=' + idsemestral + '&period=' + period + '&Score=' + this.score;
            this.form.employee_code = emp_code;
            var linkl = linkt + jasper_ip + jasper_link + params;
            this.report_link = linkl;
            return linkl;
        },
        hideModal() {
            this.displayModal = false;
        },
        hideModal2() {
            this.displayModal2 = false;
        },
        // async
        submitAction(stat) {
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
            let text = "Are you sure you want to " + acc + " the IPCR Target?";
            // alert(this.id_accomp_selected)
            // alert("/ipcrtargets/" + ipcr_id + "/"+ this.id+"/delete")/review/approve/
            if (confirm(text) == true) {
                var myurl = "/approve/accomplishments/" + stat + "/" + this.id_accomp_selected
                // await axios
                this.$inertia.post(myurl, {
                    params: {
                        remarks: this.form.remarks,
                        employee_code: this.form.employee_code,
                        core_support: this.core_support
                    }
                });
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
            this.displayModal3 = true
        },
        hideModal3() {
            this.displayModal3 = false;
        },
        submitReturnReason() {
            alert("Type: " + this.form.type + "; ipcr_semestral_id: " +
                this.form.ipcr_semestral_id + "; employee_code: " +
                this.form.employee_code + "; remarks: " +
                this.form.remarks)
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
                var total = quantity / target * 100
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
                if (total = 100) {
                    result = 5
                } else {
                    result = 2
                }
            }
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
        AverageRate(QuantityID, QualityID, quantity, target, total, quality) {
            var Quantity = this.QuantityRate(QuantityID, quantity, target)
            var Quality = this.QualityRate(QualityID, quality, total)
            var Timeliness = 0
            var Average = (parseFloat(Quantity) + parseFloat(Quality) + parseFloat(Timeliness)) / 3
            return this.format_number_conv(Average, 2, true)
            // return this.format_number_conv
        },
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
        }
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
