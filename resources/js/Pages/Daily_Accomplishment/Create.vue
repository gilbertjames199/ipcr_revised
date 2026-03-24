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
                <input @input="AutoSem" type="date" v-model="form.date" class="form-control"
                    :disabled="pageTitle == 'Edit'">

                <!-- <input @change="AutoSem()" type="date" v-model="form.date" class="form-control"
                    autocomplete="positionchrome-off" :disabled="pageTitle == 'Edit'"> -->
                <div class="fs-6 c-red-500" v-if="form.errors.date">{{ form.errors.date }}</div>

                <label class="mt-2 mb-1">
                <span v-if="emp_type === 'emp'">Individual Output</span>
                <span v-else-if="emp_type === 'div'">Division Output</span>
                <span v-else-if="emp_type === 'hemp'">Hospital Individual Output</span>
                <span v-else-if="emp_type === 'hsec'">Hospital Section Output</span>
                <span v-else-if="emp_type === 'hdiv'">Hospital Division Output</span>
                <span v-else-if="emp_type === 'hos'">Hospital Output</span>
                <span v-else>Output</span>
            </label>
                <div>
                    <!-- selected_pcr_option: {{ selected_pcr_option }} -->
                     <!-- {{ selected_pcr_option }} -->
                    <multiselect ref="IPCRInput" :options="individual_final_output_id" :searchable="true" v-model="selected_pcr_option"
                        label="label" track-by="label" @close="selected_ipcr"
                        :disabled="pageTitle == 'Edit' || isDisabled">
                    </multiselect>
                </div>
                <!-- {{ data }} -->
                <div class="fs-6 c-red-500" v-if="form.errors.individual_final_output_id">{{ form.errors.individual_final_output_id }}</div>

                <label for="">Particulars</label>
                <!-- <input type="text" v-model="form.description" class="form-control" autocomplete="positionchrome-off"
                    @keyup.enter="moveToNextInput('IPCRInput')" :disabled="isDisabled"> -->
                <textarea
                    v-model="form.description"
                    class="form-control"
                    autocomplete="positionchrome-off"
                    @keyup.enter="moveToNextInput('IPCRInput')"
                    :disabled="isDisabled"
                    rows="1"
                ></textarea>
                <div class="fs-6 c-red-500" v-if="form.errors.description">{{ form.errors.description }}</div>


                <label for="">Semester</label>
                <!-- {{ sem }} -->
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
                <!-- <h5 v-if="isDisabled" style="color: red;">
                    <span v-if="stat_accomp == '1' || stat_accomp == '2'">
                        The IPCR Semestral Accomplishment for this date range has already been approved or reviewed.
                        Select a different date
                    </span>
                    <span v-else>You cannot create an advance Accomplishment</span>
                </h5> -->

                <h5 v-if="isDisabled" style="color: red;">
                    <span v-if="disableReason === 'SEM_LOCKED'">
                        The IPCR Semestral Accomplishment for this date range has already been approved or reviewed.
                        Select a different date
                    </span>

                    <span v-else-if="disableReason === 'ADVANCE'">
                        You cannot create an advance Accomplishment
                    </span>

                    <span v-else-if="disableReason === 'CUTOFF_10TH_WEEKDAY'">
                        You cannot create accomplishment since the deadline for the approval has already passed based on MO.0028.2026.
                    </span>
                </h5>
            </form>
        </div>
        <!-- {{ form }} -->
        <!-- {{ form }}
        -------<br> -->
        <!-- {{ data }} -->
        <!-- {{ sem }}
        {{ stat_accomp }} -->
        <!-- {{ this.form.sem_id }} -->
          <!-- {{ data }}
          <br>
          {{ editData }} -->
           <!-- {{ data }}
        <hr>
        {{ ipcrs }} -->
          <!-- {{ form }}
          <hr>
          {{ ipcrs }}
          <hr>
          {{ data }} -->
           <!-- {{ selected_pcr_option }} -->
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
        print_url: String,
        emp_type: String,
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
                type: "",
            }),
            selected_pcr_option: "",
            pageTitle: "",
            stat_accomp: "",
            disableReason: '',
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
            // this.selected_pcr_option = this.editData.individual_final_output_id
            // var temp_con =this.getSelectedIFO(this.editData.individual_final_output_id, this.editData.sem_id)
            //this.selected_pcr_option = temp_con.id;
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
                // value: dat.individual_final_output_id,
                // "[id: "+ dat.individual_final_output_id+ ", type: " + dat.pcr_type + "]",
                value: dat.id,
                // "[id: "+ dat.individual_final_output_id+ ", type: " + dat.pcr_type + "]",
                label: dat.MFO + " - " + dat.performance_measure + " " + dat.individual_output,
                pcr_type: dat.pcr_type, // include for easier access later
                original: dat           // optional: include full object if needed
            }));
        },
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
        getSelectedIFO(individual_final_output_id, sem_id) {
            // Find the semester object that matches sem_id
            const semObj = this.sem.find(s => s.id === sem_id);
            console.log("gdklfgdkfgdg")
            console.log(semObj);
            // If not found, stop early
            if (!semObj) return null;

            // Extract the semester value (e.g. "1" or "2")
            const semester = semObj.semester || semObj.sem || null;

            if (!semester) return null;

            // Find the matching record in ipcrs
            return this.ipcrs.find(item =>
            item.individual_final_output_id === individual_final_output_id &&
            item.semester === semester
            ) || null;
        },
        selected_ipcr() {
            setTimeout(() => {
                // console.log("PCCCCRRRRRRRR");
                // console.log(this.selected_pcr_option);
                // var array_string = this.parseSelectedOption(this.selected_pcr_option)
                // this.form.individual_final_output_id = array_string.id
                // this.form.type=array_string.type
                // console.log(this.form.)
                if (this.selected_pcr_option !== null && this.selected_pcr_option !== undefined) {
                    // Find the index of the selected option in the array of ipcrs
                    // const index = this.data.findIndex(data => String(data.individual_final_output_id) === String(this.form.individual_final_output_id));
                    const index = this.data.findIndex(data => String(data.id) === String(this.selected_pcr_option));
                    // alert(index);
                    console.log("pint inside selected ipcr method")
                    console.log(this.data[index]);
                    this.selected_value = this.data[index];
                    this.form.individual_final_output_id = this.data[index].individual_final_output_id;
                    this.form.individual_output = this.data[index].individual_output;
                    this.form.type = this.data[index].pcr_type;
                    // alert(this.form.type + this.form.individual_final_output_id)
                    this.ipcr_submfo = this.data[index].submfo_description;
                    this.ipcr_div_output = this.data[index].div_output;
                    this.ipcr_ind_output = this.data[index].individual_output;
                    this.ipcr_performance = this.data[index].performance_measure;
                    this.performance_measure = this.data[index].performance_measure;
                    this.success_indicator = this.data[index].success_indicator;
                    this.quality = this.data[index].quality;
                    this.timeliness = this.data[index].timeliness;
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
        parseSelectedOption(str) {
            // Remove the square brackets
            str = str.replace(/^\[|\]$/g, '');

            const obj = {};
            const parts = str.split(',');

            parts.forEach(part => {
                const [key, value] = part.split(':').map(s => s.trim());

                // Convert to number if possible
                obj[key] = isNaN(value) ? value : Number(value);
            });

            return obj;
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
    this.$nextTick(() => {

        if (!this.form.date) return;

        let [selectedYear, selectedMonth] = this.form.date.split('-').map(Number);

        let selectedFullDate = new Date(this.form.date);
        let today = new Date();
        let todayOnly = new Date();
        todayOnly.setHours(0,0,0,0);

        let currentYear = today.getFullYear();
        let currentMonth = today.getMonth() + 1;


        let [selY, selM, selD] = this.form.date.split('-').map(Number);
        let t = new Date();
        let todayY = t.getFullYear();
        let todayM = t.getMonth() + 1;
        let todayD = t.getDate();
        // ================= SEMESTER CHECK =================
        let Semester = selectedMonth < 7 ? 1 : 2;

        var sem = _.find(this.sem, {
            sem: Semester.toString(),
            year: selectedYear.toString()
        });

        this.form.sem_id = sem ? sem.id : '';
        this.stat_accomp = sem ? sem.status_accomplishment : '';

        if (this.stat_accomp == '1' || this.stat_accomp == '2') {
            this.isDisabled = true;
            this.disableReason = 'SEM_LOCKED';
            return;
        }



        // ================= ADVANCE CHECK (CORRECT) =================
        if (selY > todayY || (selY === todayY && selM > todayM) || (selY === todayY && selM === todayM && selD > todayD)) {
// console.log(selectedFullDate);
//             console.log(todayOnly);
            this.isDisabled = true;
            this.disableReason = 'ADVANCE';
            return;
        }

        // ================= 10TH WEEKDAY CUT-OFF =================
        let tenthWeekday = this.getAfter10thWorkingDay(currentYear, currentMonth);

        let prevMonth = currentMonth - 1;
        let prevYear = currentYear;

        if (prevMonth === 0) {
            prevMonth = 12;
            prevYear--;
        }

        let monthDiff = (currentYear - selectedYear) * 12 + (currentMonth - selectedMonth);

            // ❌ block anything older than previous month
            if (monthDiff >= 2) {
                this.isDisabled = true;
                this.disableReason = 'CUTOFF_10TH_WEEKDAY';
                return;
            }

        if (today >= tenthWeekday) {
            if (selectedMonth === prevMonth && selectedYear === prevYear) {
                this.isDisabled = true;
                this.disableReason = 'CUTOFF_10TH_WEEKDAY';
                return;
            }
        }

        // ✅ allowed
        this.isDisabled = false;
        this.disableReason = '';
    });
},





        // AutoSem() {
        //     this.initializeDate();
        //     let currentDate = new Date(this.form.date);
        //     let currentMonth = currentDate.getMonth() + 1; // Months are zero-based, so add 1
        //     let currentYear = currentDate.getFullYear();
        //     let Semester;

        //     if (currentMonth < 7) {
        //         Semester = 1;
        //     } else {
        //         Semester = 2;
        //     }

        //     var sem = _.find(this.sem, { sem: Semester.toString(), year: currentYear.toString() });
        //     this.form.sem_id = sem ? sem.id : '';
        //     this.stat_accomp = sem ? sem.status_accomplishment : '';
        //     if (this.stat_accomp == '1' || this.stat_accomp == '2') {
        //         this.isDisabled = true;
        //     } else {
        //         this.initializeDate();
        //     }
        // },

    //    getAfter10thWeekday(year, month) {
    //     let count = 0;
    //     let date = new Date(year, month - 1, 1); // start at the 1st of the month

    //     while (count < 10) {
    //         let day = date.getDay(); // 0=Sun, 6=Sat
    //         if (day !== 0 && day !== 6) {
    //             count++;
    //         }
    //         if (count < 10) {
    //             date.setDate(date.getDate() + 1);
    //         }
    //     }

    //     // Now date = 10th weekday, add 1 day to get the "after 10th weekday"
    //     date.setDate(date.getDate() + 1);

    //     return date;
    // },

        getAfter10thWorkingDay(year, month) {
            let count = 0;
            let date = new Date(year, month - 1, 1);

            while (count < 10) {
                let day = date.getDay();

                // Working days: Monday to Thursday only
                if (day >= 1 && day <= 4) {
                    count++;
                }

                if (count < 10) {
                    date.setDate(date.getDate() + 1);
                }
            }

            // move to the day AFTER the 10th working day
            date.setDate(date.getDate() + 1);

            return date;
        }

    },
};
</script>
