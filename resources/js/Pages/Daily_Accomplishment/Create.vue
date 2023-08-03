<template>
    <div class="relative row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h3>{{ pageTitle }} Accomplishment</h3>

            <!-- {{ data }}
            {{ emp_code }} -->
            <Link :href="`/Daily_Accomplishment`">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z"/>
                <path fill-rule="evenodd" d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z"/>
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
                <input type="date" v-model="form.date" class="form-control" autocomplete="positionchrome-off" :disabled="pageTitle=='Edit'">
                <div class="fs-6 c-red-500" v-if="form.errors.date">{{ form.errors.date }}</div>

                <label for="">IPCR Code</label>
                <select class="form-control form-select" v-model="form.idIPCR"  @change="selected_ipcr" :disabled="pageTitle=='Edit'">
                    <option v-for="dat in data" :value="dat.ipcr_code" >
                        {{ dat.ipcr_code + " - " + dat.individual_output}}
                    </option>
                </select>
                <div class="fs-6 c-red-500" v-if="form.errors.idIPCR">{{ form.errors.idIPCR }}</div>

                <label for="">Individual Output</label>
                <input type="text" v-model="form.individual_output" class="form-control" autocomplete="positionchrome-off" disabled>
                <div class="fs-6 c-red-500" v-if="form.errors.individual_output">{{ form.errors.individual_output }}</div>

                <label for="">Particulars</label>
                <input type="text" v-model="form.description" class="form-control" autocomplete="positionchrome-off">
                <div class="fs-6 c-red-500" v-if="form.errors.description">{{ form.errors.description }}</div>

                <label for="">Quantity (if any)</label>
                <input type="number" v-model="form.quantity" class="form-control" autocomplete="positionchrome-off">
                <div class="fs-6 c-red-500" v-if="form.errors.quantity">{{ form.errors.quantity }}</div>

                <!-- <label for="">Amount (if any)</label>
                <input type="number" v-model="form.amount" class="form-control" autocomplete="positionchrome-off">
                <div class="fs-6 c-red-500" v-if="form.errors.amount">{{ form.errors.amount }}</div> -->

                <!-- <label for="">Source of Fund (if any)</label>
                <input type="text" v-model="form.source_of_fund" class="form-control" autocomplete="positionchrome-off">
                <div class="fs-6 c-red-500" v-if="form.errors.source_of_fund">{{ form.errors.source_of_fund }}</div> -->

                <!-- <label for="">Responsible Person/Unit</label>
                <input type="text" v-model="form.responsible_person" class="form-control" autocomplete="positionchrome-off">
                <div class="fs-6 c-red-500" v-if="form.errors.responsible_person">{{ form.errors.responsible_person }}</div> -->


                <!-- <label for="">Date To</label>
                <input type="date" v-model="form.date_to" class="form-control" autocomplete="positionchrome-off">
                <div class="fs-6 c-red-500" v-if="form.errors.date_to">{{ form.errors.date_to }}</div> -->

                <label for="">Remarks</label>
                <input type="text" v-model="form.remarks" class="form-control" autocomplete="positionchrome-off">
                <div class="fs-6 c-red-500" v-if="form.errors.remarks">{{ form.errors.remarks }}</div>

                <label for="">Link</label>
                <input type="text" v-model="form.link" class="form-control" autocomplete="positionchrome-off">
                <div class="fs-6 c-red-500" v-if="form.errors.link">{{ form.errors.link }}</div>

                <input type="hidden" v-model="form.id" class="form-control" autocomplete="chrome-off">

                <button type="button" class="btn btn-primary mt-3" @click="submit()" :disabled="form.processing">
                    Save Accomplishment
                </button>
            </form>
        </div>


    </div>

</template>
<script>
import { useForm } from "@inertiajs/inertia-vue3";
import Places from "@/Shared/PlacesShared";
    //import BootstrapModalNoJquery from './BootstrapModalNoJquery.vue';

export default {
        props: {
            data: Object,
            editData: Object,
            emp_code: Object,
            sectors: Object
        },
        components: {
          //BootstrapModalNoJquery,

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
                    emp_code:"",
                    date: "",
                    idIPCR: "",
                    individual_output: "",
                    description: "",
                    quantity: "",
                    remarks: "",
                    link: "",
                    id: null
                }),
                pageTitle: ""
            };
        },

        mounted() {
            this.form.emp_code=this.emp_code;
            if (this.editData !== undefined) {
                if(this.bari){
                    this.bar=this.bari
                }
                this.pageTitle = "Edit"
                this.form.date=this.editData.date
                this.form.idIPCR=this.editData.idIPCR
                this.form.individual_output=this.editData.individual_output
                this.form.description=this.editData.description
                this.form.quantity=this.editData.quantity
                this.form.remarks=this.editData.remarks
                this.form.link=this.editData.link
                this.form.id=this.editData.id
            } else {
                this.pageTitle = "Create"
            }

        },

        methods: {
            submit() {
                this.form.target_qty=parseFloat(this.form.target_qty1)+parseFloat(this.form.target_qty2)+parseFloat(this.form.target_qty3)+parseFloat(this.form.target_qty4);
                //alert(this.form.target_qty);
                if (this.editData !== undefined) {
                    this.form.patch("/Daily_Accomplishment/" + this.form.id, this.form);
                } else {
                    // alert("Sample");
                    var url="/Daily_Accomplishment/store"
                    // alert('for store '+url);
                    this.form.post(url);
                }
            },
            selected_ipcr(){
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
        },
    };
    </script>
