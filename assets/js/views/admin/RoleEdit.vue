<template>
    <section class="content">
        <div class="pull-right">
            <button
                class="btn btn-success btn-flat"
                @click.prevent="save"
            >
                <i class="fa fa-save fa-fw" />
                Save Group
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
                            <i class="fa fa-trash fa-fw" />
                            Delete Group
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <h3 class="box-title">
            Edit Group
        </h3>

        <div class="row">
            <form role="form">
                <div class="col-md-6">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <i class="icon fa fa-group fa-fw" />Group Info
                            </h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Group Name</label>
                                <input
                                    v-model="group.name"
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter role name"
                                >
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <i class="icon fa fa-lock fa-fw" />Roles
                            </h3>
                            <div class="box-body">
                                <div
                                    v-for="role in roles"
                                    :key="role.id"
                                >
                                    <input
                                        :id="role"
                                        v-model="group.roles"
                                        type="checkbox"
                                        name="role[]"
                                        :value="role"
                                    >
                                    <label :for="role">
                                        {{ role }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <modal
            id="confirmModal"
            :confirm-action="this.deleteGroup"
            classes="modal-danger"
        >
            <template slot="header">
                Delete Group
            </template>
            <p>Are you sure you want to delete <strong>{{ group.name }}</strong>?</p>
            <template slot="confirmButton">
                Delete Group
            </template>
        </modal>
    </section>
</template>


<script>
    import Modal from '../../components/Modal.vue';

    export default {
        components: {
            'modal' : Modal
        },
        props: ['new'],
        data() {
            return {
                group: {
                    roles: [],
                },
                roles: [],
            };
        },
        created() {
            var self = this;

            if (!this.new) {
                axios
                    .get('/api/groups/' + this.$route.params.id)
                    .then(response => self.group = response.data.data);
            }

            axios
                .get('/api/groups/list-roles')
                .then(response => self.roles = response.data);

            console.log('Component mounted.')
        },
        methods: {
            save: function () {
                var self = this;
                if (this.new) {
                    axios
                        .post('/api/groups', this.group)
                        .then(response => self.$router.push({ name: 'admin-groups' }))
                        .catch(function (error) {
                            console.log(error);
                        });
                } else {
                    axios
                        .patch('/api/groups/' + this.$route.params.id, this.group)
                        .then(response => self.$router.push({ name: 'admin-groups' }))
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            },
            askDelete: function() {
                $('#confirmModal').modal('show');
            },
            deleteGroup: function() {
                var self = this;
                axios
                    .delete('/api/groups/' + this.$route.params.id)
                    .then(self.$router.push({ name: 'admin-groups' }));
            }
        }
    }
</script>
