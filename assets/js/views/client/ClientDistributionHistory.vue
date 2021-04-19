<template>
    <table-paged
        v-if="client.id"
        :columns="columns"
        :api-url="apiUrl"
        :params="{include: ['order','order.partner']}"
        link-display-property="orderSequence"
        link-id-property="orderId"
        edit-route="/orders/distribution/"
    >
        <template v-slot:toolbar-right>
            <div class="btn-group">
                <button
                    type="button"
                    class="btn btn-info btn-flat dropdown-toggle"
                    data-toggle="dropdown"
                >
                    <i class="fa fa-fw fa-download" />Export
                    <span class="caret" />
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul
                    class="dropdown-menu"
                    role="menu"
                >
                    <li>
                        <a @click="onExportClick(client.id)"><i class="fa fa-fw fa-file-excel" />Excel</a>
                    </li>
                </ul>
            </div>
        </template>
    </table-paged>
</template>

<script>
    import TablePaged from "../../components/TablePaged";
    export default {
        name: "ClientDistributionHistory",
        components: {TablePaged},
        props: {
            client: { type: Object, required: true }
        },
        data() {
            return {
                columns: [
                    { name: '__slot:link', title: 'Order Number'},
                    {
                        name: 'order.distributionPeriod',
                        title: 'Distribution Month',
                        callback: 'periodFormat'
                    },
                    { name: 'order.partner.title', title: 'Partner'},
                    { name: 'product.name', title: 'Size'},
                    { name: 'quantity', title: 'Quantity Distributed'}
                ],
            }
        },
        computed: {
            apiUrl: function () {
                return "/api/clients/" + this.client.id + "/history";
            }
        },
        methods: {
            onExportClick: (clientId) => {
                axios
                    .get('api/clients/' + clientId + '/history/export', { params: {download: 'xlsx'}, responseType: 'blob' })
                    .then(response => {
                        let filename = response.headers['content-disposition'].match(/filename="(.*)"/)[1];
                        fileDownload(response.data, filename, response.headers['content-type']);
                    });
            }
        }
    }
</script>