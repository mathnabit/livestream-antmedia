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
                                variant="text"
                                v-bind="props"
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
                                variant="text"
                                v-bind="props"
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
                                variant="text"
                                v-bind="props"
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
                                @click="deleteStream(item)"
                            ></v-btn>
                        </template>
                    </v-tooltip>
                </template>
            </v-data-table>
            <v-snackbar
                v-model="snackbarCopy"
                color="primary"
            >
                {{ snackbarCopyMessage }}
            </v-snackbar>
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
                { key: 'status', title: 'Status', align: 'center' },
                { key: 'total_watchers', title: 'Watchers', align: 'center' },
                { key: 'start_time', title: 'Start Date', align: 'center' },
                { key: 'duration', title: 'Duration', align: 'center' },
                { key: 'actions', title: 'Actions', sortable: false, align: 'center' },
            ],
            meetings: [],
            snackbarCopy: false,
            snackbarCopyMessage: '',
        };
    },
    mounted() {
        this.getMeetings();
    },
    methods: {
        getMeetings() {
            axios.get('/meetings')
                .then(response => {
                    this.meetings = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        copyStreamKey(item) {
            navigator.clipboard.writeText(item.key)
                .then(() => {
                    this.snackbarCopy = true;
                    this.snackbarCopyMessage = 'Stream Key Copied';
                })
                .catch(() => {
                    this.snackbarCopy = true;
                    this.snackbarCopyMessage = 'Failed to Copy Stream Key';
                });
        },
        copyStreamUrl(item) {
            navigator.clipboard.writeText(item.url)
                .then(() => {
                    this.snackbarCopy = true;
                    this.snackbarCopyMessage = 'Stream URL Copied';
                })
                .catch(() => {
                    this.snackbarCopy = true;
                    this.snackbarCopyMessage = 'Failed to Copy Stream URL';
                });
        },
    },
};
</script>

<style scoped>

</style>