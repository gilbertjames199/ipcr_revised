<template>
    <div class="relative row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h3>{{ pageTitle }} IPCR</h3>
            <!-- <Link v-if="editData !== undefined" :href="`/ipcrsemestral/${emp.id}/${source}`">
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
            </Link> -->
            <button class="btn btn-danger text-white" @click="goBack">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-lg"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z" />
                    <path fill-rule="evenodd"
                        d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z" />
                </svg>
            </button>
        </div>
        <!-- {{ emp }} -->
        <!-- {{ editData.id }} -->
        <!-- {{ editData }}{{ form.semester }}{{ editData.sem }} -->
        <!-- {{ form.status }} -->
        <div class="col-md-8">
            <div>Name: <u>{{ emp.employee_name }}</u></div>
            <div>Position: <u>{{ emp.position_long_title }}</u></div>
            <div>Employment Status: <u>{{ emp.employment_type_descr }}</u></div>
            <!-- {{ emp }} -->
              {{ form }}
            <form @submit.prevent="submit()">
                <input type="hidden" required>
                <!-- {{ selected_value }} -->
                <label for="">Employee Name</label>
                <input type="text" class="form-control" v-model="form.employee_name"/>
                <div class="fs-6 c-red-500" v-if="form.errors.employee_name">{{ form.errors.employee_name }}</div>

                <label for="">Position</label>
                <input type="text" class="form-control" v-model="form.position"/>
                <div class="fs-6 c-red-500" v-if="form.errors.position">{{ form.errors.position }}</div>

                <label for="">Salary Grade</label>
                <select class="form-select" v-model="form.salary_grade" >
                    <option v-for="sg in sal_grade">
                        {{ sg }}
                    </option>
                </select>
                <div class="fs-6 c-red-500" v-if="form.errors.salary_grade">{{ form.errors.salary_grade }}</div>

                <label for="">Employment Status</label>
                <select type="text" class="form-control" v-model="form.employment_type">
                    <option>Job Order</option>
                    <option>Casual</option>
                    <option>Regular</option>
                </select>
                <div class="fs-6 c-red-500" v-if="form.errors.employment_type">{{ form.errors.employment_type }}</div>

                <label for="">Department</label>
                <input type="text" class="form-control" v-model="form.department" hidden/>
                <select class="form-select" v-model="form.department_code" @change="inheritDepartmentWord">
                    <option v-for="office in offices" :value="office.department_code">
                        {{ office.office }}
                    </option>
                </select>
                <div class="fs-6 c-red-500" v-if="form.errors.department_code">{{ form.errors.department_code }}</div>
                <!-- {{ form.division }}
{{ divisions }} -->

                <label for="">Division</label>
                <input type="text" class="form-control" v-model="form.division_name" hidden/>
                <select class="form-select" v-model="form.division" @change="inheritDivisionWord">
                    <option v-for="division in divisions" :value="division.division_code">
                        {{ division.division_name1 }}
                    </option>
                </select>
                <div class="fs-6 c-red-500" v-if="form.errors.department_code">{{ form.errors.department_code }}</div>

                <label for="">Department Head</label>
                <!-- <input type="text" class="form-control" v-model="form.division_name" /> -->
                <select class="form-select" v-model="form.pg_dept_head" >
                    <option v-for="pghead in pgheads" :value="pghead.employee_name">
                        {{ pghead.employee_name }}
                    </option>
                </select>
                <div class="fs-6 c-red-500" v-if="form.errors.department_code">{{ form.errors.department_code }}</div>

                <label for="">Rating Period</label>
                <select type="text" v-model="form.sem" class="form-control" autocomplete="chrome-off"
                    :disabled="form.status == -2">
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
                    oninput="javascript: if (this.value.length > 4) this.value = this.value.slice(0, 4);"
                    :disabled="form.status == -2" />
                <div class="fs-6 c-red-500" v-if="form.errors.year">{{ form.errors.year }}</div>
                <button type="button" class="btn btn-primary mt-3 text-white font-weight-bold" @click="submit()"
                    :disabled="form.processing">
                    Save changes
                </button>
            </form>
        </div>
        <!-- {{ emp }} -->
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
        auth: Object,
        offices: Object,
        pgheads: Object
    },
    components: {
        ModelSelect
    },
    data() {
        return {
            submitted: false,
            form: useForm({
                sem : "",
                employee_code : "",
                immediate_id : "",
                next_higher : "",
                employee_name : "",
                position : "",
                employment_type : "",
                salary_grade : "",
                division : "",
                year : "",
                status : "",
                status_accomplishment : "",
                department_code : "",
                department : "",
                division_name : "",
                pg_dept_head : "",
                id: null
            }),
            emp_sg: this.auth.user.name.salary_grade,
            sal_grade: ['01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33',],
            immediate_sg: "0",
            ipcr_mfo: "",
            ipcr_submfo: "",
            ipcr_div_output: "",
            ipcr_ind_output: "",
            ipcr_performance: "",
            ipcr_success: "",
            pageTitle: "",
            selected_value: [],
            divisions: []
        };
    },

    mounted() {

        this.form.source = this.source
        // this.form.ipcr_semester_id="0";
        if (this.editData !== undefined) {
            this.pageTitle = "Edit"
            this.form.sem =this.editData.sem
            this.form.employee_code =this.editData.employee_code
            this.form.immediate_id =this.editData.immediate_id
            this.form.next_higher =this.editData.next_higher
            this.form.employee_name =this.editData.employee_name
            this.form.position =this.editData.position
            this.form.employment_type =this.editData.employment_type
            this.form.salary_grade =this.editData.salary_grade
            this.form.year =this.editData.year
            this.form.status =this.editData.status
            this.form.status_accomplishment =this.editData.status_accomplishment
            this.form.department_code =this.editData.department_code
            this.form.department =this.editData.department


            this.form.pg_dept_head =this.editData.pg_dept_head
            this.form.id = this.editData.id
            setTimeout(() => {
                this.loadDivisions();
                this.form.division =this.editData.division
                this.form.division_name =this.editData.division_name
            }, 1000);
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
            if (this.emp.department_code == 19 || this.emp.department_code == 18) {
                // alert('Hfsdfsdfsdf');
            } else {
                if (msg > 0) {
                    supervises = supervises.filter((superv) => superv.salary_grade >= msg);
                }
                if (supervises.length === 0) {
                    supervises = this.supervisors;
                    supervises = supervises.filter((superv) => superv.salary_grade >= msg);
                }
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
                /*if (this.form.status > 0) {
                    alert('Already approved or reviewed!')
                } else {

                }*/
                        //Route::patch('/update/{id}', [IpcrSemestralController::class, 'update2']);
                alert('ipcr sem2 update')
                this.form.patch("/ipcrsemestral2/update/" + this.editData.id+'/save/it/now', this.form);
            } else {
                                alert('store')

                // this.form.post("/ipcrsemestral/store/" + this.id);
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
        },
        inheritDepartmentWord(){
            const selectedOffice = this.offices.find(office => office.department_code === this.form.department_code);
            if (selectedOffice) {
                this.form.department = selectedOffice.office;
            }
            this.loadDivisions()
        },
        inheritDivisionWord(){
            const selectedOffice = this.divisions.find(division => division.division_code === this.form.division);
            if (selectedOffice) {
                this.form.division_name = selectedOffice.division_name1;
            }
        },
        async loadDivisions(){
            //alert("select_mun is :"+select_mun);
            this.all_barangays=[];
            this.all_puroks=[];
            axios.get("/ipcrsemestral2/get/divisions/"+this.form.department_code).then((response)=>{
                    this.divisions = response.data
                });
            // this.filterData();
        },
        goBack() {
            window.history.back()
        },


    },

};
</script>
