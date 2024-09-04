<template>
    <header class="p-3 w-full bg-white shadow">
        <div class="w-3/4 flex mx-auto justify-between">
            <div class="flex">
                <div>WEB PANEL</div>
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
    <div class="md:m-0 md:my-4 m-4">
        <slot/>
    </div>
</template>

<script>
import {Link} from "@inertiajs/vue3";

export default {
    name: "MainLayout",
    components: {
        Link
    },
    methods: {
        logout() {
            this.$inertia.post(route('logout'));
        }
    }
}
</script>

<style scoped>

</style>
