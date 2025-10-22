<template>

    <Head>
        <title>Home</title>
    </Head>

    <div
        style='background-image:url("images/Davao_De_Oro_Flag.jpg"); background-size: cover;background-position: center;background-repeat: no-repeat;min-height: 100vh; padding-left:10px !important; padding-top: 10px !important;'>
        <!--<p style="text-align: justify;">Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit amet consectetur.
    </p>-->
        <Link
            href="/Daily_Accomplishment/create"
            :class="[
                'btn',
                'btn-lg',
                { active: $page.url === '/Daily_Accomplishment' }
            ]"
            style="background-color: #edca25; color: #452b02; font-weight: bold; border: none;"
        >
            <span></span>
            <span class="title">Add Daily Accomplishment</span>
        </Link>

        <!-- <button class="btn btn-primary btn-lg text-white" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Open Modal
        </button> -->

        &nbsp;
        <span v-if="canViewThis()">
                <Link
                    class="btn btn-lg"
                    style="background-color: #edca25; color: #452b02; border: none; font-weight: bold;"
                    href="/dashboard"
                >
                    <span></span>
                    <span class="title">Analytics</span>
            </Link>
        </span>
        &nbsp;
        <span v-if="canSeeThis()">
            <Link class="btn btn-lg "
            style="background-color: #edca25; color: #452b02; border: none; font-weight: bold;"
            href="/dashboard/faos">
            <span></span>
            <span class="title">Frequently Asked Questions</span>
            </Link>
        </span>
        &nbsp;
        <!-- {{ auth.user.name.salary_grade }} -->
        <span v-if="auth.user.name.salary_grade >= 26">
            <Link class="btn btn-lg "
                style="background-color: #edca25; color: #452b02; border: none; font-weight: bold;"
                href="/dashboard/accomplishments">
                    <span></span>
                    <span class="title">Daily Accomplishments Monitoring</span>
            </Link>
        </span>
        <p></p>
        <p></p>
        <h1 style="color: #edca25;">Frequently Asked Questions</h1>
        <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000"
            style="min-height: 300px !important;">
            <div class="carousel-inner">
                <div class="carousel-item" v-for="(fao, index) in faos" :key="index" :class="{ 'active': index === 0 }">
                    <div class=" d-block w-50"
                        style="height: 100%; display: flex; justify-content: center; align-items: center; color: #edca25;">
                        <h4>Q. {{ fao.Questions }}</h4>
                        <p>A. {{ fao.Answers }}</p>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>

            </div>
        </div>

        <p></p>
        <p></p>

        {{ CheckCondition() }}
        <div class="col-md-8">
            <!-- bgc-white  -->
            <div class="layers bd p-10" style="background-color: rgba(255, 255, 255, 0.5);">
                <div class="layer w-100 mB-5">
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    <span style="font-weight: bold !important; color: #edca25">
                                        <a><b>Monthly Accomplishment Rating</b>
                                        </a>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <linear-chart :chartData="linearData" :chartLabel="linearLabels"
                                        :options="chartOptionCom" :key="componentKey"></linear-chart>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                    <p></p>
                </div>
            </div>
        </div>

        <div v-if="showModal" class="modal fade show" tabindex="-1" style="display: block;"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Privacy Notice</h5>
                    </div>
                    <div class="modal-body">
                        <!-- Use an iframe to display the PDF -->
                        <iframe src="images/Privacy-notice.pdf" style="width: 100%; height: 600px;"
                            frameborder="0"></iframe>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn text-white btn-primary" @click="submit()">I Agree</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
import LinearChart from "@/Pages/Charts/LinearChart1";
import { ref, vModelCheckbox } from "vue";
import { useForm } from '@inertiajs/inertia-vue3';
const componentKey = ref(0);
export default {
    components: { LinearChart },
    props: {
        auth: Object,
        data: Object,
        faos: Object,
        user_notice: Object,
        month: Array,
        ratings: Array
    },
    data() {
        return {
            showModal: false,
            numerical_rating: "",
            month: "",
            datas: [],
            test: [],
            form: useForm({

            })
        }
    },
    mounted() {
        this.Month();
        // this.CheckCondition();
    },
    computed: {
        linearLabels() {
            return [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];
        },
        linearData() {
            return [
                {
                    label: "Numerical Rating",
                    backgroundColor: '#FFD700',
                    data: this.ratings,
                },
            ];
        },
        chartOptionCom() {
    return {
        datalabels: {
            display: false,
        },
        scales: {
            xAxes: [{
                ticks: {
                    fontColor: '#FFD700'  // gold for X-axis months
                }
            }],
            yAxes: [{
                ticks: {
                    fontColor: '#FFD700'  // gold for Y-axis numbers
                }
            }]
        },
        legend: {
            labels: {
                fontColor: '#FFD700' // gold for legend
            }
        }
    };
},
    },

    methods: {
        submit() {
            // var currentDate = new Date();

            // var year = currentDate.getFullYear();
            // var month = (currentDate.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-based
            // var day = currentDate.getDate().toString().padStart(2, '0');

            // var formattedDate = `${year}-${month}-${day}`

            // this.form.current_date
            this.form.patch("/dashboard/notice/update/" + this.user_notice.id, this.form);
        },
        GetCurrentDate() {
            var currentDate = new Date();

            var year = currentDate.getFullYear();
            var month = (currentDate.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-based
            var day = currentDate.getDate().toString().padStart(2, '0');

            var formattedDate = `${year}-${month}-${day}`;
            console.log(formattedDate);
        },
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
        canSeeThis() {
            //
            var can_see = false;

            if (this.auth.user.name.empl_id === '2730' || this.auth.user.name.empl_id === '2960' || this.auth.user.name.empl_id === '8510' || this.auth.user.name.empl_id === '8354') {
                can_see = true
            }
            return can_see;
        },
        CheckCondition() {

            var currentDate = new Date();

            var year = currentDate.getFullYear();
            var month = (currentDate.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-based
            var day = currentDate.getDate().toString().padStart(2, '0');

            var notice = this.user_notice.date_of_notice;
            var formattedDate = `${year}-${month}-${day}`;

            // if (notice == formattedDate) {
            //     this.showModal = false;
            //     console.log(this.showModal);
            // } else {
            //     this.showModal = true;
            //     console.log(this.showModal);
            // }
            if (this.auth.impersonating == 'yes') {
                this.showModal = false;
            } else {
                if (notice == formattedDate) {
                    this.showModal = false;
                    console.log(this.showModal);
                } else {
                    this.showModal = true;
                    console.log(this.showModal);
                }
            }

        },
        Month() {
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
        },
        Update_Notice() {
            this.showModal = false;
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
