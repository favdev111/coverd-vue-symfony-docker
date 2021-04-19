<template>
    <section class="content">
        <div class="pull-right">
            <button
                class="btn btn-success btn-flat"
                @click.prevent="save"
            >
                <i class="fa fa-save fa-fw" />Save Product
            </button>
            <div class="btn-group">
                <button
                    type="button"
                    class="btn btn-default dropdown-toggle dropdown btn-flat"
                    data-toggle="dropdown"
                >
                    <span class="fa fa-ellipsis-v" />
                </button>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li>
                        <a
                            href="#"
                            @click.prevent="askDelete"
                        >
                            <i class="fa fa-trash fa-fw" />Delete Product
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <h3 class="box-title">
            Edit Product
        </h3>

        <div class="row">
            <div role="form">
                <div class="col-md-6">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <i class="icon fa fa-tag fa-fw" />Product Info
                            </h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Product Name</label>
                                <input
                                    v-model="product.name"
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter product name"
                                >
                            </div>
                            <div class="form-group">
                                <optionlist
                                    v-model="product.productCategory"
                                    label="Product Category"
                                    api-path="product-categories"
                                />
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select
                                    v-model="product.status"
                                    class="form-control"
                                >
                                    <option value="ACTIVE">
                                        Active
                                    </option>
                                    <option value="INACTIVE">
                                        Inactive
                                    </option>
                                    <option value="OUTOFSTOCK">
                                        Out of Stock
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Product SKU</label>
                                <input
                                    v-model="product.sku"
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter product SKU"
                                >
                                <p class="help-block">
                                    This should match the SKU from the portal.
                                </p>
                            </div>
                            <div class="form-group">
                                <label>Product Color</label>
                                <verte
                                    v-model="product.color"
                                    :enable-alpha="false"
                                    :picker="'square'"
                                    model="hex"
                                    value="#3c8dbc"
                                />
                                <p class="help-block">
                                    Click the color swatch above for a color picker.
                                </p>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>

                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <i class="icon fa fa-money fa-fw" />Pricing Info
                            </h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Default Cost Each</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-dollar" /></span>
                                    <input
                                        v-model="product.defaultCost"
                                        type="text"
                                        class="form-control"
                                    >
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Retail Price Each</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-dollar" /></span>
                                    <input
                                        v-model="product.retailPrice"
                                        type="text"
                                        class="form-control"
                                    >
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>


                <div class="col-md-6">
                    <div
                        v-if="!create"
                        class="info-box"
                    >
                        <span class="info-box-icon bg-aqua"><i class="fa fa-industry" /></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Current Warehouse Inventory</span>
                            <span class="info-box-number">{{ inventory.warehouse | numberFormat }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                    <div
                        v-if="!create"
                        class="info-box"
                    >
                        <span class="info-box-icon bg-aqua"><i class="fa fa-sitemap" /></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Current Partner Inventory</span>
                            <span class="info-box-number">{{ inventory.partner | numberFormat }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                    <div
                        v-if="!create"
                        class="info-box"
                    >
                        <span class="info-box-icon bg-aqua"><i class="fa fa-globe" /></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Current Total Network Inventory</span>
                            <span class="info-box-number">{{ inventory.total | numberFormat }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-6">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <i class="icon fa fa-th fa-fw" />Packing Info
                            </h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Agency Packs Per Bag</label>
                                <input
                                    v-model="product.agencyPacksPerBag"
                                    type="text"
                                    class="form-control"
                                >
                            </div>
                            <div class="form-group">
                                <label>Agency Pack Size</label>
                                <input
                                    v-model="product.agencyPackSize"
                                    type="text"
                                    class="form-control"
                                >
                            </div>
                            <div class="form-group">
                                <label>Agency Max Distributable Packs per client order</label>
                                <input
                                    v-model="product.agencyMaxPacks"
                                    type="text"
                                    class="form-control"
                                >
                            </div>
                            <div class="form-group">
                                <label>Hospital Packs Per Bag</label>
                                <input
                                    v-model="product.hospitalPacksPerBag"
                                    type="text"
                                    class="form-control"
                                >
                            </div>
                            <div class="form-group">
                                <label>Hospital Pack Size</label>
                                <input
                                    v-model="product.hospitalPackSize"
                                    type="text"
                                    class="form-control"
                                >
                            </div>
                            <div class="form-group">
                                <label>Hospital Max Distributable Packs per client order</label>
                                <input
                                    v-model="product.hospitalMaxPacks"
                                    type="text"
                                    class="form-control"
                                >
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>
        </div>
        <modal
            id="confirmModal"
            :confirm-action="this.deleteProduct"
            classes="modal-danger"
        >
            <template slot="header">
                Delete Product
            </template>
            <p>Are you sure you want to delete <strong>{{ product.title }}</strong>?</p>
            <template slot="confirmButton">
                Delete Product
            </template>
        </modal>
    </section>
</template>


<script>
    import Verte from "verte";
    import Modal from '../../components/Modal';
    import OptionListEntity from '../../components/OptionListEntity.vue';
    export default {
        components: {
            Verte,
            'modal' : Modal,
            'optionlist' : OptionListEntity
        },
        props: ['create'],
        data() {
            return {
                product: {
                    productCategory: {},
                    color: '#3c8dbc'
                },
                inventory: {}
            };
        },
        created() {
            var self = this;

            if (this.create) {
                // this.product.contacts.push({isDeleted: false});
                // this.product.addresses.push({isDeleted: false});
            } else {
                axios
                    .get('/api/products/' + this.$route.params.id)
                    .then(response => self.product = response.data.data);
                axios
                    .get('/api/products/' + this.$route.params.id + '/inventory')
                    .then(response => self.inventory = response.data);
            }
            console.log('Component mounted.')
        },
        methods: {
            save: function () {
                var self = this;
                if (this.create) {
                    axios
                        .post('/api/products', this.product)
                        .then(response => self.$router.push('/products'))
                        .catch(function (error) {
                            console.log(error);
                        });
                } else {
                    axios
                        .patch('/api/products/' + this.$route.params.id, this.product)
                        .then(response => self.$router.push('/products'))
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            },
            askDelete: function () {
                $('#confirmModal').modal('show');
            },
            deleteProduct: function () {
                var self = this;
                axios
                    .delete('/api/products/' + this.$route.params.id)
                    .then(self.$router.push('/products'));
            },
            updateCat: function (value) {
                debugger;
            }
        }
    }
</script>

<style scoped>
    .verte {justify-content: left;}
</style>
