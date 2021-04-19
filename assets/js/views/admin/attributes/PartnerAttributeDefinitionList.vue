<template>
    <AttributeDefinitionList
        title="Partner Profile Attribute List"
        edit-route="admin-partner-attribute-edit"
        new-route="admin-partner-attribute-new"
        get-api="/api/partner/attribute/definition"
        order-api="/api/partner/attribute/definition/order"
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