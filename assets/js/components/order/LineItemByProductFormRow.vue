<template>
    <div>
        <div class="form-group">
            <label :class="{'col-xs-8': showCost || showPacks, 'col-xs-10': !showCost && !showPacks }">
                <i
                    class="fa fa-plus-circle text-gray fa-fw"
                    title="Show/Hide Transactions"
                    @click="showTransactions = !showTransactions"
                />
                {{ lineItem.product.name }}
                <small
                    v-if="lineItem.product.status == 'OUTOFSTOCK'"
                    class="label bg-red"
                >Currently Out of Stock</small>
            </label>
            <div
                v-if="showPacks"
                class="col-xs-2"
            >
                <strong v-text="packs" /> <small v-text="packs == 1 ? 'pack' : 'packs'" />
            </div>
            <div
                class="col-xs-2"
                :class="{'has-error': showPacks && lineItem.quantity % packSize != 0}"
            >
                <input
                    v-if="editable"
                    v-model="lineItem.quantity"
                    type="text"
                    class="form-control"
                >
                <span
                    v-else
                    v-text="lineItem.quantity"
                />
                <span
                    v-show="showPacks && lineItem.quantity % packSize != 0"
                    class="help-block"
                >
                    Must be a multiple of {{ packSize }}
                </span>
            </div>
            <div
                v-if="showCost"
                class="col-xs-2"
            >
                <input
                    v-if="editable"
                    v-model="lineItem.cost"
                    type="text"
                    class="form-control"
                >
                <span
                    v-else
                    v-text="lineItem.cost"
                />
            </div>
        </div>
        <div
            v-show="showTransactions"
            class="form-group"
        >
            <div class="col-xs-12">
                <lineitemtransactions :transactions="lineItem.transactions" />
            </div>
        </div>
    </div>
</template>

<script>
    import LineItemTransactionTable from '../LineItemTransactionTable.vue';
    export default {
        name: 'LineItemByProductFormRow',
        components: {
            'lineitemtransactions' : LineItemTransactionTable
        },
        props: {
            lineItem: { type: Object, required: true },
            editable: { type: Boolean, default: true },
            showCost: { type: Boolean, default: false },
            showPacks: { type: Boolean, default: false },
            partnerType: { type: String, default: 'AGENCY' },
        },
        data() {
            return {
                showTransactions: false
            };
        },
        computed: {
            packSize: function () {
                if (this.partnerType === 'HOSPITAL' && this.lineItem.product.hospitalPackSize) {
                    return this.lineItem.product.hospitalPackSize;
                }

                return this.lineItem.product.agencyPackSize;
            },

            packs: function () {
                return this.lineItem.quantity / this.packSize;
            }
        }
    }
</script>
