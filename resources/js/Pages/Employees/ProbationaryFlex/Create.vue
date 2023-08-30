<template>
    <div class="relative row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h3>{{ pageTitle }} Probationary/Temporary Employee</h3>
            <Link :href="`/probationary`">
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
                            :disabled="editData!==undefined"
                            @close="setSG()"
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
                    <br>
                </fieldset>
                <fieldset class="border p-4">
                    <legend class="float-none w-auto">
                        <b>Supervisors </b>
                    </legend>
                    <p>Immediate Supervisor</p>
                    <div >
                        <multiselect
                            :options="formattedImmediateList"
                            :searchable="true"
                            v-model="form.immediate_cats"
                            label="label"
                            track-by="label"
                            @close="setImmediateSG()"
                        >
                        </multiselect>
                    </div>
                    <div class="fs-6 c-red-500" v-if="form.errors.immediate_cats">{{ form.errors.immediate_cats }}</div>

                    <p>Next Higher Supervisor</p>
                    <div>
                        <multiselect
                            :options="formattedNextList"
                            :searchable="true"
                            v-model="form.next_higher_cats"
                            label="label"
                            track-by="label"
                        >
                        </multiselect>
                    </div>
                    <div class="fs-6 c-red-500" v-if="form.errors.next_higher_cats">{{ form.errors.next_higher_cats }}</div>
                    <br>
                </fieldset>
                <fieldset class="border p-4">
                    <legend class="float-none w-auto">
                        <b>Period </b>
                    </legend>






                    <div class="col-sm-12 ">
                        <label for="">Number of Months</label>
                         <!-- class="btn btn-primary mt-3 text-white"  class="btn btn-danger mt-3 text-white"-->

                    </div >
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-9">
                                <input type="number"
                                        @change="setMonthsCreate"
                                        v-model="form.no_of_months"
                                        class="form-control"
                                        autocomplete="positionchrome-off">
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-primary text-white"
                                    @click="addOneToMonth()" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-up-fill" viewBox="0 0 16 16">
                                        <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
                                    </svg>
                                </button>&nbsp;
                                <button type="button" class="btn btn-danger text-white"
                                        @click="removeOneFromMonth()" >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                                        </svg>
                                </button>
                            </div>

                        </div>

                    </div>
                    <div class="fs-6 c-red-500" v-if="form.errors.no_of_months">{{ form.errors.no_of_months }}</div>
                </fieldset>

                <div class="fs-6 c-red-500" v-if="form.errors.prob_status">{{ form.errors.prob_status }}</div>
                <!-- {{ form.no_of_months }} -->
                <div v-if="editData!==undefined">
                    <div class="col-md-12" v-if="form.date_from" v-for="(dt_from, index) in form.date_from" :key="index">
                        <fieldset class="border p-4">
                            <legend class="float-none w-auto">
                                <b>Month {{index+1}}</b>
                            </legend>
                            <div class="layers bd bgc-white p-20">
                                <div class="masonry-item w-100 " >
                                    <div class="row gap-20">
                                        <div class="col-md-6">
                                            <label for="">Date From </label>
                                            <!-- <input v-model="form.month_id[index]"
                                                    class="form-control"
                                                    hidden
                                            > -->
                                            <input type="date"
                                                    v-if="(index)<1"
                                                    v-model="form.date_from[index]"
                                                    class="form-control"
                                                    @change="setMonthsBasedOnFirstMonth(form.date_from[index], index)"
                                                    autocomplete="positionchrome-off">
                                            <input type="date"
                                                    v-else
                                                    v-model="form.date_from[index]"
                                                    class="form-control"
                                                    autocomplete="positionchrome-off">
                                            <div class="fs-6 c-red-500" v-if="form.errors.rating_period_from">{{ form.errors.rating_period_from }}</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">Date to </label>
                                            <input type="date"
                                                    v-model="form.date_to[index]"
                                                    class="form-control"
                                                    autocomplete="positionchrome-off">
                                            <div class="fs-6 c-red-500" v-if="form.errors.rating_period_to">{{ form.errors.rating_period_to }}</div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <!-- <div class="col-md-4">
                            <label for="">Quantity </label>
                            <input type="number"
                                    v-model="form.quantity[index]"
                                    class="form-control"
                                    autocomplete="positionchrome-off">
                            <div class="fs-6 c-red-500" v-if="form.errors.quantity">{{ form.errors.quantity }}</div>
                        </div> -->
                    </div>
                </div>
                <div v-else>
                    <div class="col-md-12" v-if="form.date_from" v-for="index in form.no_of_months" :key="index">
                        <fieldset class="border p-4">
                            <legend class="float-none w-auto">
                                <b>Month {{index}}</b>
                            </legend>
                            <div class="layers bd bgc-white p-20">
                                <div class="masonry-item w-100 " >
                                    <div class="row gap-20">
                                        <div class="col-md-6">
                                            <label for="">Date From </label>
                                            <input type="date"
                                                    v-if="(index-1)<1"
                                                    v-model="form.date_from[index-1]"
                                                    class="form-control"
                                                    @change="setMonthsBasedOnFirstMonth(form.date_from[index-1], index)"
                                                    autocomplete="positionchrome-off">
                                            <input type="date"
                                                    v-else
                                                    v-model="form.date_from[index-1]"
                                                    class="form-control"
                                                    autocomplete="positionchrome-off">
                                            <div class="fs-6 c-red-500" v-if="form.errors.rating_period_from">{{ form.errors.rating_period_from }}</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">Date to </label>
                                            <input type="date"
                                                    v-model="form.date_to[index-1]"
                                                    class="form-control"
                                                    autocomplete="positionchrome-off">
                                            <div class="fs-6 c-red-500" v-if="form.errors.rating_period_to">{{ form.errors.rating_period_to }}</div>
                                        </div>
                                        <!-- <div class="col-md-4">
                                            <label for="">Quantity </label>
                                            <input type="number"
                                                    v-model="form.quantity[index-1]"
                                                    class="form-control"
                                                    autocomplete="positionchrome-off">
                                            <div class="fs-6 c-red-500" v-if="form.errors.quantity">{{ form.errors.quantity }}</div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <br>
                <button type="button" class="btn btn-primary mt-3 text-white" @click="submit()" :disabled="form.processing">
                    Save
                </button>
            </form>
        </div>
        <!-- {{ employees }} -->
        <!-- {{ form.date_from }} -->
        <!-- {{ form.date_from }}
        <br />
        {{ form.date_to }} -->
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
            offices: Object,
            ids: Object,
            date_from: Object,
            date_to: Object,
            quantity: Object,
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
                    immediate_cats: "",
                    next_higher_cats: "",
                    no_of_months: "",
                    prob_status	: "",
                    status: "",
                    month_id: [],
                    date_from: [],
                    date_to: [],
                    quantity: [],
                    id: null
                }),
                pageTitle: "",
                isNotValid: false,
                isNotValidTo: false,
                immediate_sg: 0,
                emp_sg: 0,
                dept_code: '0',
            };
        },
        computed:{
            formattedEmployeeList(){
                let dataEmp = this.employees;
                return dataEmp.map((employee) => ({
                    value: employee.empl_id,
                    label: employee.employee_name,
                    position_long_title: employee.position_long_title,
                    salary_grade: employee.salary_grade,
                    department_code: employee.department_code
                }));
            },
            formattedImmediateList(){
                let dataEmp = this.employees;
                var my_sg = parseFloat(this.emp_sg);
                if(this.form.employee_code){
                    if(my_sg>0){
                        dataEmp = dataEmp.filter((empl) => empl.salary_grade > my_sg);
                    }
                    if(this.dept_code){
                        dataEmp = dataEmp.filter((empl) => empl.department_code===this.dept_code);
                    }
                }
                return dataEmp.map((employee) => ({
                    value: employee.empl_id,
                    label: employee.employee_name,
                    position_long_title: employee.position_long_title,
                    salary_grade: employee.salary_grade,
                    // department_code: department_code,
                }));
            },
            formattedNextList(){
                let dataEmp = this.employees;
                var my_sg = parseFloat(this.immediate_sg);
                if(this.form.employee_code){

                    if(this.dept_code){
                        dataEmp = dataEmp.filter((empl) => empl.department_code===this.dept_code);
                    }
                }
                if(this.form.immediate_cats){
                    if(my_sg>0){
                        dataEmp = dataEmp.filter((empl) => empl.salary_grade > my_sg);
                    }
                }
                return dataEmp.map((employee) => ({
                    value: employee.empl_id,
                    label: employee.employee_name,
                    position_long_title: employee.position_long_title,
                    salary_grade: employee.salary_grade,
                    //department_code: department_code
                }));
            }
        },
        mounted() {
            if (this.editData !== undefined) {
                this.pageTitle = "Edit"
                this.form.employee_code=this.editData.employee_code
                this.setSG()
                this.form.immediate_cats=this.editData.immediate_cats
                this.setImmediateSG()
                this.form.next_higher_cats=this.editData.next_higher_cats
                this.form.prob_status=this.editData.prob_status
                this.form.no_of_months=this.editData.no_of_months
                this.form.id=this.editData.id
                this.form.date_from = this.date_from
                this.form.date_to = this.date_to
                this.form.month_id = this.ids
            } else {
                this.form.no_of_months=0
                this.pageTitle = "Add"
                this.form.rating_period_from=null
            }
        },

        methods: {
            submit() {
                this.form.target_qty=parseFloat(this.form.target_qty1)+parseFloat(this.form.target_qty2)+parseFloat(this.form.target_qty3)+parseFloat(this.form.target_qty4);
                //alert(this.form.target_qty);
                this.checkDateFrom()
                this.checkDateTo()
                if(this.isNotValid==true || this.isNotValidTo==true){
                    alert("Some dates are invalid!")
                }else{
                    if (this.editData !== undefined) {
                        this.form.patch("/probationary/update/" + this.form.id, this.form);
                    } else {
                        this.form.status="-1"
                        var url="/probationary/store"
                        this.form.post(url);
                    }
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
                if(this.form.prob_status==='Probationary'){this.form.no_of_months=6}else{
                    this.form.no_of_months=10
                }
                this.setMonthsCreate()

                // if(this.form.prob_status==='Probationary'){
                //     // alert('Probationary '+this.form.prob_status)
                //     //i=6;
                //     this.form.rating_period_from_7=null
                //     this.form.rating_period_to_7=null
                //     this.form.rating_period_from_8=null
                //     this.form.rating_period_to_8=null
                //     this.form.rating_period_from_9=null
                //     this.form.rating_period_to_9=null
                //     this.form.rating_period_from_10=null
                //     this.form.rating_period_to_10=null
                // }else{
                //     // alert('Temporary '+this.form.prob_status)
                //     i=10;

                // }
                // if (this.form.rating_period_from) {
                //     // Create a Date object from the selected date
                //     const selectedDateObj = new Date(this.form.rating_period_from);
                //     selectedDateObj.setMonth(selectedDateObj.getMonth() + i);
                //     this.form.rating_period_to = selectedDateObj.toISOString().split('T')[0];

                // } else {
                //     // If no date is selected, reset the calculated date
                //     this.form.rating_period_from=null;
                //     this.form.rating_period_to = null;
                // }
            },
            addOneToMonth(){
                var i=this.form.no_of_months;
                // alert(i);
                // if(this.editData!==undefined){
                //     i=this.form.no_of_months+1;
                // }else{
                //     i=this.form.no_of_months;
                // }

                this.form.no_of_months = parseFloat(this.form.no_of_months)+1;
                var currentDate = new Date();
                if(i>0){
                    var my_day = new Date(this.form.date_to[i-1]);
                    //alert(my_day)
                    my_day.setDate(my_day.getDate() + 1);
                    my_day = my_day.toISOString().split('T')[0];
                    this.form.date_from.push(my_day);
                }else{

                    // var gt = currentDate.setMonth(currentDate.getMonth() + i);
                    // alert(gt)
                    var my_dt = currentDate.toISOString().split('T')[0];
                    this.form.date_from.push(my_dt);
                }
                //DATE TO
                //var ia = i+1;
                var fromDate = new Date(this.form.date_from[i])
                fromDate.setMonth(fromDate.getMonth() + 1);
                var dateTo = fromDate.toISOString().split('T')[0];
                this.form.date_to.push(dateTo);
                this.form.quantity.push('1');
                //this.setMonthsCreate();
            },
            removeOneFromMonth(){
                if(parseFloat(this.form.no_of_months)>0){
                    this.form.no_of_months = parseFloat(this.form.no_of_months)-1;
                }
                this.form.date_from.pop();
                this.form.date_to.pop();
                this.form.quantity.pop();
            },
            setMonthsCreate(){
                //alert(this.form.no_of_months);
                this.form.date_from=[];
                this.form.date_to=[];
                this.form.quantity=[];
                var mos = this.form.no_of_months;
                for(let i=0; i<mos; i++){
                    var currentDate = new Date();
                    // alert(currentDate);
                    //var my_dt = currentDate.toDateString();

                    //DATE FROM
                    if(i>0){
                        var my_day = new Date(this.form.date_to[i-1]);
                        // alert(my_day)
                        my_day.setDate(my_day.getDate() + 1);
                        my_day = my_day.toISOString().split('T')[0];
                        this.form.date_from.push(my_day);
                    }else{
                        currentDate.setMonth(currentDate.getMonth() + i);
                        var my_dt = currentDate.toISOString().split('T')[0];
                        this.form.date_from.push(my_dt);
                    }
                    //DATE TO
                    var fromDate = new Date(this.form.date_from[i])
                    fromDate.setMonth(fromDate.getMonth() + 1);
                    var dateTo = fromDate.toISOString().split('T')[0];
                    this.form.date_to.push(dateTo);

                    this.form.quantity.push('1');
                }
            },
            setMonthsBasedOnFirstMonth(my_date, ind){
                // this.form.date_from=[];
                // this.form.date_to=[];
                // alert(my_date)
                ind = parseFloat(ind)
                if(this.editData!==undefined){

                }else{
                    ind=ind-1
                }
                var curDate = new Date();
                var myDate = new Date(my_date)
                if(myDate<curDate){
                    alert('Date selected is invalid!')
                    var date_to1 = new Date(this.form.date_to[ind])
                    date_to1.setMonth(date_to1.getMonth() - 1);
                    var dateTo = date_to1.toISOString().split('T')[0];
                    //alert("to "+dateTo)
                    this.form.date_from[ind]=dateTo
                }else{

                    var mos = this.form.no_of_months ;
                    for(let i=ind; i<mos; i++){
                        var currentDate = new Date(my_date);
                        if(i>0){
                            // alert(this.form.date_to[i-1])
                            var my_day = new Date(this.form.date_to[i-1]);

                            my_day.setDate(my_day.getDate() + 1);
                            my_day = my_day.toISOString().split('T')[0];
                            //alert("from "+my_day)
                            this.form.date_from[i]=my_day
                            //this.form.date_from.push(my_day);
                        }else{
                            // alert('First: '+i+" "+currentDate)
                            currentDate.setMonth(currentDate.getMonth() + i);
                            // alert('After: '+currentDate)
                            var my_dt = currentDate.toISOString().split('T')[0];
                            //alert("from =0 "+my_dt)
                            this.form.date_from[i]=my_dt

                            //this.form.date_from.push(my_dt);
                        }
                        //DATE TO
                        //var ia = i+1;
                        var fromDate = new Date(this.form.date_from[i])
                        fromDate.setMonth(fromDate.getMonth() + 1);
                        var dateTo = fromDate.toISOString().split('T')[0];
                        //alert("to "+dateTo)
                        this.form.date_to[i]=dateTo
                        //this.form.date_to.push(dateTo);
                    }
                }

            },
            isValidDate(dateString) {
                const date = new Date(dateString);
                return !isNaN(date) && date instanceof Date;
            },
            checkDateFrom(){
                this.isNotValid=false
                for (const date of this.form.date_from) {
                    if (!this.isValidDate(date)) {
                        //alert("Some dates are not valid.");
                        this.isNotValid=true;
                        return; // Prevent form submission
                    }
                }
            },
            checkDateTo(){
                this.isNotValidTo=false;
                for (const date of this.form.date_to) {
                    if (!this.isValidDate(date)) {
                        //alert("Some dates are not valid.");
                        this.isNotValidTo=true;
                        return; // Prevent form submission
                    }
                }
            },
            setSG(){
                var recid = this.form.employee_code;
                var index = this.employees.findIndex(emp => emp.empl_id === recid);
                if (index !== -1) {
                    this.emp_sg = this.employees[index].salary_grade;
                    this.dept_code= this.employees[index].department_code;

                } else {
                    this.emp_sg = "0";
                    this.dept_code ="00";
                }
            },
            setImmediateSG(){
                var recid = this.form.immediate_cats;
                var index = this.employees.findIndex(emp => emp.empl_id === recid);
                if (index !== -1) {
                    this.immediate_sg = this.employees[index].salary_grade;
                    this.dept_code= this.employees[index].department_code;
                } else {
                    this.immediate_sg = "0";
                }
            }
            //fdsfsdfsdfsfdsf
        },
    };
    </script>
