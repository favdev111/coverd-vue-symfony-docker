<template>
    <div class="box-body form-horizontal">
        <div class="form-group">
            <h4 :class="{'col-xs-8': showCost || showPacks, 'col-xs-10': !showCost && !showPacks }">
                Product
            </h4>
            <h4
                v-if="showPacks"
                class="col-xs-2"
            >
                Packs
            </h4>
            <h4 class="col-xs-2">
                Quantity
            </h4>
            <h4
                v-if="showCost"
                class="col-xs-2"
            >
                Cost
            </h4>
        </div>
        <template>
            <div
                v-for="product in products"
                :key="product.id"
            >
                <div v-if="findLineItem(product)">
                    <hr>
                    <lineitemformrow
                        :line-item="findLineItem(product)"
                        :show-cost="showCost"
                        :editable="editable"
                        :show-packs="showPacks"
                        :partner-type="partnerType"
                    />
                </div>
            </div>
        </template>
    </div>
</template>

<script>
    import LineItemFormRow from './LineItemByProductFormRow.vue';
    export default {
        name: 'LineItemByProductForm',
        components: {
            'lineitemformrow' : LineItemFormRow
        },
        props: {
            products: { type: Array, required: true },
            lineItems: { type: Array, required: true },
            editable: { type: Boolean, default: true },
            showCost: { type: Boolean, default: false },
            showPacks: { type: Boolean, default: false },
            partnerType: { type: String, default: 'AGENCY' }
        },
        methods: {
            findLineItem: function(product) {
                let self = this;
                let lineItem = this.lineItems.filter(function(line) {
                    return line.product.id === product.id && !line.client;
                }).pop();

                if (!lineItem) {
                    lineItem = self.lineItems.push({
                        product: product,
                        cost: product.defaultCost,
                        quantity: null,
                    });
                }

                return lineItem;
            }
        }
    }
</script>
