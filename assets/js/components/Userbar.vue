<template>
    <ul class="nav navbar-nav">
        <li
            v-if="userPartners.length > 0"
            class="dropdown admin-menu"
        >
            <a
                id="partner-switch-dropdown"
                href="#"
                class="dropdown-toggle"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
            >
                <i class="fa fa-sitemap" /> Active Partner: <span v-text="userActivePartner.title" />
            </a>

            <ul
                class="dropdown-menu dropdown-menu-right"
                role="menu"
                aria-labelledby="partner-switch-dropdown"
            >
                <li
                    v-for="partner in userPartners"
                    :key="partner.id"
                >
                    <a
                        href="#"
                        @click.prevent="switchPartner(partner.id)"
                    >
                        <i
                            class="fa fa-fw fa-group"
                        />
                        {{ partner.title }}
                    </a>
                </li>
            </ul>
        </li>
        <!-- Authentication Links -->
        <li class="dropdown user admin-menu">
            <a
                id="admin-dropdown"
                href="#"
                class="dropdown-toggle"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
            >
                <i class="fa fa-gear" /> Administration
            </a>

            <ul
                class="dropdown-menu dropdown-menu-right"
                role="menu"
                aria-labelledby="admin-dropdown"
            >
                <li
                    v-for="link in links"
                    :key="link.id"
                >
                    <router-link :to="link.route">
                        <i
                            class="fa"
                            :class="'fa-' + link.icon"
                        />
                        {{ link.title }}
                    </router-link>
                </li>
            </ul>
        </li>
    </ul>
</template>

<script>
import {mapGetters} from 'vuex';
import axios from 'axios';

export default {
        props:[],
        data() {
            return {
                links: [
                    { title: "Manage Users", route: { name: 'admin-users' }, icon: "user" },
                    { title: "Manage Groups", route: { name: 'admin-groups' }, icon: "list" },
                    { title: "Manage Fulfillment Periods", route: { name: 'partners-fulfillment' }, icon: "calendar" },
                    { title: "Manage Distribution Methods", route: { name: 'partners-dist-methods' }, icon: "archive" },
                    { title: "Manage Partner Profile Attributes", route: { name: 'admin-partner-attribute' }, icon: "list-alt" },
                    { title: "Manage Client Profile Attributes", route: { name: 'admin-client-attribute' }, icon: "list-alt" },
                    { title: "Configuration", route: "/admin/configuration", icon: "wrench" },
                ]
            }
        },
        computed: {
            ...mapGetters([
                'userActivePartner',
                'userPartners'
            ])
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            switchPartner(id) {
                let self = this;
                axios
                    .post('/api/users/active-partner', {active_partner: id})
                    .then((response) => {
                        self.$store.dispatch('loadCurrentUser')
                    });
            }
        }
    }
</script>
