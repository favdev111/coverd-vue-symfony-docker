<template>
    <modal
        id="clientMergeModal"
        classes="modal-info"
        :confirm-action="mergeClients"
        :confirm-enabled="isTargetSet()"
    >
        <template slot="header">
            Merge Clients
        </template>

        <OptionListEntity
            v-model="targetClient"
            label="Merge clients in to"
            display-property="selectListText"
            :preloaded-options="selectedClients"
            empty-string="-- Select a Destination Client --"
            :chosen="false"
        />

        <template v-if="isTargetSet()">
            <div class="form-group">
                <div class="checkbox">
                    <label for="deactivate">
                        <input
                            id="deactivate"
                            v-model="mergeContext"
                            type="checkbox"
                            value="deactivate"
                        >
                        Deactivate the {{ selectedClientList.length }} merged client(s)
                    </label>
                </div>
            </div>
            Merge the following clients in to <strong>{{ targetClientName }}</strong> <span class="text-white-alpha">&ndash; {{ targetClient.id }}</span>
            <ul>
                <li
                    v-for="client in selectedClientList"
                    :key="client.id"
                    v-html="client"
                />
            </ul>
        </template>

        <template slot="confirmButton">
            Merge
        </template>
    </modal>
</template>


<script>
    import Modal from '../../components/Modal.vue';
    import OptionListEntity from "../../components/OptionListEntity";

    export default {
        name: 'ClientMerge',
        components: {
            OptionListEntity,
            'modal' : Modal,
        },
        props: {
            selectedClientIds: { type: Array, required: true },
        },
        data() {
            return {
                targetClient: {},
                mergeContext: ['deactivate'],
            };
        },
        computed: {
            selectedClients: function () {
                let me = this;
                return this.selectedClientIds.map(clientId => me.$store.getters.getClientById(clientId));
            },
            targetClientName: function () {
                if (this.isTargetSet()) {
                    let target = this.$store.getters.getClientById(this.targetClient.id);
                    return target.fullName;
                }

                return '';
            },
            selectedClientList: function () {
                if (!this.isTargetSet()) return [];
                let me = this;
                let clients = this.selectedClientIds.map(clientId => me.$store.getters.getClientById(clientId));
                clients = clients.filter(client => client.id !== me.targetClient.id);
                return clients.map(client => client.fullName+' <span class="text-white-alpha">&ndash; '+client.id+'</span>')
            },
        },
        created() {
            console.log('Component mounted.')
        },
        mounted() {
            this.$store.dispatch('loadClients');
        },
        methods: {
            mergeClients: function() {
                let me = this;
                axios
                    .post('/api/clients/merge', {
                        targetClient: this.targetClient.id,
                        sourceClients: this.getSourcesClientIds(),
                        context: this.mergeContext,
                    })
                    .then(response => me.$parent.refreshTable())
                    .catch(function (error) {
                        console.log(error);
                    });
                console.log('send the merge');
            },
            fetchTargetClient: function() {
                if (this.targetClient.hasOwnProperty('id')) {
                    return this.$store.getters.getClientById(this.targetClient.id);
                }
            },
            isTargetSet: function () {
                return this.targetClient.hasOwnProperty('id') && !!this.targetClient.id;
            },
            getSourcesClientIds: function () {
                if (!this.isTargetSet()) return [];
                let me = this;
                let clients = this.selectedClientIds.map(clientId => me.$store.getters.getClientById(clientId));
                clients = clients.filter(client => client.id !== me.targetClient.id);
                return clients.map(client => client.id);
            },
            reset: function() {
                this.targetClient = {};
                this.mergeContext = ['deactivate'];
            }
        }
    }
</script>
