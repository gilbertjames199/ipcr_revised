<template>
    <div class="relative row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h2><b>{{ pageTitle }} IPCR Target</b></h2>
            <Link :href="`/ipcrtargets/${my_id}`">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-lg"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z" />
                <path fill-rule="evenodd"
                    d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z" />
            </svg>
            </Link>
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
                                    <label for="">IPCR Code</label>
                                    <div>
                                        <multiselect :options="ipcr_sel" :searchable="true" v-model="form.ipcr_code"
                                            label="label" track-by="label" @close="selected_ipcr">
                                        </multiselect>
                                    </div>
                                    <!-- <select type="text" v-model="form.ipcr_code" :disabled="editData !== undefined" class="form-control" autocomplete="chrome-off" @change="selected_ipcr">
                                        <option v-for="ipcr, index in ipcrs" :value="ipcr.ipcr_code">
                                            {{ ipcr.ipcr_code }} - {{ ipcr.individual_output }}
                                        </option>
                                    </select> -->
                                    <div class="fs-6 c-red-500" v-if="form.errors.ipcr_code">{{ form.errors.ipcr_code }}
                                    </div>
                                    <div class="fs-6 c-red-500" v-if="form.errors.employee_code">{{
                                        form.errors.employee_code }}</div>
                                    <label for="">Major Final Output</label>
                                    <input type="text" v-model="ipcr_mfo" class="form-control" autocomplete="chrome-off"
                                        readonly>

                                    <label for="">Sub MFO</label>
                                    <input type="text" v-model="ipcr_submfo" class="form-control" autocomplete="chrome-off"
                                        readonly>

                                    <label for="">Division Output</label>
                                    <input type="text" v-model="ipcr_div_output" class="form-control"
                                        autocomplete="chrome-off" readonly>

                                    <label for="">Individual Final Output</label>
                                    <input type="text" v-model="ipcr_ind_output" class="form-control"
                                        autocomplete="chrome-off" readonly>

                                    <label for="">Performance Measure</label>
                                    <input type="text" v-model="ipcr_ind_output" class="form-control"
                                        autocomplete="chrome-off" readonly>

                                    <input type="hidden" v-model="form.id" class="form-control" autocomplete="chrome-off">

                                    <label for="">Semester</label>
                                    <select type="text" v-model="form.semester" class="form-control"
                                        autocomplete="chrome-off" disabled>
                                        <option value="1">First Semester</option>
                                        <option value="2">Second Semester</option>
                                    </select>
                                    <div class="fs-6 c-red-500" v-if="form.errors.semester">{{ form.errors.semester }}</div>

                                    <label for="">Type/Category</label>
                                    <select type="text" v-model="form.ipcr_type" class="form-control"
                                        autocomplete="chrome-off">
                                        <option value="Core Function">Core Function</option>
                                        <option value="Support Function">Support Function</option>
                                    </select>
                                    <div class="fs-6 c-red-500" v-if="form.errors.ipcr_type">{{ form.errors.ipcr_type }}
                                    </div>

                                    <div v-if="is_add === '1'">
                                        <label for="">Remarks</label>
                                        <input type="text" v-model="form.remarks" class="form-control"
                                            autocomplete="chrome-off">
                                        <div class="fs-6 c-red-500" v-if="form.errors.remarks">{{ form.errors.remarks }}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                </fieldset>
            </div>

            <div class="col-md-8" v-if="is_add != '1'">
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
                                        <label for="">Semestral Target &nbsp;</label>
                                        <input type="number" v-model="form.quantity_sem" class="form-control"
                                            autocomplete="chrome-off">
                                        <div class="fs-6 c-red-500" v-if="form.errors.quantity_sem">{{
                                            form.errors.quantity_sem }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="">{{ month_list[0] }}</label>
                                    <input type="number" v-model="form.month_1" class="form-control"
                                        autocomplete="chrome-off">
                                    <div class="fs-6 c-red-500" v-if="form.errors.month_1">{{ form.errors.month_1 }}</div>

                                    <label for="">{{ month_list[1] }}</label>
                                    <input type="text" v-model="form.month_2" class="form-control"
                                        autocomplete="chrome-off">
                                    <div class="fs-6 c-red-500" v-if="form.errors.month_2">{{ form.errors.month_2 }}</div>

                                    <label for="">{{ month_list[2] }}</label>
                                    <input type="number" v-model="form.month_3" class="form-control"
                                        autocomplete="chrome-off">
                                    <div class="fs-6 c-red-500" v-if="form.errors.month_3">{{ form.errors.month_3 }}</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="">{{ month_list[3] }}</label>
                                    <input type="number" v-model="form.month_4" class="form-control"
                                        autocomplete="chrome-off">
                                    <div class="fs-6 c-red-500" v-if="form.errors.month_4">{{ form.errors.month_4 }}</div>

                                    <label for="">{{ month_list[4] }}</label>
                                    <input type="number" v-model="form.month_5" class="form-control"
                                        autocomplete="chrome-off">
                                    <div class="fs-6 c-red-500" v-if="form.errors.month_5">{{ form.errors.month_5 }}</div>

                                    <label for="">{{ month_list[5] }}</label>
                                    <input type="number" v-model="form.month_6" class="form-control"
                                        autocomplete="chrome-off">
                                    <div class="fs-6 c-red-500" v-if="form.errors.month_6">{{ form.errors.month_6 }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>


            <div hidden>
                <input type="number" v-model="form.year" class="form-control" autocomplete="chrome-off">
                <div class="fs-6 c-red-500" v-if="form.errors.year">{{ form.errors.year }}</div>
                <input type="text" v-model="form.is_additional_target" class="form-control" autocomplete="chrome-off">
            </div>

            <button type="button" class="btn btn-primary mt-3 text-white" @click="submit()" :disabled="form.processing">
                Save changes
            </button>&nbsp;
            <button type="button" class="btn btn-danger mt-3 text-white" @click="cancelEdit()" :disabled="form.processing">
                Cancel
            </button>
        </form>
        <!-- {{ editData }}
        {{ additional }} -->
        <!-- additional {{ additional }} -->
        <!-- //{{ id }} {{ form.year }} -->
        <!-- {{  sem }} -->
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
        ipcrs: Object,
        sem: Object,
        additional: String
    },
    components: {
        ModelSelect
    },
    data() {
        return {
            is_add: '0',
            submitted: false,
            my_id: "",
            form: useForm({
                ipcr_code: "",
                employee_code: "",
                semester: "",
                ipcr_type: "",
                is_additional_target: "",
                ipcr_semester_id: "",
                quantity_sem: "",
                month_1: "",
                month_2: "",
                month_3: "",
                month_4: "",
                month_5: "",
                month_6: "",
                year: "",
                remarks: "",
                id: null
            }),
            ipcr_mfo: "",
            ipcr_submfo: "",
            ipcr_div_output: "",
            ipcr_ind_output: "",
            ipcr_performance: "",
            ipcr_success: "",
            pageTitle: "",
            selected_value: []
        };
    },

    mounted() {

        this.form.ipcr_semester_id = "0";
        if (this.editData !== undefined) {

            this.pageTitle = "Edit"
            this.form.employee_code = this.editData.employee_code
            this.form.id = this.editData.id
            const index = this.ipcrs.findIndex(ipcr => ipcr.ipcr_code === this.form.ipcr_code);
            this.form.ipcr_code = this.editData.ipcr_code
            this.$nextTick(() => {
                this.selected_ipcr();
            });
            this.form.semester = this.editData.semester
            this.form.quantity_sem = this.editData.quantity_sem
            this.form.ipcr_type = this.editData.ipcr_type
            this.form.month_1 = this.editData.month_1
            this.form.month_2 = this.editData.month_2
            this.form.month_3 = this.editData.month_3
            this.form.month_4 = this.editData.month_4
            this.form.month_5 = this.editData.month_5
            this.form.month_6 = this.editData.month_6
            this.form.is_additional_target = this.editData.is_additional_target
            this.form.remarks = this.editData.remarks
            this.is_add = this.editData.is_additional_target
            this.form.year = this.editData.year
            this.form.ipcr_semester_id = this.editData.ipcr_semester_id
            this.my_id = this.form.ipcr_semester_id
        } else {
            this.form.employee_code = this.emp.empl_id
            this.pageTitle = "New"
            this.form.quantity_sem = "0";
            this.form.month_1 = "0";
            this.form.month_2 = "0";
            this.form.month_3 = "0";
            this.form.month_4 = "0";
            this.form.month_5 = "0";
            this.form.month_6 = "0";
            this.form.semester = this.sem.sem;
            this.form.ipcr_semester_id = this.id;
            this.form.is_additional_target = this.additional
            if (this.additional == null) {
                this.form.is_additional_target = '0'
            }
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
            if (this.form.month_1 !== "" || this.form.month_1 !== undefined) {
                v1 = parseFloat(this.form.month_1);
                v2 = parseFloat(this.form.month_2);
                v3 = parseFloat(this.form.month_3);
                v4 = parseFloat(this.form.month_4);
                v5 = parseFloat(this.form.month_5);
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
        ipcr_sel() {
            let ipcrs_1 = this.ipcrs;
            return ipcrs_1.map((ipcr) => ({
                value: ipcr.ipcr_code,
                label: ipcr.ipcr_code + "-" + ipcr.individual_output + " - " + ipcr.performance_measure,
                // FFUNCCOD: ipcr.FFUNCCOD,
                // department_code: ipcr.department_code,
                // department_code: ipcr.department_code,
                // department_code: ipcr.department_code,
                // department_code: ipcr.department_code,
                // department_code: ipcr.department_code,
            }));
        }
    },
    methods: {
        submit() {
            var v1 = parseFloat(this.form.month_1);
            var v2 = parseFloat(this.form.month_2);
            var v3 = parseFloat(this.form.month_3);
            var v4 = parseFloat(this.form.month_4);
            var v5 = parseFloat(this.form.month_5);
            var v6 = parseFloat(this.form.month_6);
            var sem_targ = parseFloat(this.form.quantity_sem);
            var sum = v1 + v2 + v3 + v4 + v5 + v6;
            if (sum != sem_targ) {
                alert(this.quantity_needed);
            } else {
                if (this.editData !== undefined) {
                    //alert("patch");
                    this.form.patch("/ipcrtargets/" + this.id, this.form);
                } else {
                    if (this.is_add != '1') {
                        this.form.post("/ipcrtargets/store/" + this.id);
                    } else {

                        this.form.post("/ipcrtargets/store/" + this.id + "/additional/ipcr/targets/store");
                    }

                }
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
        selected_ipcr() {
            if (this.form.ipcr_code !== null && this.form.ipcr_code !== undefined) {
                // Find the index of the selected option in the array of ipcrs
                const index = this.ipcrs.findIndex(ipcr => String(ipcr.ipcr_code) === String(this.form.ipcr_code));
                // alert(index);
                this.selected_value = this.ipcrs[index];
                this.ipcr_mfo = this.ipcrs[index].mfo_desc;
                this.ipcr_submfo = this.ipcrs[index].submfo_description;
                this.ipcr_div_output = this.ipcrs[index].div_output;
                this.ipcr_ind_output = this.ipcrs[index].individual_output;
                this.ipcr_performance = this.ipcrs[index].performance_measure;
                //this.ipcr_success = this.ipcrs[index].s
                //alert(index);
            } else {
                // Handle case when no option is selected (form.ipcr_code is null or undefined)
                return -1; // Return -1 to indicate no option is selected
            }
        },
        setYear() {
            const now = new Date();
            this.form.year = now.getFullYear();
        }
    },
};
</script>

<style></style>
