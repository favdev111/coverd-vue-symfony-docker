<template>
    <section class="content">
        <router-link
            :to="{ name: 'supplier-new' }"
            class="btn btn-success btn-flat pull-right"
        >
            <i class="fa fa-plus-circle fa-fw" />
            Create Supplier
        </router-link>
        <h3 class="box-title">
            Suppliers List
        </h3>

        <div class="row">
            <div class="col-xs-2">
                <TextField
                    v-model="filters.keyword"
                    label="Keyword"
                />
            </div>
            <div class="col-xs-2">
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

            <div class="col-xs-2">
                <OptionListStatic
                    v-model="filters.status"
                    label="Status"
                    :preloaded-options="statuses"
                    empty-string="-- All Statuses --"
                />
                <!-- /.input group -->
            </div>
            <div class="col-xs-3">
                <button
                    class="btn btn-success btn-flat"
                    @click="doFilter"
                >
                    <i class="fa fa-fw fa-filter" />
                    Filter
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <div class="col-xs-12">
                            <div class="input-group-btn">
                                <button
                                    type="button"
                                    class="btn btn-info btn-flat dropdown-toggle"
                                    data-toggle="dropdown"
                                    :disabled="selection.length < 2"
                                >
                                    <i class="fa fa-fw fa-wrench" />
                                    Bulk Operations ({{ selection.length }})
                                    <span class="caret" />
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul
                                    class="dropdown-menu"
                                    role="menu"
                                >
                                    <li>
                                        <a @click="onClickMerge()">
                                            <i class="fa fa-compress fa-fw" /> Merge Suppliers
                                        </a>
                                    </li>
                                    <!--<li><a href="#">Separated link</a></li>-->
                                </ul>
                            </div>
                        </div>
                    </div>
                    <TablePaged
                        ref="hbtable"
                        :columns="columns"
                        api-url="/api/suppliers"
                        edit-route="/suppliers/"
                        :sort-order="[{ field: 'title', direction: 'asc'}]"
                        :params="requestParams()"
                        :per-page="50"
                    />
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
        <SupplierMerge
            ref="supplierMerge"
            :selected-supplier-ids="selection"
        />
    </section>
</template>

<script>
    import SupplierMerge from './SupplierMerge.vue';
    import OptionListStatic from '../../components/OptionListStatic.vue';
    import TablePaged from '../../components/TablePaged.vue';
    import TextField from "../../components/TextField";

    export default {
        components: {
            TextField,
            SupplierMerge,
            OptionListStatic,
            TablePaged,
        },
        props:[],
        data() {
            let columns = [
                { name: '__checkbox', title: "#" },
                { name: '__slot:link', title: "Supplier Id", sortField: 'id' },
                { name: "title", title: "Supplier", sortField: "title" },
                { name: "supplierType", title: "Supplier Type", sortField: "supplierType" },
                { name: "status", title: "Status", sortField: "status" },
                { name: 'updatedAt', title: "Last Updated", callback: 'dateTimeFormat', sortField: 'updatedAt' },
            ];

            return {
                columns: columns,
                suppliers: {},
                statuses: [
                    {id: "ACTIVE", name: "Active"},
                    {id: "INACTIVE", name: "Inactive"},
                ],
                filters: {
                    supplierType: null,
                    status: "ACTIVE",
                    keyword: null
                },
                selection: [],
            };
        },
        created() {
            axios
                .get('/api/suppliers')
                .then(response => this.suppliers = response.data);
            console.log('Component mounted.')
        },
        mounted() {
            this.$events.$on('selection-change', eventData => this.onSelectionChange(eventData));
        },
        methods: {
            routerLink: function (id) {
                return "<router-link :to=" + { name: 'supplier-edit', params: { id: id }} + "><i class=\"fa fa-edit\"></i> " + id + "</router-link>";
            },
            onPaginationData (paginationData) {
                this.$refs.pagination.setPaginationData(paginationData)
            },
            onChangePage (page) {
                this.$refs.vuetable.changePage(page)
            },
            doFilter () {
                console.log('doFilter:', this.requestParams());
                this.$events.fire('filter-set', this.requestParams());
            },
            onSelectionChange (selection) {
                this.selection = selection;
            },
            bulkStatusChange (statusId) {
                $('#bulkChangeModal').modal('show');
                this.bulkChange = {
                    status: statusId
                };
            },
            refreshTable()  {
                this.$refs.hbtable.refresh();
            },
            doBulkChange () {
                let self = this;
                axios
                    .patch('/api/supplier/bulk-change', {
                        ids: self.selection,
                        changes: self.bulkChange,
                    })
                    .then(response => self.refreshTable())
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            requestParams: function () {
                return {
                    status: this.filters.status || null,
                    supplierType: this.filters.supplierType || null,
                    keyword: this.filters.keyword || null
                }
            },
            onClickMerge: function () {
                this.$refs.supplierMerge.reset();
                $('#supplierMergeModal').modal('show');
            }
        }
    }
</script>
