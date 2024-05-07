<template>
    <div class="relative row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h3>
                {{ pageTitle }} Individual Final Output
                <!-- {{ editData.id_div_output }} -->
                <!-- IPCR myIPCR: {{ editData }} -->
            </h3>
            <Link v-if="editData !== undefined">
            <!-- :href="`/ipcrsemestral/${emp.id}/${source}`" -->
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-lg"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z" />
                <path fill-rule="evenodd"
                    d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z" />
            </svg>
            </Link>
            <Link v-else :href="`/individual-final-output-crud/`">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-lg"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z" />
                <path fill-rule="evenodd"
                    d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z" />
            </svg>
            </Link>
        </div>

        <div class="col-md-8">
            <!-- <div>Name: <u>{{ emp.employee_name }}</u></div> {{ source }}
            <div>Position: <u>{{ emp.position_long_title }}</u></div>
            <div>Employment Status: <u>{{ emp.employment_type_descr }}</u></div> -->
            <!-- {{ emp }} -->
            <form @submit.prevent="submit()">
                <input type="hidden" required>
                <label>Office: </label>
                <select class="form-select" v-model="ffunccod" @change="loadMFOs()">
                    <option value="00"></option>
                    <option v-for="office in offices" :value="office.ffunccod">
                        {{ office.office }}
                    </option>
                </select>

                <label>Major Final Outputs</label>
                <select class="form-select" v-model="form.idmfo" @change="loadSubMFOs()">
                    <option value="00"></option>
                    <option v-for="mfo in mfos" :value="mfo.id">
                        {{ mfo.id }} - {{ mfo.mfo_desc }}
                    </option>
                </select>
                <div class="fs-6 c-red-500" v-if="form.errors.idmfo">{{ form.errors.idmfo }}</div>
                <label>Sub MFO</label>
                <select class="form-select" v-model="form.idsubmfo">
                    <option value="00"></option>
                    <option v-for="sub_mfo in sub_mfos" :value="sub_mfo.id">
                        {{ sub_mfo.submfo_description }}
                    </option>
                </select>
                <div class="fs-6 c-red-500" v-if="form.errors.idsubmfo">{{ form.errors.idsubmfo }}</div>

                <label>Division Output</label>
                <!-- dsdsdid_div_output: {{ form.id_div_output }} -->
                <select class="form-select" v-model="form.id_div_output">
                    <option value="00"></option>
                    <option v-for="div_output in div_outputs" :value="div_output.id">
                        {{ div_output.id }} - {{ div_output.output }}
                    </option>
                </select>
                <div class="fs-6 c-red-500" v-if="form.errors.id_div_output">{{ form.errors.id_div_output }}</div>

                <label>Individual Output</label>
                <input v-model="form.individual_output" class="form-control" type="text" @change="setIndivPlusWith()" />
                <div class="fs-6 c-red-500" v-if="form.errors.individual_output">{{ form.errors.individual_output }}</div>

                <label>Performance Measure</label>
                <input v-model="form.performance_measure" class="form-control" type="text" />
                <div class="fs-6 c-red-500" v-if="form.errors.performance_measure">{{ form.errors.performance_measure }}
                </div>

                <label>Success Indicator</label>
                <input v-model="form.success_indicator" class="form-control" type="text" />
                <div class="fs-6 c-red-500" v-if="form.errors.success_indicator">{{ form.errors.success_indicator }}
                </div>

                <!-- <label>Concerned Individual</label>
                <input v-model="form.concerned_indiviual" class="form-control" type="text" />
                <div class="fs-6 c-red-500" v-if="form.errors.concerned_indiviual">{{ form.errors.concerned_indiviual }}
                </div> -->

                <label>Quantity Type</label>
                <select v-model="form.quantity_type" class="form-select">
                    <option></option>
                    <option value="1">To be rated</option>
                    <option value="2">Not to be rated</option>
                </select>
                <div class="fs-6 c-red-500" v-if="form.errors.quantity_type">{{ form.errors.quantity_type }}
                </div>

                <label>Quality Error</label>
                <select v-model="form.quality_error" class="form-select">
                    <option></option>
                    <option value="1">error based</option>
                    <option value="2">feedback</option>
                    <option value="3">not rated</option>
                    <option value="4">accuracy rule</option>
                </select>
                <div class="fs-6 c-red-500" v-if="form.errors.quantity_type">{{ form.errors.quantity_type }}
                </div>

                <label>Time Range</label>
                <select v-model="form.time_range_code" class="form-select" @change="setTimeUnit">
                    <option></option>
                    <option v-for="time_range in time_ranges" :value="time_range.time_code">
                        {{ time_range.time_code }} - {{ time_range.time }}
                    </option>
                </select>
                <div class="fs-6 c-red-500" v-if="form.errors.quantity_type">{{ form.errors.quantity_type }}
                </div>

                <label>Time Class</label>
                <select v-model="form.time_based" class="form-select">
                    <option></option>
                    <option value="1">based on time spent</option>
                    <option value="2">deadline</option>
                    <option value="3">not rated</option>
                </select>
                <div class="fs-6 c-red-500" v-if="form.errors.quantity_type">{{ form.errors.quantity_type }}
                </div>


                <label>Time Unit</label>
                <input v-model="form.unit_of_time" class="form-control" type="text" />
                <div class="fs-6 c-red-500" v-if="form.errors.unit_of_time">{{ form.errors.unit_of_time }}</div>

                <label>Activity/Verb</label>
                <input v-model="form.activity" class="form-control" type="text" />
                <div class="fs-6 c-red-500" v-if="form.errors.activity">{{ form.errors.activity }}</div>


                <label>Individual Final Output</label>
                <input v-model="form.verb" class="form-control" type="text" />
                <div class="fs-6 c-red-500" v-if="form.errors.verb">{{ form.errors.verb }}</div>

                <label>Within &nbsp;</label>
                <input type="checkbox" v-model="form.within" true-value="within" false-value="" />
                <div class="fs-6 c-red-500" v-if="form.errors.within">{{ form.errors.within }}</div>
                <br>
                <label>unit of time per individual output</label>
                <input v-model="form.concatenate" class="form-control" type="text" />
                <div class="fs-6 c-red-500" v-if="form.errors.concatenate">{{ form.errors.concatenate }}</div>

                <button type="button" class="btn btn-primary mt-3 text-white font-weight-bold" @click="submit()"
                    :disabled="form.processing">
                    Save changes
                </button>
            </form>
        </div>
        <!-- {{ time_ranges }} -->
        <!-- div_outputs: {{ div_outputs }} -->
        <!-- {{ supervisors_h }} -->
    </div>
</template>
<script>
import { useForm } from "@inertiajs/inertia-vue3";
import axios from "axios";
import { handleError } from "vue";
import { ModelSelect } from 'vue-search-select';
//import Places from "@/Shared/PlacesShared";

export default {
    props: {
        editData: Object,
        id: String,
        offices: Object,
        major_final_outputs: Object,
        time_ranges: Object,
        FFUNCCOD_selected: String,

        emp: Object,
        supervisors: Object,
        emp: Object,
        dept_code: String,
        source: String,
        auth: Object
    },
    components: {
        ModelSelect
    },
    data() {
        return {
            submitted: false,
            ffunccod: "",
            mfos: [],
            sub_mfos: [],
            div_outputs: [],
            started: 0,
            preview: " ",
            form: useForm({
                // ipcr_code: "",
                idmfo: "",
                idsubmfo: "",
                id_div_output: "",
                individual_output: "",
                performance_measure: "",
                success_indicator: "",
                concerned_indiviual: "",
                quantity_type: "",
                quality_error: "",
                time_range_code: "",
                time_based: "",
                activity: "",
                verb: "",
                error_feedback: "",
                within: "",
                unit_of_time: "",
                concatenate: "",
                id: null
            }),
            emp_sg: this.auth.user.name.salary_grade,
            immediate_sg: "0",
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
    watch: {

        // editData.id_div_output: _.debounce(function (value) {
        //     handler(newVal, oldVal) {
        //         console.log('id_div_output changed:', newVal);
        //         this.form.id_div_output = newVal;
        //     },
        //     immediate: true // This will trigger the handler immediately after the component is created
        // }
    },
    mounted() {
        this.form.source = this.source
        this.mfos = this.major_final_outputs
        // this.form.ipcr_semester_id="0";
        if (this.editData !== undefined) {
            this.started = 1;
            this.pageTitle = "Edit"
            this.form.id = this.editData.id;
            this.ffunccod = this.FFUNCCOD_selected
            this.loadMFOs();
            this.form.idmfo = this.editData.idmfo
            this.loadSubMFOs();
            this.loadDivOutputs();
            this.form.idsubmfo = this.editData.idsubmfo
            this.form.id_div_output = this.editData.id_div_output

            this.form.individual_output = this.editData.individual_output
            this.form.performance_measure = this.editData.performance_measure
            this.form.success_indicator = this.editData.success_indicator
            this.form.quantity_type = this.editData.quantity_type
            this.form.quality_error = this.editData.quality_error
            this.form.time_range_code = this.editData.time_range_code
            this.form.time_based = this.editData.time_based
            this.form.unit_of_time = this.editData.unit_of_time
            this.form.activity = this.editData.activity
            this.form.verb = this.editData.verb
            this.form.within = this.editData.within
            this.form.concatenate = this.editData.concatenate
            // alert('id_div_output: ' + this.form.id_div_output + ' editData.id_div_output: ' + this.editData.id_div_output)
            // this.$nextTick(() => {
            //     this.form.id_div_output = this.editData.id_div_output
            //     // Any other assignments or operations that depend on this value can go here
            // });
        } else {
            this.started = 0;
            this.pageTitle = "Create"
            this.form.status = "-1"
        }
    },
    computed: {

    },
    methods: {
        submit() {
            if (this.editData !== undefined) {
                if (this.form.status > 0) {
                    alert('Already approved or reviewed!')
                } else {
                    this.form.patch("/individual-final-output-crud/update/" + this.editData.id, this.form);
                }

            } else {
                this.form.post("/individual-final-output-crud/store");
            }
        },
        async loadMFOs() {
            this.mfos = [];
            this.sub_mfos = [];
            this.div_outputs = [];
            this.form.idmfo = "";
            this.form.idsubmfo = "";
            this.form.id_div_output = "";
            if (this.ffunccod) {
                await axios.post('/fetch/data/major/final/outputs', {
                    FFUNCCOD: this.ffunccod
                }).then((response) => {
                    this.mfos = response.data
                })
            }
        },
        async loadSubMFOs() {
            this.sub_mfos = [];
            this.form.idsubmfo = "";
            // alert("idmfo: " + this.form.idmfo)
            if (this.form.idmfo) {
                await axios.post('/fetch/data/sub/mfos', {
                    idmfo: this.form.idmfo
                }).then((response) => {
                    this.sub_mfos = response.data
                })
            }
            if (this.started < 1) {
                this.loadDivOutputs();

            } else {
                this.started = this.started - 1
            }

        },
        async loadDivOutputs() {
            this.div_outputs = [];
            this.form.id_div_output = "";
            // alert("idmfo: " + this.form.idmfo)
            if (this.form.idmfo) {
                await axios.post('/fetch/data/division/div-outputs', {
                    idmfo: this.form.idmfo
                }).then((response) => {
                    this.div_outputs = response.data
                })
            }
        },
        setTimeUnit() {
            // alert(this.form.time_range_code);
            const selectedTimeRange = this.time_ranges.find(
                (timeRange) => timeRange.time_code === this.form.time_range_code
            );

            if (selectedTimeRange) {
                this.form.unit_of_time = selectedTimeRange.time_unit.toLowerCase();
                this.form.concatenate = this.form.unit_of_time + " per " + this.form.individual_output
            } else {
                // Handle the case where no time range is selected
                this.form.unit_of_time = ''; // Or set a default value
            }
        },
        setIndivPlusWith() {
            // alert(this.form.individual_output)
            this.form.verb = this.form.individual_output + " with";

        }
    },
};
</script>
