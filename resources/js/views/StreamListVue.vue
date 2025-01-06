<template>
    <v-container>
        <v-card flat>
            <v-card-title class="d-flex align-center pe-2">
                <v-icon icon="mdi-view-stream">Find a Meeting</v-icon> &nbsp;
                <v-spacer></v-spacer>
                <v-text-field
                    v-model="search"
                    density="compact"
                    label="Search"
                    prepend-inner-icon="mdi-magnify"
                    variant="solo-filled"
                    flat
                    hide-details
                    single-line
                ></v-text-field>
            </v-card-title>

            <v-divider></v-divider>
            <v-data-table
                :headers="headers"
                :items="meetings"
                :search="search"
            >
                <template v-slot:item.status="{ item }">
                    <div class="text-start">
                        <v-chip
                            :color="item.status == 'created' ? 'blue' : (item.status == 'broadcasting' ? 'green' : 'red')"
                            :text="item.status"
                            class=""
                            size="small"
                            label
                        ></v-chip>
                    </div>
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-tooltip text="Copy Key"  location="bottom">
                        <template v-slot:activator="{ props }">
                            <v-btn
                                class="ma-0"
                                color="blue-lighten-2"
                                density="comfortable"
                                icon="mdi-identifier"
                                variant="plain"
                                @click="copyStreamKey(item)"
                            >
                            </v-btn>
                        </template>
                    </v-tooltip>
                    <v-tooltip text="Copy url"  location="bottom">
                        <template v-slot:activator="{ props }">
                            <v-btn
                                class="ma-0"
                                color="blue-lighten-2"
                                density="comfortable"
                                icon="mdi-link"
                                variant="plain"
                                @click="copyStreamUrl(item)"
                            >
                            </v-btn>
                        </template>
                    </v-tooltip>
                    <v-tooltip text="Edit name"  location="bottom">
                        <template v-slot:activator="{ props }">
                            <v-btn
                                class="ma-0"
                                color="green-lighten-2"
                                density="comfortable"
                                icon="mdi-pencil-outline"
                                variant="plain"
                                @click="editStreamName(item)"
                            ></v-btn>
                        </template>
                    </v-tooltip>
                    <v-tooltip text="Delete"  location="bottom">
                        <template v-slot:activator="{ props }">
                            <v-btn
                                class="ma-0"
                                color="red-lighten-2"
                                icon="mdi-delete-outline"
                                variant="text"
                                v-bind="props"
                            ></v-btn>
                        </template>
                    </v-tooltip>
                </template>
            </v-data-table>
        </v-card>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            search: '',
            headers: [
                { key: 'name', title: 'Name' },
                { key: 'created_at', title: 'Creation Date', align: 'center' },
                { key: 'status', title: 'Status', align: 'center' },
                { key: 'duration', title: 'Duration', align: 'center' },
                { key: 'actions', title: 'Actions', sortable: false, align: 'center' },
            ],
            meetings: [
                {
                    name: 'meeting-antmedia-789',
                    created_at: '2025-01-06',
                    status: 'created',
                    duration: 5,
                },  
            ],
        };
    },
    methods: {
        
    },
};
</script>

<style scoped>

</style>