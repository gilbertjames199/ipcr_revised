<template>

    <Head>
        <title>Home</title>
    </Head>

    <div
        style='background-image:url("images/image.jpg"); background-size: cover;background-position: center;background-repeat: no-repeat;min-height: 100vh; padding-left:10px !important; padding-top: 10px !important;'>
        <!--<p style="text-align: justify;">Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit amet consectetur.
    </p>-->
        <button class="btn btn-primary btn-lg text-white">
            <Link class="sidebar-link" href="/Daily_Accomplishment/create"
                :class="{ 'active': $page.url === `/Daily_Accomplishment` }">
            <span></span>
            <span class="title text-white">Add Daily Accomplishment</span>
            </Link>
        </button>

        <!-- <button class="">

        </button> -->
        <p></p>
        <p></p>
        <span v-if="canViewThis()">
            <Link class="btn btn-primary btn-lg text-white" href="/dashboard">
            <span></span>
            <span class="title text-white">Charts and Statistics</span>
            </Link>
        </span>

        <p></p>
        <p></p>
        <div class="col-md-6">
            <div class="layers bd bgc-white p-10">
                <div class="layer w-100 mB-5">
                    <table>
                        <tr>
                            <td>
                                <a>Monthly Accomplishment Rating
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
    </div>


</template>
<script>
import LinearChart from "@/Pages/Charts/LinearChart1";
import { ref } from "vue";
const componentKey = ref(0);
export default {
    components: { LinearChart },
    props: {
        auth: Object,
        data: Object,
        month: Array,
        ratings: Array
    },
    data() {
        return {
            numerical_rating: "",
            month: "",
            datas: [],
            test: []
        }
    },
    mounted(){
        this.Month()
        console.log(this.datas)
        console.log([1, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,])
    },
    computed:{
        linearLabels(){
            return [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];
        },
        linearData() {
                return [
                    {
                        label: "Numerical Rating",
                        backgroundColor: '#2196f3',
                        data: this.ratings,
                    },
                ];
        },
        chartOptionCom() {
            return {
                datalabels: {
                    display: false,

                },
            };
        },
    },

    methods: {
        canViewThis() {
            //
            var can_see = false;

            if (this.auth.user.name.salary_grade >= 18) {
                can_see = true;
            }
            if (this.auth.user.name.empl_id === '2730' || this.auth.user.name.empl_id === '2960' || this.auth.user.name.empl_id === '8510' || this.auth.user.name.empl_id === '8354') {
                can_see = true
            }
            return can_see;
        },
        Month(){
            // this.datas = Array(12).fill(0);
            const itemArray = this.data;
            var month = _.flatMap(this.data, (o) => o.month)
            this.datas = month
            // console.log(month, 'month')
            // console.log(this.data, 'aa')
            // for(let i = 1; i <= 12; i++){
            //     itemArray.forEach((data, item) => {
            //         if(data.month == i){
            //         this.datas.push(data.numerical_rating);
            //         } else {
            //         this.datas.push(0)
            //         }

            //     });
            // }
            // console.log(itemArray);
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
