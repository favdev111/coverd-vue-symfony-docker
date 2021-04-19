<template>
    <modal
        id="confirmModal"
        :confirm-action="action"
        classes="modal-danger"
    >
        <template slot="header">
            Delete Order
        </template>
        <p>Are you sure you want to delete <strong>{{ orderTitle }}</strong>?</p>
        <template slot="confirmButton">
            Delete Order
        </template>
    </modal>
</template>

<script>
    import Modal from '../components/Modal.vue';

    export default {
        components: {
            'modal' : Modal
        },
        props: {
            action: { type: Function },
            orderTitle: {type: String },
        },
    }
</script>
