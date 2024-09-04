<template>
    <div class="bg-white p-4 rounded xl:w-3/4 xl:mx-auto mx-3 min-h-screen shadow-md">
        <h3 class="text-3xl mb-6">Create cloudflare account</h3>
        <div class="mb-4 bg-red-600 text-white rounded p-2" v-if="error.message">{{ error.message }}</div>
        <div class="mb-4">
            <label class="block mb-2">Account id</label>
            <input v-model="cloudflareAccount.account_id" class="w-1/2 rounded p-2 border-gray-300" placeholder="Account id">
<!--            <div v-if="error.errors.account_id" class="text-red-600 text-xs mx-1 mt-1">{{ error.errors.account_id[0] }}</div>-->
        </div>
        <div class="mb-4">
            <label class="block mb-2">Email</label>
            <input v-model="cloudflareAccount.email" class="w-1/2 rounded p-2 border-gray-300" placeholder="Email">
<!--            <div v-if="error.errors.email" class="text-red-600 text-xs mx-1 mt-1">{{ error.errors.email[0] }}</div>-->
        </div>
        <div class="mb-4">
            <label class="block mb-2">API key</label>
            <input v-model="cloudflareAccount.api_key" class="w-1/2 rounded p-2 border-gray-300" placeholder="API key">
<!--            <div v-if="error.errors.api_key" class="text-red-600 text-xs mx-1 mt-1">{{ error.errors.api_key[0] }}</div>-->
        </div>
        <div class="mb-3">
            <button @click.prevent="storeCloudflareAccount" class="p-3 text-white rounded text-center hover:bg-emerald-500 bg-emerald-400">Create</button>
        </div>
        <div>
            <Link class="p-2 bg-blue-400 text-white rounded inline-block text-center hover:bg-blue-500" :href="route('cloudflare-accounts.index')">Go back</Link>
        </div>
    </div>
</template>
<script>
import {Link} from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";

export default {
    name: "Create",
    components: {Link},
    layout: MainLayout,
    data() {
        return {
            error: {
                message: '',
                errors: {}
            },
            cloudflareAccount: {}
        }
    },
    methods: {
        storeCloudflareAccount() {
            this.error = {}
            axios.post('/cloudflare-accounts', this.cloudflareAccount)
                .then(res => {
                    this.$inertia.visit('/cloudflare-accounts')
                })
                .catch(err => {
                    this.error = err.response.data;
                })
        }
    }
}
</script>
