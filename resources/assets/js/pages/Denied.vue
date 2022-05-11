<template>
    <div class="content">
        <div class="md-layout">
            <div class="md-layout-item">
                <md-card>
                    <md-card-header data-background-color="red">
                        <h4 class="title">Sorry</h4>
                        <p class="category">
                            You seem to lack the necessary permissions to view this page,
                            <br />If this is an error please contact the database developer.
                        </p>
                    </md-card-header>
                    <md-card-content></md-card-content>
                </md-card>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        dataBackgroundColor: {
            type: String,
            default: ""
        }
    },
    created() {
        this.$store.dispatch("getRolePermission");
    }
};
</script>