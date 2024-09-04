<template>
    <div class="bg-white p-4 rounded min-h-screen shadow-md">
        <h3 class="text-3xl mb-6">Page Rules of "{{domain.name}}"</h3>
        <Link class="p-2 bg-blue-400 text-white rounded inline-block text-center hover:bg-blue-500 mb-3" :href="route('cloudflare.domains.page-rules.create', [cloudflareAccount.id, domain.id])">Create</Link>
        <div v-if="pageRules.length > 0" class="w-1/2 mb-3">
            <div v-for="pageRule in pageRules" class="rounded border p-3 mb-3">
                <div>
                    <Link :href="route('cloudflare.domains.page-rules.edit', [cloudflareAccount.id, domain.id, pageRule.id])" class="font-bold">{{ pageRule.targets[0].constraint.value }}</Link>
                    <p v-for="action in pageRule.actions">{{action.id}}: {{action.value}}</p>
                    <div class="justify-end flex">
                        <a @click.prevent="destroyPageRule(pageRule.id)" class="p-2 bg-red-400 text-white rounded inline-block text-center hover:bg-red-500" href="#">Delete</a>
                    </div>
                </div>
            </div>
        </div>
        <p v-else >There is not page rules</p>
    </div>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";
import {Link} from "@inertiajs/vue3";
import CloudflareAccountLayout from "@/Layouts/CloudflareAccountLayout.vue";

export default {
    name: "PageRuleIndex",
    layout: CloudflareAccountLayout,
    props: {
        pageRules: Array,
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
        destroyPageRule(pageRuleId) {
            axios.delete(`/cloudflare-accounts/${this.cloudflareAccount.id}/domains/${this.domain.id}/page-rules/${pageRuleId}`)
                .then(res => {
                    this.$inertia.reload();
                })
        }
    }
}
</script>

<style scoped>

</style>
