<template>
    <div class="relative row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h3>{{ pageTitle }} IPCR {{ form.source }}</h3>
            <Link :href="`/ipcrsemestral/${id}/${source}`">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z"/>
                <path fill-rule="evenodd" d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z"/>
                </svg>
            </Link>
        </div>


        <div class="col-md-8">
            <div>Name: <u>{{ emp.employee_name }}</u></div> {{ source }}
            <div>Position: <u>{{ emp.position_long_title }}</u></div>
            <div>Employment Status: <u>{{ emp.employment_type_descr }}</u></div>
            <!-- {{ emp }} -->
            <form @submit.prevent="submit()">
                <input type="hidden" required>
                <!-- {{ selected_value }} -->

                <label for="">Semester 1</label>
                <select type="text" v-model="form.sem" class="form-control" autocomplete="chrome-off" >
                    <option value="1">First Semester</option>
                    <option value="2">Second Semester</option>
                </select>
                <div class="fs-6 c-red-500" v-if="form.errors.sem">{{ form.errors.sem }}</div>

                <label for="">Immediate Supervisor</label>
                <select type="text" v-model="form.immediate_id" class="form-control" autocomplete="chrome-off" >
                    <option></option>
                    <option v-for="superv in supervisors" :value="superv.empl_id">{{ superv.employee_name }}</option>
                </select>
                <div class="fs-6 c-red-500" v-if="form.errors.immediate_id">{{ form.errors.immediate_id }}</div>

                <label for="">Next Higher Supervisor</label>
                <select type="text" v-model="form.next_higher" class="form-control" autocomplete="chrome-off" >
                    <option></option>
                    <option v-for="superv in supervisors" :value="superv.empl_id">{{ superv.employee_name }}</option>
                </select>
                <div class="fs-6 c-red-500" v-if="form.errors.next_higher">{{ form.errors.next_higher }}</div>

                <label for="">Year</label>
                <input v-model="form.year" class="form-control" type="number" name="year" min="1900" max="2099" step="1" oninput="javascript: if (this.value.length > 4) this.value = this.value.slice(0, 4);"/>
                <div class="fs-6 c-red-500" v-if="form.errors.year">{{ form.errors.year }}</div>
                <button type="button" class="btn btn-primary mt-3" @click="submit()" :disabled="form.processing">
                    Save changes
                </button>
            </form>
        </div>

    </div>

</template>
<script>
import { useForm } from "@inertiajs/inertia-vue3";
//import Places from "@/Shared/PlacesShared";

export default {
        props: {
            editData: Object,
            id: String,
            emp: Object,
            supervisors: Object,
            id: String,
            emp: Object,
            dept_code: String,
            source: String,
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
            this.form.source = this.source
            // this.form.ipcr_semester_id="0";
            if (this.editData !== undefined) {
                this.pageTitle = "Edit"
                this.form.employee_code =this.editData.employee_code
                this.form.id = this.editData.id
                const index = this.ipcrs.findIndex(ipcr => ipcr.ipcr_code === this.form.ipcr_code);
                this.form.ipcr_code =this.editData.ipcr_code
                this.$nextTick(() => {
                    this.selected_ipcr();
                });
                this.form.semester = this.editData.semester
                this.form.quantity_sem = this.editData.semester
                this.form.month_1 = this.editData.month_1
                this.form.month_2 = this.editData.month_2
                this.form.month_3 = this.editData.month_3
                this.form.month_4 = this.editData.month_4
                this.form.month_5 = this.editData.month_5
                this.form.month_6 = this.editData.month_6
                this.form.ipcr_semester_id = this.editData.ipcr_semester_id
            } else {
                this.form.employee_code = this.emp.empl_id
                this.pageTitle= "Create"
                this.form.quantity_sem="0";
                this.form.month_1="0";
                this.form.month_2="0";
                this.form.month_3="0";
                this.form.month_4="0";
                this.form.month_5="0";
                this.form.month_6="0";
                this.setYear();
            }
        },
        computed:{
            month_list(){
                var mos =[];
                if(this.form.semester==="1"){
                    mos=["January", "February", "March","April","May","June"];
                }else if(this.form.semester==="2"){
                    mos=["July", "August", "September","October","November","December"];
                }else{
                    mos=["", "", "","","",""];
                }
                return mos;
            },
            quantity_needed(){
                var v1 = 0;
                var v2 = 0;
                var v3 = 0;
                var v4 = 0;
                var v5 = 0;
                var v6 = 0;
                if(this.form.month_1!=="" || this.form.month_1!==undefined){
                    v1 = parseFloat(this.form.month_1);
                    v2 = parseFloat(this.form.month_2);
                    v3 = parseFloat(this.form.month_3);
                    v4 = parseFloat(this.form.month_4);
                    v5 = parseFloat(this.form.month_5);
                    v6 = parseFloat(this.form.month_6);
                }
                var sem_targ = parseFloat(this.form.quantity_sem);
                var sum = v1+v2+v3+v4+v5+v6;
                var ret ="";
                var diff=0;
                if(sem_targ>sum){
                    diff = sem_targ-sum;
                    ret = "Add "+diff+" to your monthly targets!"
                }else if(sem_targ<sum){
                    diff = sum-sem_targ;
                    ret = "Remove "+diff+" from your monthly targets!"
                }
                return ret;
            }
        },
        methods: {
            submit() {
                if (this.editData !== undefined) {
                    this.form.patch("/ipcrtargets/" + this.id, this.form);
                } else {
                    this.form.post("/ipcrsemestral/store/"+this.id);
                }
            },
            selected_ipcr(){
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
            setYear(){
                const now = new Date();
                this.form.year = now.getFullYear();
            }
        },
    };
    </script>
