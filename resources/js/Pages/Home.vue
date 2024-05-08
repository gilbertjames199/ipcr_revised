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

    </div>
</template>
<script>

export default {
    props: {
        auth: Object
    },
    data() {
        return {

        }
    },
    components: {

    },
    methods: {
        canViewThis() {
            //
            var can_see = false;
            if (this.auth.user.name.department_code == '26' && this.auth.user.name.salary_grade >= 18) {
                can_see = true;
            }
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
