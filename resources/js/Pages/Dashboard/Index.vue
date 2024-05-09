<template>

    <Head>
        <title>Home</title>
    </Head>

    <h1 style="color: #26394a; font-weight: bold; font-family: verdana;">Performance Management</h1>
    <span v-if="canViewThis()">
        <!-- {{ dept_code }} -->
        Filter By Office:
        <select v-model="dept_code" @change="filterData">
            <option :value="empty_val"></option>
            <option v-for="office in offices" :value="office.department_code">
                {{ office.office }}
            </option>
        </select>
        <p></p>
    </span>

    <!-- {{ auth }} -->
    <div class="row gap-20 masonry pos-r">
        <div class="masonry-item w-100">
            <div class="row gap-20">
                <div class="col-md-3">
                    <div class="layers bd bgc-white p-10">
                        <div class="layer w-100 mB-10">
                            <table>
                                <tr>
                                    <td><a href="/dashboard" target="_blank">Last 30 Days</a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h1>{{ format_number_conv(last_30_days, 0, true) }}</h1>
                                        <p></p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="layers bd bgc-white p-10 ">
                        <div class="layer w-100 mB-10 lh-1">
                            <table>
                                <tr>
                                    <td><a href="/dashboard" target="_blank">Weekly</a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h1>{{ format_number_conv(week_current, 0, true) }}</h1>
                                        <span
                                            :class="week_mystat.toLowerCase() === 'increase' ? 'text-success' : 'text-danger'">
                                            {{ weeklyData }}
                                        </span>
                                        <!-- week status : {{ week_mystat }} -->
                                        <span v-if="week_mystat === 'increase'">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                fill="#32a852" class="bi bi-graph-up-arrow" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5" />
                                            </svg>
                                        </span>
                                        <span v-else>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                fill="#ff0a0a" class="bi bi-graph-down-arrow" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M10 11.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-4a.5.5 0 0 0-1 0v2.6l-3.613-4.417a.5.5 0 0 0-.74-.037L7.06 8.233 3.404 3.206a.5.5 0 0 0-.808.588l4 5.5a.5.5 0 0 0 .758.06l2.609-2.61L13.445 11H10.5a.5.5 0 0 0-.5.5" />
                                            </svg>
                                        </span>
                                    </td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="layers bd bgc-white p-10 ">
                        <div class="layer w-100 mB-10 lh-1">
                            <table>
                                <tr>
                                    <td><a href="/dashboard" target="_blank">Monthly</a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h1>{{ format_number_conv(current_month, 0, true) }}</h1>
                                        <span
                                            :class="month_mystat.toLowerCase() === 'increase' ? 'text-success' : 'text-danger'">
                                            {{ getStatusMonthly() }}
                                        </span>
                                        <!-- month status: {{ month_mystat }}
                                        <p>current_month: {{ current_month }} </p>
                                        <p>prev_month: {{ prev_month }} </p> -->
                                        <span v-if="month_mystat === 'increase'">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                fill="#32a852" class="bi bi-graph-up-arrow" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5" />
                                            </svg>
                                        </span>
                                        <span v-else>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                fill="#ff0a0a" class="bi bi-graph-down-arrow" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M10 11.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-4a.5.5 0 0 0-1 0v2.6l-3.613-4.417a.5.5 0 0 0-.74-.037L7.06 8.233 3.404 3.206a.5.5 0 0 0-.808.588l4 5.5a.5.5 0 0 0 .758.06l2.609-2.61L13.445 11H10.5a.5.5 0 0 0-.5.5" />
                                            </svg>
                                        </span>
                                    </td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="layers bd bgc-white p-10">
                        <div class="layer w-100 mB-10">
                            <table>
                                <tr>
                                    <td><a href="/dashboard" target="_blank">Total</a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h1>{{ format_number_conv(annual_current, 0, true) }}</h1>
                                        <p></p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="layers bd bgc-white p-10">
                        <div class="layer w-100 mB-10">
                            <table>
                                <tr>
                                    <td>
                                        <a href="/dashboard" target="_blank">Completed Tasks Trend
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <!-- <h1>{{ format_number_conv(annual_current, 0, true) }}</h1> -->
                                        <!-- <p></p> -->
                                        <linear-chart :chartData="linearData" :chartLabel="linearLabels"
                                            :plugins="chartOptionCom" :key="componentKey"></linear-chart>
                                        <!-- <p>last_30_days: {{ last_30_days }} </p>
                                        <p>week_current: {{ week_current }} </p>
                                        <p>week_prev_current: {{ week_prev_current }} </p>
                                        <p>annual_current: {{ annual_current }} </p>
                                        <p>current_month: {{ current_month }} </p>
                                        <p>prev_month: {{ prev_month }} </p>
                                        <p>twomonths_data: {{ twomonths_data }} </p>
                                        <p>{{ linearData }}</p>
                                        <p>{{ linearLabels }}</p> -->
                                    </td>
                                </tr>
                            </table>
                            <p></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="layers bd bgc-white p-10">
                        <div class="layer w-100 mB-10">
                            <div class="form-group row mb-3">
                                <div class="col-4">
                                    <a href="/dashboard" target="_blank">Total Tasks per Employee
                                    </a>
                                </div>
                                <div class="col-4">
                                    <label class="pull-right text-right">Filter By Month</label>
                                </div>
                                <div class="col-4">
                                    <select v-model="month_filter" @change="filterData()" class="form-control">
                                        <option value="" selected></option>
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                            </div>

                            <table class="table table-borderless">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>
                                            Employee Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        </th>
                                        <th>
                                            Tasks Count
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for=" task in tasks">
                                        <td>
                                            <!-- <h1>{{ format_number_conv(annual_current, 0, true) }}</h1> -->
                                            <!-- <p></p> -->
                                            {{ task.employee_name }}
                                        </td>
                                        <td>
                                            <!-- {{ dat.quantity }} -->
                                            <span v-if="task.quant > 0">{{ format_number_conv(task.quant, 0, true)
                                                }}</span>

                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                            <p></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import LinearChart from "@/Pages/Charts/LinearChart";
import { ref } from "vue";
// import LinearChart from "../Charts/LinearChart.vue";
const componentKey = ref(0);
export default {
    components: { LinearChart },
    props: {
        auth: Object,
        last_30_days: String,
        week_current: String,
        week_prev_current: String,
        annual_current: String,
        current_month: String,
        prev_month: String,
        twomonths_data: String,
        tasks: Object,
        offices: Object,
        my_dept_code: String,
        can_see: String
    },

    data() {
        return {
            stat_weekly: "increase",
            stat_monthly: "increase",
            month_now: "March",
            month_prev: "February",
            month_prev2: "January",
            dept_code: '',
            empty_val: '',
            month_filter: "",
            // currentMonth: "",
            // prevMonth1: "",
            // prevMonth2: "",
        }
    },
    computed: {
        linearLabels() {

            return [
                this.month_prev2,
                this.month_prev,
                this.month_now,


            ];
        },
        linearData() {
            return [
                {
                    label: "Completed Tasks",
                    backgroundColor: '#2196f3',
                    data: [this.twomonths_data, this.prev_month, this.current_month,],
                },
                // {
                //     label: this.month_prev,
                //     backgroundColor: '#f44336',
                //     data: [this.prev_month]
                // },
                // {   //#30345c  #F2F601
                //     label: this.month_prev2,
                //     backgroundColor: '#c8cf04',
                //     data: [this.twomonths_data]
                // }
            ];
        },
        chartOptionCom() {
            return {
                datalabels: {
                    display: false,

                },
            };
        },
        textColor() {
            return this.week_current > this.week_prev_current ? 'green' : 'red';
        },
        weeklyData() {
            return this.getStatusWeekly();
        },
        monthlyData() {
            return this.getStatusMonthly();
        },
        week_mystat() {
            return this.stat_weekly;
        },
        month_mystat() {
            return this.stat_monthly;
        }

    },
    mounted() {
        this.getDate();
    },

    methods: {
        getStatusWeekly() {
            var diff = this.week_current - this.week_prev_current;
            var percent = (diff / this.week_prev_current) * 100;
            if (diff < 0) {
                this.stat_weekly = "decrease";
                percent = percent * -1;
            } else {
                this.stat_weekly = "increase";
            }
            var form_prct = this.format_number_conv(percent, 2, true);
            return form_prct + "% " + this.stat_weekly + " from previous week ";
        },
        getStatusMonthly() {
            var diff = this.current_month - this.prev_month;
            // diff = -1233;
            var percent = (diff / this.prev_month) * 100;
            if (diff < 0) {
                this.stat_monthly = "decrease";
                percent = percent * -1;
            } else {
                this.stat_monthly = "increase";
            }
            var form_prct = this.format_number_conv(percent, 2, true);
            return form_prct + "% " + this.stat_monthly + " from previous month ";
        },
        forceRerender() {
            this.componentKey += 1;
        },
        getDate() {
            this.getStatusMonthly();
            this.getStatusWeekly();
            let month_arr = [];
            let currentDate = new Date();

            // Get the names of the current month and the two previous months
            this.month_now = currentDate.toLocaleString('default', { month: 'long' });
            // month_arr.push(currentMonth);
            currentDate.setMonth(currentDate.getMonth() - 1);

            this.month_prev = currentDate.toLocaleString('default', { month: 'long' });
            // month_arr.push(prevMonth1);

            currentDate.setMonth(currentDate.getMonth() - 1);
            this.month_prev2 = currentDate.toLocaleString('default', { month: 'long' });
            this.forceRerender();
            // month_arr.push(prevMonth2);
            // this.dept_code = this.my_dept_code
        },
        async filterData() {
            // this.nullify();
            // this.dept_code = this.my_dept_code
            this.$inertia.get(
                "/dashboard",
                {
                    dept_code: this.dept_code,
                    month: this.month_filter,
                },
                {
                    preserveScroll: true,
                    preserveState: true,
                    replace: true,
                }
            );
            this.getDate();
            this.forceRerender();

        },
        canViewThis() {
            //this.auth.user.name.department_code == '26' &&
            var can_see = false;
            // if (this.auth.user.name.salary_grade >= 18) {
            //     can_see = true;
            // }
            // if (this.auth.user.name.department_code == '03') {
            //     can_see = true;
            // }
            // 2730
            //
            if (this.auth.user.name.empl_id === '2730' || this.auth.user.name.empl_id === '2960' || this.auth.user.name.empl_id === '8510' || this.auth.user.name.empl_id === '8354') {
                can_see = true
            }
            return can_see;
        }
    }
};
</script>
<style>
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
</style>
