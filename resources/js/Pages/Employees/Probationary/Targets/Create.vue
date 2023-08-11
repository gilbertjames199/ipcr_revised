<template>
    <div class="relative row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h2><b>{{ pageTitle }} {{ prob.prob_status }} IPCR Target</b></h2>
            my_id: {{ my_id }} {{ id }}
            <Link :href="`/prob/individual/targets/${my_id}`">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z"/>
                <path fill-rule="evenodd" d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z"/>
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
                    <legend class="float-none w-auto"><b>IPCR Code</b></legend>
                    <!-- <label for="">IPCR Code</label> -->
                    <div class="layers bd bgc-white p-20">
                        <div class="masonry-item w-100 " >
                            <div class="row gap-20">
                                <div class="col-md-12">
                                    <select type="text" v-model="form.ipcr_code" :disabled="editData !== undefined" class="form-control" autocomplete="chrome-off" @change="selected_ipcr">
                                        <option v-for="ipcr, index in ipcrs" :value="ipcr.ipcr_code">
                                            {{ ipcr.ipcr_code }} - {{ ipcr.individual_output }}
                                        </option>
                                    </select>
                                    <div class="fs-6 c-red-500" v-if="form.errors.ipcr_code">{{ form.errors.ipcr_code }}</div>
                                    <div class="fs-6 c-red-500" v-if="form.errors.employee_code">{{ form.errors.employee_code }}</div>
                                    <label for="">Major Final Output</label>
                                    <input type="text" v-model="ipcr_mfo" class="form-control" autocomplete="chrome-off" readonly>

                                    <label for="">Sub MFO</label>
                                    <input type="text" v-model="ipcr_submfo" class="form-control" autocomplete="chrome-off" readonly>

                                    <label for="">Division Output</label>
                                    <input type="text" v-model="ipcr_div_output" class="form-control" autocomplete="chrome-off" readonly>

                                    <label for="">Individual Final Output</label>
                                    <input type="text" v-model="ipcr_ind_output" class="form-control" autocomplete="chrome-off" readonly>

                                    <label for="">Performance Measure</label>
                                    <input type="text" v-model="ipcr_ind_output" class="form-control" autocomplete="chrome-off" readonly>

                                    <input type="hidden" v-model="form.id" class="form-control" autocomplete="chrome-off">

                                    <label for="">Type/Category</label>
                                    <select type="text" v-model="form.ipcr_type" class="form-control" autocomplete="chrome-off" >
                                        <option value="Core Function">Core Function</option>
                                        <option value="Support Function">Support Function</option>
                                    </select>
                                    <div class="fs-6 c-red-500" v-if="form.errors.ipcr_type">{{ form.errors.ipcr_type }}</div>
                                </div>

                            </div>
                        </div>

                    </div>

                </fieldset>
            </div>
            <div class="col-md-8">
                <fieldset class="border p-4">
                    <legend class="float-none w-auto">
                        <b>Target Quantity</b>
                    </legend>
                    <span class="small text-danger">{{ quantity_needed }}</span>
                    <div class="layers bd bgc-white p-20">
                        <div class="masonry-item w-100 " >
                            <div class="row gap-20">
                                <div class="col-md-12">
                                    <div >
                                        <label for="">Total Targets &nbsp;</label>
                                        <input type="number" v-model="form.target_quantity" class="form-control" autocomplete="chrome-off" >
                                        <div class="fs-6 c-red-500" v-if="form.errors.target_quantity">{{ form.errors.target_quantity }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Monthly Target 1 {{ month_list[0] }}</label>
                                    <input type="number" v-model="form.month_1" class="form-control" autocomplete="chrome-off" >
                                    <div class="fs-6 c-red-500" v-if="form.errors.month_1">{{ form.errors.month_1 }}</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Monthly Target 2 {{ month_list[1] }}</label>
                                    <input type="text" v-model="form.month_2" class="form-control" autocomplete="chrome-off" >
                                    <div class="fs-6 c-red-500" v-if="form.errors.month_2">{{ form.errors.month_2 }}</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Monthly Target 3 {{ month_list[2] }}</label>
                                    <input type="number" v-model="form.month_3" class="form-control" autocomplete="chrome-off" >
                                    <div class="fs-6 c-red-500" v-if="form.errors.month_3">{{ form.errors.month_3 }}</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Monthly Target 4 {{ month_list[3] }}</label>
                                    <input type="number" v-model="form.month_4" class="form-control" autocomplete="chrome-off" >
                                    <div class="fs-6 c-red-500" v-if="form.errors.month_4">{{ form.errors.month_4 }}</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Monthly Target 5 {{ month_list[4] }}</label>
                                    <input type="number" v-model="form.month_5" class="form-control" autocomplete="chrome-off" >
                                    <div class="fs-6 c-red-500" v-if="form.errors.month_5">{{ form.errors.month_5 }}</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Monthly Target 6 {{ month_list[5] }}</label>
                                    <input type="number" v-model="form.month_6" class="form-control" autocomplete="chrome-off" >
                                    <div class="fs-6 c-red-500" v-if="form.errors.month_6">{{ form.errors.month_6 }}</div>
                                </div>
                                <div class="col-md-6" v-if="prob.prob_status==='Temporary'">
                                    <label for="">Monthly Target 7 {{ month_list[6] }}</label>
                                    <input type="number" v-model="form.month_7" class="form-control" autocomplete="chrome-off" >
                                    <div class="fs-6 c-red-500" v-if="form.errors.month_7">{{ form.errors.month_7 }}</div>
                                </div>
                                <div class="col-md-6" v-if="prob.prob_status==='Temporary'">
                                    <label for="">Monthly Target 8 {{ month_list[7] }}</label>
                                    <input type="number" v-model="form.month_8" class="form-control" autocomplete="chrome-off" >
                                    <div class="fs-6 c-red-500" v-if="form.errors.month_8">{{ form.errors.month_8 }}</div>
                                </div>
                                <div class="col-md-6" v-if="prob.prob_status==='Temporary'">
                                    <label for="">Monthly Target 9 {{ month_list[8] }}</label>
                                    <input type="number" v-model="form.month_9" class="form-control" autocomplete="chrome-off" >
                                    <div class="fs-6 c-red-500" v-if="form.errors.month_9">{{ form.errors.month_9 }}</div>
                                </div>
                                <div class="col-md-6" v-if="prob.prob_status==='Temporary'">
                                    <label for="">Monthly Target 10 {{ month_list[9] }}</label>
                                    <input type="number" v-model="form.month_10" class="form-control" autocomplete="chrome-off" >
                                    <div class="fs-6 c-red-500" v-if="form.errors.month_10">{{ form.errors.month_10 }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </fieldset>
            </div>


            <!--  -->
            <button type="button" class="btn btn-primary mt-3 text-white" @click="submit()" :disabled="form.processing">
                Save changes
            </button>&nbsp;
            <button type="button" class="btn btn-danger mt-3 text-white" @click="cancelEdit()" :disabled="form.processing">
                Cancel
            </button>
        </form>
        <!-- {{ prob }} -->
        {{ form }}
        <!-- //{{ id }}  -->
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
            ipcrs: Object,
            prob: Object
        },

        data() {
            return {
                submitted: false,
                my_id: "",
                form: useForm({
                    employee_code: "",
                    ipcr_pob_tempo_id: "",
                    ipcr_code:     "",
                    ipcr_type: "",
                    target_quantity: "",
                    month_1: "",
                    month_2: "",
                    month_3: "",
                    month_4: "",
                    month_5: "",
                    month_6: "",
                    month_7: "",
                    month_8: "",
                    month_9: "",
                    month_10: "",
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
            //
            if (this.editData !== undefined) {

                this.pageTitle = "Edit"
                this.form.employee_code =this.editData.employee_code
                this.form.id = this.editData.id
                const index = this.ipcrs.findIndex(ipcr => ipcr.ipcr_code === this.form.ipcr_code);
                this.form.ipcr_code =this.editData.ipcr_code
                this.form.ipcr_pob_tempo_id=this.editData.ipcr_pob_tempo_id
                this.$nextTick(() => {
                    this.selected_ipcr();
                });

                this.form.target_quantity = this.editData.target_quantity
                this.form.ipcr_type=this.editData.ipcr_type
                this.form.month_1 = this.editData.month_1
                this.form.month_2 = this.editData.month_2
                this.form.month_3 = this.editData.month_3
                this.form.month_4 = this.editData.month_4
                this.form.month_5 = this.editData.month_5
                this.form.month_6 = this.editData.month_6
                this.form.month_7 = this.editData.month_7
                this.form.month_8 = this.editData.month_8
                this.form.month_9 = this.editData.month_9
                this.form.month_10 = this.editData.month_10


                this.my_id = this.editData.ipcr_pob_tempo_id
            } else {
                this.form.employee_code = this.emp.empl_id
                this.pageTitle= "Add"
                this.form.target_quantity="0";
                this.form.ipcr_pob_tempo_id = this.id
                this.form.month_1="0";
                this.form.month_2="0";
                this.form.month_3="0";
                this.form.month_4="0";
                this.form.month_5="0";
                this.form.month_6="0";
                this.form.month_7="0";
                this.form.month_8="0";
                this.form.month_9="0";
                this.form.month_10="0";
                this.my_id=this.id

            }

        },
        computed:{
            month_list(){
                var mos =["January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"];

                return mos;
            },
            quantity_needed(){
                var v1 = 0;
                var v2 = 0;
                var v3 = 0;
                var v4 = 0;
                var v5 = 0;
                var v6 = 0;
                var v7 = 0;
                var v8 = 0;
                var v9 = 0;
                var v10 = 0;
                if(this.form.month_1!=="" || this.form.month_1!==undefined){
                    v1 = parseFloat(this.form.month_1);
                    v2 = parseFloat(this.form.month_2);
                    v3 = parseFloat(this.form.month_3);
                    v4 = parseFloat(this.form.month_4);
                    v5 = parseFloat(this.form.month_5);
                    v6 = parseFloat(this.form.month_6);
                    if(this.prob.prob_status==='Temporary'){
                        v7 = parseFloat(this.form.month_7);
                        v8 = parseFloat(this.form.month_8);
                        v9 = parseFloat(this.form.month_9);
                        v10 = parseFloat(this.form.month_10);
                    }
                }
                var targq = parseFloat(this.form.target_quantity);
                var sum = v1+v2+v3+v4+v5+v6+v7+v8+v9+v10;
                var ret ="";
                var diff=0;
                if(targq>sum){
                    diff = targq-sum;
                    ret = "WARNING: Add "+diff+" to your monthly targets OR remove " + diff +" from your total target "
                }else if(targq<sum){
                    diff = sum-targq;
                    ret = "WARNING: Remove "+diff+" from your monthly targets OR add " + diff +" to your total target "
                }
                return ret;
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
                var v7=0;
                var v8=0;
                var v9=0;
                var v10=0;
                if(this.prob.prob_status==='Temporary'){
                    v7 = parseFloat(this.form.month_7);
                    v8 = parseFloat(this.form.month_8);
                    v9 = parseFloat(this.form.month_9);
                    v10 = parseFloat(this.form.month_10);
                };
                var targ_quant = parseFloat(this.form.target_quantity);
                var sum = v1+v2+v3+v4+v5+v6+v7+v8+v9+v10;
                if(sum!=targ_quant){
                    alert(this.quantity_needed);
                }else{
                    if (this.editData !== undefined) {
                        //alert("patch");
                        this.form.patch("/prob/individual/targets/" + this.id, this.form);
                    } else {
                        this.form.post("/prob/individual/targets/store/"+this.id);
                    }
                }

            },
            cancelEdit(){
                //:href="`/ipcrtargets/${my_id}`"
                let text = "WARNING!\nYou have unsaved changes in this form. Are you sure you want to exit without saving changes?";
                // alert("/ipcrtargets/" + ipcr_id + "/"+ this.id+"/delete")
                if (confirm(text) == true) {
                    this.$inertia.get("/ipcrtargets/"+this.my_id);
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

        },
    };
    </script>

<style>

</style>
