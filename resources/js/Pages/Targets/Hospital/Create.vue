<template>
    <div class="relative row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h2><b>{{ pageTitle }}
                <div v-if="pcr_type == 'hemp'">
                    <label for="">IPCR </label>
                </div>
                <label v-if="pcr_type == 'hos'" for="">HPCR </label>
                <label v-if="pcr_type == 'hdiv'" for="">DPCR </label>
                <label v-if="pcr_type == 'hsec'" for="">HSPCR </label>
                &nbsp;Target
            </b></h2>
            <!-- <Link :href="`/ipcrtargets/${my_id}`"> -->
            <button class="btn btn-danger text-white" @click="goBack">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-lg"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z" />
                    <path fill-rule="evenodd"
                        d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z" />
                </svg>
            </button>

            <!-- </Link> -->
        </div>

        <!-- <div class="col-md-8">
            <div>Name: <u>{{ emp.employee_name }}</u></div>
            <div>Position: <u>{{ emp.position_long_title }}</u></div>
            <div>Employment Status: <u>{{ emp.employment_type_descr }}</u></div>
        </div> -->
        <!-- {{ emp }} -->
        <form @submit.prevent="submit()">
            <input type="hidden" required>
            <!-- {{ selected_value }} -->
            <div class="col-md-8">
                <fieldset class="border p-4">
                    <legend class="float-none w-auto"><b></b></legend>
                    <!-- <label for="">IPCR Code</label> -->
                    <div class="layers bd bgc-white p-20">
                        <div class="masonry-item w-100 ">
                            <div class="row gap-20">
                                <div class="col-md-12">
                                    <!-- <label for="">Division Output *</label>
                                    <div>
                                        <multiselect :options="dpcr_sel" :searchable="true" v-model="form.idDPCR"
                                            label="label" track-by="label" @close="selected_dpcr">
                                        </multiselect>
                                    </div> -->
                                    <!-- {{ pcr_type }} -->
                                    <div v-if="pcr_type == 'hemp'">
                                        <label for="">Individual Output *</label>
                                    </div>
                                    <label v-if="pcr_type == 'hos'" for="">Hospital Output *</label>
                                    <label v-if="pcr_type == 'hdiv'" for="">Hospital Division Output *</label>
                                    <label v-if="pcr_type == 'hsec'" for="">Hospital Individual Output *</label>
                                    <div>
                                        <multiselect :options="pcr_sel" :searchable="true" v-model="selectedPCR"
                                            label="label" track-by="label" @close="selected_pcr(id, type)">
                                        </multiselect>
                                    </div>
                                    <!-- Hospital Chief -->
                                    <div class="fs-6 c-red-500" v-if="form.errors.idHPCR">{{ form.errors.idHPCR }}</div>
                                    <!-- Individual -->
                                    <div class="fs-6 c-red-500" v-if="form.errors.idIPCR">{{ form.errors.idIPCR }}</div>
                                    <!-- Division -->
                                    <div class="fs-6 c-red-500" v-if="form.errors.idDPCR">{{ form.errors.idDPCR }}</div>
                                    <!-- Hospital Division -->
                                    <div class="fs-6 c-red-500" v-if="form.errors.idHDPCR">{{ form.errors.idHDPCR }}</div>
                                    <!-- Hospital Section -->
                                    <div class="fs-6 c-red-500" v-if="form.errors.idHSPCR">{{ form.errors.idHSPCR }}</div>
                                    <!-- Hospital Individual -->
                                    <div class="fs-6 c-red-500" v-if="form.errors.idHIPCR">{{ form.errors.idHIPCR }}</div>


                                    <!-- <select type="text" v-model="form.ipcr_code" :disabled="editData !== undefined" class="form-control" autocomplete="chrome-off" @change="selected_pcr">
                                        <option v-for="ipcr, index in pcrs" :value="ipcr.ipcr_code">
                                            {{ ipcr.ipcr_code }} - {{ ipcr.individual_output }}
                                        </option>
                                    </select> -->
                                    <div class="fs-6 c-red-500" v-if="form.errors.individual_final_output_id && form.individual_final_output_id==''">{{ form.errors.individual_final_output_id }}
                                    </div>
                                    <div class="fs-6 c-red-500" v-if="form.errors.employee_code">{{ form.errors.employee_code }}</div>
                                    <!-- <label for="">Major Final Output</label>
                                    <input type="text" v-model="ipcr_mfo" class="form-control" autocomplete="chrome-off"
                                        readonly>

                                    <label for="">Sub MFO</label>
                                    <input type="text" v-model="ipcr_submfo" class="form-control"
                                        autocomplete="chrome-off" readonly> -->

                                    <!-- <label for="">Division Output</label>
                                    <input type="text" v-model="pcr_output" class="form-control"
                                        autocomplete="chrome-off" readonly> -->

                                    <!-- <label for="">Individual Final Output</label>
                                    <input type="text" v-model="pcr_ind_output" class="form-control"
                                        autocomplete="chrome-off" readonly> -->

                                    <label for="">Performance Measure</label>
                                    <input type="text" v-model="pcr_performance" class="form-control"
                                        autocomplete="chrome-off" readonly>

                                        <label for="">Prescribed Period / Deadline</label>
                                    <input type="text" v-model="pcr_prescribed_period" class="form-control"
                                        autocomplete="chrome-off" readonly>

                                    <input type="hidden" v-model="form.id" class="form-control"
                                        autocomplete="chrome-off">
                                    <label for="">Year</label>
                                    <input type="text" v-model="form.year" class="form-control"
                                        autocomplete="chrome-off" readonly>

                                    <label for="">Semester</label>
                                    <select type="text" v-model="form.semester" class="form-control"
                                        autocomplete="chrome-off" disabled>
                                        <option value="1">First Semester</option>
                                        <option value="2">Second Semester</option>
                                    </select>
                                    <div class="fs-6 c-red-500" v-if="form.errors.semester">{{ form.errors.semester }}
                                    </div>

                                    <label for="">Type/Category *</label>
                                    <select type="text" v-model="form.type" class="form-control"
                                        autocomplete="chrome-off">
                                        <option value="Core Function">Core Function</option>
                                        <option value="Support Function">Support Function</option>
                                    </select>
                                    <div class="fs-6 c-red-500" v-if="form.errors.type && form.type==''">{{ form.errors.type }}
                                    </div>

                                    <div >
                                        <label for="">For designation/additional task and function, please provide the Office Memorandum Order Number</label>
                                        <input type="text" v-model="form.remarks" class="form-control"
                                            autocomplete="chrome-off">
                                        <div class="fs-6 c-red-500" v-if="form.errors.remarks">{{ form.errors.remarks }}
                                        </div>
                                    </div>
                                    <!-- remsrks: {{ form.remarks }} -->
                                    <div v-if="form.remarks && form.remarks.trim() !== ''">
                                        <label for="">Type of Memo</label>
                                        <select v-model="form.identifier" class="form-control"
                                            autocomplete="chrome-off">
                                            <option></option>
                                            <option>Designation</option>
                                            <option>Additional tasks and functions</option>
                                        </select>
                                        <div class="fs-6 c-red-500" v-if="form.errors.remarks">{{ form.errors.remarks }}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>

                </fieldset>
            </div>

            <!-- <div class="col-md-8" v-if="is_add != '1'">
                <fieldset class="border p-4">
                    <legend class="float-none w-auto">
                        <b>Targets</b>
                    </legend>
                    <span class="small text-danger">{{ quantity_needed }}</span>
                    <div class="layers bd bgc-white p-20">
                        <div class="masonry-item w-100 ">
                            <div class="row gap-20">
                                <div class="col-md-12">
                                    <div>
                                        <label for="">Semestral Target *&nbsp;</label>
                                        <input ref="sem_target" type="number" v-model="form.quantity_sem"
                                            class="form-control" autocomplete="chrome-off"
                                            @keydown.enter.prevent="moveToNextInput('month1Input')"
                                            @keydown.up.prevent="moveToNextInput('month6Input')"
                                            @keydown.down.prevent="moveToNextInput('month1Input')">
                                        <div class="fs-6 c-red-500" v-if="form.errors.quantity_sem">{{
                form.errors.quantity_sem }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="">{{ month_list[0] }} *</label>
                                    <input ref="month1Input" type="number" v-model="form.month_1" class="form-control"
                                        autocomplete="chrome-off" min="0" @keyup.enter="moveToNextInput('month2Input')"
                                        @keydown.down.prevent="moveToNextInput('month2Input')"
                                        @keydown.up.prevent="moveToNextInput('sem_target')">
                                    <div class="fs-6 c-red-500" v-if="form.errors.month_1">{{ form.errors.month_1 }}
                                    </div>

                                    <label for="">{{ month_list[1] }} *</label>
                                    <input ref="month2Input" type="number" v-model="form.month_2" class="form-control"
                                        autocomplete="chrome-off" min="0" @keyup.enter="moveToNextInput('month3Input')"
                                        @keydown.down.prevent="moveToNextInput('month3Input')"
                                        @keydown.up.prevent="moveToNextInput('month1Input')">
                                    <div class="fs-6 c-red-500" v-if="form.errors.month_2">{{ form.errors.month_2 }}
                                    </div>

                                    <label for="">{{ month_list[2] }} *</label>
                                    <input ref="month3Input" type="number" v-model="form.month_3" class="form-control"
                                        autocomplete="chrome-off" min="0" @keyup.enter="moveToNextInput('month4Input')"
                                        @keydown.down.prevent="moveToNextInput('month4Input')"
                                        @keydown.up.prevent="moveToNextInput('month2Input')">
                                    <div class="fs-6 c-red-500" v-if="form.errors.month_3">{{ form.errors.month_3 }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="">{{ month_list[3] }} *</label>
                                    <input ref="month4Input" type="number" v-model="form.month_4" class="form-control"
                                        autocomplete="chrome-off" min="0" @keyup.enter="moveToNextInput('month5Input')"
                                        @keydown.down.prevent="moveToNextInput('month5Input')"
                                        @keydown.up.prevent="moveToNextInput('month3Input')">
                                    <div class="fs-6 c-red-500" v-if="form.errors.month_4">{{ form.errors.month_4 }}
                                    </div>

                                    <label for="">{{ month_list[4] }} *</label>
                                    <input ref="month5Input" type="number" v-model="form.month_5" class="form-control"
                                        autocomplete="chrome-off" min="0" @keyup.enter="moveToNextInput('month6Input')"
                                        @keydown.down.prevent="moveToNextInput('month6Input')"
                                        @keydown.up.prevent="moveToNextInput('month4Input')">
                                    <div class="fs-6 c-red-500" v-if="form.errors.month_5">{{ form.errors.month_5 }}
                                    </div>

                                    <label for="">{{ month_list[5] }} *</label>
                                    <input ref="month6Input" type="number" v-model="form.month_6" class="form-control"
                                        autocomplete="chrome-off" min="0" @keyup.enter="moveToNextInput('sem_target')"
                                        @keydown.down.prevent="moveToNextInput('sem_target')"
                                        @keydown.up.prevent="moveToNextInput('month5Input')">
                                    <div class="fs-6 c-red-500" v-if="form.errors.month_6">{{ form.errors.month_6 }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div> -->


            <div hidden>
                <input type="number" v-model="form.year" class="form-control" autocomplete="chrome-off">
                <div class="fs-6 c-red-500" v-if="form.errors.year">{{ form.errors.year }}</div>
                <input type="text" v-model="form.is_additional_target" class="form-control" autocomplete="chrome-off">
            </div>

            <button type="button" class="btn btn-primary mt-3 text-white" @click="submit()" :disabled="form.processing">
                Save changes
            </button>&nbsp;
            <button type="button" class="btn btn-danger mt-3 text-white" @click="cancelEdit()"
                :disabled="form.processing">
                Cancel
            </button>
        </form>
        <!-- {{ pcrs[0] }} -->
<!-- PCRS:m
 PCR Type: {{ form.pcr_type }}<br> -->
        <!-- year: {{ form.year }} -->
         <!-- {{ form }} -->
          <!-- {{ id }} -->
        <!-- <br>**************************************************************<br>
        {{ editData.year }} -->
        <!-- {{ editData }}
        {{ additional }} -->
        <!-- additional {{ additional }} -->
        <!-- //{{ id }} {{ form.year }} -->
        <!-- {{  sem }} -->
        <!-- {{ form.ipcr_code }}
           -->
        <!-- {{ pcr_type }} -->
        <!-- {{ pcrs }} -->
          <!-- *********************FORM <br> -->
        <!-- {{ editData }} -->
    </div>
</template>
<script>
import { useForm } from "@inertiajs/inertia-vue3";
import { ModelSelect } from 'vue-search-select';

//import Places from "@/Shared/PlacesShared";

export default {
    props: {
        editData: Object,
        id: String,
        emp: Object,
        sem: Object,
        additional: String,
        dpcrs: Object,
        slug: String,
        pcrs: Object,
        pcr_type: String,
        is_additional_target: Number
    },
    components: {
        ModelSelect
    },
    data() {
        return {
            is_add: '0',
            submitted: false,
            my_id: "",
            selectedPCR: "",
            form: useForm({
                // ipcr_code: "",
                // individual_final_output_id: "",
                // employee_code: "",
                // semester: "",
                // ipcr_type: "",
                // is_additional_target: "",
                // ipcr_semestral_id: "",
                // quantity_sem: "",
                idPCR: "",
                idIPCR: "",
                idDPCR: "",
                idHIPCR: "",
                idHSPCR: "",
                idHDPCR: "",
                idHPCR:"",
                id:"",
                ipcr_semestral_id:"",
                type:"",
                employee_code:"",
                is_additional_target:"",
                semester:"",
                year:"",
                status:"",
                remarks:"",
                identifier: "",
                slug:"",
                slug_sem: "",
                pcr_type: "",

                // year: "",
                // remarks: "",
                // id: null
            }),
            ipcr_mfo: "",
            ipcr_submfo: "",
            // pcr_output: "",
            // pcr_ind_output: "",
            pcr_performance: "",
            pcr_success: "",
            pcr_prescribed_period: "",
            pageTitle: "",
            selected_value: []
        };
    },

    mounted() {

        this.form.ipcr_semestral_id = "0";
        this.form.slug_sem = this.slug;
        if (this.editData !== undefined) {
            this.pageTitle = "Edit"
            this.form.employee_code = this.editData.employee_code
            if(this.pcr_type=="hos"){
                this.form.idPCR = this.editData.idHPCR
            }
            if(this.pcr_type=="hdiv"){
                this.form.idPCR = this.editData.idHDPCR
                if(this.editData.idDPCR!==null){
                    this.form.idPCR = this.editData.idDPCR
                }
            }
            if(this.pcr_type=="hsec"){
                this.form.idPCR = this.editData.idHSPCR
            }
            if(this.pcr_type=="hemp"){
                this.form.idPCR = this.editData.idHIPCR
                if(this.editData.idIPCR!==null){
                    this.form.idPCR = this.editData.idIPCR
                }
            }
            this.form.id = this.editData.id
            // const index = this.pcrs.findIndex(ipcr => pcr.individual_final_output_id === this.form.individual_final_output_id);
            this.form.individual_final_output_id = this.editData.individual_final_output_id
            this.$nextTick(() => {
                this.selected_pcr();
            });

            this.form.semester = this.editData.semester
            this.form.quantity_sem = this.editData.quantity_sem
            this.form.type = this.editData.type
            this.form.remarks = this.editData.remarks
            // this.form.month_1 = this.editData.month_1
            // this.form.month_2 = this.editData.month_2
            // this.form.month_3 = this.editData.month_3
            // this.form.month_4 = this.editData.month_4
            // this.form.month_5 = this.editData.month_5
            // this.form.month_6 = this.editData.month_6
            this.form.slug=this.editData.slug
            this.form.is_additional_target = this.editData.is_additional_target
            this.form.remarks = this.editData.remarks
            this.is_add = this.editData.is_additional_target
            this.form.year = this.editData.year
            this.form.ipcr_semestral_id = this.editData.ipcr_semestral_id
            this.form.identifier = this.editData.identifier
            this.my_id = this.form.ipcr_semestral_id
        } else {
            this.form.employee_code = this.emp.empl_id
            this.pageTitle = "New"
            this.form.quantity_sem = "0";
            // this.form.month_1 = "0";
            // this.form.month_2 = "0";
            // this.form.month_3 = "0";
            // this.form.month_4 = "0";
            // this.form.month_5 = "0";
            // this.form.month_6 = "0";
            this.form.status='-1';
            this.form.semester = this.sem.sem;
            this.form.ipcr_semestral_id = this.id;
            this.form.is_additional_target = this.is_additional_target
            // alert(this.additional);

            // else {
            //     this.form.quantity_sem = "1";
            //     this.form.month_1 = "1";
            //     this.form.month_2 = "1";
            //     this.form.month_3 = "1";
            //     this.form.month_4 = "1";
            //     this.form.month_5 = "1";
            //     this.form.month_6 = "1";
            // }
            this.my_id = this.id
            this.setYear();
            this.is_add = this.additional
        }

    },
    computed: {
        month_list() {
            var mos = [];
            if (this.form.semester === "1") {
                mos = ["January", "February", "March", "April", "May", "June"];
            } else if (this.form.semester === "2") {
                mos = ["July", "August", "September", "October", "November", "December"];
            } else {
                mos = ["", "", "", "", "", ""];
            }
            return mos;
        },
        quantity_needed() {
            var v1 = 0;
            var v2 = 0;
            var v3 = 0;
            var v4 = 0;
            var v5 = 0;
            var v6 = 0;
            if (this.form.month_1 !== "" && this.form.month_1 !== undefined
                && this.form.month_1 != NaN && this.form.month_1 != null) {
                v1 = parseFloat(this.form.month_1);
            }
            if (this.form.month_2 !== "" && this.form.month_2 !== undefined
                && this.form.month_2 != NaN && this.form.month_2 != null
            ) {
                v2 = parseFloat(this.form.month_2);
            }
            if (this.form.month_3 !== "" && this.form.month_3 !== undefined
                && this.form.month_3 !== NaN && this.form.month_3 !== null
            ) {
                v3 = parseFloat(this.form.month_3);
            }
            if (this.form.month_4 !== "" && this.form.month_4 !== undefined
                && this.form.month_4 !== NaN && this.form.month_4 !== null
            ) {
                v4 = parseFloat(this.form.month_4);
            }
            if (this.form.month_5 !== "" && this.form.month_5 !== undefined
                && this.form.month_5 !== NaN && this.form.month_5 !== null
            ) {
                v5 = parseFloat(this.form.month_5);
            }
            if (this.form.month_6 !== "" && this.form.month_6 !== undefined
                && this.form.month_6 !== NaN && this.form.month_6 !== null
            ) {
                v6 = parseFloat(this.form.month_6);
            }
            var sem_targ = parseFloat(this.form.quantity_sem);
            var sum = v1 + v2 + v3 + v4 + v5 + v6;
            var ret = "";
            var diff = 0;
            if (sem_targ > sum) {
                diff = sem_targ - sum;
                ret = "WARNING: Add " + diff + " to your monthly targets OR remove " + diff + " from your semestral target "
            } else if (sem_targ < sum) {
                diff = sum - sem_targ;
                ret = "WARNING: Remove " + diff + " from your monthly targets OR add " + diff + " to your semestral target "
            }
            return ret;
        },
        // dpcr_sel() {
        //     let dpcrs_1 = this.dpcrs;
        //     return dpcrs_1.map((dpcr) => ({
        //         value: dpcr.id,
        //         label: dpcr.division_output,
        //         // FFUNCCOD: dpcr.FFUNCCOD
        //     }));
        // },
        pcr_sel() {
            let pcrs_1 = this.pcrs;
            // return this.pcrs;
            return pcrs_1.map((pcr) => ({
                value: `${pcr.id}-${pcr.type}`,
                id: pcr.id,
                type: pcr.type,
                label:  (pcr.mfo_desc ? pcr.mfo_desc + " - " : "") + pcr.performance_measure + " " + pcr.output  ,
                // + " - " + pcr.type
                // ipcr.individual_final_output_id + "-" +
                // FFUNCCOD: ipcr.FFUNCCOD,
                // department_code: ipcr.department_code,
                // department_code: ipcr.department_code,
                // department_code: ipcr.department_code,
                // department_code: ipcr.department_code,
                // department_code: ipcr.department_code,
            }));
        },

    },
    methods: {
        submit() {
            if(this.form.remarks == null || this.form.remarks == undefined || this.form.remarks == '') {
                this.form.identifier = '';
            }
            if (this.editData !== undefined) {
                this.form.patch("/hospital-targets/r/" + this.form.id, this.form);
            } else {
                this.form.ifo_desc = this.pcr_ind_output;
                // if (this.is_add != '1') {
                    this.form.post("/hospital-targets/r/store/" + this.id);
                // }
            }
        },
        cancelEdit() {
            //:href="`/ipcrtargets/${my_id}`"
            let text = "WARNING!\nYou have unsaved changes in this form. Are you sure you want to exit without saving changes?";
            // alert("/ipcrtargets/" + ipcr_id + "/"+ this.id+"/delete")
            if (confirm(text) == true) {
                this.$inertia.get("/ipcrtargets/" + this.my_id);
            }
        },
        selected_pcr() {
            setTimeout(() => {
                const selectedValue = this.selectedPCR;
                if (!selectedValue) return;

                const [s_id, s_type] = selectedValue.split('-');
                this.form.idPCR = s_id;
                this.form.pcr_type = s_type;
                const index = this.pcrs.findIndex(pcr =>
                    String(pcr.id) === s_id && pcr.type === s_type
                );
                if (String(this.form.idPCR) !== null && String(this.form.idPCR) !== undefined && String(this.form.idPCR) !== '') {
                    // Find the index of the selected option in the array of pcrs
                    const index = this.pcrs.findIndex(pcr => String(pcr.id) === String(s_id)&& pcr.type === s_type);
                    // console.log(index)
                    // console.log(s_id)
                    // console.log(s_type)
                    // alert(this.form.individual_final_output_id);
                    this.selected_value = this.pcrs[index];
                    // console.log(this.selected_value)
                    // this.pcr_div_output = this.pcrs[index].div_output;
                    // this.pcr_ind_output = this.pcrs[index].individual_output;
                    this.pcr_performance = this.pcrs[index].efficiency1 == "No" && this.pcrs[index].timeliness == "No"? this.pcrs[index].performance_measure + " "
                        + this.pcrs[index].output
                        + " with a satisfactory rating for quality/effectiveness and satisfactory in efficiency"
                        : this.pcrs[index].efficiency1 == "Yes" ? this.pcrs[index].performance_measure
                        + " " + this.pcrs[index].output
                        + " with a satisfactory rating for quality/effectiveness and satisfactory in efficiency within "
                        + this.pcrs[index].prescribed_period: this.pcrs[index].performance_measure + " "
                        + this.pcrs[index].output + " with a satisfactory rating for quality/effectiveness and satisfactory in efficiency on or before "
                        + this.pcrs[index].timeliness;
                    this.pcr_prescribed_period = this.pcrs[index].efficiency1 == "No" && this.pcrs[index].timeliness == "No"? "Not to be Rated" : this.pcrs[index].efficiency1 == "Yes" ?
                    this.pcrs[index].prescribed_period : this.pcrs[index].timeliness;
                    this.form.pcr_type = this.pcrs[index].type;

                    if(this.form.pcr_type=="ipcr"){
                        this.form.idIPCR=this.form.idPCR
                    }
                    if(this.form.pcr_type=="dpcr"){
                        this.form.idDPCR=this.form.idPCR
                    }
                    if(this.form.pcr_type=="hpcr"){
                        this.form.idHPCR=this.form.idPCR
                    }
                    if(this.form.pcr_type=="hspcr"){
                        this.form.idHSPCR=this.form.idPCR
                    }
                    if(this.form.pcr_type=="hdpcr"){
                        this.form.idHDPCR=this.form.idPCR
                    }
                    if(this.form.pcr_type=="hipcr"){
                        this.form.idHIPCR=this.form.idPCR
                    }
                    console.log(this.pcrs[index])
                    // alert(this.pcrs[index].prescribed_period);
                } else {
                    // Handle case when no option is selected (form.pcr_code is null or undefined)
                    console.log("Error")
                    return -1; // Return -1 to indicate no option is selected
                }
            }, 300);

        },
        setYear() {
            const now = new Date();
            this.form.year = now.getFullYear();
        },
        moveToNextInput(nextInput) {
            this.$refs[nextInput].focus();
        },
        goBack() {
            window.history.back()
        },
    },
};
</script>

<style></style>
