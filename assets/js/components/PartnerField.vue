<template>
    <div class="form-group">
        <OptionListEntity
            v-if="!multiple"
            ref="partnerSelect"
            v-model="value"
            :preloaded-options="allActivePartners"
            display-property="title"
            empty-string="-- Select Partner --"
            :label="label"
            @input="onSelectionChange"
        />
        <MultiOptionListEntity
            v-else
            ref="partnerSelect"
            v-model="value"
            :preloaded-options="allActivePartners"
            display-property="title"
            empty-string="-- Select Partners --"
            :label="label"
            @input="onSelectionChange"
        />
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'
    import OptionListEntity from './OptionListEntity.vue';
    import MultiOptionListEntity from "./MultiOptionListEntity";

    export default {
        name: 'PartnerField',
        components:{
            MultiOptionListEntity,
            OptionListEntity
        },
        props: {
            value: { required: true, type: [Object, Array] },
            label: { type: String, default: "Partner" },
            multiple: { type: Boolean, default: false },
        },
        computed: mapGetters([
            'allActivePartners'
        ]),
        mounted: function () {
            this.$store.dispatch('loadStorageLocations');
            this.$refs.partnerSelect.$on('change', eventData => this.onSelectionChange(eventData))
        },
        methods: {
            onSelectionChange: function ( values) {
                this.$emit('input', values);
            }
        }
    }
</script>
