<template>
    <div class="relative row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h3>{{ pageTitle }} Accomplishment</h3>

            <!-- {{ data }}
            {{ emp_code }} -->
            <Link :href="`/Daily_Accomplishment`">
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

                <label for="">IPCR Code</label>
                <div>
                    <multiselect ref="IPCRInput" :options="ipcr_codes" :searchable="true" v-model="form.idIPCR"
                        label="label" track-by="label" @close="selected_ipcr" :disabled="pageTitle == 'Edit' || isDisabled">
                    </multiselect>
                </div>


                <!-- <select class="form-control form-select" v-model="form.idIPCR"  @change="selected_ipcr" :disabled="pageTitle=='Edit' || isDisabled">
                    <option v-for="dat in ipcrs" :value="dat.ipcr_code" >
                        {{ dat.ipcr_code + " - " + dat.individual_output}}
                    </option>
                </select> -->


                <div class="fs-6 c-red-500" v-if="form.errors.idIPCR">{{ form.errors.idIPCR }}</div>

                <label for="">Individual Output</label>
                <input type="text" v-model="form.individual_output" class="form-control" autocomplete="positionchrome-off"
                    disabled>
                <div class="fs-6 c-red-500" v-if="form.errors.individual_output">{{ form.errors.individual_output }}</div>

                <label for="">Success Indicator</label>
                <input type="text" v-model="success_indicator" class="form-control" autocomplete="positionchrome-off"
                    disabled>
                <div class="fs-6 c-red-500" v-if="form.errors.success_indicator">{{ form.errors.success_indicator }}</div>

                <label for="">Performance Measure</label>
                <input type="text" v-model="performance_measure" class="form-control" autocomplete="positionchrome-off"
                    disabled>
                <div class="fs-6 c-red-500" v-if="form.errors.success_indicator">{{ form.errors.success_indicator }}</div>

                <label for="">Quantity</label>
                <input ref="QuantityInput" type="number" v-model="form.quantity" class="form-control"
                    autocomplete="positionchrome-off" @keyup.enter="moveToNextInput('QualityInput')" :disabled="isDisabled">
                <div class="fs-6 c-red-500" v-if="form.errors.quantity">{{ form.errors.quantity }}</div>

                <label for="">Quality</label>
                <input ref="QualityInput" type="number" v-model="form.quality" class="form-control"
                    autocomplete="positionchrome-off" @keyup.enter="moveToNextInput('TimelinessInput')"
                    @keydown.down.prevent="moveToNextInput('TimelinessInput')"
                    @keydown.up.prevent="moveToNextInput('QuantityInput')" :disabled="isDisabled">
                <div class="fs-6 c-red-500" v-if="form.errors.quality">{{ form.errors.quality }}</div>

                <label for="">Timeliness</label>
                <input ref="TimelinessInput" type="number" v-model="form.timeliness" class="form-control"
                    autocomplete="positionchrome-off" @keyup.enter="moveToNextInput('RemarksInput')"
                    @keydown.down.prevent="moveToNextInput('RemarksInput')"
                    @keydown.up.prevent="moveToNextInput('QuantityInput')" :disabled="isDisabled">
                <div class="fs-6 c-red-500" v-if="form.errors.timeliness">{{ form.errors.timeliness }}</div>


                <input type="hidden" v-model="form.average_timeliness" class="form-control"
                    autocomplete="positionchrome-off" disabled>
                <div class="fs-6 c-red-500" v-if="form.errors.average_timeliness">{{ form.errors.average_timeliness }}</div>


                <div class="form-control" hidden>
                    {{ average_timeliness }}
                </div>

                <label for="">Remarks</label>
                <input ref="RemarksInput" type="text" v-model="form.remarks" class="form-control"
                    autocomplete="positionchrome-off" @keyup.enter="moveToNextInput('LinkInput')" :disabled="isDisabled">
                <div class="fs-6 c-red-500" v-if="form.errors.remarks">{{ form.errors.remarks }}</div>

                <label for="">Link</label>
                <input ref="LinkInput" type="text" v-model="form.link" class="form-control"
                    autocomplete="positionchrome-off" @keyup.enter="moveToNextInput('Button')" :disabled="isDisabled">
                <div class="fs-6 c-red-500" v-if="form.errors.link">{{ form.errors.link }}</div>

                <input type="hidden" v-model="form.id" class="form-control" autocomplete="chrome-off">

                <button ref="Button" type="button" class="btn btn-primary mt-3" @click="submit()"
                    :disabled="form.processing" :hidden="isDisabled">
                    {{ pageTitle != "Edit" ? "Save Accomplishment" : "Save Changes" }}
                </button>

                <br>
                <h5 v-if="isDisabled" style="color: red;">You cannot create an advance Accomplishment</h5>
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
            success_indicator: '',
            performance_measure: '',
            form: useForm({
                emp_code: "",
                date: "",
                idIPCR: "",
                individual_output: "",
                description: "",
                quantity: null,
                remarks: "",
                link: "",
                sem_id: "",
                quality: "",
                timeliness: null,
                average_timeliness: null,
                id: null
            }),
            pageTitle: ""
        };
    },

    mounted() {
        this.initializeDate();
        this.form.emp_code = this.emp_code;
        if (this.editData !== undefined) {
            if (this.bari) {
                this.bar = this.bari
            }
            this.pageTitle = "Edit"
            this.form.date = this.editData.date
            this.form.idIPCR = this.editData.idIPCR
            this.form.individual_output = this.editData.individual_output
            this.form.description = this.editData.description
            this.form.quantity = this.editData.quantity
            this.form.remarks = this.editData.remarks
            this.form.link = this.editData.link
            this.form.sem_id = this.editData.sem_id
            this.form.id = this.editData.id
            this.form.quality = this.editData.quality
            this.form.timeliness = this.editData.timeliness
            this.form.average_timeliness = this.editData.average_timeliness

            this.selected_ipcr()
        } else {
            this.pageTitle = "Create"
            this.form.date = new Date().toISOString().substr(0, 10);
            this.AutoSem()
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
            if(this.form.quantity <= 0){
                alert("Accomplishment Quantity should not be less than 1")
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
