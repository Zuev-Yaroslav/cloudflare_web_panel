<template>
    <div class="bg-white p-4 rounded min-h-screen shadow-md">
        <h3 class="text-3xl mb-6">Create domain</h3>
        <div class="mb-4 bg-red-600 text-white rounded p-2" v-if="error.message">{{ error.message }}</div>
        <div class="mb-4">
            <label class="block mb-2">Name</label>
            <input v-model="domain.name" class="w-1/2 rounded p-2 border-gray-300" placeholder="Name">
<!--            <div v-if="error.errors.account_id" class="text-red-600 text-xs mx-1 mt-1">{{ error.errors.account_id[0] }}</div>-->
        </div>
        <div class="mb-3">
            <button @click.prevent="storeDomain" class="p-3 text-white rounded text-center hover:bg-emerald-500 bg-emerald-400">Create</button>
        </div>
        <div>
            <Link class="p-2 bg-blue-400 text-white rounded inline-block text-center hover:bg-blue-500" :href="route('cloudflare.domains.index', cloudflareAccount.id)">Go back</Link>
        </div>
    </div>
</template>
<script>
import {Link} from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import CloudflareAccountLayout from "@/Layouts/CloudflareAccountLayout.vue";

export default {
    name: "DomainCreate",
    components: {Link},
    layout: CloudflareAccountLayout,
    props: {
        cloudflareAccount: Object
    },
    mounted() {
        this.$parent.setFalse();
        this.$parent.isYouInDomains = true
    },
    data() {
        return {
            error: {
                message: '',
                errors: {}
            },
            domain: {}
        }
    },
    methods: {
        storeDomain() {
            this.error = {}
            axios.post(`/cloudflare-accounts/${this.cloudflareAccount.id}/domains`, this.domain)
                .then(res => {
                    this.$inertia.visit(`/cloudflare-accounts/${this.cloudflareAccount.id}/domains`)
                })
                .catch(err => {
                    this.error = err.response.data;
                })
        }
    }
}
</script>
