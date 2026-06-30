<template>
    <div class="row gap-20">
        <div class="peers">

            <!-- <div class="peer">
                <Link class="btn btn-primary btn-sm" :href="`/ELA/create`">Add Agenda</Link>
                <button class="btn btn-primary btn-sm mL-2 text-white" @click="showFilter()">Filter</button>
            </div> -->
            <Link :href="`/ipcr-app/accomplishments`" v-if="src==='rev'">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left-square-fill" viewBox="0 0 16 16">
                    <path d="M16 14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2zm-4.5-6.5H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5a.5.5 0 0 0 0-1"/>
                </svg>
                BACK
            </Link>
        </div>
        <div class="col-md-12">
            <h2><b> {{ pageTitle }} Coaching Report Form</b></h2>

            <form @submit.prevent="submit">

                <!-- Header -->
                <fieldset class="custom-fieldset">
                    <legend class="float-none w-auto">
                        <b>Employee Information</b>
                    </legend>

                    <div class="row">
                        <div class="col-md-4">
                            <label>Date</label>
                            <input
                                type="date"
                                v-model="form.date"
                                class="form-control"
                                 readonly
                            >
                        </div>

                        <div class="col-md-4">
                            <label>Name of Coachee</label>
                            <input
                                type="text"
                                v-model="form.coachee_name"
                                class="form-control"
                                readonly
                            >
                        </div>

                    </div>
                </fieldset>

                <!-- Critical Incident -->
                <fieldset class="custom-fieldset">
                    <legend class="float-none w-auto">
                        <b>Critical Incident Description</b>
                    </legend>

                    <textarea
                        rows="5"
                        v-model="form.critical_incident"
                        class="form-control"
                        placeholder="Describe actual events and behaviors..."
                    ></textarea>
                </fieldset>

                <!-- Goals -->
                <fieldset class="custom-fieldset">
                    <legend class="float-none w-auto">
                        <b>Goals</b>
                    </legend>

                    <textarea
                        rows="4"
                        v-model="form.goals"
                        class="form-control"
                        placeholder="What the coachee wants to achieve"
                    ></textarea>

                     <div class="coaching-guide mt-3">

        <h6>Structure for Coaching</h6>

        <ul>
            <li>What would you like to work on?</li>
            <li>What would you like to have after answering this set of questions (e.g. first step, strategy or solution)?</li>
            <li>What is your goal related to this issue?</li>
            <li>When are you going to achieve it?</li>
            <li>What are the benefits for you in achieving this goal?</li>
            <li>Who else will benefit and in what way?</li>
            <li>What will it be like if you achieve your goal?</li>
            <li>What will you see, hear and feel?</li>
        </ul>
    </div>
                </fieldset>

                <!-- Reality -->
                <fieldset class="custom-fieldset">
                    <legend class="float-none w-auto">
                        <b>Reality</b>
                    </legend>

                    <textarea
                        rows="4"
                        v-model="form.reality"
                        class="form-control"
                        placeholder="Current situation and challenges"
                    ></textarea>

                    <div class="coaching-guide mt-3">
        <h6>Structure for Coaching</h6>

        <ul>
            <li>What action have you taken so far?</li>
            <li>What is moving you toward your goal?</li>
            <li>What is getting in the way?</li>
            <li>What is happening at the moment?</li>
            <li>How important is this to you?</li>
            <li>On a scale of 1–10, if an ideal situation is 10, what number are you at now?</li>
            <li>What number would you like to be at?</li>
            <li>How do you feel about this?</li>
            <li>What impact is this having on you?</li>
        </ul>
    </div>
                </fieldset>

                <!-- Opportunities -->
                <fieldset class="custom-fieldset">
                    <legend class="float-none w-auto">
                        <b>Opportunities</b>
                    </legend>

                    <textarea
                        rows="4"
                        v-model="form.opportunities"
                        class="form-control"
                        placeholder="Possible solutions and remedies"
                    ></textarea>

                    <div class="coaching-guide mt-3">
        <h6>Structure for Coaching</h6>

        <ul>
            <li>What different kinds of options do you have to achieve your goal?</li>
            <li>What else could you do?</li>
            <li>What are the principal advantages and disadvantages of each option?</li>
            <li>What ideas do you have?</li>
            <li>What alternatives do you have?</li>
            <li>What steps could you take?</li>
            <li>Who could help you with this?</li>
            <li>Where could you find out the information?</li>
            <li>How could you do that?</li>
        </ul>
    </div>
                </fieldset>

                <!-- Way Forward -->
                <fieldset class="custom-fieldset">
                    <legend class="float-none w-auto">
                        <b>Way Forward</b>
                    </legend>

                    <textarea
                        rows="4"
                        v-model="form.way_forward"
                        class="form-control"
                        placeholder="Actions to be executed"
                    ></textarea>

                    <div class="coaching-guide mt-3">
        <h6>Structure for Coaching</h6>

        <ul>
            <li>Which options will you choose to act on?</li>
            <li>When are you going to start each action?</li>
            <li>How committed are you, on a scale of 1–10, to taking each action?</li>
            <li>If it is not a 10, what would make it a 10?</li>
            <li>What will you commit to doing?</li>
        </ul>
    </div>
                </fieldset>

                <!-- Follow-up Session -->
                <fieldset class="custom-fieldset">
                    <legend class="float-none w-auto">
                        <b>Follow-Up Coaching Session</b>
                    </legend>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Follow-up Date</label>
                            <input
                                type="date"
                                v-model="form.followup_date"
                                class="form-control"
                            >
                        </div>

                        <div class="col-md-6">
                            <label>Follow-up Time</label>
                            <input
                                type="time"
                                v-model="form.followup_time"
                                class="form-control"
                            >
                        </div>
                    </div>

                    <label class="mt-3">
                        Improved behavior, competency, development,
                        growth or new skills
                    </label>

                    <textarea
                        rows="4"
                        v-model="form.followup_notes"
                        class="form-control"
                    ></textarea>

                    <div class="coaching-guide mt-3">
    <h6>Follow-up Coaching Guide</h6>

    <p class="mb-0">
        Identify the expectations, agreements, and commitments. Determine the progress
        and give the coachee the space to open up. Observe signs of growth and make
        a deliberate effort to observe improved behavior, competency, development,
        growth, or new skills.
    </p>
</div>
                </fieldset>

                <!-- Supervisor -->
                <fieldset class="custom-fieldset">
                    <legend class="float-none w-auto">
                        <b>Supervisor Information</b>
                    </legend>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Supervisor Name</label>
                            <input
                                type="text"
                                v-model="form.supervisor_name"
                                class="form-control"
                                readonly
                            >
                        </div>

                        <div class="col-md-6">
                            <label>Position</label>
                            <input
                                type="text"
                                v-model="form.supervisor_position"
                                class="form-control"
                                readonly
                            >
                        </div>
                    </div>
                </fieldset>

                <button
                    type="submit"
                    class="btn btn-primary text-white"
                >
                    Save
                </button>

            </form>
            <!-- {{ form }} {{ src }} -->
        </div>
    </div>
</template>

<script>
import { useForm } from "@inertiajs/inertia-vue3";

export default {

    props: {
        sem: Object,
        auth: Object,
        immediate_head: String,
        immediate_position: String,
        coachee_name: String,
        emp_code: String,
        semester: String,
        year: String,
        month: String,
        editData: Object,
        src: String
    },
    data() {
        return {
            form: useForm({
                date: new Date().toISOString().split('T')[0],
                coachee_name: this.coachee_name ?? "",
                critical_incident: "",
                goals: "",
                reality: "",
                opportunities: "",
                way_forward: "",
                followup_date: "",
                followup_time: "",
                followup_notes: "",

                supervisor_name: this.immediate_head ?? "",
                supervisor_position: this.immediate_position ?? "",
                emp_code: this.emp_code ?? "",
                month: this.month ?? "",
                year: this.sem?.[0]?.year ?? "",
                sem: this.sem?.[0]?.sem ?? "",
                department_code: this.auth?.user?.department_code ?? "",
                src: ""
            }),
            pageTitle: "",
        };
    },
    mounted() {
        this.form.month = this.month;
        this.form.department_code = this.auth?.user?.department_code;

        this.form.emp_code = this.emp_code;
        this.form.src = this.src
        if (this.editData !== undefined) {
            if (this.bari) {
                this.bar = this.bari
            }
            this.pageTitle = "Edit"
            this.form.date = this.editData.date
            this.form.coachee_name = this.editData.employee_name
            this.form.critical_incident = this.editData.critical_incidence_description
            this.form.goals = this.editData.goal
            this.form.reality = this.editData.reality
            this.form.opportunities = this.editData.opportunities
            this.form.way_forward = this.editData.way_forward
            this.form.followup_date = this.editData.follow_up_date
            this.form.followup_time = this.editData.follow_up_time
            this.form.followup_notes = this.editData.way_forward
            this.form.supervisor_name = this.editData.coach_name
            this.form.supervisor_position = this.editData.position
            this.form.sem_id = this.editData.sem_id
            this.form.id = this.editData.id

            } else {
            this.pageTitle = "Create"
            this.form.date = new Date().toISOString().substr(0, 10);
        }
},

    methods: {
        submit() {
            console.log(this.form);
            this.form.post("/coaching-report/store");
            if (this.src === "rev"  ) {

                this.form.src = this.src
            }
            if (this.editData !== undefined) {
                    this.form.patch("/coaching-report/" + this.form.id, this.form);
                } else {
                    // alert("Sample");

                    var url = "/coaching-report/store"
                    // alert('for store '+url);
                    this.form.post(url);
                }
        }
    }
};
</script>
<style scoped>
.coaching-guide {
    border: 1px solid #0d6efd;
    border-radius: 6px;
    background: #f8f9fa;
    padding: 15px;
    margin-top: 20px;
    margin-bottom: 15px;
}

.coaching-guide h6 {
    font-weight: bold;
    color: #0d6efd;
    margin-bottom: 10px;
}

.coaching-guide ul {
    margin-bottom: 0;
    padding-left: 20px;
}

.coaching-guide li {
    margin-bottom: 6px;
}

.custom-fieldset {
    border: 2px solid #000 !important;
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.custom-fieldset legend {
    width: auto;
    padding: 0 10px;
    font-size: 1.1rem;
    color: #000;
}
</style>
