<template>
    <div class="relative row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h3>{{ pageTitle }} IPCR</h3>
            <Link v-if="editData !== undefined" :href="`/ipcrsemestral/${emp.id}/${source}`">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-lg"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z" />
                <path fill-rule="evenodd"
                    d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z" />
            </svg>
            </Link>
            <Link v-else :href="`/ipcrsemestral/${id}/${source}`">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-lg"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z" />
                <path fill-rule="evenodd"
                    d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z" />
            </svg>
            </Link>
        </div>
        <!-- {{ emp }} -->
        <!-- {{ editData.id }} -->
        <!-- {{ editData }}{{ form.semester }}{{ editData.sem }} -->
        <div class="col-md-8">
            <div>Name: <u>{{ emp.employee_name }}</u></div>
            <div>Position: <u>{{ emp.position_long_title }}</u></div>
            <div>Employment Status: <u>{{ emp.employment_type_descr }}</u></div>
            <!-- {{ emp }} -->
            <form @submit.prevent="submit()">
                <input type="hidden" required>
                <!-- {{ selected_value }} -->

                <label for="">Rating Period</label>
                <select type="text" v-model="form.sem" class="form-control" autocomplete="chrome-off">
                    <option value="1">First Semester</option>
                    <option value="2">Second Semester</option>
                </select>
                <div class="fs-6 c-red-500" v-if="form.errors.sem">{{ form.errors.sem }}</div>

                <label for="">Immediate Supervisor</label>
                <div>
                    <multiselect :options="supervisors_i" :searchable="true" v-model="form.immediate_id" label="label"
                        track-by="label" @close="setSG">
                    </multiselect>
                </div>
                <!-- <select type="text" v-model="form.immediate_id" class="form-control" @change="setSG" autocomplete="chrome-off" >
                    <option></option>
                    <option v-for="superv in supervisors" :value="superv.empl_id" >{{ superv.employee_name }}</option>
                </select> -->
                <div class="fs-6 c-red-500" v-if="form.errors.immediate_id">{{ form.errors.immediate_id }}</div>

                <label for="">Next Higher Supervisor</label>
                <div>
                    <multiselect :options="supervisors_h" :searchable="true" v-model="form.next_higher" label="label"
                        track-by="label">
                    </multiselect>
                </div>
                <!-- {{ form.next_higher }} -->
                <!-- <select type="text" v-model="form.next_higher" class="form-control" autocomplete="chrome-off" >
                    <option></option>
                    <option v-for="superv in supervisors_h" :value="superv.empl_id">{{ superv.employee_name }}</option>
                </select> -->
                <div class="fs-6 c-red-500" v-if="form.errors.next_higher">{{ form.errors.next_higher }}</div>

                <label for="">Year</label>
                <input v-model="form.year" class="form-control" type="number" name="year" min="1900" max="2099" step="1"
                    oninput="javascript: if (this.value.length > 4) this.value = this.value.slice(0, 4);" />
                <div class="fs-6 c-red-500" v-if="form.errors.year">{{ form.errors.year }}</div>
                <button type="button" class="btn btn-primary mt-3 text-white font-weight-bold" @click="submit()"
                    :disabled="form.processing">
                    Save changes
                </button>
            </form>
        </div>
        <!-- {{ supervisors_h }} -->
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
        supervisors: Object,
        emp: Object,
        dept_code: String,
        source: String,
        auth: Object
    },
    components: {
        ModelSelect
    },
    data() {
        return {
            submitted: false,
            form: useForm({
                sem: "",
                employee_code: "",
                immediate_id: "",
                next_higher: "",
                year: "",
                source: "",
                status: "",
                id: null
            }),
            emp_sg: this.auth.user.name.salary_grade,
            immediate_sg: "0",
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
        this.form.source = this.source
        // this.form.ipcr_semester_id="0";
        if (this.editData !== undefined) {
            this.pageTitle = "Edit"
            this.form.sem = this.editData.sem
            this.form.immediate_id = this.editData.immediate_id
            this.form.next_higher = this.editData.next_higher
            this.form.year = this.editData.year
            this.form.employee_code = this.editData.employee_code
            this.form.status = this.editData.status
            this.form.id = this.editData.id
            // alert(this.id)
        } else {
            this.form.employee_code = this.emp.empl_id
            this.pageTitle = "Create"
            this.form.status = "-1"
            this.setYear();
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
                ret = "Add " + diff + " to your monthly targets!"
            } else if (sem_targ < sum) {
                diff = sum - sem_targ;
                ret = "Remove " + diff + " from your monthly targets!"
            }
            return ret;
        },
        supervisors_i() {
            let supervises = this.supervisors;
            return supervises.map((superv) => ({
                value: superv.empl_id,
                label: superv.employee_name,
                salary_grade: superv.salary_grade,
            }));
        },
        supervisors_h() {
            let supervises = this.supervisors;
            let msg = parseFloat(this.immediate_sg);
            if (msg > 0) {
                supervises = supervises.filter((superv) => superv.salary_grade > msg);
            }
            if (supervises.length === 0) {
                supervises = this.supervisors;
                supervises = supervises.filter((superv) => superv.salary_grade >= msg);
            }
            return supervises.map((superv) => ({
                value: superv.empl_id,
                label: superv.employee_name,
                salary_grade: superv.salary_grade,
            }));
        }
    },
    methods: {
        submit() {
            if (this.editData !== undefined) {
                if (this.form.status > 0) {
                    alert('Already approved or reviewed!')
                } else {
                    this.form.patch("/ipcrsemestral/update/" + this.editData.id, this.form);
                }

            } else {
                this.form.post("/ipcrsemestral/store/" + this.id);
            }
        },
        setYear() {
            const now = new Date();
            this.form.year = now.getFullYear();
        },
        setSG() {
            var recid = this.form.immediate_id;
            var index = this.supervisors.findIndex(superv => superv.empl_id === recid);
            if (index !== -1) {
                this.immediate_sg = this.supervisors[index].salary_grade;
            } else {
                this.immediate_sg = "0";
            }
        }
    },
};
</script>
