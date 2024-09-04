<template>
    <div class="bg-white p-4 rounded min-h-screen shadow-md">
        <h3 class="text-3xl mb-6">Edit Page Rule for "{{domain.name}}"</h3>
        <div class="mb-4 bg-red-600 text-white rounded p-2" v-if="error && error.message">{{ error.message }}</div>
        <div class="mb-4 bg-red-600 text-white rounded p-2" v-if="error && error.error_messages && error.error_messages.length > 0">{{ error.error_messages[0].message }}</div>
        <div class="mb-4">
            <label class="block mb-2">URL</label>
            <input v-model="pageRule.targets[0].constraint.value" class="w-1/2 rounded p-2 border-gray-300" placeholder="URL">
<!--            <div v-if="error.errors.account_id" class="text-red-600 text-xs mx-1 mt-1">{{ error.errors.account_id[0] }}</div>-->
        </div>
        <div class="mb-4 w-1/2">
            <label class="block mb-2">Actions</label>
            <a href="#" class="text-blue-500" @click.prevent="addAction">Add</a>
            <div class="flex justify-between" v-for="action in pageRule.actions">
                <div>
                    <select @change="action.value = ''" v-model="action.id" class="rounded p-2 border-gray-300 mb-6">
                        <option value="browser_cache_ttl">browser_cache_ttl</option>
                        <option value="browser_check">browser_check</option>
                        <option value="cache_deception_armor">cache_deception_armor</option>
                        <option value="edge_cache_ttl">edge_cache_ttl</option>
                        <option value="email_obfuscation">email_obfuscation</option>
                        <option value="ip_geolocation">ip_geolocation</option>
                        <option value="explicit_cache_control">explicit_cache_control</option>
                        <option value="rocket_loader">rocket_loader</option>
                        <option value="ssl">ssl</option>
                    </select>
                </div>
                <div>
                    <select v-if="booleanActionIds.includes(action.id)" v-model="action.value" style="width: 4rem" class="rounded p-2 border-gray-300 mb-6">
                        <option value="off">off</option>
                        <option value="on">on</option>
                    </select>
                    <input v-else-if="ttlActionIds.includes(action.id)" v-model="action.value" class="rounded p-2 border-gray-300" placeholder="Value in seconds">
                    <input v-else v-model="action.value" class="rounded p-2 border-gray-300" placeholder="Value">
                </div>
                <div>
                    <a href="#" @click.prevent="removeAction(action)" class="text-red-500">Remove</a>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <button @click.prevent="updatePageRule" class="p-3 text-white rounded text-center hover:bg-emerald-500 bg-emerald-400">Save</button>
        </div>
        <div>
            <Link class="p-2 bg-blue-400 text-white rounded inline-block text-center hover:bg-blue-500" :href="route('cloudflare.domains.page-rules.index', [cloudflareAccount.id, domain.id])">Go back</Link>
        </div>
    </div>
</template>
<script>
import {Link} from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import CloudflareAccountLayout from "@/Layouts/CloudflareAccountLayout.vue";

export default {
    name: "PageRuleEdit",
    components: {Link},
    layout: CloudflareAccountLayout,
    props: {
        cloudflareAccount: Object,
        domain: Object,
        pageRule: Object
    },
    mounted() {
        this.$parent.setFalse();
        this.$parent.isYouInDomains = true
    },
    data() {
        return {
            error:{},
            booleanActionIds: [
                'browser_check',
                'ip_geolocation',
                'cache_deception_armor',
                'email_obfuscation',
                'explicit_cache_control',
                'rocket_loader'
            ],
            ttlActionIds: [
                'browser_cache_ttl',
                'edge_cache_ttl'
            ]
        }
    },
    methods: {
        updatePageRule() {
            this.error = {}
            axios.put(`/cloudflare-accounts/${this.cloudflareAccount.id}/domains/${this.domain.id}/page-rules/${this.pageRule.id}`, this.pageRule)
                .then(res => {
                    // this.$inertia.visit(`/cloudflare-accounts/${this.cloudflareAccount.id}/domains/${this.domain.id}/page-rules`)
                    this.$inertia.reload();
                })
                .catch(err => {
                    this.error = err.response.data;
                })
        },
        addAction() {
            this.pageRule.actions.push({id: '', value: ''})
        },
        removeAction(action) {
            this.pageRule.actions = this.pageRule.actions.filter(function(item) {
                return item !== action
            })
        }
    }
}
</script>
