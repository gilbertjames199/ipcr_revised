<template>
    <div class="relative row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <!-- {{ office }} -->

            <h3>{{ pageTitle }} PG Head</h3>
            <Link href="/offices">
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
                <label for="">Office: <u>{{ office.office }}</u></label>
                <div></div>
                <label for="">PG Department Head</label>

                <multiselect :options="pgdhs_computed" :searchable="true" v-model="form.empl_id" label="label"
                    track-by="label">
                </multiselect>
                <div class="fs-6 c-red-500" v-if="form.errors.empl_id">Select a PG department head!</div>

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

                <button type="button" class="btn btn-primary mt-3 text-white" @click="submit()" :disabled="form.processing">
                    Save changes
                </button>
            </form>
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
        office: Object,
        employees: Object,
        // offices: Object,
        // pgdhs: Object,
        // editData: Object
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
                // employee_code: "",
                department_code: "",
                // designate_department_code: "",
                empl_id: "",
                id: null
            }),
            pageTitle: ""
        };
    },
    computed: {
        employees_computed() {
            // let emps = this.employees;
            // return emps.map((emp) => ({
            //     value: emp.empl_id,
            //     label: emp.employee_name,
            //     //   + ' (' + emp.Office.office + ')',
            //     salary_grade: emp.salary_grade,
            // }));
        },
        pgdhs_computed() {
            let emps = this.employees;
            return emps.map((emp) => ({
                value: emp.empl_id,
                label: emp.employee_name,
                salary_grade: emp.salary_grade,
            }));
        }
    },
    mounted() {
        if (this.office !== undefined) {
            this.pageTitle = "Edit"
            this.form.id=this.office.id
            this.form.empl_id=this.office.empl_id
            this.form.department_code = this.office.department_code
            // this.form.name = this.editData.name
            // this.form.email = this.editData.email
            // this.form.id = this.editData.id
            // this.form.employee_code = this.editData.employee_code
            // this.form.department_code = this.editData.department_code
            // this.form.designate_department_code = this.editData.designate_department_code
            // this.form.pgdh_cats = this.editData.pgdh_cats
            // this.form.id = this.editData.id
        } else {
            this.pageTitle = "Set"
        }

    },

    methods: {
        submit() {
            if (this.office !== undefined) {
                this.form.patch("/offices/update_pghead/" + this.form.id, this.form);
            } else {
                // this.form.post("/employee/special/department/store", this.form);
                alert('dsdasdasdasd');
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
