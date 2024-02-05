<template>
    <Head>
        <title>Home</title>
    </Head>

    <!--<p style="text-align: justify;">Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit amet consectetur.
    </p>-->
    <div class="row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <!--SEMESTRAL***************************************************************************************-->
            <h3>Review/Approve Submissions</h3>
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

                            <tr v-for="target in targets.data">
                                <td></td>
                                <td>{{ target.employee_name }}</td>
                                <td>
                                    <span v-if="target.sem === '1'">January to June, </span>
                                    <span v-if="target.sem === '2'">July to December, </span>
                                    {{ target.year }} &nbsp;
                                    <button class="btn-danger text-white" v-if="target.is_additional_target == '1'">
                                        Additional Target
                                    </button>
                                </td>
                                <td>
                                    <!-- {{ target.sem }} -->
                                    <!-- {{ target }} gfdgdfg -->
                                    <div v-if="target.is_additional_target == '1'">
                                        <!-- {{ target.target_status }} -->
                                        <div style="color:coral; font-weight: bold" v-if="target.target_status === '0'">
                                            Submitted</div>
                                        <div style="color:blue; font-weight: bold" v-if="target.target_status === '1'">
                                            Reviewed</div>
                                        <div style="color:darkgreen; font-weight: bold" v-if="target.target_status === '2'">
                                            Approved</div>
                                    </div>
                                    <div v-else>
                                        <div style="color:coral; font-weight: bold" v-if="target.status === '0'">Submitted
                                        </div>
                                        <div style="color:blue; font-weight: bold" v-if="target.status === '1'">Reviewed
                                        </div>
                                        <div style="color:darkgreen; font-weight: bold" v-if="target.status === '2'">
                                            Approved</div>
                                    </div>

                                </td>
                                <td v-if="target.is_additional_target == '1'">
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
                                            <li>
                                                <button class="dropdown-item"
                                                    @click="reviewAdditionalTarget(target.id_target, target.target_status)">

                                                    <span v-if="target.target_status === '0'">Review Additional
                                                        Target</span>
                                                    <span v-if="target.target_status === '1'">Approve Additional
                                                        Target</span>
                                                    <span v-if="target.target_status === '2'">Return Additional
                                                        Target</span>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                <td v-else>
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
                                            <li v-if="target.sem === '1' || target.sem === '2'">
                                                <button class="dropdown-item"
                                                    @click="showModal(target.id, target.empl_id, target.employee_name, target.year, target.sem, target.status)">
                                                    View Submission
                                                </button>
                                            </li>
                                            <li v-else>
                                                <button class="dropdown-item"
                                                    @click="showModal2(target.id, target.empl_id, target.employee_name, target.year, target.sem, target.status)">
                                                    View Submission
                                                </button>
                                            </li>
                                            <li v-if="target.status === '1'">
                                                <Link class="dropdown-item" :href="`/ipcrtargets/${target.id}`">
                                                Add/Remove Targets
                                                </Link>
                                            </li>
                                            <li v-if="target.status === '0'">
                                                <Link class="dropdown-item" :href="`/ipcrtargets/${target.id}`">
                                                Add/Remove Targets
                                                </Link>
                                            </li>
                                            <!-- <li><Link class="dropdown-item" :href="`/ipcrtargets/edit/${ifo.id}`">Edit</Link></li> -->
                                            <!-- <li><button class="dropdown-item" @click="deleteIPCR(ifo.id)">Delete</button></li> -->
                                            <!-- <li>
                                                <button class="dropdown-item"
                                                    @click="showModal(functional.FFUNCCOD,functional.FFUNCTION,
                                                    functional.MOOE,
                                                    functional.PS)"
                                                    > View OPCR Standard
                                                </button>
                                            </li> -->
                                        </ul>
                                    </div>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                    <pagination :next="targets.next_page_url" :prev="targets.prev_page_url" />
                </div>
            </div>
        </div>
        <Modal v-if="displayModal" @close-modal-event="hideModal">
            <div class="justify-content-center">
                <div style="text-align: center">
                    <h4>IPCR Targets</h4>
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
                        <span v-if="emp_status === '2'">Approved</span>
                    </u>
                </div>
                <div class="masonry-item w-100">
                    <div class="bgc-white p-20 bd">

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered border-dark">
                                <tr class="text-dark" style="background-color: #B7DEE8;">
                                    <th rowspan="2" style="text-align: center; background-color: #edd29d !important;">IPCR
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
                                    <td v-if="ipc.ipcr_type == 'Core Function'">{{ ipc.month_1 }}</td>
                                    <td v-if="ipc.ipcr_type == 'Core Function'">{{ ipc.month_2 }}</td>
                                    <td v-if="ipc.ipcr_type == 'Core Function'">{{ ipc.month_3 }}</td>
                                    <td v-if="ipc.ipcr_type == 'Core Function'">{{ ipc.month_4 }}</td>
                                    <td v-if="ipc.ipcr_type == 'Core Function'">{{ ipc.month_5 }}</td>
                                    <td v-if="ipc.ipcr_type == 'Core Function'">{{ ipc.month_6 }}</td>
                                    <td v-if="ipc.ipcr_type == 'Core Function'" style="text-align: center">{{
                                        ipc.quantity_sem
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
                                    <td v-if="ipc.ipcr_type == 'Support Function'">{{ ipc.month_1 }}</td>
                                    <td v-if="ipc.ipcr_type == 'Support Function'">{{ ipc.month_2 }}</td>
                                    <td v-if="ipc.ipcr_type == 'Support Function'">{{ ipc.month_3 }}</td>
                                    <td v-if="ipc.ipcr_type == 'Support Function'">{{ ipc.month_4 }}</td>
                                    <td v-if="ipc.ipcr_type == 'Support Function'">{{ ipc.month_5 }}</td>
                                    <td v-if="ipc.ipcr_type == 'Support Function'">{{ ipc.month_6 }}</td>
                                    <td v-if="ipc.ipcr_type == 'Support Function'" style="text-align: center">{{
                                        ipc.quantity_sem }}</td>
                                </tr>
                            </table>

                        </div>

                    </div>

                </div>
                <div style="align: center">
                    <h3>Remarks</h3>
                    <input type="text" v-model="form.remarks" class="form-control" autocomplete="chrome-off"><br>
                    <button class="btn btn-primary text-white" @click="submitAction('1')" v-if="emp_status === '0'">
                        Review
                    </button>
                    <button class="btn btn-primary text-white" @click="submitAction('2')" v-if="emp_status === '1'">
                        Approve
                    </button>&nbsp;
                    <button class="btn btn-danger text-white" @click="submitAction('-2')">
                        <!-- </button>@click="showModal3()"> -->
                        Return
                    </button>
                    <!-- empl_id: {{ empl_id }}
                        <button class="btn btn-danger text-white"
                            @click="hideModal()"
                    >
                        Cancel
                    </button> -->
                </div>
                <!-- {{ ipcr_targets }} -->
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

                                        <th v-for="(item, index) in parseQuantity(ipcr_targets[0].quantity)" :key="index">
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
                                        <td v-if="target.ipcr_type == 'Core Function'">{{ target.individual_output }}</td>
                                        <td v-if="target.ipcr_type == 'Core Function'"
                                            v-for="(quant, index) in parseQuantity(target.quantity)" :key="index">{{ quant
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
                                            v-for="(quant, index) in parseQuantity(target.quantity)" :key="index">{{ quant
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
        <!-- {{ quantityArray }} -->
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
        targets: Object,
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
            emp_sem_id: "",
            emp_name: "",
            emp_year: "",
            emp_sem: "",
            emp_status: "",
            empl_id: "",
            displayModal2: false,
            displayModal3: false,
            length: 0,
            form: useForm({
                type: "",
                remarks: "",
                ipcr_semestral_id: "",
                employee_code: ""
            })
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
            // let text = "WARNING!\nAre you sure you want to delete the Program and Projects? "+id;
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

        showModal(my_id, empl_id, e_name, e_year, e_sem, e_stat) {
            // alert('my_id: '+my_id+" "+empl_id);
            this.emp_name = e_name;
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
            this.displayModal = true;

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
                this.$inertia.post("/review/approve/" + stat + "/" + this.emp_sem_id, this.form);
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
}</style>
