<template>
    <div class="relative row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h3>{{ pageTitle }} FAOs</h3>

            <!-- {{ data }}
            {{ emp_code }} -->
            <!-- {{ session.previous_url }} -->
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-lg"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z" />
                <path fill-rule="evenodd"
                    d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z" />
            </svg>

        </div>

        <!-- <div class="col-md-8">
            <button class="btn btn-secondary" @click="showModal" :disabled="submitted">Permissions</button>
        </div> -->

        <div class="col-md-8">
            <form @submit.prevent="submit()">
                <input type="hidden" required>
                <input type="hidden" v-model="form.emp_code" class="form-control" autocomplete="positionchrome-off">


                <label for="">Questions</label>
                <input type="text" v-model="form.Questions" class="form-control" autocomplete="positionchrome-off"
                     :disabled="isDisabled">
                <div class="fs-6 c-red-500" v-if="form.errors.Questions">{{ form.errors.Questions }}</div>

                <label for="">Answers</label>
                <input type="text" v-model="form.Answers" class="form-control" autocomplete="positionchrome-off"
                     :disabled="isDisabled">
                <div class="fs-6 c-red-500" v-if="form.errors.Answers">{{ form.errors.Answers }}</div>

                <input type="hidden" v-model="form.id" class="form-control" autocomplete="chrome-off">

                <button ref="Button" type="button" class="btn btn-primary mt-3" @click="submit()"
                    :disabled="form.processing" :hidden="isDisabled">
                    {{ pageTitle != "Edit" ? "Save Accomplishment" : "Save Changes" }}
                </button>



            </form>
        </div>

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
            ipcr_code: [],
            submitted: false,
            isDisabled: false,
            form: useForm({
                Questions: "",
                Answers: "",
                id: null
            }),
            pageTitle: ""
        };
    },

    mounted() {

        this.form.emp_code = this.emp_code;
        if (this.editData !== undefined) {
            if (this.bari) {
                this.bar = this.bari
            }
            this.pageTitle = "Edit"
            this.form.Questions = this.editData.Questions
            this.form.Answers = this.editData.Answers
            this.form.id = this.editData.id
        } else {
            this.pageTitle = "Create"
        }

    },

    computed: {
        ipcrs() {
            return _.filter(this.data, (o) => o.sem_id == this.form.sem_id && o.status == 2)
        },
        ipcr_codes() {
            let ipcr = this.ipcrs;
            return ipcr.map((dat) => ({
                value: dat.ipcr_code,
                label: dat.ipcr_code + " - " + dat.individual_output + " - " + dat.performance_measure
            }));
        },
        average_timeliness() {
            return this.form.average_timeliness = this.form.quantity * this.form.timeliness
        }
    },

    methods: {
        submit() {
            // alert(this.form.id)
                this.form.target_qty = parseFloat(this.form.target_qty1) + parseFloat(this.form.target_qty2) + parseFloat(this.form.target_qty3) + parseFloat(this.form.target_qty4);
                //alert(this.form.target_qty);
                if (this.editData !== undefined) {
                    this.form.patch("/dashboard/update/" + this.form.id, this.form);
                } else {
                    // alert("Sample");
                    var url = "/dashboard/store"
                    // alert('for store '+url);
                    this.form.post(url);
                }

        },
        selected_ipcr() {
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
        },
    },
};
</script>
