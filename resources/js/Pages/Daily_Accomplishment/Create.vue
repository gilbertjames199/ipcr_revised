<template>
    <div class="relative row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h3>{{ pageTitle }} Accomplishment</h3>

            <!-- {{ data }}
            {{ emp_code }} -->
            <!-- {{ session.previous_url }} -->
            <Link :href="session.previous_url">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-lg"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z" />
                <path fill-rule="evenodd"
                    d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z" />
            </svg>
            </Link>
        </div>

        <!-- <div class="col-md-8">
            <button class="btn btn-secondary" @click="showModal" :disabled="submitted">Permissions</button>
        </div> -->

        <div class="col-md-8">
            <form @submit.prevent="submit()">
                <input type="hidden" required>
                <input type="hidden" v-model="form.emp_code" class="form-control" autocomplete="positionchrome-off">

                <label for="">Date</label>
                <input @change="AutoSem()" type="date" v-model="form.date" class="form-control"
                    autocomplete="positionchrome-off" :disabled="pageTitle == 'Edit'">
                <div class="fs-6 c-red-500" v-if="form.errors.date">{{ form.errors.date }}</div>

                 <label for="">Individual Output</label>
                <div>
                    <multiselect ref="IPCRInput" :options="individual_final_output_id" :searchable="true" v-model="form.individual_final_output_id"
                        label="label" track-by="label" @close="selected_ipcr"
                        :disabled="pageTitle == 'Edit' || isDisabled">
                    </multiselect>
                </div>
                <div class="fs-6 c-red-500" v-if="form.errors.individual_final_output_id">{{ form.errors.individual_final_output_id }}</div>

                <label for="">Particulars</label>
                <input type="text" v-model="form.description" class="form-control" autocomplete="positionchrome-off"
                    @keyup.enter="moveToNextInput('IPCRInput')" :disabled="isDisabled">
                <div class="fs-6 c-red-500" v-if="form.errors.description">{{ form.errors.description }}</div>


                <label for="">Semester</label>
                <select ref="SemesterInput" class="form-control form-select" v-model="form.sem_id" disabled
                    :disabled="pageTitle == 'Edit' || isDisabled">
                    <option v-for="sem in sem" :value="sem.id">
                        {{ sem.sem_in_word + " - " + sem.year }}
                    </option>
                </select>
                <div class="fs-6 c-red-500" v-if="form.errors.sem_id">{{ form.errors.sem_id }}</div>


                <br>
                <!-- {{ ipcr_codes }} -->

                <!-- <select class="form-control form-select" v-model="form.idIPCR"  @change="selected_ipcr" :disabled="pageTitle=='Edit' || isDisabled">
                    <option v-for="dat in ipcrs" :value="dat.ipcr_code" >
                        {{ dat.ipcr_code + " - " + dat.individual_output}}
                    </option>
                </select> -->




                <!-- <label for="">Individual Output</label>
                <input type="text" v-model="form.individual_output" class="form-control"
                    autocomplete="positionchrome-off" disabled>
                <div class="fs-6 c-red-500" v-if="form.errors.individual_output">{{ form.errors.individual_output }}
                </div> -->

                <input type="hidden" v-model="form.id" class="form-control" autocomplete="chrome-off">

                <button ref="Button" type="button" class="btn btn-primary mt-3 text-white" @click="submit()"
                    :disabled="form.processing" :hidden="isDisabled">
                    {{ pageTitle != "Edit" ? "Save Accomplishment" : "Save Changes" }}
                </button>

                <br>
                <h5 v-if="isDisabled" style="color: red;">
                    <span v-if="stat_accomp == '1' || stat_accomp == '2'">
                        The IPCR Semestral Accomplishment for this date range has already been approved or reviewed.
                        Select a different date
                    </span>
                    <span v-else>You cannot create an advance Accomplishment</span>
                </h5>
            </form>
        </div>
        <!-- {{ sem }}
        {{ stat_accomp }} -->
        <!-- {{ this.form.sem_id }} -->
    </div>
</template>
<script>
import { useForm } from "@inertiajs/inertia-vue3";
import Places from "@/Shared/PlacesShared";
import { ModelSelect, MultiSelect } from 'vue-search-select';
//import BootstrapModalNoJquery from './BootstrapModalNoJquery.vue';

export default {
    props: {
        data: Object,
        editData: Object,
        emp_code: Object,
        sectors: Object,
        sem: Object,
        session: Object,
        print_url: String
    },
    components: {
        //BootstrapModalNoJquery,
        ModelSelect,
        Places: () => new Promise((resolve) => {
            setTimeout(() => {
                resolve(Places);
            }, 2000);
        }),
        MultiSelect
    },
    data() {
        return {
            my_paps: [],
            individual_final_output_id: [],
            submitted: false,
            isDisabled: false,
            success_indicator: '',
            performance_measure: '',
            quality_error: 1,
            time_range_code: 0,
            unit_of_time: '',
            prescribed_period: 0,
            form: useForm({
                emp_code: "",
                date: "",
                individual_final_output_id: "",
                individual_output: "",
                description: "",
                sem_id: "",
                id: null,
            }),
            pageTitle: "",
            stat_accomp: "",
        };
    },

    mounted() {

        this.form.emp_code = this.emp_code;
        if (this.editData !== undefined) {
            if (this.bari) {
                this.bar = this.bari
            }
            this.pageTitle = "Edit"
            this.form.date = this.editData.date
            this.form.individual_final_output_id = this.editData.individual_final_output_id
            this.form.individual_output = this.editData.individual_output
            this.form.description = this.editData.description
            this.form.sem_id = this.editData.sem_id
            this.form.id = this.editData.id

            this.selected_ipcr()
        } else {
            this.pageTitle = "Create"
            this.form.date = new Date().toISOString().substr(0, 10);
            this.AutoSem()
            this.initializeDate();
        }

    },

    computed: {
        ipcrs() {
            return _.filter(this.data, (o) => o.sem_id == this.form.sem_id && o.status == 2)
        },
        individual_final_output_id() {
            let ipcr = this.ipcrs;
            return ipcr.map((dat) => ({
                value: dat.individual_final_output_id,
                label: dat.individual_output
            }));
        },
        average_timeliness() {
            return this.form.average_timeliness = this.form.quantity * this.form.timeliness
        }
    },

    methods: {
        submit() {
            if (this.form.quantity <= 0) {
                alert("Accomplishment Quantity should not be less than 1")
            } else if (this.form.quality < 0 && this.time_range_code != 3) {
                alert("Quality should not be empty")
            } else if (this.form.timeliness <= 0 && this.time_range_code != 56) {
                alert("Timeliness should not be empty")
            } else {
                this.form.target_qty = parseFloat(this.form.target_qty1) + parseFloat(this.form.target_qty2) + parseFloat(this.form.target_qty3) + parseFloat(this.form.target_qty4);
                //alert(this.form.target_qty);
                if (this.editData !== undefined) {
                    this.form.patch("/Daily_Accomplishment/" + this.form.id, this.form);
                } else {
                    // alert("Sample");
                    var url = "/Daily_Accomplishment/store"
                    // alert('for store '+url);
                    this.form.post(url);
                }
            }
        },
        selected_ipcr() {
            setTimeout(() => {
                if (this.form.individual_final_output_id !== null && this.form.individual_final_output_id !== undefined) {
                    // Find the index of the selected option in the array of ipcrs
                    const index = this.data.findIndex(data => String(data.individual_final_output_id) === String(this.form.individual_final_output_id));
                    // alert(index);
                    this.selected_value = this.data[index];
                    this.form.individual_output = this.data[index].individual_output;
                    this.ipcr_submfo = this.data[index].submfo_description;
                    this.ipcr_div_output = this.data[index].div_output;
                    this.ipcr_ind_output = this.data[index].individual_output;
                    this.ipcr_performance = this.data[index].performance_measure;
                    this.performance_measure = this.data[index].performance_measure;
                    this.success_indicator = this.data[index].success_indicator;
                    this.quality = this.data[index].quality;
                    this.timeliness = this.data[index].timeliness;
                    this.average_timeliness = this.data[index].average_timeliness;
                    this.quality_error = this.data[index].quality_error;
                    this.time_range_code = this.data[index].time_range_code;
                    this.unit_of_time = this.data[index].unit_of_time;
                    this.prescribed_period = this.data[index].prescribed_period;
                    //this.ipcr_success = this.ipcrs[index].s
                    //alert(index);
                } else {
                    // Handle case when no option is selected (form.ipcr_code is null or undefined)
                    return -1; // Return -1 to indicate no option is selected
                }
            }, 300);

        },
        initializeDate() {

            let currentDate = new Date().toISOString().substr(0, 10);

            if (this.form.date > currentDate) {
                this.isDisabled = true;
            } else {
                this.isDisabled = false;
            }
            // this.form.date = new Date().toISOString().substr(0, 10); // Set current date
        },
        moveToNextInput(nextInput) {
            this.$refs[nextInput].focus();
        },
        AutoSem() {
            this.initializeDate();
            let currentDate = new Date(this.form.date);
            let currentMonth = currentDate.getMonth() + 1; // Months are zero-based, so add 1
            let currentYear = currentDate.getFullYear();
            let Semester;

            if (currentMonth < 7) {
                Semester = 1;
            } else {
                Semester = 2;
            }

            var sem = _.find(this.sem, { sem: Semester.toString(), year: currentYear.toString() });
            this.form.sem_id = sem ? sem.id : '';
            this.stat_accomp = sem ? sem.status_accomplishment : '';
            if (this.stat_accomp == '1' || this.stat_accomp == '2') {
                this.isDisabled = true;
            } else {
                this.initializeDate();
            }
        },
    },
};
</script>
