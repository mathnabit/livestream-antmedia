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
                <template v-slot:item.name="{ item }">
                    <v-text-field
                        v-model="item.name"
                        variant="plain"
                        density="compact"
                        hide-details
                        :readonly="editingField !== item.id"
                    ></v-text-field>
                    <v-btn
                        class="ma-0"
                        color="green-lighten-2"
                        density="comfortable"
                        icon="mdi-check-outline"
                        variant="text"
                        v-bind="props"
                        v-if="editingField === item.id"
                        @click="saveMeetName(item)"
                    ></v-btn>
                </template>
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
                                @click="editMeetName(item)"
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
                                @click="deleteMeet(item)"
                            ></v-btn>
                        </template>
                    </v-tooltip>
                    <!-- Confirm Delete Dialog -->
                    <v-dialog
                        v-model="deleteDialog"
                        width="auto"
                    >
                        <v-card
                            max-width="400"
                            prepend-icon="mdi-alert"
                            title="Are You Sure !"
                            text="This action cannot be undone."
                        >
                            <template v-slot:actions>
                                <v-btn
                                    class="ms-auto"
                                    text="Yes"
                                    color="error"
                                    @click="saveDeleteMeet()"
                                ></v-btn>
                                <v-btn
                                    class="ms-auto"
                                    text="Cancel"
                                    color="primary"
                                    @click="deleteDialog = false"
                                ></v-btn>
                            </template>
                        </v-card>
                    </v-dialog>
                </template>
            </v-data-table>
            <!-- Copy Status Snackbar -->
            <v-snackbar
                v-model="snackbarCopy"
                color="primary"
            >
                {{ snackbarCopyMessage }}
            </v-snackbar>
            <!-- Edit Delete Status Snackbar -->
            <v-snackbar
                v-model="snackbarEditDelete"
                :color="snackbarEditDeleteStatus === 'success' ? 'success' : 'error'"
            >
                {{ snackbarEditDeleteMessage }}
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
                { key: 'name', title: 'Meeting Name', width:"20%", align: 'start' },
                { key: 'status', title: 'Status', align: 'center' },
                { key: 'total_watchers', title: 'Watchers', align: 'center' },
                { key: 'start_time', title: 'Start At', align: 'center' },
                { key: 'duration', title: 'Duration', align: 'center' },
                { key: 'actions', title: 'Actions', sortable: false, align: 'center' },
            ],
            meetings: [],
            // Copy data
            snackbarCopy: false,
            snackbarCopyMessage: '',
            // Edit & Delete data
            editingField: null,
            snackbarEditDelete: false,
            snackbarEditDeleteStatus: '',
            snackbarEditDeleteMessage: '',
            // confirm delete data
            deletedMeet: null,
            deleteDialog: false,
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
        editMeetName(item) {
            this.editingField = item.id;
        },
        saveMeetName(item) {
            axios.post(`/meetings/${item.key}`, { meetName: item.name })
                .then(response => {
                    this.snackbarEditDeleteStatus = 'success';
                    this.snackbarEditDeleteMessage = 'Meeting Name Updated';
                    this.snackbarEditDelete = true;
                    this.getMeetings();
                })
                .catch(error => {
                    this.snackbarEditDelete = true;
                    this.snackbarEditDeleteMessage = 'Failed to Update Meeting Name';
                    this.snackbarEditDeleteStatus = 'error';
                });
            // Reset the editing state    
            this.editingField = null;
        },
        deleteMeet(item) {
            this.deletedMeet = item;
            this.deleteDialog = true;
        },
        saveDeleteMeet() {
            axios.delete(`/meetings/${this.deletedMeet.id}`)
                .then(response => {
                    this.deleteDialog = false;
                    this.snackbarEditDeleteStatus = 'success';
                    this.snackbarEditDeleteMessage = 'Meeting Deleted';
                    this.snackbarEditDelete = true;
                    this.getMeetings();
                    this.deletedMeet = null;
                })
                .catch(error => {
                    this.deleteDialog = false;
                    this.snackbarEditDelete = true;
                    this.snackbarEditDeleteMessage = 'Failed to Delete Meeting';
                    this.snackbarEditDeleteStatus = 'error';
                });
            
        },
    },
};
</script>

<style scoped>

</style>