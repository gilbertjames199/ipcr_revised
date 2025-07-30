<template>

    <Head>
        <title>Home</title>
    </Head>

    <!--<p style="text-align: justify;">Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit amet consectetur.
    </p>-->
    <div class="row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h3>Semestral Accomplishment - {{ SemName(sem_data.sem) }}  {{ sem_data.year }} </h3>
            <!-- sem_data: {{ sem_data }} -->
            <!-- {{ emp_code }}

            {{ data }} -->
            <!-- {{ sem_data.imm }} -->
            <!-- {{ auth }} -->
            <div class="peers">
                <div class="peer mR-10">

                    <!-- <input v-model="search" type="text" class="form-control form-control-sm" placeholder="Search..."> -->
                </div>
                <div class="peer">
                    <!-- <Link class="btn btn-primary btn-sm" :href="`/Daily_Accomplishment/create`">Add Daily Accomplishment</Link> -->
                    <!-- <button class="btn btn-primary btn-sm mL-2 text-white" @click="showFilter()">Filter</button> -->
                    <button class="btn btn-primary btn-sm mL-2 text-white" @click="printSubmit1">Print Semestral Accomplishment</button>
                    <!-- <button class="btn btn-primary btn-sm mL-2 text-white" @click="printSubmit">Print Part 2</button> -->
                </div>
                <div class="peer">
                    <!-- <button class="btn btn-primary btn-sm mL-2 text-white" @click="submitAccomplishmentFOrThisMonth()"
                        v-if="sem_data.status_accomplishment < 0 && canSubmit">Submit</button> -->
                    <!-- canSubmit: {{canSubmit }} -->
                    <button class="btn btn-primary btn-sm mL-2 text-white" @click="recallAccomplishmentFOrThisMonth()"
                        v-if="sem_data.status_accomplishment == 0">Recall</button>
                </div>
            </div>

            <Link :href="'/monthly-accomplishment/r'">
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
                                <!-- <th style="width: 5%;" rowspan="2" colspan="1">IPCR Code</th> -->
                                <th style="width: 15%;" rowspan="2" colspan="1">{{ data[0].Accomplishment_type == "ipcr"? "Individual Output": data[0].Accomplishment_type == "dpcr"? "Division Output" : "" }}</th>
                                <th style="width: 30%;" rowspan="2" colspan="1">Success Indicator</th>
                                <th style="width: 20%;" colspan="4">Rating</th>
                                <th style="width: 20%;" rowspan="2" colspan="1">Remarks</th>
                                <th rowspan="2" colspan="1"></th>
                            </tr>
                            <tr style="background-color: #B7DEE8;" class="text-center">
                                <th style="width: 5%;">Quality Rating</th>
                                <th style="width: 5%;">Efficiency Rating</th>
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
                                <td colspan="8">
                                    <b>CORE FUNCTION</b>
                                </td>
                            </tr>
                            <template v-for="(dat, index) in data" :key="index">
                                <tr v-if="dat.ipcr_type === 'Core Function'"
                                :class="{ opened: opened.includes(dat.individual_output) }" class="text-center">
                                    <td @click="toggle(dat.individual_output, index)"
                                    style="cursor: pointer; background-color: lightblue">{{ dat.individual_output }}</td>
                                    <td>{{ dat.efficiency1 == "Yes"? dat.performance_measure + " " + dat.individual_output + " with a satisfactory rating for quality/effectiveness and satisfactory in efficiency within " + dat.prescribed_period : dat.performance_measure + " " + dat.individual_output + " with a satisfactory rating for quality/effectiveness and satisfactory in efficiency on or before " + dat.timeliness }}</td>
                                    <td>
                                        {{ QualityRateSem(dat.avg_q1, dat.avg_q2, dat.avg_q3) }}
                                    </td>
                                    <td>
                                        {{ EfficiencyRateSem(dat.avg_e1, dat.avg_e2, dat.avg_e3)}}
                                    </td>

                                    <td>{{ dat.timeliness == "No" ? "Not to be Rated" : dat.avg_t1}}
                                    </td>
                                    <td>{{ AverageComputationSem(QualityRateSem(dat.avg_q1, dat.avg_q2, dat.avg_q3), EfficiencyRateSem(dat.avg_e1, dat.avg_e2, dat.avg_e3), dat.timeliness == "No" ? 0 : dat.avg_t1 ) }}
                                    </td>
                                    <td v-html="dat.target_remarks ? dat.target_remarks + '<br>' + dat.remarks : dat.remarks"></td>
                                    <td><button v-if="dat.remarks == ''" class="btn btn-primary btn-sm mL-2 text-white"
                                            @click="showModal2(dat.individual_output_id, dat.sem_id, dat.result[0].year)">Add
                                            Remarks</button>
                                        <button v-else class="btn btn-primary btn-sm mL-2 text-white"
                                            @click="showModal3(dat.individual_output_id, dat.sem_id, dat.remarks, dat.remarks_id)">Edit/Delete
                                            Remarks</button>
                                    </td>

                                </tr>
                                <tr v-if="opened.includes(dat.individual_output) && dat.ipcr_type === 'Core Function'">
                                    <td colspan="8" class="background-white">
                                        <Transition name="bounce">
                                            <span v-if="show[index]">
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
                                                        <th colspan="3" style="text-align: center;">Quality/Effectiveness</th>
                                                        <th colspan="3" style="text-align: center;">Efficiency</th>
                                                        <th rowspan="1" style="text-align: center;">Timeliness</th>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 0;">
                                                            <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="6" style="border: 1px solid #000;">{{ dat.quality1 }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[0].q1 == null ? 0 : dat.result[0].q1}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[1].q1 == null ? 0 : dat.result[1].q1}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[2].q1 == null ? 0 : dat.result[2].q1}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[3].q1 == null ? 0 : dat.result[3].q1}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[4].q1 == null ? 0 : dat.result[4].q1}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[5].q1 == null ? 0 : dat.result[5].q1}}</td>
                                                                    </tr>
                                                                </tbody>

                                                            </table>
                                                        </td>
                                                        <td style="padding: 0;">
                                                            <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="6" style="border: 1px solid #000;">{{ dat.quality2 }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[0].q2 == null ? 0 : dat.result[0].q2}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[1].q2 == null ? 0 : dat.result[1].q2}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[2].q2 == null ? 0 : dat.result[2].q2}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[3].q2 == null ? 0 : dat.result[3].q2}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[4].q2 == null ? 0 : dat.result[4].q2}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[5].q2 == null ? 0 : dat.result[5].q2}}</td>
                                                                    </tr>
                                                                </tbody>

                                                            </table>
                                                        </td>
                                                        <td style="padding: 0;">
                                                            <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="6" style="border: 1px solid #000;">{{ dat.quality3 }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[0].q3 == null ? 0 : dat.result[0].q3}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[1].q3 == null ? 0 : dat.result[1].q3}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[2].q3 == null ? 0 : dat.result[2].q3}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[3].q3 == null ? 0 : dat.result[3].q3}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[4].q3 == null ? 0 : dat.result[4].q3}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[5].q3 == null ? 0 : dat.result[5].q3}}</td>
                                                                    </tr>
                                                                </tbody>

                                                            </table>
                                                        </td>
                                                        <td style="padding: 0;">
                                                            <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="6" style="border: 1px solid #000;">{{ "Standard Response Time" }}</td>
                                                                    </tr>
                                                                    <tr v-if="dat.efficiency1 === 'No'">
                                                                        <td colspan="6" style="border: 1px solid #000; text-align: center;">Not to be Rated</td>
                                                                    </tr>

                                                                    <tr v-else>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[1].e1 == null ? 0 : dat.result[1].e1}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[0].e1 == null ? 0 : dat.result[0].e1}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[2].e1 == null ? 0 : dat.result[2].e1}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[3].e1 == null ? 0 : dat.result[3].e1}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[4].e1 == null ? 0 : dat.result[4].e1}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[5].e1 == null ? 0 : dat.result[5].e1}}</td>
                                                                    </tr>
                                                                </tbody>

                                                            </table>
                                                        </td>
                                                        <td style="padding: 0;">
                                                            <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="6" style="border: 1px solid #000;">{{ "Quantity Based" }}</td>
                                                                    </tr>
                                                                    <tr v-if="dat.efficiency2 === 'No'">
                                                                        <td colspan="6" style="border: 1px solid #000; text-align: center;">Not to be Rated</td>
                                                                    </tr>

                                                                    <tr v-else>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[1].e2 == null ? 0 : dat.result[1].e2}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[0].e2 == null ? 0 : dat.result[0].e2}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[2].e2 == null ? 0 : dat.result[2].e2}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[3].e2 == null ? 0 : dat.result[3].e2}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[4].e2 == null ? 0 : dat.result[4].e2}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[5].e2 == null ? 0 : dat.result[5].e2}}</td>
                                                                    </tr>
                                                                </tbody>

                                                            </table>
                                                        </td>
                                                        <td style="padding: 0;">
                                                            <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="6" style="border: 1px solid #000;">{{ "Optimum use of resources" }}</td>
                                                                    </tr>
                                                                    <tr v-if="dat.efficiency3 === 'No'">
                                                                        <td colspan="6" style="border: 1px solid #000; text-align: center;">Not to be Rated</td>
                                                                    </tr>

                                                                    <tr v-else>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[1].e3 == null ? 0 : dat.result[1].e3}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[0].e3 == null ? 0 : dat.result[0].e3}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[2].e3 == null ? 0 : dat.result[2].e3}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[3].e3 == null ? 0 : dat.result[3].e3}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[4].e3 == null ? 0 : dat.result[4].e3}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[5].e3 == null ? 0 : dat.result[5].e3}}</td>
                                                                    </tr>
                                                                </tbody>

                                                            </table>
                                                        </td>
                                                        <td style="padding: 0;">
                                                            <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="6" style="border: 1px solid #000;">{{ "Timeliness" }}</td>
                                                                    </tr>
                                                                    <tr v-if="dat.timeliness === 'No'">
                                                                        <td colspan="6" style="border: 1px solid #000; text-align: center;">Not to be Rated</td>
                                                                    </tr>

                                                                    <tr v-else>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[1].time == null ? 0 : dat.result[1].time}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[0].time == null ? 0 : dat.result[0].time}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[2].time == null ? 0 : dat.result[2].time}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[3].time == null ? 0 : dat.result[3].time}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[4].time == null ? 0 : dat.result[4].time}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[5].time == null ? 0 : dat.result[5].time}}</td>
                                                                    </tr>
                                                                </tbody>

                                                            </table>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                            </span>
                                        </Transition>
                                    </td>
                                </tr>

                            </template>
                            <tr>
                                <td colspan="7">
                                    <b style="float:right">Average Point Score - Core Function</b>
                                </td>
                                <td>
                                    {{ Average_Point_Core }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7">
                                    <b style="float:right">Multiply by Weighted Allocation</b>
                                </td>
                                <td>
                                    70%
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7">
                                    <b style="float:right">Weighted Average Score - Core Function</b>
                                </td>
                                <td>
                                    {{ (Average_Point_Core * .70).toFixed(2) }}
                                </td>
                            </tr>
                            <!-- //SUPPORT -->
                            <tr>
                                <td colspan="8">
                                    <b>Support FUNCTION </b>
                                </td>
                            </tr>
                            <template v-for="(dat, index) in data" :key="index">
                                <tr v-if="dat.ipcr_type === 'Support Function'"
                                :class="{ opened: opened.includes(dat.individual_output) }" class="text-center">
                                    <td @click="toggle(dat.individual_output, index)"
                                    style="cursor: pointer; background-color: lightblue">{{ dat.individual_output }}</td>
                                    <td>{{ dat.efficiency1 == "Yes"? dat.performance_measure + " " + dat.individual_output + " with a satisfactory rating for quality/effectiveness and satisfactory in efficiency within " + dat.prescribed_period : dat.performance_measure + " " + dat.individual_output + " with a satisfactory rating for quality/effectiveness and satisfactory in efficiency on or before " + dat.timeliness }}</td>
                                    <td>
                                        {{ QualityRateSem(dat.avg_q1, dat.avg_q2, dat.avg_q3) }}
                                    </td>
                                    <td>
                                        {{ EfficiencyRateSem(dat.avg_e1, dat.avg_e2, dat.avg_e3)}}
                                    </td>

                                    <td>{{ dat.timeliness == "No" ? "Not to be Rated" : dat.avg_t1 }}
                                    </td>
                                    <td>{{ AverageComputationSem(QualityRateSem(dat.avg_q1, dat.avg_q2, dat.avg_q3), EfficiencyRateSem(dat.avg_e1, dat.avg_e2, dat.avg_e3), dat.timeliness == "No" ? 0 : dat.avg_t1 )}}
                                    </td>
                                    <td v-html="dat.target_remarks ? dat.target_remarks + '<br>' + dat.remarks : dat.remarks"></td>
                                    <td><button v-if="dat.remarks == ''" class="btn btn-primary btn-sm mL-2 text-white"
                                            @click="showModal2(dat.individual_output_id, dat.sem_id, dat.result[0].year)">Add
                                            Remarks</button>
                                        <button v-else class="btn btn-primary btn-sm mL-2 text-white"
                                            @click="showModal3(dat.individual_output_id, dat.sem_id, dat.remarks, dat.remarks_id)">Edit/Delete
                                            Remarks</button>


                                    </td>

                                </tr>
                                <tr v-if="opened.includes(dat.individual_output) && dat.ipcr_type === 'Support Function'">
                                    <td colspan="8" class="background-white">
                                        <Transition name="bounce">
                                            <span v-if="show[index]">
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
                                                        <th colspan="3" style="text-align: center;">Quality/Effectiveness</th>
                                                        <th colspan="3" style="text-align: center;">Efficiency</th>
                                                        <th rowspan="1" style="text-align: center;">Timeliness</th>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 0;">
                                                            <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="6" style="border: 1px solid #000;">{{ dat.quality1 }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[0].q1 == null ? 0 : dat.result[0].q1}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[1].q1 == null ? 0 : dat.result[1].q1}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[2].q1 == null ? 0 : dat.result[2].q1}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[3].q1 == null ? 0 : dat.result[3].q1}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[4].q1 == null ? 0 : dat.result[4].q1}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[5].q1 == null ? 0 : dat.result[5].q1}}</td>
                                                                    </tr>
                                                                </tbody>

                                                            </table>
                                                        </td>
                                                        <td style="padding: 0;">
                                                            <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="6" style="border: 1px solid #000;">{{ dat.quality2 }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[0].q2 == null ? 0 : dat.result[0].q2}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[1].q2 == null ? 0 : dat.result[1].q2}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[2].q2 == null ? 0 : dat.result[2].q2}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[3].q2 == null ? 0 : dat.result[3].q2}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[4].q2 == null ? 0 : dat.result[4].q2}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[5].q2 == null ? 0 : dat.result[5].q2}}</td>
                                                                    </tr>
                                                                </tbody>

                                                            </table>
                                                        </td>
                                                        <td style="padding: 0;">
                                                            <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="6" style="border: 1px solid #000;">{{ dat.quality3 }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[0].q3 == null ? 0 : dat.result[0].q3}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[1].q3 == null ? 0 : dat.result[1].q3}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[2].q3 == null ? 0 : dat.result[2].q3}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[3].q3 == null ? 0 : dat.result[3].q3}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[4].q3 == null ? 0 : dat.result[4].q3}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[5].q3 == null ? 0 : dat.result[5].q3}}</td>
                                                                    </tr>
                                                                </tbody>

                                                            </table>
                                                        </td>
                                                        <td style="padding: 0;">
                                                            <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="6" style="border: 1px solid #000;">{{ "Standard Response Time" }}</td>
                                                                    </tr>
                                                                    <tr v-if="dat.efficiency1 === 'No'">
                                                                        <td colspan="6" style="border: 1px solid #000; text-align: center;">Not to be Rated</td>
                                                                    </tr>

                                                                    <tr v-else>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[1].e1 == null ? 0 : dat.result[1].e1 }}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[0].e1 == null ? 0 : dat.result[0].e1 }}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[2].e1 == null ? 0 : dat.result[2].e1 }}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[3].e1 == null ? 0 : dat.result[3].e1 }}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[4].e1 == null ? 0 : dat.result[4].e1 }}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[5].e1 == null ? 0 : dat.result[5].e1 }}</td>
                                                                    </tr>
                                                                </tbody>

                                                            </table>
                                                        </td>
                                                        <td style="padding: 0;">
                                                            <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="6" style="border: 1px solid #000;">{{ "Quantity Based" }}</td>
                                                                    </tr>
                                                                    <tr v-if="dat.efficiency2 === 'No'">
                                                                        <td colspan="6" style="border: 1px solid #000; text-align: center;">Not to be Rated</td>
                                                                    </tr>

                                                                    <tr v-else>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[1].e2 == null ? 0 : dat.result[1].e2}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[0].e2 == null ? 0 : dat.result[0].e2}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[2].e2 == null ? 0 : dat.result[2].e2}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[3].e2 == null ? 0 : dat.result[3].e2}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[4].e2 == null ? 0 : dat.result[4].e2}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[5].e2 == null ? 0 : dat.result[5].e2}}</td>
                                                                    </tr>
                                                                </tbody>

                                                            </table>
                                                        </td>
                                                        <td style="padding: 0;">
                                                            <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="6" style="border: 1px solid #000;">{{ "Optimum use of resources" }}</td>
                                                                    </tr>
                                                                    <tr v-if="dat.efficiency3 === 'No'">
                                                                        <td colspan="6" style="border: 1px solid #000; text-align: center;">Not to be Rated</td>
                                                                    </tr>

                                                                    <tr v-else>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[1].e3 == null ? 0 : dat.result[1].e3}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[0].e3 == null ? 0 : dat.result[0].e3}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[2].e3 == null ? 0 : dat.result[2].e3}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[3].e3 == null ? 0 : dat.result[3].e3}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[4].e3 == null ? 0 : dat.result[4].e3}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[5].e3 == null ? 0 : dat.result[5].e3}}</td>
                                                                    </tr>
                                                                </tbody>

                                                            </table>
                                                        </td>
                                                        <td style="padding: 0;">
                                                            <table style="width: 100%; border-collapse: collapse; text-align: center;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="6" style="border: 1px solid #000;">{{ "Timeliness" }}</td>
                                                                    </tr>
                                                                    <tr v-if="dat.timeliness === 'No'">
                                                                        <td colspan="6" style="border: 1px solid #000; text-align: center;">Not to be Rated</td>
                                                                    </tr>

                                                                    <tr v-else>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[1].time == null ? 0 : dat.result[1].time}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[0].time == null ? 0 : dat.result[0].time}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[2].time == null ? 0 : dat.result[2].time}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[3].time == null ? 0 : dat.result[3].time}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[4].time == null ? 0 : dat.result[4].time}}</td>
                                                                        <td style="border: 1px solid #000;">{{ dat.result[5].time == null ? 0 : dat.result[5].time}}</td>
                                                                    </tr>
                                                                </tbody>

                                                            </table>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                            </span>
                                        </Transition>
                                    </td>
                                </tr>
                            </template>

                            <tr>
                                <td colspan="7">
                                    <b style="float:right">Average Point Score - Support Function</b>
                                </td>
                                <td>
                                    {{ Average_Point_Support }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7">
                                    <b style="float:right">Multiply by Weighted Allocation</b>
                                </td>
                                <td>
                                    30%
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7">
                                    <b style="float:right">Weighted Average Score - Support Function</b>
                                </td>
                                <td>
                                    {{ (Average_Point_Support * .30).toFixed(2) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7">
                                    <b style="float:right">Total Average Score</b>
                                </td>
                                <td>
                                    {{ getAdjectivalScoreSem(Average_Point_Core * 0.70, Average_Point_Support * 0.30)}}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7">
                                    <b style="float:right">Additional Point Intervening Factor - if applicable -
                                        Maximum: 0.5 pts</b>
                                </td>
                                <td>

                                </td>
                            </tr>
                            <tr>
                                <td colspan="7">
                                    <b style="float:right">Total Final Average Rating</b>
                                </td>
                                <td style="background-color: yellow">
                                    <b>
                                        {{
                                        getAdjectivalScoreSem(Average_Point_Core * 0.70, Average_Point_Support * 0.30)
                                        }}
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7">
                                    <b style="float:right">Final Adjectival Rating</b>
                                </td>
                                <td style="background-color: yellow">
                                    <b>{{ getAdjectivalRatingSem(getAdjectivalScoreSem(Average_Point_Core * 0.70,
                                        Average_Point_Support * 0.30)) }}
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="8">
                                    <b>Supervisor's comments and recommendations for development purposes or
                                        Rewards/Promotion</b>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="8" v-if="sem_data.status_accomplishment == 1 || sem_data.status_accomplishment == 2">
                                    <span v-if="sem_data.remarks">{{ sem_data.remarks }} <br></span>

                                    <!-- <span v-if="sem_data['remarks']">{{ sem_data["remarks"] }}dasdadadasdadasd </span> -->

                                    <!-- {{ sem_data["remarkshigher"] }} -->
                                    <span v-if="sem_data.remarkshigher">{{ sem_data.remarkshigher }} <br></span>

                                    <!-- <span v-if="sem_data['remarkshigher']">{{ sem_data["remarkshigher"] }}</span> -->
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>


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
    {{ sem_data }}
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
        emp: Object,
        sem_data: Object,
        sem_id: String,
        month: Object,
        data: Object,
        month_data: Object,
        // sem: Object,
        // dept: Object,
        // pghead: Object,
        division: Object,
        dept_con: String,
        pghead_con: String,
        division_con: String,
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
            }),
            canSubmit: false,
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
        this.Average_Point_Core=this.calculateAverageCoreSem(this.data)
        this.Average_Point_Support=this.calculateAverageSupportSem(this.data)

        this.setShow()
        this.canSubmit = this.checkIfELigibleToSubmit()
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
            // alert(this.form.year);
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
            // alert(this.form.remarks_id);
            this.displayModal2 = true;
        },
        hideModal2() {
            this.displayModal2 = false;
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


            // console.log(this.emp.office.pg_head.first_name + " " + this.emp.office.pg_head.middle_name[0] + ". " + this.emp.office.pg_head.last_name)
            // var pg_heads_postfix = "";
            // var pg_heads_suffix = "";
            var pg_heads = this.pghead_con;
            // if (this.emp.office) {
            //     if (this.emp.office.pg_head) {
            //         if (this.emp.office.pg_head.postfix_name != "") {
            //             pg_heads_postfix = ", " + this.emp.office.pg_head.postfix_name;
            //         }
            //         if (this.emp.office.pg_head.suffix_name != "") {
            //             pg_heads_suffix = ", " + this.emp.office.pg_head.suffix_name;
            //         }
            //         pg_heads = this.emp.office.pg_head.first_name + " " + this.emp.office.pg_head.middle_name[0] + ". " + this.emp.office.pg_head.last_name + pg_heads_suffix + pg_heads_postfix;

            //     }


            // }

            // console.log(this.division)
            var suffix_imm = "";
            var suffix_next = "";
            var suffix_a = "";

            if (this.sem_data.imm.suffix_name != "") {
                suffix_imm = ', ' + this.sem_data.imm.suffix_name;
            }
            if (this.sem_data.next.suffix_name != "") {
                suffix_next = ', ' + this.sem_data.next.suffix_name;
            }
            if (this.auth.user.name.suffix_name != "") {
                suffix_a = ', ' + this.auth.user.name.suffix_name;
            }

            var post_imm = "";
            var post_next = "";
            var post_a = "";
            if (this.sem_data.imm.postfix_name != "") {
                post_imm = ", " + this.sem_data.imm.postfix_name;
            }
            if (this.sem_data.next.postfix_name != "") {
                post_next = ", " + this.sem_data.next.postfix_name;
            }
            if (this.auth.user.name.postfix_name != "") {
                post_a = ', ' + this.auth.user.name.postfix_name;
            }

            //MIDDLE NAME
            var mid_imm = "";
            var mid_next = "";
            var mid_a = "";
            if (this.sem_data.imm.middle_name != "") {
                mid_imm = this.sem_data.imm.middle_name[0] + ". ";
            }
            if (this.sem_data.next.middle_name != "") {
                mid_next = this.sem_data.next.middle_name[0] + ". ";
            }
            if (this.auth.user.name.middle_name != "") {
                mid_a = this.auth.user.name.middle_name[0] + ". ";
            }
            //dept_con =>emp.office.office
            this.my_link = this.viewlink1(this.sem_data.employee_code, this.auth.user.name.first_name + " " + mid_a +
                this.auth.user.name.last_name + suffix_a + post_a, this.auth.user.name.employment_type_descr,
                this.sem_data.position, this.dept_con, this.sem_data.division,
                this.sem_data.imm.first_name + " " + mid_imm + this.sem_data.imm.last_name + suffix_imm + post_imm,
                this.sem_data.next.first_name + " " + mid_next + this.sem_data.next.last_name + suffix_next + post_next,
                this.sem_data.sem, this.sem_data.year, this.sem_data.id,
                this.getPeriod(this.sem_data.sem, this.sem_data.year),
                pg_heads, '3.33', '4.55');
            console.log(this.sem_data.division);
            // this.Average_Point_Core, this.Average_Point_Support
            this.showModal1();
            // console.log(this.my_link);
            // console.log(this.division)
        },
        viewlink1(emp_code, employee_name, emp_status, position, office, division, immediate, next_higher, sem, year, idsemestral, period, pghead, Average_Score) {


            //var linkt ="abcdefghijklo534gdmoivndfigudfhgdyfugdhfugidhfuigdhfiugmccxcxcxzczczxczxczxcxzc5fghjkliuhghghghaaa555l&&&&-";
            var linkt = "https://";
            var jasper_ip = this.jasper_ip;
            var jasper_link = 'jasperserver/flow.html?pp=u%3DJamshasadid%7Cr%3DManager%7Co%3DEMEA%2CSales%7Cpa1%3DSweden&_flowId=viewReportFlow&_flowId=viewReportFlow&ParentFolderUri=%2Freports%2Fcorporate_planning&reportUnit=%2Freports%2Fcorporate_planning%2FNew_Semestral_Accomplishment&standAlone=true&decorate=no&output=pdf';
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
            // this.emp.office.office,
            this.my_link = this.viewlink(this.sem_data.employee_code,
                this.auth.user.name.first_name + " " + this.auth.user.name.last_name,
                this.auth.user.name.employment_type_descr, this.auth.user.name.position_long_title,
                this.dept_con, null, this.sem_data.imm.first_name + " " + this.sem_data.imm.last_name,
                null, this.sem_data.sem, this.sem_data.year, this.sem_data.id, this.SemName(this.sem_data.sem));

            this.showModal();
        },

        viewlink(emp_code, employee_name, emp_status, position, office, division, immediate, next_higher, sem, year, idsemestral, period) {
            var linkt = "http://";
            var jasper_ip = this.jasper_ip;
            var jasper_link = 'jasperserver/flow.html?pp=u%3DJamshasadid%7Cr%3DManager%7Co%3DEMEA%2CSales%7Cpa1%3DSweden&__flowId=viewReportFlow&_flowId=viewReportFlow&ParentFolderUri=%2Freports%2FIPCR&reportUnit=%2Freports%2FIPCR%2FSemesterAccomplishmentPart2&standAlone=true&decorate=no&output=pdf';
            var params = '&emp_code=' + emp_code + '&employee_name=' + employee_name + '&emp_status=' + emp_status + '&position=' + position + '&office=' + office + '&division=' + division + '&immediate=' + immediate + '&next_higher=' + next_higher + '&sem=' + sem + '&year=' + year + '&idsemestral=' + idsemestral + '&period=' + period;
            var linkl = linkt + jasper_ip + jasper_link + params;
            // console.log(params)
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
        toggle(id, i) {
            // alert(this.data.length);
            // for (var x = 0; x < this.data.length; x++) {
            //     this.$('#collapse-b' + x).removeClass('show');
            // }
            const index = this.opened.indexOf(id);
            if (index > -1) {
                // this.opened.splice(index, 1)
            } else {
                this.opened = [];
                this.opened.push(id)
            }
            // alert(this.show);
            setTimeout(() => {
                // alert(this.show);
                for (var t = 0; t < this.data.length; t++) {
                    if (i != t) {
                        this.show[t] = false
                    }

                }
                this.show[i] = !this.show[i];
            }, 100);
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
            var yr = this.sem_data.year;
            var sm = this.sem_data.sem;
            var canSubmit = this.checkIfELigibleToSubmit();
            // alert(canSubmit);

            // alert(text);
            if(canSubmit){
                let text = "Are you sure you want to submit this accomplishment?" + this.sem_id;
                if (confirm(text) == true) {
                    this.$inertia.post('/semester-accomplishment/submit/ipcr/semestral/' + this.sem_id);
                } else {
                    alert('undo')
                }
            }

            //
        },
        checkIfELigibleToSubmit(){
            // Define last day of the semester
            let ldy;
            var sm = this.sem_data.sem;
            var yr = this.sem_data.year;

            if (sm === '1') {
                // Semester 1: Last day is June 30

                ldy = "06-30";
            } else if (sm ==='2') {

                // Semester 2: Last day is December 31
                ldy = "12-31";
            }

            // Compute last date of the semester
            let ldtString = `${yr}-${ldy}`;
            let ldt = new Date(ldtString); // Convert to Date object
            var cd = new Date();
            // Compare current date (cd) with last date (ldt)
            // alert('current date: '+cd+' latest date: '+ ldt);
            if (cd < ldt) {
                return false; // Current date is before the last day of the semester
            } else {
                return true; // Current date is on or after the last day of the semester
            }

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
