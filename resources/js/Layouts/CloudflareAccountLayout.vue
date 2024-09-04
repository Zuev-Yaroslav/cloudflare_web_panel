<template>
    <header class="p-3 w-full bg-white shadow">
        <div class="w-3/4 flex mx-auto justify-between">
            <div class="flex">
                <div>CLOUDFLARE ACCOUNT PANEL</div>
            </div>
            <div class="flex">
                <div v-if="!$page.props.auth.user" class="mx-3">
                    <Link :href="route('login')">Login</Link>
                </div>
                <div v-if="!$page.props.auth.user" class="mx-3">
                    <Link :href="route('register')">Register</Link>
                </div>
                <div v-if="$page.props.auth.user" class="mx-3">
                    <a href="#" @click.prevent="logout">Logout</a>
                </div>
            </div>
        </div>

    </header>
    <div class="flex">
        <div class="m-4" style="width: 12rem">
            <div class="bg-white p-4 rounded min-h-screen shadow-md">
                <Link :href="route('cloudflare-accounts.show', $page.props.cloudflareAccount.id)" :class="(isYouInAccount) ? 'bg-blue-400 text-white' : 'border-blue-400'" class="p-2 rounded border text-center block mb-3">Account</Link>
                <Link :href="route('cloudflare.domains.index', $page.props.cloudflareAccount.id)" :class="(isYouInDomains) ? 'bg-blue-400 text-white' : 'border-blue-400'" class="p-2 rounded border text-center block mb-3">Domains</Link>
                <Link :href="route('cloudflare-accounts.index')" class="p-2 rounded border text-center block mb-3 border-blue-400">Accounts</Link>
            </div>
        </div>
        <div class="m-4 w-full">
                <slot/>
        </div>
    </div>
</template>

<script>
import {Link} from "@inertiajs/vue3";

export default {
    name: "CloudflareAccountLayout",
    components: {
        Link
    },
    data() {
        return {
            isYouInDomains: false,
            isYouInAccount: false,
        }
    },
    methods: {
        setFalse() {
            this.isYouInAccount = false;
            this.isYouInDomains = false;
        },
        logout() {
            this.$inertia.post(route('logout'));
        }
    }
}
</script>

<style scoped>

</style>
