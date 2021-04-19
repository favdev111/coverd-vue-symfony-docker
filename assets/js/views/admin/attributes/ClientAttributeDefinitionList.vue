<template>
    <AttributeDefinitionList
        title="Client Profile Attribute List"
        edit-route="admin-client-attribute-edit"
        new-route="admin-client-attribute-new"
        get-api="/api/client/attribute/definition"
        order-api="/api/client/attribute/definition/order"
    />
</template>

<script>
    import AttributeDefinitionList from "./AttributeDefinitionList";
    
    export default {
        components: {
            AttributeDefinitionList
        }
    }
</script>