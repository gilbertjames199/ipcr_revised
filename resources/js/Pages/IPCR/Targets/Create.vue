<template>
    <div class="relative row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h3>{{ pageTitle }} IPCR Code</h3>
            <Link :href="`/ipcrtargets/${id}`">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z"/>
                <path fill-rule="evenodd" d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z"/>
                </svg>
            </Link>
        </div>


        <div class="col-md-8">
            <div>Name: <u>{{ emp.employee_name }}</u></div>
            <div>Position: <u>{{ emp.position_long_title }}</u></div>
            <div>Employment Status: <u>{{ emp.employment_type_descr }}</u></div>
            <!-- {{ emp }} -->
            <form @submit.prevent="submit()">
                <input type="hidden" required>
                <!-- {{ selected_value }} -->
                <label for="">IPCR Code</label>
                <select type="text" v-model="form.ipcr_code" class="form-control" autocomplete="chrome-off" @change="selected_ipcr">
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
            ipcrs: Object
        },

        data() {
            return {
                submitted: false,
                form: useForm({
                    ipcr_code:     "",
                    employee_code: "",
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

            if (this.editData !== undefined) {
                this.pageTitle = "Edit"
                this.form.employee_code =this.editData.employee_code
                this.form.id = this.editData.id
                const index = this.ipcrs.findIndex(ipcr => ipcr.ipcr_code === this.form.ipcr_code);
                this.form.ipcr_code =this.editData.ipcr_code
                this.$nextTick(() => {
                    this.selected_ipcr();
                });
            } else {
                this.form.employee_code = this.emp.empl_id
                this.pageTitle                  = "Create"
            }
        },

        methods: {
            submit() {
                if (this.editData !== undefined) {
                    this.form.patch("/ipcrtargets/" + this.id, this.form);
                } else {
                    this.form.post("/ipcrtargets/store/"+this.id);
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
            }
        },
    };
    </script>
