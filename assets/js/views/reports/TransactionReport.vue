<template>
    <section class="content">
        <div class="row">
            <h3 class="box-title col-lg-10">
                Transactions Report
            </h3>
            <div class="col-lg-2 text-right">
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
                            <a @click="downloadExcel"><i class="fa fa-fw fa-file-excel" />Excel</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <storagelocationselectionform
                    v-model="filters.location"
                />
            </div>
            <div class="col-lg-2 col-sm-4">
                <productselection
                    v-model="filters.product"
                />
            </div>
            <div class="col-lg-2 col-sm-4">
                <optionlist
                    v-model="filters.orderType"
                    label="Order Type"
                    :preloaded-options="[
                        { id: 'PartnerOrder', name: 'Partner Order' },
                        { id: 'TransferOrder', name: 'Transfer' },
                        { id: 'AdjustmentOrder', name: 'Stock Change' },
                        { id: 'BulkDistribution', name: 'Partner Distribution' },
                        { id: 'SupplyOrder', name: 'Supply Order' },
                    ]"
                />
            </div>

            <div class="form-group col-lg-2 col-sm-4">
                <datefield
                    v-model="filters.startingAt"
                    label="Start Date Created"
                />
            </div>
            <div class="form-group col-lg-2 col-sm-4">
                <datefield
                    v-model="filters.endingAt"
                    label="End Date Created"
                />
            </div>

            <div class="col-xs-1">
                <button
                    class="btn btn-success btn-flat"
                    @click="doFilter"
                >
                    <i class="fa fa-fw fa-filter" />Filter
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <tablepaged
                        ref="hbtable"
                        :columns="columns"
                        :sort-order="[{ field: 'id', direction: 'desc'}]"
                        :params="requestParams()"
                        :per-page="50"
                        api-url="/api/reports/transactions"
                    />
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
</template>

<script>
    import DateField from '../../components/DateField.vue';
    import OptionListEntity from '../../components/OptionListEntity.vue';
    import ProductSelectionField from '../../components/ProductSelectionField.vue';
    import StorageLocationSelectionForm from '../../components/StorageLocationSelectionForm.vue';
    import TablePaged from '../../components/TablePaged.vue';
    export default {
        components: {
            'datefield' : DateField,
            'optionlist': OptionListEntity,
            'productselection' : ProductSelectionField,
            'storagelocationselectionform' : StorageLocationSelectionForm,
            'tablepaged' : TablePaged
        },
        props:[],
        data() {
            return {
                transactions: {},
                locations: [],
                columns: [
                    { name: "id", title: "Transaction ID", sortField: "id" },
                    { name: "product", title: "Product", sortField: "p.name" },
                    { name: "storageLocation", title: "Storage Location", sortField: "s.title" },
                    { name: "delta", title: "Change", sortField: "delta" },
                    { name: "orderType", title: "Order Type"},
                    { name: "order", title: "Order #", sortField: "o.id" },
                    { name: "reason", title: "Reason" },
                    { name: "isCommitted", title: "Committed", sortField: "committed" },
                    { name: "committedAt", title: "Date Committed", sortField: "committedAt", callback: 'dateTimeFormat' },
                    { name: "createdAt", title: "Date Created", sortField: "createdAt", callback: 'dateTimeFormat' },
                ],
                filters: {
                    location: {},
                    product: {},
                    endingAt: null,
                    startingAt: null,
                    orderType: {},
                },
            };
        },
        created() {
            console.log('Component mounted.')
        },
        methods: {
            requestParams: function () {
                return {
                    location: this.filters.location.id || null,
                    product: this.filters.product.id || null,
                    orderType: this.filters.orderType.id || null,
                    startingAt: this.filters.startingAt ? moment(this.filters.startingAt).startOf('day').toISOString() : null,
                    endingAt: this.filters.endingAt ? moment(this.filters.endingAt).endOf('day').toISOString() : null,
                }
            },
            doFilter () {
                this.$events.fire('filter-set', this.requestParams());
            },
            downloadExcel () {
                let params = this.requestParams();
                params.download = 'xlsx';
                axios
                    .get('/api/reports/transactions', { params: params, responseType: 'blob' })
                    .then(response => {
                        let filename = response.headers['content-disposition'].match(/filename="(.*)"/)[1]
                        fileDownload(response.data, filename, response.headers['content-type'])
                    });
            }
        }
    }
</script>
