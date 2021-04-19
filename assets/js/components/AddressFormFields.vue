<template>
    <div class="addressform">
        <div
            v-if="hasTitle"
            class="form-group"
        >
            <label>Title</label>
            <input
                v-model="value.title"
                type="text"
                class="form-control"
                placeholder="Enter address title"
            >
        </div>
        <div class="form-group">
            <label>Street 1</label>
            <input
                v-model="value.street1"
                type="text"
                class="form-control"
                placeholder="Enter address street 1"
            >
        </div>
        <div class="form-group">
            <label>Street 2</label>
            <input
                v-model="value.street2"
                type="text"
                class="form-control"
                placeholder="Enter address street 2"
            >
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>City</label>
                    <input
                        v-model="value.city"
                        type="text"
                        class="form-control"
                        placeholder="Enter address city"
                    >
                </div>
            </div>
            <div class="col-sm-3">
                <StateField v-model="value.state" />
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Zip/Postal Code</label>
                    <input
                        v-model="value.postalCode"
                        type="text"
                        class="form-control"
                        placeholder="Enter address postal code"
                    >
                </div>
            </div>
        </div>
        <CountryField v-model="value.country" />
    </div>
</template>

<script>
    import StateField from '../components/StateField';
    import CountryField from '../components/CountryField';

    export default {
        name: "AddressFormFields",
        components: {
            StateField,
            CountryField
        },
        props: {
            hasTitle: { type: Boolean, default: true },
            value: { type: Object, required: true },
        },
    };
</script>
