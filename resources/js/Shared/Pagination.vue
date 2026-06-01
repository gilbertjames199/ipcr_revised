<template>
    <div>
        <!--
            I intend to recreate a simple pagination [simplePaginate()] for performance purpose
            read https://laravel.com/docs/8.x/pagination#simple-pagination

            If you think you will not have huge dataset in the future you can use
            the paginate() by uncommenting below and in the actual component.
        -->

        <!-- <Component
            :is="link.url ? 'Link' : 'span'"
            v-for="link in links"
            :href="link.url"
            v-html="link.label"
            class="p-3 text-decoration-none"
            :class="{'text-muted' : !link.url, 'fw-bold' : link.active}"
        /> -->
        <ul class="pagination">
            <li class="page-item">
                <Link class="page-link" :href="prevHref" v-if="prev" preserve-scroll>Previous</Link>
                <span class="page-link" :class="{ 'text-muted' : !prev }" v-else >Previous</span>
            </li>
            <li class="page-item">
                <Link class="page-link" :href="nextHref" v-if="next" preserve-scroll>Next</Link>
                <span class="page-link" :class="{ 'text-muted' : !next }" v-else >Next</span>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        prev: String,
        next: String
    },
    computed: {
        prevHref() {
            return this.normalizeHttps(this.prev)
        },
        nextHref() {
            return this.normalizeHttps(this.next)
        }
    },
    methods: {
        normalizeHttps(url) {
            if (!url || typeof window === 'undefined') {
                return url
            }

            if (window.location.protocol === 'https:' && url.startsWith('http:')) {
                console.log('Converting URL to HTTPS:', url)
                alert('Converting URL to HTTPS: ' + url.replace(/^http:/, 'https:'))
                return url.replace(/^http:/, 'https:')
            }

            return url
        }
    }
}
</script>

