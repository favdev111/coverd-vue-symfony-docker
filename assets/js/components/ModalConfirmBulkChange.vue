<template>
    <modal
        id="bulkChangeModal"
        :confirm-action="action"
        classes="modal-danger"
    >
        <template slot="header">
            Bulk {{ bulkChangeType }}
        </template>
        <p>Are you sure you want to bulk {{ bulkChangeType }} <strong>{{ items.length }}</strong> <strong>{{ itemType }}</strong>?</p>
        <template slot="confirmButton">
            Bulk {{ bulkChangeType }}
        </template>
    </modal>
</template>

<script>
    import Modal from '../components/Modal';

    export default {
        components: {Modal},
        props: {
            action: { type: Function },
            itemType: { type: String, default: 'orders' },
            items: { type: Array },
            bulkChangeType: { type: String, default: 'change' }
        },
    }
</script>
