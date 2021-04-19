<template>
    <div>
        <optionlist
            v-if="editable"
            v-model="value"
            :label="label"
            :preloaded-options="allActiveProducts"
            display-property="name"
            empty-string="-- Select Product --"
            @change="onSelectionChange"
        />
        <span
            v-else
            v-text="value.name"
        />
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'
    import OptionListEntity from './OptionListEntity';
    export default {
        components: {
            'optionlist' : OptionListEntity
        },
        props: {
            value: { required: true, type: Object },
            editable: { type: Boolean, default: true },
            label: { type: [String, Boolean], default: "Product:"}
        },
        computed: mapGetters([
            'allActiveProducts'
        ]),
        mounted: function () {
            this.$store.dispatch('loadProducts');
        },
        methods: {
            onSelectionChange: function (eventData) {
                this.$emit('change', eventData);
            }
        }
    }
</script>
