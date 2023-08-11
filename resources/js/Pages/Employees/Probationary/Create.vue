<template>
    <div class="relative row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h3>{{ pageTitle }} Probationary/Temporary Employee</h3>
            <Link :href="`/Daily_Accomplishment`">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z"/>
                <path fill-rule="evenodd" d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z"/>
                </svg>
            </Link>
        </div>

        <div class="col-md-8">
            <form @submit.prevent="submit()">
                <input type="hidden" required>
                <input type="hidden" v-model="form.emp_code" class="form-control" autocomplete="positionchrome-off">


                <fieldset class="border p-4">
                    <legend class="float-none w-auto">
                        <b>Employee </b>
                    </legend>
                    <div>
                        <multiselect
                            :options="formattedEmployeeList"
                            :searchable="true"
                            v-model="form.employee_code"
                            label="label"
                            track-by="label"
                        >
                        </multiselect>
                    </div>

                    <div class="fs-6 c-red-500" v-if="form.errors.employee_code">{{ form.errors.employee_code }}</div>

                    <label for="">Status</label>
                    <!-- @change="selected_ipcr" :disabled="pageTitle=='Edit'" status: {{ form.prob_status }}-->
                    <select class="form-control form-select" v-model="form.prob_status" @change="setDateTo" >
                        <option value="Probationary">Probationary</option>
                        <option value="Temporary">Temporary</option>
                    </select>
                </fieldset>

                <div class="fs-6 c-red-500" v-if="form.errors.prob_status">{{ form.errors.prob_status }}</div>
                <fieldset class="border p-4">
                    <legend class="float-none w-auto">
                        <b>Month 1</b>
                    </legend>
                    <label for="">Date From</label>
                    <input type="date"
                            v-model="form.rating_period_from"
                            class="form-control"
                            autocomplete="positionchrome-off">
                    <div class="fs-6 c-red-500" v-if="form.errors.rating_period_from">{{ form.errors.rating_period_from }}</div>

                    <label for="">Date to </label>
                    <input type="date"
                            v-model="form.rating_period_to"

                            class="form-control"
                            autocomplete="positionchrome-off">
                    <div class="fs-6 c-red-500" v-if="form.errors.rating_period_to">{{ form.errors.rating_period_to }}</div>
                </fieldset>

                <fieldset class="border p-4">
                    <legend class="float-none w-auto">
                        <b>Month 2</b>
                    </legend>
                    <label for="">Date From</label>
                    <input type="date"
                            v-model="form.rating_period_from_2"
                            class="form-control"
                            autocomplete="positionchrome-off">
                    <div class="fs-6 c-red-500" v-if="form.errors.rating_period_from_2">{{ form.errors.rating_period_from_2 }}</div>

                    <label for="">Date to </label>
                    <input type="date"
                            v-model="form.rating_period_to_2"
                            class="form-control"
                            autocomplete="positionchrome-off">
                    <div class="fs-6 c-red-500" v-if="form.errors.rating_period_to_2">{{ form.errors.rating_period_to_2 }}</div>
                </fieldset>

                <fieldset class="border p-4">
                    <legend class="float-none w-auto">
                        <b>Month 3</b>
                    </legend>
                    <label for="">Date From</label>
                    <input type="date"
                            v-model="form.rating_period_from_3"
                            class="form-control"
                            autocomplete="positionchrome-off">
                    <div class="fs-6 c-red-500" v-if="form.errors.rating_period_from_3">{{ form.errors.rating_period_from_3 }}</div>

                    <label for="">Date to </label>
                    <input type="date"
                            v-model="form.rating_period_to_3"
                            class="form-control"
                            autocomplete="positionchrome-off">
                    <div class="fs-6 c-red-500" v-if="form.errors.rating_period_to_3">{{ form.errors.rating_period_to_3 }}</div>
                </fieldset>

                <fieldset class="border p-4">
                    <legend class="float-none w-auto">
                        <b>Month 4</b>
                    </legend>
                    <label for="">Date From</label>
                    <input type="date"
                            v-model="form.rating_period_from_4"
                            class="form-control"
                            autocomplete="positionchrome-off">
                    <div class="fs-6 c-red-500" v-if="form.errors.rating_period_from_4">{{ form.errors.rating_period_from_4 }}</div>

                    <label for="">Date to </label>
                    <input type="date"
                            v-model="form.rating_period_to_4"
                            class="form-control"
                            autocomplete="positionchrome-off">
                    <div class="fs-6 c-red-500" v-if="form.errors.rating_period_to_4">{{ form.errors.rating_period_to_4 }}</div>
                </fieldset>

                <fieldset class="border p-4">
                    <legend class="float-none w-auto">
                        <b>Month 5</b>
                    </legend>
                    <label for="">Date From</label>
                    <input type="date"
                            v-model="form.rating_period_from_5"
                            class="form-control"
                            autocomplete="positionchrome-off">
                    <div class="fs-6 c-red-500" v-if="form.errors.rating_period_from_5">{{ form.errors.rating_period_from_5 }}</div>

                    <label for="">Date to </label>
                    <input type="date"
                            v-model="form.rating_period_to_5"
                            class="form-control"
                            autocomplete="positionchrome-off">
                    <div class="fs-6 c-red-500" v-if="form.errors.rating_period_to_5">{{ form.errors.rating_period_to_5 }}</div>
                </fieldset>

                <fieldset class="border p-4">
                    <legend class="float-none w-auto">
                        <b>Month 6</b>
                    </legend>
                    <label for="">Date From</label>
                    <input type="date"
                            v-model="form.rating_period_from_6"
                            class="form-control"
                            autocomplete="positionchrome-off">
                    <div class="fs-6 c-red-500" v-if="form.errors.rating_period_from_6">{{ form.errors.rating_period_from_6 }}</div>

                    <label for="">Date to </label>
                    <input type="date"
                            v-model="form.rating_period_to_6"
                            class="form-control"
                            autocomplete="positionchrome-off">
                    <div class="fs-6 c-red-500" v-if="form.errors.rating_period_to_6">{{ form.errors.rating_period_to_6 }}</div>
                </fieldset>

                <fieldset class="border p-4" v-if="form.prob_status==='Temporary'">
                    <legend class="float-none w-auto">
                        <b>Month 7</b>
                    </legend>
                    <label for="">Date From</label>
                    <input type="date"
                            v-model="form.rating_period_from_7"
                            class="form-control"
                            autocomplete="positionchrome-off">
                    <div class="fs-6 c-red-500" v-if="form.errors.rating_period_from_7">{{ form.errors.rating_period_from_7 }}</div>

                    <label for="">Date to </label>
                    <input type="date"
                            v-model="form.rating_period_to_7"
                            class="form-control"
                            autocomplete="positionchrome-off">
                    <div class="fs-6 c-red-500" v-if="form.errors.rating_period_to_7">{{ form.errors.rating_period_to_7 }}</div>
                </fieldset>

                <fieldset class="border p-4" v-if="form.prob_status==='Temporary'">
                    <legend class="float-none w-auto">
                        <b>Month 8</b>
                    </legend>
                    <label for="">Date From</label>
                    <input type="date"
                            v-model="form.rating_period_from_8"
                            class="form-control"
                            autocomplete="positionchrome-off">
                    <div class="fs-6 c-red-500" v-if="form.errors.rating_period_from_8">{{ form.errors.rating_period_from_8 }}</div>

                    <label for="">Date to </label>
                    <input type="date"
                            v-model="form.rating_period_to_8"
                            class="form-control"
                            autocomplete="positionchrome-off">
                    <div class="fs-6 c-red-500" v-if="form.errors.rating_period_to_8">{{ form.errors.rating_period_to_8 }}</div>
                </fieldset>

                <fieldset class="border p-4" v-if="form.prob_status==='Temporary'">
                    <legend class="float-none w-auto">
                        <b>Month 9</b>
                    </legend>
                    <label for="">Date From</label>
                    <input type="date"
                            v-model="form.rating_period_from_9"
                            class="form-control"
                            autocomplete="positionchrome-off">
                    <div class="fs-6 c-red-500" v-if="form.errors.rating_period_from_9">{{ form.errors.rating_period_from_9 }}</div>

                    <label for="">Date to </label>
                    <input type="date"
                            v-model="form.rating_period_to_9"
                            class="form-control"
                            autocomplete="positionchrome-off">
                    <div class="fs-6 c-red-500" v-if="form.errors.rating_period_to_9">{{ form.errors.rating_period_to_9 }}</div>
                </fieldset>

                <fieldset class="border p-4" v-if="form.prob_status==='Temporary'">
                    <legend class="float-none w-auto">
                        <b>Month 10</b>
                    </legend>
                    <label for="">Date From {{ form.rating_period_from_10 }}</label>
                    <input type="date"
                            v-model="form.rating_period_from_10"
                            class="form-control"
                            autocomplete="positionchrome-off">
                    <div class="fs-6 c-red-500" v-if="form.errors.rating_period_from_10">{{ form.errors.rating_period_from_10 }}</div>

                    <label for="">Date to </label>
                    <input type="date"
                            v-model="form.rating_period_to_10"
                            class="form-control"
                            autocomplete="positionchrome-off">
                    <div class="fs-6 c-red-500" v-if="form.errors.rating_period_to_10">{{ form.errors.rating_period_to_10 }}</div>
                </fieldset>
                <button type="button" class="btn btn-primary mt-3 text-white" @click="submit()" :disabled="form.processing">
                    Save
                </button>
            </form>
        </div>


    </div>

</template>
<script>
import { useForm } from "@inertiajs/inertia-vue3";
import Places from "@/Shared/PlacesShared";
import { ModelSelect } from 'vue-search-select'
    //import BootstrapModalNoJquery from './BootstrapModalNoJquery.vue';

export default {
        props: {
            data: Object,
            editData: Object,
            employees: Object,
            divisions: Object,
            offices: Object
        },
        components: {
          //BootstrapModalNoJquery,
          ModelSelect,
          Places: () => new Promise((resolve) => {
            setTimeout(() => {
                resolve(Places)
            }, 2000)
        })

        },
        data() {
            return {
                my_paps: [],
                submitted: false,
                form: useForm({
                    employee_code:"",
                    prob_status	: "",
                    rating_period_from: "",
                    rating_period_to: "",
                    rating_period_from_2 :"",
                    rating_period_to_2 :"",
                    rating_period_from_3 :"",
                    rating_period_to_3 :"",
                    rating_period_from_4 :"",
                    rating_period_to_4 :"",
                    rating_period_from_5 :"",
                    rating_period_to_5 :"",
                    rating_period_from_6 :"",
                    rating_period_to_6 :"",
                    rating_period_from_7 :"",
                    rating_period_to_7 :"",
                    rating_period_from_8 :"",
                    rating_period_to_8 :"",
                    rating_period_from_9 :"",
                    rating_period_to_9 :"",
                    rating_period_from_10 :"",
                    rating_period_to_10 :"",
                    id: null
                }),
                pageTitle: ""
            };
        },
        computed:{
            formattedEmployeeList(){
                let dataEmp = this.employees;
                // if (this.form.raaotype) {
                //     dataPrograms = dataPrograms.filter((employee) => program.ftype === this.form.raaotype);
                // }
                // if(this.form.FFUNCCOD){
                //     dataPrograms = dataPrograms.filter((program) => program.FFUNCCOD === this.form.FFUNCCOD);
                // }

                return dataEmp.map((employee) => ({
                    value: employee.empl_id,
                    label: employee.employee_name,
                    position_long_title: employee.position_long_title,
                }));
            }
        },
        mounted() {
            if (this.editData !== undefined) {
                this.pageTitle = "Edit"
                this.form.employee_code=this.editData.employee_code
                this.form.prob_status=this.editData.prob_status
                this.form.rating_period_from=this.editData.rating_period_from
                this.form.rating_period_to=this.editData.rating_period_to
                this.form.rating_period_from_2=this.editData.rating_period_from_2
                this.form.rating_period_to_2=this.editData.rating_period_to_2
                this.form.rating_period_from_3=this.editData.rating_period_from_3
                this.form.rating_period_to_3=this.editData.rating_period_to_3
                this.form.rating_period_from_4=this.editData.rating_period_from_4
                this.form.rating_period_to_4=this.editData.rating_period_to_4
                this.form.rating_period_from_5=this.editData.rating_period_from_5
                this.form.rating_period_to_5=this.editData.rating_period_to_5
                this.form.rating_period_from_6=this.editData.rating_period_from_6
                this.form.rating_period_to_6=this.editData.rating_period_to_6
                this.form.rating_period_from_7=this.editData.rating_period_from_7
                this.form.rating_period_to_7=this.editData.rating_period_to_7
                this.form.rating_period_from_8=this.editData.rating_period_from_8
                this.form.rating_period_to_8=this.editData.rating_period_to_8
                this.form.rating_period_from_9=this.editData.rating_period_from_9
                this.form.rating_period_to_9=this.editData.rating_period_to_9
                this.form.rating_period_from_10=this.editData.rating_period_from_10
                this.form.rating_period_to_10=this.editData.rating_period_to_10
                this.form.id=this.editData.id
            } else {
                this.pageTitle = "Add"
                this.form.rating_period_from=null
            }
        },

        methods: {
            submit() {
                this.form.target_qty=parseFloat(this.form.target_qty1)+parseFloat(this.form.target_qty2)+parseFloat(this.form.target_qty3)+parseFloat(this.form.target_qty4);
                //alert(this.form.target_qty);
                if (this.editData !== undefined) {
                    this.form.patch("/probationary/temporary/update/" + this.form.id, this.form);
                } else {
                    // alert("Sample");
                    var url="/probationary/temporary/store"
                    // alert('for store '+url);
                    this.form.post(url);
                }
            },
            selected_employee(){
                if (this.form.idIPCR !== null && this.form.idIPCR !== undefined) {
                    // Find the index of the selected option in the array of ipcrs
                    const index = this.data.findIndex(data => String(data.ipcr_code) === String(this.form.idIPCR));
                    // alert(index);
                    this.selected_value = this.data[index];
                    this.form.individual_output = this.data[index].individual_output;
                    this.ipcr_submfo = this.data[index].submfo_description;
                    this.ipcr_div_output = this.data[index].div_output;
                    this.ipcr_ind_output = this.data[index].individual_output;
                    this.ipcr_performance = this.data[index].performance_measure;
                    //this.ipcr_success = this.ipcrs[index].s
                    //alert(index);
                } else {
                    // Handle case when no option is selected (form.ipcr_code is null or undefined)
                    return -1; // Return -1 to indicate no option is selected
                }
            },
            setDateTo(){
                var i=0;
                if(this.form.prob_status==='Probationary'){
                    // alert('Probationary '+this.form.prob_status)
                    //i=6;
                    this.form.rating_period_from_7=null
                    this.form.rating_period_to_7=null
                    this.form.rating_period_from_8=null
                    this.form.rating_period_to_8=null
                    this.form.rating_period_from_9=null
                    this.form.rating_period_to_9=null
                    this.form.rating_period_from_10=null
                    this.form.rating_period_to_10=null
                }else{
                    // alert('Temporary '+this.form.prob_status)
                    i=10;

                }
                if (this.form.rating_period_from) {
                    // Create a Date object from the selected date
                    const selectedDateObj = new Date(this.form.rating_period_from);
                    selectedDateObj.setMonth(selectedDateObj.getMonth() + i);
                    this.form.rating_period_to = selectedDateObj.toISOString().split('T')[0];

                } else {
                    // If no date is selected, reset the calculated date
                    this.form.rating_period_from=null
                    this.form.rating_period_to = null;
                }
            }
        },
    };
    </script>
