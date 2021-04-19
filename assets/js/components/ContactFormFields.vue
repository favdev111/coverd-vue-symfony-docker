<template>
    <div class="contact">
        <div class="row">
            <div class="form-group col-xs-6">
                <label>First Name</label>
                <input
                    v-model="contact.firstName"
                    type="text"
                    class="form-control"
                    placeholder="Enter address name"
                >
            </div>
            <div class="form-group col-xs-6">
                <label>Last Name</label>
                <input
                    v-model="contact.lastName"
                    type="text"
                    class="form-control"
                    placeholder="Enter address name"
                >
            </div>
        </div>
        <div class="form-group">
            <label>Title</label>
            <input
                v-model="contact.title"
                type="text"
                class="form-control"
                placeholder="Enter address name"
            >
        </div>
        <div class="row">
            <div class="form-group col-xs-6">
                <label>Email</label>
                <input
                    v-model="contact.email"
                    type="text"
                    class="form-control"
                    placeholder="Enter address name"
                >
            </div>
            <div class="form-group col-xs-6">
                <label>Phone</label>
                <input
                    v-model="contact.phoneNumber"
                    type="text"
                    class="form-control"
                    placeholder="Enter address name"
                >
            </div>
        </div>
        <div class="row">
            <div class="form-group col-xs-12">
                <YesNoRadioField
                    v-model="contact.isProgramContact"
                    label="Program contact?"
                />
            </div>
        </div>
    </div>
</template>

<script>
    import YesNoRadioField from "./YesNoRadioField";
    export default {
        components: {YesNoRadioField},
        props: {
            contact: {type: Object, required: true},
            showProgramContact: {type: Boolean, default: false}
        }
    }
</script>
