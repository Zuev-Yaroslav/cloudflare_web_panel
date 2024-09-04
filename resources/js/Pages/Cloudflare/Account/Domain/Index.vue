<template>
    <div class="bg-white p-4 rounded min-h-screen shadow-md">
        <h3 class="text-3xl mb-6">Domains</h3>
        <Link class="p-2 bg-blue-400 text-white rounded inline-block text-center hover:bg-blue-500 mb-3" :href="route('cloudflare.domains.create', cloudflareAccount.id)">Create</Link>
        <div v-if="domains.length > 0" class="w-1/2 mb-3">
            <div v-for="domain in domains" class="rounded border p-3 mb-3">
                <div>
                    <Link :href="route('cloudflare.domains.edit', [cloudflareAccount.id, domain.id])" class="font-bold text-blue-500">{{ domain.name }}</Link>
                    <div class="justify-end flex">
                        <a @click.prevent="destroyDomain(domain.id)" class="p-2 bg-red-400 text-white rounded inline-block text-center hover:bg-red-500" href="#">Delete</a>
                    </div>
                </div>
            </div>
        </div>
        <p v-else >There is not domains</p>
    </div>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";
import {Link} from "@inertiajs/vue3";
import CloudflareAccountLayout from "@/Layouts/CloudflareAccountLayout.vue";

export default {
    name: "DomainIndex",
    layout: CloudflareAccountLayout,
    props: {
        domains: Array,
        cloudflareAccount: Object
    },
    components: {
        Link
    },
    mounted() {
        this.$parent.setFalse();
        this.$parent.isYouInDomains = true
    },
    methods: {
        destroyDomain(domainId) {
            axios.delete(`/cloudflare-accounts/${this.cloudflareAccount.id}/domains/${domainId}`)
                .then(res => {
                    this.$inertia.reload();
                })
        }
    }
}
</script>

<style scoped>

</style>
