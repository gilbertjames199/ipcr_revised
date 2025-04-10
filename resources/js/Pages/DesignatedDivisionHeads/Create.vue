<template>
    <div class="relative row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h3>{{ pageTitle }} Designations</h3>
            <Link href="/designated-division-head">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-lg"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z" />
                <path fill-rule="evenodd"
                    d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z" />
            </svg>
            </Link>
        </div>

        <!--
    <div class="col-md-8">
        <button class="btn btn-secondary" @click="showModal" :disabled="submitted">Permissions</button>
    </div>
    -->
        <div class="col-md-8">
            <form @submit.prevent="submit()">
                <input type="hidden" required>
                <label for="">Employee</label>
                <!-- <multiselect v-model="form.employee_code" class="form-select">
                    <option v-for="emp in employees">
                        {{ emp.employee_name }}
                    </option>
                </multiselect> -->
                <multiselect :options="employees_computed" :searchable="true" v-model="form.empl_id" label="label"
                    track-by="label">
                </multiselect>
                <div class="fs-6 c-red-500" v-if="form.errors.empl_id">Select an employee!</div>

                <label for="">Type</label>
                <select v-model="form.type" class="form-select" @change="setChildValues">
                    <option value=""></option>
                     <option value="ipcr">IPCR User</option>
                    <option value="hpcr">Hospital Head</option>
                    <option value="hdpcr">Hospital Division Head</option>
                    <option value="hspcr">Hospital Section Head</option>
                    <option value="dpcr">Division Head</option>
                    <option value="spcr">Section Head</option>
                </select>
                <div class="fs-6 c-red-500" v-if="form.errors.type">Select a type!</div>

                <label for="">Departments</label>
                <select v-model="form.department_code" class="form-select" >
                    <option value=""></option>
                    <option v-for="office in filteredOffices" :value="office.department_code">
                        {{ office.office }}
                    </option>
                </select>
                <div class="fs-6 c-red-500" v-if="form.errors.department_code">Select a department!</div>
                <!-- {{ offices }} -->
                <!-- <label for="">Designate Department</label>
                <select v-model="form.designate_department_code" class="form-select">
                    <option value=""></option>
                    <option v-for="office in offices" :value="office.department_code">
                        {{ office.office }}
                    </option>
                </select>
                <div class="fs-6 c-red-500" v-if="form.errors.designate_department_code">Select a designate department!
                </div> -->
                <label for="">Division {{ form.division_code }}</label>
                <multiselect :options="divisions_computed" :searchable="true" v-model="form.division_code" label="label"
                    track-by="label">
                </multiselect>
                <div class="fs-6 c-red-500" v-if="form.errors.division_code">
                    <span v-if="form.type==='hpcr'">Do not select a division!</span>
                    <span v-else>Select a division!</span>
                </div>

                <!-- <label for="">PG Department Head</label> -->

                <!-- <multiselect :options="pgdhs_computed" :searchable="true" v-model="form.pgdh_cats" label="label"
                    track-by="label">
                </multiselect>
                <div class="fs-6 c-red-500" v-if="form.errors.pgdh_cats">Select a PG department head!</div> -->

                <!-- <input type="text" v-model="form.email" class="form-control" autocomplete="chrome-off">
                <div class="fs-6 c-red-500" v-if="form.errors.email">{{ form.errors.email }}</div> -->
                <!-- <span v-if="editData === undefined">
                    <label for="">Password</label>
                    <input type="password" v-model="form.password" class="form-control" autocomplete="chrome-off">
                    <div class="fs-6 c-red-500" v-if="form.errors.password">{{ form.errors.password }}</div>
                </span> -->
                <div class="parent">
                    <div class="row">
                        <div class="col-md-6">

                        </div>
                    </div>
                    <bootstrap-modal-no-jquery v-if="displayModal" @close-modal-event="hideModal"
                        :permissions="permissions" />
                </div>
                <input type="hidden" v-model="form.id" class="form-control" autocomplete="chrome-off">
<br><br><br><br><br><br><br>
                <button type="button" class="btn btn-primary mt-3 text-white" @click="submit()" :disabled="form.processing">
                    Save changes
                </button>
            </form>
            <!-- {{ editData }} -->
            <!-- {{  divisions }} -->
            <!-- {{ employees[0] }} <br/> -->
            <!-- Office {{ employees[0].office.office }} -->
             <!-- {{ form.added_by }}<br>
             {{ auth }} -->
              <!-- {{ employees }} -->
        </div>
    </div>
</template>
<script>
import { useForm } from "@inertiajs/inertia-vue3";
import { ModelSelect } from 'vue-search-select';

// import BootstrapModalNoJquery from './BootstrapModalNoJquery.vue';

export default {
    props: {
        auth: Object,
        employees: Object,
        offices: Object,
        divisions: Object,
        pgdhs: Object,
        editData: Object
    },
    components: {
        // BootstrapModalNoJquery,
        ModelSelect
    },
    data() {
        return {
            submitted: false,
            displayModal: false,
            exampleModalShowing: false,
            arr_length: 0,
            newData: [],
            form: useForm({
                empl_id: "",
                department_code: "",
                division_code: "",
                // designate_department_code: "",
                type: "",
                added_by: "",
                id: null
            }),
            pageTitle: ""
        };
    },
    computed: {
        employees_computed() {
            let emps = this.employees;
            return emps.map((emp) => ({
                value: emp.empl_id,
                label: emp.empl_id+' - '+emp.employee_name + ' (' + emp.pos + ' at '+ (emp.office?.office || 'No Office') + ')',
                salary_grade: emp.salary_grade,
            }));
        },
        divisions_computed() {
            let divs = this.divisions;
            if (this.form.department_code) {
                divs = divs.filter((div) => div.department_code === this.form.department_code);
            }
            return divs.map((div) => ({
                value: div.division_code,
                label: div.division_name1,
            }));
        },
        filteredOffices() {
            if (this.form.type === 'hpcr' || this.form.type === 'hdpcr' || this.form.type === 'hspcr') {
                return this.offices.filter(office => office.office.includes('HOSPITAL'));
            }
            // || this.form.type === 'spcr'
            if (this.form.type === 'dpcr' ) {
                return this.offices.filter(office => office.office.includes('OFFICE'));
            }
            return this.offices;
        },
        // pgdhs_computed() {
        //     let emps = this.pgdhs;
        //     return emps.map((emp) => ({
        //         value: emp.empl_id,
        //         label: emp.employee_name,
        //         salary_grade: emp.salary_grade,
        //     }));
        // }
    },
    mounted() {

        if (this.editData !== undefined) {
            this.pageTitle = "Edit"
            // this.form.name = this.editData.name
            // this.form.email = this.editData.email
            // this.form.id = this.editData.id
            this.form.empl_id = this.editData.empl_id
            this.form.type = this.editData.type
            if(this.form.type=='hpcr'){
                this.form.department_code = this.editData.department_code
            }else{
                if(this.form.division_code){
                    this.form.department_code = this.editData.division.department_code
                }else{
                    this.form.department_code = this.editData.department_code
                }

            }

            this.form.division_code = this.editData.division_code

            this.form.added_by = this.editData.added_by
            this.form.id = this.editData.id
        } else {
            this.pageTitle = "Set"
            this.form.added_by = this.auth.user.username;
        }

    },

    methods: {
        submit() {
            if (this.editData !== undefined) {
                this.form.patch("/designated-division-head/update/" + this.form.id, this.form);
            } else {
                this.form.post("/designated-division-head/store", this.form);
            }
        },

        canCreateCheck: function (value, event) {
            if (event.target.checked) {
                alert('is selected')
            }
        },
        setChildValues() {

                this.form.division_code = null;
                this.form.department_code = null;

        },

    },
};
</script>
