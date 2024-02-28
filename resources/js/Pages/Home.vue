<template>
    <Head>
        <title>Home</title>
    </Head>

    <div style='background-image:url("images/image.jpg"); background-size: cover;background-position: center;
    background-repeat: no-repeat;min-height: 100vh;'>
    <!--<p style="text-align: justify;">Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit amet consectetur.
    </p>-->
    <div class="row gap-20 masonry pos-r">
        <div class="masonry-sizer col-md-6"></div>
        <div class="masonry-item w-100">
            <div class="row gap-20"></div>
            <button class="btn btn-primary btn-lg mL-2 text-white">
            <Link class="sidebar-link" href="/Daily_Accomplishment/create"
                            :class="{ 'active': $page.url === `/Daily_Accomplishment` }">
                        <span></span>
                        <span class="title text-white">Add Daily Accomplishment</span>
                        </Link>
                        </button>
         </div>
        </div>
    </div>
</template>
<script>

export default {
    props: {
        auth: Object
    },
    data() {
        return{

        }
    },
    components: {

    }
};
</script>
<style>



            .row-centered {
                text-align:center;
            }
            .col-centered {
                display:inline-block;
                float:none;
                text-align:left;
                margin-right:-4px;
            }
            .pos{
                position: top;
                top: 240px;
            }
</style>
