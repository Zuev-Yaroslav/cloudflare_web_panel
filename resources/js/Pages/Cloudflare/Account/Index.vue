<template>
    <div class="bg-white p-4 w-3/4 mx-auto rounded min-h-screen shadow-md">
        <Link class="p-2 bg-blue-400 text-white rounded inline-block text-center hover:bg-blue-500 mb-3" :href="route('cloudflare-accounts.create')">Create</Link>
        <div v-if="cloudflareAccounts.length > 0" class="w-1/2 mb-3">
            <div v-for="account in cloudflareAccounts" class="rounded border p-3">
                <div>
                    <p class="font-bold">{{ account.name }}</p>
                    <p>{{ account.email }}</p>
                    <div class="justify-end flex">
                        <Link class="p-2 bg-blue-400 text-white rounded inline-block text-center hover:bg-blue-500" :href="route('cloudflare-accounts.show', account.id)" >Go to</Link>
                    </div>
                </div>
            </div>
        </div>
        <p v-else >There is not accounts</p>
    </div>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";
import {Link} from "@inertiajs/vue3";

export default {
    name: "Index",
    layout: MainLayout,
    props: {
        cloudflareAccounts: Array
    },
    components: {
        Link
    }
}
</script>

<style scoped>

</style>
