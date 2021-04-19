<template>
    <section class="content">
        <div class="pull-right">
            <button
                class="btn btn-success btn-flat"
                @click.prevent="save"
            >
                <i class="fa fa-save fa-fw" />Save Supplier
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
                            <i class="fa fa-trash fa-fw" />Delete Supplier
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <h3 class="box-title">
            Edit Supplier
        </h3>

        <div class="row">
            <form role="form">
                <div class="col-md-6">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <i class="icon fa fa-group fa-fw" />Supplier Info
                            </h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Supplier Name</label>
                                <input
                                    v-model="supplier.title"
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter supplier name"
                                >
                            </div>
                            <div class="form-group">
                                <label>Type</label>
                                <select
                                    v-model="supplier.supplierType"
                                    class="form-control"
                                >
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
                            <div class="form-group">
                                <label>Status</label>
                                <select
                                    v-model="supplier.status"
                                    class="form-control"
                                >
                                    <option value="ACTIVE">
                                        Active
                                    </option>
                                    <option value="INACTIVE">
                                        Inactive
                                    </option>
                                </select>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>

                    <template>
                        <div
                            v-for="(address, index) in supplier.addresses"
                            :key="address.id"
                        >
                            <div
                                v-if="!address.isDeleted"
                                class="box box-info"
                            >
                                <div class="box-header with-border">
                                    <button
                                        class="btn btn-xs btn-danger btn-flat pull-right"
                                        title="Remove Address"
                                        @click.prevent="address.isDeleted = true"
                                    >
                                        <i class="fa fa-trash fa-fw" />
                                    </button>
                                    <h3 class="box-title">
                                        <i class="icon fa fa-map-marker fa-fw" />{{ address.title }}
                                    </h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <!-- text input -->
                                    <AddressFormFields
                                        v-model="supplier.addresses[index]"
                                        :has-title="true"
                                    />
                                </div>
                            <!-- /.box-body -->
                            </div>
                            <div
                                v-else=""
                                class="box box-danger bg-gray"
                            >
                                <div class="box-header">
                                    <button
                                        class="btn btn-xs btn-info btn-flat pull-right"
                                        title="Undo Delete"
                                        @click.prevent="address.isDeleted = false"
                                    >
                                        <i class="fa fa-undo fa-fw" />
                                    </button>
                                    <h3 class="box-title">
                                        <i class="icon fa fa-trash fa-fw" />Marked for deletion: {{ address.title }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </template>
                    <button
                        class="btn btn-info btn-flat pull-right"
                        @click.prevent="supplier.addresses.push({isDeleted: false})"
                    >
                        <i class="fa fa-plus fa-fw" />New Address
                    </button>
                </div>

                <div class="col-md-6">
                    <template>
                        <div
                            v-for="contact in supplier.contacts"
                            :key="contact.id"
                        >
                            <div
                                v-if="!contact.isDeleted"
                                class="box box-info"
                            >
                                <div class="box-header with-border">
                                    <button
                                        class="btn btn-xs btn-danger btn-flat pull-right"
                                        title="Remove Contact"
                                        @click.prevent="contact.isDeleted = true"
                                    >
                                        <i class="fa fa-trash fa-fw" />
                                    </button>
                                    <h3 class="box-title">
                                        <i class="icon fa fa-user fa-fw" />{{ contact.firstName }} {{ contact.lastName }}
                                    </h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <ContactFormFields :contact="contact" />
                                </div>
                            <!-- /.box-body -->
                            </div>
                            <div
                                v-else=""
                                class="box box-danger bg-gray"
                            >
                                <div class="box-header">
                                    <button
                                        class="btn btn-xs btn-info btn-flat pull-right"
                                        title="Undo Delete"
                                        @click.prevent="contact.isDeleted = false"
                                    >
                                        <i class="fa fa-undo fa-fw" />
                                    </button>
                                    <h3 class="box-title">
                                        <i class="icon fa fa-trash fa-fw" />Marked for deletion: {{ contact.firstName }} {{ contact.lastName }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </template>
                    <button
                        class="btn btn-info btn-flat pull-right"
                        @click.prevent="supplier.contacts.push({isDeleted: false})"
                    >
                        <i class="fa fa-plus fa-fw" />New contact
                    </button>
                </div>
            </form>
        </div>
        <Modal
            id="confirmModal"
            :confirm-action="this.deleteSupplier"
            classes="modal-danger"
        >
            <template slot="header">
                Delete Supplier
            </template>
            <p>Are you sure you want to delete <strong>{{ supplier.title }}</strong>?</p>
            <template slot="confirmButton">
                Delete Supplier
            </template>
        </Modal>
    </section>
</template>


<script>
    import Modal from '../../components/Modal.vue';
    import AddressFormFields from '../../components/AddressFormFields.vue';
    import ContactFormFields from '../../components/ContactFormFields.vue';

    export default {
        components: {
            Modal,
            AddressFormFields,
            ContactFormFields
        },
        props: ['new'],
        data() {
            return {
                supplier: {
                    addresses: [],
                    contacts: []
                }
            };
        },
        created() {
            var self = this;
            if (this.new) {
                this.supplier.contacts.push({ isDeleted: false });
                this.supplier.addresses.push({ isDeleted: false });
            } else {
                axios
                    .get('/api/suppliers/' + this.$route.params.id, {
                        params: { include: ['contacts', 'addresses']}
                }).then(response => self.supplier = response.data.data);
            }
            console.log('Component mounted.')
        },
        methods: {
            save: function () {
                var self = this;
                if (this.new) {
                    axios
                        .post('/api/suppliers', this.supplier)
                        .then(response => self.$router.push({ name: 'suppliers' }))
                        .catch(function (error) {
                            console.log(error);
                        });
                } else {
                    axios
                        .patch('/api/suppliers/' + this.$route.params.id, this.supplier)
                        .then(response => self.$router.push({ name: 'suppliers' }))
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            },
            askDelete: function() {
                $('#confirmModal').modal('show');
            },
            deleteSupplier: function() {
                var self = this;
                axios
                    .delete('/api/suppliers/' + this.$route.params.id)
                    .then(self.$router.push({ name: 'suppliers' }));
            }
        }
    }
</script>
