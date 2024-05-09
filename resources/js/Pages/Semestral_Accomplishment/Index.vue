<template>

    <Head>
        <title>Home</title>
    </Head>

    <!--<p style="text-align: justify;">Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit amet consectetur.
    </p>-->
    <div class="row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h3>Semestral Accomplishment - {{ SemName(sem_data.sem) }} {{ sem_data.year }} </h3>
            <!-- {{ emp_code }}
            {{ data }} -->
            <div class="peers">
                <div class="peer mR-10">

                    <!-- <input v-model="search" type="text" class="form-control form-control-sm" placeholder="Search..."> -->
                </div>
                <div class="peer">
                    <!-- <Link class="btn btn-primary btn-sm" :href="`/Daily_Accomplishment/create`">Add Daily Accomplishment</Link> -->
                    <!-- <button class="btn btn-primary btn-sm mL-2 text-white" @click="showFilter()">Filter</button> -->
                    <button class="btn btn-primary btn-sm mL-2 text-white" @click="printSubmit1">Print Part 1</button>
                    <button class="btn btn-primary btn-sm mL-2 text-white" @click="printSubmit">Print Part 2</button>
                </div>
                <div class="peer">
                    <button class="btn btn-primary btn-sm mL-2 text-white" @click="submitAccomplishmentFOrThisMonth()"
                        v-if="sem_data.status_accomplishment < 0">Submit</button>

                    <button class="btn btn-primary btn-sm mL-2 text-white" @click="recallAccomplishmentFOrThisMonth()"
                        v-if="sem_data.status_accomplishment == 0">Recall</button>
                </div>
            </div>

            <Link :href="'/monthly-accomplishment'">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-lg"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z" />
                <path fill-rule="evenodd"
                    d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z" />
            </svg>
            </Link>
        </div>
        <div>
            <p><b>Status</b>: <u>{{ getStatus(sem_data.status_accomplishment.toString()) }}</u></p>
        </div>
        <!-- {{ sem_data.status_accomplishment }} -->
        <!-- <filtering v-if="filter" @closeFilter="filter = false">
            Filter by MFO
            <select v-model="mfosel" class="form-control" @change="filterData()">
                <option></option>
                <option v-for="mfo in mfos" :value="mfo.id">
                    {{ mfo.mfo_desc }}
                </option>
            </select>
            <button class="btn btn-sm btn-danger mT-5 text-white" @click="clearFilter">Clear Filter</button>
        </filtering> -->
        <div class="masonry-sizer col-md-6"></div>
        <div class="masonry-item w-100">
            <div class="row gap-20"></div>
            <div class="bgc-white p-20 bd">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered border-dark table-hover">
                        <thead>
                            <tr style="background-color: #B7DEE8;" class="text-center table-bordered">
                                <th style="width: 5%;" rowspan="2" colspan="1">IPCR Code</th>
                                <th style="width: 15%;" rowspan="2" colspan="1">Major Final Output</th>
                                <th style="width: 30%;" rowspan="2" colspan="1">Success Indicator</th>
                                <th style="width: 20%;" colspan="4">Rating</th>
                                <th style="width: 20%;" rowspan="2" colspan="1">Remarks</th>
                                <th rowspan="2" colspan="1"></th>
                            </tr>
                            <tr style="background-color: #B7DEE8;" class="text-center">
                                <th style="width: 5%;">Quantity Rating</th>
                                <th style="width: 5%;">Quality Rating</th>
                                <th style="width: 5%;">Timeliness Rating</th>
                                <th style="width: 5%;">Average</th>
                            </tr>
                            <tr>

                            </tr>
                        </thead>
                        <tbody>
                            <!--CORE FUNCTION-->
                            <tr>
                                <!-- <td colspan="9">
                                        <b>CORE FUNCTION</b> -->
                                <td colspan="9">
                                    <b>CORE FUNCTION</b>
                                </td>
                            </tr>
                            <template v-for="(dat, index) in data" :key="index">
                                <tr v-if="dat.ipcr_type === 'Core Function'"
                                    :class="{ opened: opened.includes(dat.ipcr_code) }" class="text-center">
                                    <td @click="toggle(dat, index)"
                                        style="cursor: pointer; background-color: lightblue">{{ dat.ipcr_code }}</td>
                                    <td>{{ dat.mfo_desc }}</td>
                                    <td>{{ dat.success_indicator }}</td>
                                    <td>
                                        {{ dat.result.length == 0 ? 0 : QuantityRate(dat.quantity_type,
                GetSumQuantity(dat.result), dat.quantity_sem)
                                        }}

                                    </td>
                                    <td>
                                        {{ dat.result.length == 0 ? 0 : QualityRating(dat.quality_error,
                QualityTypes(dat.quality_error,
                    GetSumQuality(dat.result), CountMonth(dat.result))) }}
                                    </td>

                                    <td>{{ TimeRatings(AveTime(TotalTime(dat.result), GetSumQuantity(dat.result)),
                dat.TimeRange, dat.time_range_code) }}
                                    </td>
                                    <td>{{ AverageRate(dat.result.length == 0 ? 0 : QuantityRate(dat.quantity_type,
                GetSumQuantity(dat.result),
                dat.quantity_sem), dat.result.length == 0 ? 0 : QualityRating(dat.quality_error,
                    QualityTypes(dat.quality_error,
                        GetSumQuality(dat.result), CountMonth(dat.result))),
                TimeRatings(AveTime(TotalTime(dat.result), GetSumQuantity(dat.result)),
                    dat.TimeRange, dat.time_range_code)) }}
                                    </td>
                                    <td>{{ dat.remarks }}</td>
                                    <td><button v-if="dat.remarks == null"
                                            class="btn btn-primary btn-sm mL-2 text-white"
                                            @click="showModal2(dat.ipcr_code, dat.ipcr_semester_id, dat.year)">Add
                                            Remarks</button>
                                        <button v-else class="btn btn-primary btn-sm mL-2 text-white"
                                            @click="showModal3(dat.ipcr_code, dat.ipcr_semester_id, dat.remarks, dat.remarks_id)">Edit/Delete
                                            Remarks</button>
                                    </td>

                                </tr>
                                <tr v-if="opened.includes(dat.ipcr_code) && dat.ipcr_type === 'Core Function'">
                                    <td colspan="9" class="background-white">
                                        <Transition name="bounce">
                                            <p v-if="show[index]">
                                            <table
                                                class="table-responsive full-width table-bordered border-dark text-center">
                                                <tbody>
                                                    <tr>
                                                        <th class="text-white text-center "
                                                            style="background-color: #727272;" colspan="31">
                                                            <h6>&nbsp;&nbsp;Accomplishment</h6>
                                                        </th>
                                                    </tr>
                                                </tbody>
                                                <tbody>
                                                    <tr>
                                                        <th> </th>
                                                        <th></th>
                                                        <th style="padding: 5px;">Target</th>
                                                        <th style="padding: 5px;">1</th>
                                                        <th style="padding: 5px;">2</th>
                                                        <th style="padding: 5px;">3</th>
                                                        <th style="padding: 5px;">4</th>
                                                        <th style="padding: 5px;">5</th>
                                                        <th style="padding: 5px;">6</th>
                                                        <th style="padding: 5px;">Total</th>
                                                        <th style="padding: 5px;">Percentage</th>
                                                        <th> </th>
                                                        <th> </th>
                                                        <th style="padding: 5px;">1</th>
                                                        <th style="padding: 5px;">2</th>
                                                        <th style="padding: 5px;">3</th>
                                                        <th style="padding: 5px;">4</th>
                                                        <th style="padding: 5px;">5</th>
                                                        <th style="padding: 5px;">6</th>
                                                        <th>Total Error/Average Feedback </th>
                                                        <th>Rating </th>
                                                        <th>Time Type</th>
                                                        <th>Prescribed Period</th>
                                                        <th style="padding: 5px;">1</th>
                                                        <th style="padding: 5px;">2</th>
                                                        <th style="padding: 5px;">3</th>
                                                        <th style="padding: 5px;">4</th>
                                                        <th style="padding: 5px;">5</th>
                                                        <th style="padding: 5px;">6</th>
                                                        <th style="padding: 5px;">Total</th>
                                                        <th>Ave. Time per Doc/Activity</th>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 5px;">{{ dat.quantity_type }}</td>
                                                        <td>{{ QuantityType(dat.quantity_type) }}</td>
                                                        <td>{{ dat.quantity_sem }}</td>
                                                        <td><span v-html="getScore(dat.result, 1, 7)"></span></td>
                                                        <td><span v-html="getScore(dat.result, 2, 8)"></span></td>
                                                        <td><span v-html="getScore(dat.result, 3, 9)"></span></td>
                                                        <td><span v-html="getScore(dat.result, 4, 10)"></span></td>
                                                        <td><span v-html="getScore(dat.result, 5, 11)"></span></td>
                                                        <td><span v-html="getScore(dat.result, 6, 12)"></span></td>
                                                        <td>
                                                            <span v-html="GetSumQuantity(dat.result)"></span>
                                                        </td>
                                                        <td>
                                                            {{
                dat.quantity_sem === "0"
                    ? ""
                    : (GetSumQuantity(dat.result) / dat.quantity_sem *
                        100).toFixed(0) + "%"
            }}
                                                        </td>
                                                        <td style="padding: 5px;">{{ dat.quality_error }}</td>
                                                        <td>{{ QualityType(dat.quality_error) }}</td>
                                                        <td><span
                                                                v-html="getQuality(dat.result, 1, 7, dat.quality_error)"></span>
                                                        </td>
                                                        <td><span
                                                                v-html="getQuality(dat.result, 2, 8, dat.quality_error)"></span>
                                                        </td>
                                                        <td><span
                                                                v-html="getQuality(dat.result, 3, 9, dat.quality_error)"></span>
                                                        </td>
                                                        <td><span
                                                                v-html="getQuality(dat.result, 4, 10, dat.quality_error)"></span>
                                                        </td>
                                                        <td><span
                                                                v-html="getQuality(dat.result, 5, 11, dat.quality_error)"></span>
                                                        </td>
                                                        <td><span
                                                                v-html="getQuality(dat.result, 6, 12, dat.quality_error)"></span>
                                                        </td>
                                                        <td>{{ QualityTypes(dat.quality_error,
                GetSumQuality(dat.result), CountMonth(dat.result)) }}
                                                        </td>
                                                        <td>{{ dat.result.length == 0 ? 0 :
                QualityRating(dat.quality_error,
                    QualityTypes(dat.quality_error, GetSumQuality(dat.result),
                        CountMonth(dat.result))) }}</td>
                                                        <td>{{ dat.time_based }}</td>
                                                        <td>{{ dat.time_range_code === 56 ? "Not to be Rated" :
                "Prescribed Period is " + dat.prescribed_period
                + " " +
                dat.time_unit }}
                                                        </td>
                                                        <td><span v-html="getTime(dat.result, 1, 7)"></span>
                                                        </td>
                                                        <td><span v-html="getTime(dat.result, 2, 8)"></span>
                                                        </td>
                                                        <td><span v-html="getTime(dat.result, 3, 9)"></span>
                                                        </td>
                                                        <td><span v-html="getTime(dat.result, 4, 10)"></span>
                                                        </td>
                                                        <td><span v-html="getTime(dat.result, 5, 11)"></span>
                                                        </td>
                                                        <td><span v-html="getTime(dat.result, 6, 12)"></span>
                                                        </td>
                                                        <td><span v-html="TotalTime(dat.result)"></span></td>
                                                        <td><span
                                                                v-html="AveTime(TotalTime(dat.result), GetSumQuantity(dat.result))"></span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            </p>
                                        </Transition>
                                    </td>
                                </tr>



                            </template>
                            <!-- //SUPPORT -->
                            <tr>
                                <td colspan="9">
                                    <b>Support FUNCTION </b>
                                </td>
                            </tr>
                            <template v-for="(dat, index) in data" :key="index">
                                <tr v-if="dat.ipcr_type === 'Support Function'"
                                    :class="{ opened: opened.includes(dat.ipcr_code) }" class="text-center">
                                    <td @click="toggle(dat, index)"
                                        style="cursor: pointer; background-color: lightblue">{{ dat.ipcr_code }}</td>
                                    <td>{{ dat.mfo_desc }}</td>
                                    <td>{{ dat.success_indicator }}</td>
                                    <td>
                                        {{ dat.result.length == 0 ? 0 : QuantityRate(dat.quantity_type,
                GetSumQuantity(dat.result),
                dat.quantity_sem) }}

                                    </td>
                                    <td>
                                        {{ dat.result.length == 0 ? 0 : QualityRating(dat.quality_error,
                QualityTypes(dat.quality_error,
                    GetSumQuality(dat.result), CountMonth(dat.result))) }}
                                    </td>
                                    <td>{{ TimeRatings(AveTime(TotalTime(dat.result), GetSumQuantity(dat.result)),
                dat.TimeRange, dat.time_range_code) }}
                                    </td>
                                    <td>{{ AverageRate(dat.result.length == 0 ? 0 : QuantityRate(dat.quantity_type,
                GetSumQuantity(dat.result),
                dat.quantity_sem), dat.result.length == 0 ? 0 : QualityRating(dat.quality_error,
                    QualityTypes(dat.quality_error,
                        GetSumQuality(dat.result), CountMonth(dat.result))),
                TimeRatings(AveTime(TotalTime(dat.result), GetSumQuantity(dat.result)),
                    dat.TimeRange, dat.time_range_code)) }} </td>

                                    <td>{{ dat.remarks }}</td>
                                    <td><button v-if="dat.remarks == null"
                                            class="btn btn-primary btn-sm mL-2 text-white"
                                            @click="showModal2(dat.ipcr_code, dat.ipcr_semester_id, dat.year)">Add
                                            Remarks</button>
                                        <button v-else class="btn btn-primary btn-sm mL-2 text-white"
                                            @click="showModal3(dat.ipcr_code, dat.ipcr_semester_id, dat.remarks, dat.remarks_id)">Edit/Delete
                                            Remarks</button>
                                    </td>

                                </tr>
                                <tr v-if="opened.includes(dat.ipcr_code) && dat.ipcr_type === 'Support Function'">
                                    <td colspan="9" class="background-white">
                                        <Transition name="bounce">
                                            <p v-if="show[index]">
                                            <table
                                                class="table-responsive full-width table-bordered border-dark text-center">
                                                <tbody>
                                                    <tr>
                                                        <th class="text-white text-center "
                                                            style="background-color: #727272;" colspan="31">
                                                            <h6>&nbsp;&nbsp;Accomplishment</h6>
                                                        </th>
                                                    </tr>
                                                </tbody>
                                                <tbody>
                                                    <tr>
                                                        <th> </th>
                                                        <th></th>
                                                        <th style="padding: 5px;">Target</th>


                                                        <th style="padding: 5px; border-right:1px solid; ">1</th>
                                                        <th
                                                            style="padding: 5px; border-right:1px solid; border-left:1px solid">
                                                            2</th>
                                                        <th
                                                            style="padding: 5px; border-right:1px solid; border-left:1px solid">
                                                            3</th>
                                                        <th
                                                            style="padding: 5px; border-right:1px solid; border-left:1px solid">
                                                            4</th>
                                                        <th
                                                            style="padding: 5px; border-right:1px solid; border-left:1px solid">
                                                            5</th>
                                                        <th style="padding: 5px;  border-left:1px solid">6</th>


                                                        <th style="padding: 5px;">Total</th>
                                                        <th style="padding: 5px;">Percentage</th>
                                                        <th> </th>
                                                        <th> </th>
                                                        <th style="padding: 5px;">1</th>
                                                        <th style="padding: 5px;">2</th>
                                                        <th style="padding: 5px;">3</th>
                                                        <th style="padding: 5px;">4</th>
                                                        <th style="padding: 5px;">5</th>
                                                        <th style="padding: 5px;">6</th>
                                                        <th>Total Error/Average Feedback </th>
                                                        <th>Rating </th>
                                                        <th>Time Type</th>
                                                        <th>Prescribed Period</th>
                                                        <th style="padding: 5px;">1</th>
                                                        <th style="padding: 5px;">2</th>
                                                        <th style="padding: 5px;">3</th>
                                                        <th style="padding: 5px;">4</th>
                                                        <th style="padding: 5px;">5</th>
                                                        <th style="padding: 5px;">6</th>
                                                        <th style="padding: 5px;">Total</th>
                                                        <th>Ave. Time per Doc/Activity</th>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 5px;">{{ dat.quantity_type }}</td>
                                                        <td>{{ QuantityType(dat.quantity_type) }}</td>
                                                        <td>{{ dat.quantity_sem }}</td>
                                                        <td><span v-html="getScore(dat.result, 1, 7)"></span></td>
                                                        <td><span v-html="getScore(dat.result, 2, 8)"></span></td>
                                                        <td><span v-html="getScore(dat.result, 3, 9)"></span></td>
                                                        <td><span v-html="getScore(dat.result, 4, 10)"></span></td>
                                                        <td><span v-html="getScore(dat.result, 5, 11)"></span></td>
                                                        <td><span v-html="getScore(dat.result, 6, 12)"></span></td>
                                                        <td><span v-html="GetSumQuantity(dat.result)"></span></td>
                                                        <td>
                                                            {{
                dat.quantity_sem === "0"
                    ? ""
                    : (GetSumQuantity(dat.result) / dat.quantity_sem *
                        100).toFixed(0) + "%"
            }}
                                                        </td>
                                                        <td style="padding: 5px;">{{ dat.quality_error }}</td>
                                                        <td>{{ QualityType(dat.quality_error) }}</td>
                                                        <td><span
                                                                v-html="getQuality(dat.result, 1, 7, dat.quality_error)"></span>
                                                        </td>
                                                        <td><span
                                                                v-html="getQuality(dat.result, 2, 8, dat.quality_error)"></span>
                                                        </td>
                                                        <td><span
                                                                v-html="getQuality(dat.result, 3, 9, dat.quality_error)"></span>
                                                        </td>
                                                        <td><span
                                                                v-html="getQuality(dat.result, 4, 10, dat.quality_error)"></span>
                                                        </td>
                                                        <td><span
                                                                v-html="getQuality(dat.result, 5, 11, dat.quality_error)"></span>
                                                        </td>
                                                        <td><span
                                                                v-html="getQuality(dat.result, 6, 12, dat.quality_error)"></span>
                                                        </td>
                                                        <td>{{ QualityTypes(dat.quality_error,
                GetSumQuality(dat.result), CountMonth(dat.result)) }}
                                                        </td>
                                                        <td>{{ dat.result.length == 0 ? 0 :
                                                            QualityRating(dat.quality_error,
                                                            QualityTypes(dat.quality_error, GetSumQuality(dat.result),
                                                            CountMonth(dat.result))) }}</td>
                                                        <td>{{ dat.time_based }}</td>
                                                        <td>{{ dat.time_range_code === 56 ? "Not to be Rated" :
                                                            "Prescribed Period is " + dat.prescribed_period
                                                            + " " + dat.time_unit }}
                                                        </td>
                                                        <td><span v-html="getTime(dat.result, 1, 7)"></span>
                                                        </td>
                                                        <td><span v-html="getTime(dat.result, 2, 8)"></span>
                                                        </td>
                                                        <td><span v-html="getTime(dat.result, 3, 9)"></span>
                                                        </td>
                                                        <td><span v-html="getTime(dat.result, 4, 10)"></span>
                                                        </td>
                                                        <td><span v-html="getTime(dat.result, 5, 11)"></span>
                                                        </td>
                                                        <td><span v-html="getTime(dat.result, 6, 12)"></span></td>
                                                        <td><span v-html="TotalTime(dat.result)"></span></td>
                                                        <td><span
                                                                v-html="AveTime(TotalTime(dat.result), GetSumQuantity(dat.result))"></span>
                                                        </td>

                                                    </tr>

                                                </tbody>
                                            </table>
                                            </p>
                                        </Transition>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <!-- <div class="row justify-content-center">
                    <div class="col-md-12">
                        <pagination :next="data.next_page_url" :prev="data.prev_page_url" />
                    </div>
                </div> -->
                <!-- <div class="row justify-content-center">
                    <div class="col-md-12">
                        <p>
                            {{ data.from }} to {{ data.to }} of
                            {{ data.total }} entries
                        </p>
                    </div>
                </div> -->
            </div>
        </div>

        <Modal v-if="displayModal" @close-modal-event="hideModal">
            <div class="d-flex justify-content-center">
                <!-- {{ my_link }} -->
                <iframe :src="my_link" style="width:100%; height:450px" />
            </div>
        </Modal>

        <Modal v-if="displayModal1" @close-modal-event="hideModal1">
            <div class="d-flex justify-content-center">
                <iframe :src="my_link" style="width:100%; height:450px" />
            </div>
        </Modal>

        <Modals v-if="displayModal2" @close-modal-event="hideModal2">
            <input type="text" v-model="form.remarks" class="form-control" autocomplete="chrome-off"><br>
            <!-- <button class="btn btn-primary btn-sm mL-2 text-white" @click="submit()">Save Remarks</button> -->

            <span v-if="form.remarks_id === ''">
                <button class="btn btn-primary btn-sm mL-2 text-white" @click="submit()">Add Remarks</button>
            </span>
            <span v-else>
                <button class="btn btn-primary btn-sm mL-2 text-white" @click="edit()">Edit Remarks</button>
                <button class="btn btn-primary btn-sm mL-2 text-white"
                    @click="deleteOutput(form.remarks_id, form.idSemestral)">Delete Remarks</button>
            </span>

        </Modals>
    </div>
</template>
<script>

import { useForm } from "@inertiajs/inertia-vue3";
import Filtering from "@/Shared/Filter";
import FilterPrinting from "@/Shared/FilterPrint";
import Pagination from "@/Shared/Pagination";
import Modal from "@/Shared/PrintModal";
import Modals from "@/Shared/Modal"
export default {
    props: {
        auth: Object,
        emp_code: Object,
        sem_data: Object,
        sem_id: String,
        month: Object,
        data: Object,
        month_data: Object,
        dept: Object,
        pghead: Object
    },
    data() {
        return {
            // search: this.$props.filters.search,
            // filter: false,
            filter_p: false,
            displayModal: false,
            displayModal1: false,
            displayModal2: false,
            my_link: "",
            year: "",
            opened: [],
            // show: false,
            show: [],
            Average_Point_Core: 0,
            Average_Point_Support: 0,
            Average_Core: 0,
            Average_Support: 0,
            rating_data: {},
            form: useForm({
                remarks: "",
                remarks_id: "",
                year: "",
                idIPCR: "",
                idSemestral: "",
                emp_code: "",
            })
            // mfosel: "",
        }
    },
    watch: {
        //     search: _.debounce(function (value) {
        //     this.$inertia.get(
        //         "/AddAccomplishment",
        //         { search: value },
        //         {
        //             preserveScroll: true,
        //             preserveState: true,
        //             replace: true,
        //         }
        //     );
        // }, 300),
    },
    components: {
        Pagination, Filtering, Modal, FilterPrinting, Modals,
    },
    mounted() {
        this.calculateAverageCore()
        this.calculateAverageSupport()
        this.setShow()
    },
    methods: {
        submit() {
            var url = "/semester-accomplishment/store"
            // alert('for store '+url);
            this.form.post(url);

            this.displayModal2 = false;

            this.form.remarks = "";
        },
        edit() {
            this.form.patch("/semester-accomplishment/" + this.form.remarks_id, this.form);
            this.form.remarks_id = "";
            this.displayModal2 = false;
        },
        deleteOutput(id) {
            this.$inertia.delete("/semester-accomplishment/" + id);
            this.form.remarks_id = "";
            this.displayModal2 = false;
        },
        showFilter() {
            //alert("show filter");
            this.filter = !this.filter
        },
        showFilterP() {
            // alert("show filter");
            this.filter_p = !this.filter_p
        },
        AverageScore() {

        },
        showModal2(idIPCR, ipcr_semester, year) {
            this.form.year = year;
            // this.form.month = this.month;
            this.form.emp_code = this.emp_code;
            this.form.idIPCR = idIPCR;
            this.form.idSemestral = ipcr_semester;
            // alert(this.form.month);
            this.displayModal2 = true;
            this.form.remarks = "";
            this.form.remarks_id = "";
        },
        showModal3(idIPCR, ipcr_semester, remarks, id) {
            this.form.year = this.year;
            this.form.emp_code = this.emp_code;
            this.form.idIPCR = idIPCR;
            this.form.idSemestral = ipcr_semester;
            this.form.remarks = remarks;
            this.form.remarks_id = id;

            this.displayModal2 = true;
        },
        hideModal2() {
            this.displayModal2 = false;
        },
        getScore(Item, month1, month2) {
            var result = _.find(Item, obj => {
                return obj.month == month1 || obj.month == month2;
            });

            return result ? result.quantity : ''
        },
        getQuality(Item, month1, month2, type) {
            if (type == 1) {
                var result = _.find(Item, obj => {
                    return obj.month == month1 || obj.month == month2;
                });

                return result ? result.average_quality : ''
            } else if (type == 2) {
                var result = _.find(Item, obj => {
                    return obj.month == month1 || obj.month == month2;
                });

                return result ? result.average_quality : ''
            }
        },
        getTime(Item, month1, month2) {
            var result = _.find(Item, obj => {
                return obj.month == month1 || obj.month == month2;
            });

            return result ? result.average_time : ''
        },
        GetSumQuantity(Item) {
            var result = _.sumBy(Item, (o) => {
                return Number(o.quantity)
            });
            return result;
        },
        GetSumQuality(Item) {
            var result = _.sumBy(Item, (o) => {
                return Number(o.average_quality)
            });
            return result;


        },
        CountMonth(Item) {
            var result = Item.length
            return result;
        },
        TotalTime(Item) {
            var result = _.sumBy(Item, obj => {
                return obj.average_time ? obj.average_time * obj.quantity : 0;
            })

            return result;
        },
        MonthlyAveTime(Time, TotalQuantity) {
            var Time = Time
            var TotalQuantity = TotalQuantity
            var Result
            console.log(Time);
            console.log(TotalQuantity)
            if (Time == 0 && TotalQuantity == 0) {
                Result = ""
            } else {
                Result = Math.round(Number(Time /
                    TotalQuantity))
            }
            return Result;
        },
        AveTime(Time, TotalQuantity) {
            var Time = Time
            var TotalQuantity = TotalQuantity
            var Result
            if (Time == 0 && TotalQuantity == 0) {
                Result = 0
            } else {
                Result = Math.round(Number(Time /
                    TotalQuantity))
            }
            return Result;
        },
        QuantityRate(id, quantity, target) {
            var result;
            if (id == 1) {
                var total = Math.round((quantity / target) * 100)
                if (total >= 130) {
                    result = "5"
                } else if (total <= 129 && total >= 115) {
                    result = "4"
                } else if (total <= 114 && total >= 90) {
                    result = "3"
                } else if (total <= 89 && total >= 51) {
                    result = "2"
                } else if (total <= 50) {
                    result = "1"
                } else
                    result = "0"
            } else if (id == 2) {
                if (quantity == target) {
                    result = 5
                } else {
                    result = 2
                }
            }
            return result;
        },
        QualityRate(id, total) {
            var result;
            if (id == 1) {
                if (total == 0) {
                    result = "5"
                } else if (total >= .01 && total <= 2.99) {
                    result = "4"
                } else if (total >= 3 && total <= 4.99) {
                    result = "3"
                } else if (total >= 5 && total <= 6.99) {
                    result = "2"
                } else if (total >= 7) {
                    result = "1"
                } else {
                    result = "0"
                }
            } else if (id == 2) {
                if (total == 5) {
                    result = "5"
                } else if (total >= 4 && total <= 4.99) {
                    result = "4"
                } else if (total >= 3 && total <= 3.99) {
                    result = "3"
                } else if (total >= 2 && total <= 2.99) {
                    result = "2"
                } else if (total >= 1 && total <= 1.99) {
                    result = "1"
                } else {
                    result = "0"
                }
            } else if (id == 3) {
                result = "0"
            } else if (id == 4) {
                if (total >= 1) {
                    result = "2"
                } else {
                    result = "5"
                }
            }
            return result;
        },
        QuantityType(id) {
            var result;
            if (id == 1) {
                result = "TO BE RATED"
            } else {
                result = "ACCURACY RULE (100%=5,2 if less than 100%)"
            }
            return result;
        },
        QualityType(id) {
            var result;
            if (id == 1) {
                result = "NO. OF ERROR"
            } else if (id == 2) {
                result = "AVE. FEEDBACK"
            } else if (id == 3) {
                result = "NOT TO BE RATED"
            } else if (id == 4) {
                result = "ACCURACY RULE"
            }
            return result;
        },
        SemName(id) {
            var result;
            if (id == 1) {
                result = "January to June"
            } else {
                result = "July to December"
            }

            return result;
        },
        QualityTypes(quality_type, score, length) {
            var result;
            if (quality_type == 1) {
                result = score;
            } else if (quality_type == 2) {
                if (length == 0) {
                    result = 0;
                } else {
                    result = Math.round(score / length);
                }
            } else if (quality_type == 3) {
                result = score;
            } else if (quality_type == 4) {
                result = score;
            }
            return result;
        },
        QualityRating(quality_type, quality_score) {
            var result;
            if (quality_type == 1) {
                if (quality_score == 0) {
                    result = "5"
                } else if (quality_score >= .01 && quality_score <= 2.99) {
                    result = "4"
                } else if (quality_score >= 3 && quality_score <= 4.99) {
                    result = "3"
                } else if (quality_score >= 5 && quality_score <= 6.99) {
                    result = "2"
                } else if (quality_score >= 7) {
                    result = "1"
                } else {
                    result = "0"
                }
            } else if (quality_type == 2) {
                if (quality_score == 5) {
                    result = "5"
                } else if (quality_score >= 4 && quality_score <= 4.99) {
                    result = "4"
                } else if (quality_score >= 3 && quality_score <= 3.99) {
                    result = "3"
                } else if (quality_score >= 2 && quality_score <= 2.99) {
                    result = "2"
                } else if (quality_score >= 1 && quality_score <= 1.99) {
                    result = "1"
                } else {
                    result = "0"
                }
            } else if (quality_type == 3) {
                result = "0"
            } else if (quality_type == 4) {
                if (quality_score >= 1) {
                    result = "2"
                } else {
                    result = "5"
                }
            }

            return result;
        },
        AverageRate(QuantityRating, QualityRating, TimeRating) {
            // alert(TimeRating)

            if (TimeRating == " ") {
                TimeRating = 0;
            }
            var ratings = [parseFloat(QuantityRating), parseFloat(QualityRating), parseFloat(TimeRating)];

            var NotZero = ratings.filter(rating => rating !== 0);

            if (NotZero.length === 0) {
                return 0; // or any default value when all ratings are zero
            }

            const average = NotZero.reduce((sum, rating) => sum + rating, 0) / NotZero.length;


            return this.format_number_conv(average, 2, true)


        },
        TimeRatings(Ave_Time, Range, Time_Code) {
            // alert(Range);
            var result;
            var EQ;

            if (Time_Code == 56) {
                result = " ";
            } else {
                Range.map(Item => {
                    if (Ave_Time <= Item.equivalent_time_from && Item.rating == 5) {
                        result = 5;
                        EQ = Item.equivalent_time_from;
                    } else if (Ave_Time >= Item.equivalent_time_from && Ave_Time <= Item.equivalent_time_to && Item.rating == 4) {
                        result = 4;
                        EQ = Item.equivalent_time_from;
                    } else if (Ave_Time == Item.equivalent_time_from && Item.rating == 3) {
                        result = 3;
                        EQ = Item.equivalent_time_from;
                    } else if (Ave_Time >= Item.equivalent_time_from && Ave_Time <= Item.equivalent_time_to && Item.rating == 2) {
                        result = 2;
                        EQ = Item.equivalent_time_from;
                    } else if (Ave_Time >= Item.equivalent_time_from && Item.rating == 1) {
                        result = 1;
                        EQ = Item.equivalent_time_from;
                    } else if (Ave_Time == 0) {
                        result = 0;
                    }
                })
            }
            return result;
        },
        calculateAverageCore() {
            let sum = 0;
            let num_of_data = 0;
            let average = 0;

            if (Array.isArray(this.data)) {
                this.data.forEach(item => {
                    if (item.ipcr_type === 'Core Function') {
                        var val = this.AverageRate(item.result == 0 ? 0 : this.QuantityRate(item.quantity_type, this.GetSumQuantity(item.result),
                            item.quantity_sem), item.result == 0 ? 0 : this.QualityRating(item.quality_error, this.QualityTypes(item.quality_error,
                                this.GetSumQuality(item.result), this.CountMonth(item.result))),
                            this.TimeRatings(this.AveTime(this.TotalTime(item.result), this.GetSumQuantity(item.result)), item.TimeRange, item.time_range_code));
                        // alert(val);
                        // alert(this.TimeRatings(this.AveTime(this.TotalTime(item.result), this.GetSumQuantity(item.result)), item.TimeRange, item.time_range_code));
                        if (val !== 0) {
                            num_of_data += 1;
                            sum += parseFloat(val);
                            average = sum / num_of_data
                        }
                    }
                });
            }

            this.Average_Point_Core = average.toFixed(2);

        },
        calculateAverageSupport() {
            let sum = 0;
            let num_of_data = 0;
            let average = 0;
            if (Array.isArray(this.data)) {
                this.data.forEach(item => {
                    if (item.ipcr_type === 'Support Function') {
                        var val = this.AverageRate(item.result == 0 ? 0 : this.QuantityRate(item.quantity_type, this.GetSumQuantity(item.result),
                            item.quantity_sem), item.result == 0 ? 0 : this.QualityRating(item.quality_error, this.QualityTypes(item.quality_error,
                                this.GetSumQuality(item.result), this.CountMonth(item.result))),
                            this.TimeRatings(this.AveTime(this.TotalTime(item.result), this.GetSumQuantity(item.result)), item.TimeRange, item.time_range_code));
                        // alert(val);
                        if (val !== 0) {
                            num_of_data += 1;
                            sum += parseFloat(val);
                            average = sum / num_of_data
                        }
                    }
                });
            }

            this.Average_Point_Support = average.toFixed(2);
        },

        showCreate() {
            this.$inertia.get(
                "/targets/create",
                {
                    raao_id: this.raao_id
                },
                {
                    preserveScroll: true,
                    preserveState: true,
                    replace: true,
                }
            )
        },
        getAccomplishment(tar_id) {
            this.$inertia.get(
                "/accomplishments",
                {
                    idtarget: tar_id
                },
                {
                    preserveScroll: true,
                    preserveState: true,
                    replace: true,
                }
            );
        },
        getPercent(accomp, targqty) {
            var accSum = 0;
            accomp.forEach(myFunction);
            function myFunction(item) {
                accSum += parseFloat(item.accomplishment_qty)
            }
            var percentt = (accSum / targqty) * 100
            percentt = this.format_number(percentt, 2, true)
            return percentt;
        },
        printSubmit1() {
            // alert(this.Average_Point_Core);
            //var office_ind = document.getElementById("selectOffice").selectedIndex;
            // this.office =this.auth.user.office.office;
            // var pg_head = this.functions.DEPTHEAD;
            // var forFFUNCCOD = this.auth.user.office.department_code;
            // alert(this.)
            this.my_link = this.viewlink1(this.sem_data.employee_code, this.auth.user.name.first_name + " " +
                this.auth.user.name.last_name, this.auth.user.name.employment_type_descr,
                this.auth.user.name.position_long_title, this.dept.office, " ",
                this.sem_data.imm.first_name + " " + this.sem_data.imm.last_name,
                this.sem_data.next.first_name + " " + this.sem_data.next.last_name,
                this.sem_data.sem, this.sem_data.year, this.sem_data.id,
                this.getPeriod(this.sem_data.sem, this.sem_data.year),
                this.pghead, '3.33', '4.55');
            // this.Average_Point_Core, this.Average_Point_Support
            this.showModal1();
        },
        viewlink1(emp_code, employee_name, emp_status, position, office, division, immediate, next_higher, sem, year, idsemestral, period, pghead, Average_Score) {


            //var linkt ="abcdefghijklo534gdmoivndfigudfhgdyfugdhfugidhfuigdhfiugmccxcxcxzczczxczxczxcxzc5fghjkliuhghghghaaa555l&&&&-";
            var linkt = "http://";
            var jasper_ip = this.jasper_ip;
            var jasper_link = 'jasperserver/flow.html?pp=u%3DJamshasadid%7Cr%3DManager%7Co%3DEMEA%2CSales%7Cpa1%3DSweden&_flowId=viewReportFlow&_flowId=viewReportFlow&ParentFolderUri=%2Freports%2FIPCR%2FIPCR_Semester&reportUnit=%2Freports%2FIPCR%2FIPCR_Semester%2FSemester_Accomplishment_part1&standAlone=true&decorate=no&output=pdf';
            var params = '&emp_code=' + emp_code + '&employee_name=' + employee_name +
                '&emp_status=' + emp_status + '&position=' + position +
                '&office=' + office + '&division=' + division + '&immediate=' + immediate +
                '&next_higher=' + next_higher + '&sem=' + sem + '&year=' + year +
                '&idsemestral=' + idsemestral + '&period=' + period + '&pghead=' + pghead +
                '&Average_Point_Core=' + this.Average_Point_Core +
                '&Average_Point_Support=' + this.Average_Point_Support + '&SemestralStatus=' + this.sem_data.status_accomplishment;

            var linkl = linkt + jasper_ip + jasper_link + params;
            console.log(params);
            return linkl;
        },
        showModal1() {
            this.displayModal = true;
        },
        hideModal1() {
            this.displayModal = false;
        },
        printSubmit() {

            //var office_ind = document.getElementById("selectOffice").selectedIndex;

            // this.office =this.auth.user.office.office;
            // var pg_head = this.functions.DEPTHEAD;
            // var forFFUNCCOD = this.auth.user.office.department_code; this.month
            this.my_link = this.viewlink(this.sem_data.employee_code,
                this.auth.user.name.first_name + " " + this.auth.user.name.last_name,
                this.auth.user.name.employment_type_descr, this.auth.user.name.position_long_title,
                this.dept.office, null, this.sem_data.imm.first_name + " " + this.sem_data.imm.last_name,
                null, this.sem_data.sem, this.sem_data.year, this.sem_data.id, "");

            this.showModal();
        },

        viewlink(emp_code, employee_name, emp_status, position, office, division, immediate, next_higher, sem, year, idsemestral, period) {
            var linkt = "http://";
            var jasper_ip = this.jasper_ip;
            var jasper_link = 'jasperserver/flow.html?pp=u%3DJamshasadid%7Cr%3DManager%7Co%3DEMEA%2CSales%7Cpa1%3DSweden&_flowId=viewReportFlow&_flowId=viewReportFlow&ParentFolderUri=%2Freports%2FIPCR%2FIPCR_Monthly&reportUnit=%2Freports%2FIPCR%2FIPCR_Monthly%2FMonthly_IPCR&standAlone=true&decorate=no&output=pdf';
            var params = '&emp_code=' + emp_code + '&employee_name=' + employee_name + '&emp_status=' + emp_status + '&position=' + position + '&office=' + office + '&division=' + division + '&immediate=' + immediate + '&next_higher=' + next_higher + '&sem=' + sem + '&year=' + year + '&idsemestral=' + idsemestral + '&period=' + period + '&Score=' + this.score;
            var linkl = linkt + jasper_ip + jasper_link + params;

            return linkl;
        },
        showModal() {
            this.displayModal = true;
        },
        hideModal() {
            this.displayModal = false;
        },
        setShow() {
            for (var x = 0; x < this.data.length; x++) {
                this.show.push(false);
            }
        },
        toggle(Item, i) {


            axios.post('/semester-accomplishment/get-time-ranges', { time_range_code: Item.time_range_code })
                .then(response => {
                    this.rating_data = response.data

                    const index = this.opened.indexOf(Item.ipcr_code);
                    if (index > -1) {
                        // this.opened.splice(index, 1)
                    } else {
                        this.opened = [];
                        this.opened.push(Item.ipcr_code)
                    }
                    // alert(this.show);
                    setTimeout(() => {
                        // alert(this.show);
                        // this.show = !this.show;
                        for (var t = 0; t < this.data.length; t++) {
                            if (i != t) {
                                this.show[t] = false
                            }

                        }
                        this.show[i] = !this.show[i];
                    }, 100);
                })

        },
        async filterData() {
            //alert(this.mfosel);

            this.$inertia.get(
                "/AddAccomplishment",
                {
                    mfosel: this.mfosel
                },
                {
                    preserveScroll: true,
                    preserveState: true,
                    replace: true,
                }
            );
        },
        clearFilter() {

            this.mfosel = "";
            this.search = "";
            this.filterData();
        },
        submitAccomplishmentFOrThisMonth() {
            // alert("submitAccomplishmentFOrThisMonth");
            let text = "Are you sure you want to submit this accomplishment?" + this.sem_id;
            // alert(text);
            if (confirm(text) == true) {
                this.$inertia.post('/semester-accomplishment/submit/ipcr/semestral/' + this.sem_id);
            } else {
                alert('undo')
            }
            //
        },
        recallAccomplishmentFOrThisMonth() {
            let text = "Are you sure you want to submit this accomplishment?" + this.sem_id;
            // alert(text);
            if (confirm(text) == true) {
                this.$inertia.post('/semester-accomplishment/submit/ipcr/semestral/recall/' + this.sem_id);
            } else {
                alert('undo')
            }
        }
    }
};
</script>
<style>
/***TABLE FULL WIDTH */
.full-width {
    width: 100%;
}

/**ACCORDION BEGIN*********************/
.my-table {
    width: 100%;
    border: 1px solid #ccc;
}

.my-td {
    padding: 2px;
    border: 1px solid #ccc;
}

.opened {
    background-color: rgb(2, 255, 251);
}


/**ACCORDION END*********************/
.row-centered {
    text-align: center;
}

.col-centered {
    display: inline-block;
    float: none;
    text-align: left;
    margin-right: -4px;
}

.pos {
    position: top;
    top: 240px;
}

/*TOGGLE FADE TRANSITION*/
.v-enter-active,
.v-leave-active {
    transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}

/* transition */
.bounce-enter-active {
    animation: bounce-in 0.5s;
}

.bounce-leave-active {
    animation: bounce-in 0.5s reverse;
}

@keyframes bounce-in {
    0% {
        transform: scale(0);
    }

    50% {
        transform: scale(1.1);
    }

    100% {
        transform: scale(1);
    }


}
</style>
