<template>
    <div id="client_info" class="row tab-pane active">
        <div class="col-md-6">
            <div class="form-group">
                <label>First Name</label>
                <input
                    v-model="value.firstName"
                    type="text"
                    class="form-control"
                    placeholder="Enter first name"
                >

                <label>Last Name</label>
                <input
                    v-model="value.lastName"
                    type="text"
                    class="form-control"
                    placeholder="Enter last name"
                >
            </div>
            <div class="form-group">
                <label>Parent/Guardian First Name</label>
                <input
                    v-model="value.parentFirstName"
                    type="text"
                    class="form-control"
                    placeholder="Enter parent or guardian first name"
                >

                <label>Parent/Guardian Last Name</label>
                <input
                    v-model="value.parentLastName"
                    type="text"
                    class="form-control"
                    placeholder="Enter parent or guardian last name"
                >
            </div>
            <DateField
                v-model="value.birthdate"
                label="Birthdate"
                format="YYYY-MM-DD"
            />
            <PartnerSelectionForm
                v-model="value.partner"
                label="Assigned Partner"
            />
        </div>
        <div class="col-md-6">
            <div v-if="showExpirations" class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="icon far fa-clock fa-fw" />Expiration Info
                    </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <!-- text input -->
                    <BooleanField
                        v-model="value.isExpirationOverridden"
                        label="Override Expirations"
                    />
                    <DateField
                        v-model="value.ageExpiresAt"
                        label="Age Expiration"
                        format="YYYY-MM-DD"
                    />
                    <DateField
                        v-model="value.distributionExpiresAt"
                        label="Distribution Expiration"
                        format="YYYY-MM-DD"
                    />
                    <NumberField
                        v-model="value.pullupDistributionMax"
                        label="Pullup Maximum Limit"
                    />
                    <DisplayField
                        v-model="value.pullupDistributionCount"
                        label="Pullup Distributions"
                    />
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
</template>

<script>
import PartnerSelectionForm from "../../components/PartnerSelectionForm";
import DateField from "../../components/DateField";
import BooleanField from "../../components/ToggleField";
import NumberField from "../../components/NumberField";
import DisplayField from "../../components/DisplayField";
import ClientDistributionHistory from "./ClientDistributionHistory";

export default {
    name: 'ClientInfoForm',
    components: {
        DisplayField,
        NumberField,
        BooleanField,
        DateField,
        PartnerSelectionForm
    },
    props: {
        new: {
            type: Boolean,
            default: false,
            required: false
        },
        showExpirations: {
            type: Boolean,
            default: true,
            required: false
        },
        value: { required: true, type: [Object, Array] },
    },
    created() {
        let self = this;

        console.log('ClientEdit Component mounted.');
    },
}
</script>