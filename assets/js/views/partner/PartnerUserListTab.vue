<template>
    <table-paged
        v-if="partner.id"
        :columns="columns"
        :api-url="apiUrl"
        :params="{include: ['partners']}"
        link-display-property="email"
        edit-route="/admin/users/"
    />
</template>

<script>
    import TablePaged from "../../components/TablePaged";
    export default {
        name: "PartnerUserListTab",
        components: {TablePaged},
        props: {
            partner: { type: Object, required: true }
        },
        data() {
            return {
                columns: [
                    { name: '__slot:link', title: "User Email", sortField: 'email' },
                    { name: 'name.firstName', title: "First Name", sortField: 'u.name.firstname' },
                    { name: 'name.lastName', title: "Last Name", sortField: 'u.name.lastname' },
                    {
                        name: 'partners',
                        title: "Assigned Partners",
                        callback: (value) => value.map((partner) => partner.title).join(', ')
                    },
                    { name: 'createdAt', title: "Created", callback: 'dateTimeFormat', sortField: 'createdAt' },
                    { name: 'updatedAt', title: "Last Updated", callback: 'dateTimeFormat', sortField: 'updatedAt' },
                ],
            }
        },
        computed: {
            apiUrl: function () {
                console.log({ partner: this.partner });
                return "/api/users/partner/" + this.partner.id;
            }
        }
    }
</script>