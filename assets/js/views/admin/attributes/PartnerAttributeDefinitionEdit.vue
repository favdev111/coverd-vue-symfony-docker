<template>
    <AttributeDefinitionEdit
        get-api="/api/partner/attribute/definition/"
        post-api="/api/partner/attribute/definition"
        patch-api="/api/partner/attribute/definition/"
        list-route="admin-partner-attribute"
        definition-entity="Partner"
        :new-form="newForm"
    />
</template>


<script>
import AttributeDefinitionEdit from "./AttributeDefinitionEdit";

export default {
        components: {
            AttributeDefinitionEdit,
        },
        props: {
            newForm: {type: Boolean, default: false},
        }
    }
</script>