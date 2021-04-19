<template>
    <AttributeDefinitionEdit
        get-api="/api/client/attribute/definition/"
        post-api="/api/client/attribute/definition"
        patch-api="/api/client/attribute/definition/"
        list-route="admin-client-attribute"
        definition-entity="Client"
        :new-form="newForm"
        :has-duplicate-check="true"
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