<template>
    <section class="content">
        <div class="row">
            <h3 class="box-title col-lg-10">
                Supply Totals Report
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
            <div class="col-lg-2 col-sm-4">
                <div class="form-group">
                    <label>Type</label>
                    <select
                        v-model="filters.supplierType"
                        v-chosen
                        class="form-control"
                    >
                        <option value="">
                            --All Supplier Types--
                        </option>
                        <option value="DONOR">
                            Donor
                        </option>
                        <option value="VENDOR">
                            Vendor
                        </option>
                        <option value="DIAPERDRIVE">
                            Diaper Drive
                        </option>
                        <option value="DROPSITE">
                            Dropsite
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <supplierselectionform
                    v-model="filters.supplier"
                    :address="false"
                    label="Supplier"
                />
            </div>

            <div class="form-group col-lg-3 col-sm-6">
                <datefield
                    v-model="filters.startingAt"
                    label="Start Date Created"
                />
            </div>
            <div class="form-group col-lg-3 col-sm-6">
                <datefield
                    v-model="filters.endingAt"
                    label="End Date Created"
                />
            </div>

            <div class="col-xs-1 text-right">
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
                        :sort-order="[{ field: 's.id', direction: 'asc' }]"
                        :params="requestParams()"
                        :per-page="50"
                        api-url="/api/reports/supplier-totals"
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
    import SupplierSelectionForm from '../../components/SupplierSelectionForm.vue';
    import TablePaged from '../../components/TablePaged.vue';
    export default {
        components: {
            'datefield' : DateField,
            'supplierselectionform' : SupplierSelectionForm,
            'tablepaged' : TablePaged
        },
        props:[],
        data() {
            let columns = [
                { name: "id", title: "Supplier ID", sortField: "s.id" },
                { name: "name", title: "Supplier", sortField: "s.title" },
                { name: "type", title: "Supplier Type", sortField: "s.supplierType" },
                { name: "total", title: "Total Supplied", sortField: "total", dataClass: "text-right", titleClass: "text-right" },
            ];

            return {
                transactions: {},
                locations: [],
                columns: columns,
                filters: {
                    supplier: {},
                    supplierType: null,
                    product: {},
                    endingAt: null,
                    startingAt: null,
                    orderType: {},
                },
            };
        },
        mounted() {
            let me = this;
            this.$store.dispatch('loadProducts').then((response)=>{
                let newColumns = [];
                me.$store.getters.allOrderableProducts.forEach(function(product) {
                    newColumns.push(
                        { name: product.sku, title: product.name, sortField: "total" + product.id, dataClass: "text-right", titleClass: "text-right" }
                    );
                });
                me.columns.splice(-1, 0, ...newColumns);
                me.$refs.hbtable.reinitializeFields();
            });
            console.log('Component mounted.')
        },
        methods: {
            requestParams: function () {
                return {
                    supplier: this.filters.supplier.id || null,
                    supplierType: this.filters.supplierType || null,
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
                    .get('/api/reports/supplier-totals', { params: params, responseType: 'blob' })
                    .then(response => {
                        let filename = response.headers['content-disposition'].match(/filename="(.*)"/)[1]
                        fileDownload(response.data, filename, response.headers['content-type'])
                    });
            }
        }
    }
</script>
