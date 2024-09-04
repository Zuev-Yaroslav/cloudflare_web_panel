<template>
    <div class="bg-white p-4 rounded min-h-screen shadow-md">
        <div class="rounded border p-3 mb-3">
            <div>
                <p class="font-bold">{{ cloudflareAccount.name }}</p>
                <p>{{ cloudflareAccount.email }}</p>
            </div>
        </div>
        <div class="flex justify-end">
            <a @click.prevent="destroyAccount" class="p-2 bg-red-400 text-white rounded inline-block text-center hover:bg-red-500" href="#">Delete account</a>
        </div>
    </div>
</template>

<script>
import CloudflareAccountLayout from "@/Layouts/CloudflareAccountLayout.vue";
import {Link} from "@inertiajs/vue3";

export default {
    name: "AccountShow",
    props: {
        cloudflareAccount: Object,

    },
    mounted() {
        this.$parent.setFalse();
        this.$parent.isYouInAccount = true
    },
    methods: {
        destroyAccount() {
            axios.delete(`/cloudflare-accounts/${this.cloudflareAccount.id}`)
                .then(res => {
                    this.$inertia.visit(route('cloudflare-accounts.index'));
                })
        }
    },
    components: {Link},
    layout: CloudflareAccountLayout
}
</script>

<style scoped>

</style>
