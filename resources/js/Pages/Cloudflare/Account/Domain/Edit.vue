<template>
    <div class="bg-white p-4 rounded min-h-screen shadow-md">
        <h3 class="text-3xl mb-6">Edit domain</h3>
        <p class="font-bold mb-3">{{domain.name}}</p>
        <div class="mb-3 border-b">
            <label class="block mb-2">SSL encryption mode</label>
            <select @change="updateSSL" v-model="domain.settings.ssl.value" class="w-1/2 rounded p-2 border-gray-300 mb-6">
                <option value="off">Off</option>
                <option value="flexible">Flexible</option>
                <option value="full">Full</option>
                <option value="strict">Full (strict)</option>
            </select>
        </div>
        <div>
            <Link class="p-2 bg-blue-400 text-white rounded inline-block text-center hover:bg-blue-500 mb-3" :href="route('cloudflare.domains.page-rules.index', [cloudflareAccount.id, domain.id])">Page Rules</Link>
        </div>
        <div class="flex justify-end">
            <a @click.prevent="destroyDomain(domain.id)" class="p-2 bg-red-400 text-white rounded inline-block text-center hover:bg-red-500" href="#">Delete</a>
        </div>
    </div>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";
import {Link} from "@inertiajs/vue3";
import CloudflareAccountLayout from "@/Layouts/CloudflareAccountLayout.vue";

export default {
    name: "DomainEdit",
    layout: CloudflareAccountLayout,
    props: {
        domain: Object,
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
            axios.delete(`/cloudflare-accounts/${this.cloudflareAccount.id}/domains/${this.domain.id}`)
                .then(res => {
                    this.$inertia.visit(route('cloudflare.domains.index', this.cloudflareAccount.id));
                })
        },
        updateSSL() {
            axios.patch(`/cloudflare-accounts/${this.cloudflareAccount.id}/domains/${this.domain.id}/settings/ssl`, this.domain.settings.ssl)
                .then(res => {
                    // this.$inertia.reload();
                })
        }
    }
}
</script>

<style scoped>

</style>
