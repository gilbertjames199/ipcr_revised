<template>
    <div class="relative row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h3>{{ pageTitle }} Employee Special Department</h3>
            <Link href="/employee/special/department">
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
                <multiselect :options="employees_computed" :searchable="true" v-model="form.employee_code" label="label"
                    track-by="label">
                </multiselect>
                <div class="fs-6 c-red-500" v-if="form.errors.employee_code">Select an employee!</div>
                <label for="">Departments</label> {{ form.department_code }}
                <select v-model="form.department_code" class="form-select">
                    <option value=""></option>
                    <option v-for="office in offices" :value="office.department_code">
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
                <label for="">PG Department Head</label>
                <!-- {{ pgdhs }} -->
                <!-- <select v-model="form.pgdh_cats" class="form-select">
                    <option v-for="pgdh in pgdhs" :value="pgdh.empl_id">
                        {{ pgdh.employee_name }}
                    </option>
                </select> -->
                <!-- {{ editData }} -->
                <multiselect :options="pgdhs_computed" :searchable="true" v-model="form.pgdh_cats" label="label"
                    track-by="label">
                </multiselect>
                <div class="fs-6 c-red-500" v-if="form.errors.pgdh_cats">Select a PG department head!</div>

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

                <button type="button" class="btn btn-primary mt-3" @click="submit()" :disabled="form.processing">
                    Save changes
                </button>
            </form>
        </div>
    </div>
</template>
<script>
import { useForm } from "@inertiajs/inertia-vue3";
import { ModelSelect } from 'vue-search-select';

// import BootstrapModalNoJquery from './BootstrapModalNoJquery.vue';

export default {
    props: {
        employees: Object,
        offices: Object,
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
                employee_code: "",
                department_code: "",
                designate_department_code: "",
                pgdh_cats: "",
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
                label: emp.employee_name + ' (' + emp.office.office + ')',
                salary_grade: emp.salary_grade,
            }));
        },
        pgdhs_computed() {
            let emps = this.pgdhs;
            return emps.map((emp) => ({
                value: emp.empl_id,
                label: emp.employee_name,
                salary_grade: emp.salary_grade,
            }));
        }
    },
    mounted() {
        if (this.editData !== undefined) {
            this.pageTitle = "Edit"
            // this.form.name = this.editData.name
            // this.form.email = this.editData.email
            // this.form.id = this.editData.id
            this.form.employee_code = this.editData.employee_code
            this.form.department_code = this.editData.department_code
            this.form.designate_department_code = this.editData.designate_department_code
            this.form.pgdh_cats = this.editData.pgdh_cats
            this.form.id = this.editData.id
        } else {
            this.pageTitle = "Set"
        }

    },

    methods: {
        submit() {
            if (this.editData !== undefined) {
                this.form.patch("/employee/special/department/update/" + this.form.id, this.form);
            } else {
                this.form.post("/employee/special/department/store", this.form);
            }
        },

        canCreateCheck: function (value, event) {
            if (event.target.checked) {
                alert('is selected')
            }
        },

    },
};
</script>
