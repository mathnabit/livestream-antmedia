<template>
   <v-container>
        <v-sheet class="pt-4 px-4 mx-auto" :elevation="1" rounded>
            <v-row align="center" justify="center" class="mb-2">
                <v-col cols="5">
                    <v-form @submit.prevent="createMeeting">
                        <v-text-field
                            v-model="createdMeetName"
                            :rules="rules"
                            label="Enter Meeting Name"
                            variant="outlined"
                            density="compact"
                            prepend-icon="mdi-pencil-box"
                        ></v-text-field>
                        <div class="d-flex justify-center">
                            <v-btn 
                                class="" 
                                type="submit" 
                                color="indigo" 
                                prepend-icon="mdi-plus"
                                :loading="loading"
                            >
                                Create Meeting
                            </v-btn>
                        </div>
                    </v-form>
                    <v-snackbar
                        v-model="snackbarMeet"
                        timeout="3000"
                        :color="snackbarMeetStatus == 'success' ? 'success' : 'red-darken-2'"
                    >
                        {{ snackbarMeetMessage }}
                    </v-snackbar>
                </v-col>
                <v-col cols="7"> 
                    <v-text-field
                        label="Stream URL"
                        v-model="streamUrl"
                        prepend-icon="mdi-link-box"
                        variant="outlined"
                        density="compact"
                        class=""
                        readonly
                    ></v-text-field>
                    <div class="d-flex justify-center">
                        <v-btn 
                            class="" 
                            color="indigo" 
                            prepend-icon="mdi-content-copy"
                            @click="copyToClipBoard(streamUrl)"
                        >
                            Copy URL
                        </v-btn>
                    </div>
                </v-col>
            </v-row>
        </v-sheet>
        <!-- <v-divider thickness="3"></v-divider> -->
        <v-sheet class="pb-6 mx-auto" :elevation="1" rounded>
        <v-row justify="center" class="mx-auto mt-1 mb-0">
            <v-col cols="8">
                <v-text-field
                    v-model="playedMeetingKey"
                    label="Enter Meeting Key"
                    variant="outlined"
                    density="compact"
                    prepend-icon="mdi-identifier"
                ></v-text-field>
            </v-col>
            <v-col cols="4">
                <v-btn 
                    color="indigo" 
                    prepend-icon="mdi-play"
                >
                    Play Meeting
                </v-btn>
            </v-col>
        </v-row>
        <v-row justify="center">
        <col cols="8">   
            <v-card title="Stream Video" width="700" height="380">
                <v-empty-state
                    image="https://cdn.vuetifyjs.com/docs/images/components/v-empty-state/connection.svg"
                    text="When a stream is played, it will be displayed here"
                    title="Stream Video Unavailable"
                ></v-empty-state>
            </v-card>
        </col>
        <!-- Live Feed -->
        <col cols="4">
            <v-list
                class="ml-4"
                width="300"
                height="230"
                border
            >
                <v-list-item
                    prepend-icon="mdi-view-stream"
                    title="Meeting Name" 
                    subtitle="meeting 123"
                ></v-list-item>
                <v-list-item
                    prepend-icon="mdi-information-box"
                    title="Meeting Status" 
                    subtitle="broadcasting"
                ></v-list-item>
                <v-list-item
                    prepend-icon="mdi-database-eye"
                    title="All Watchers"
                >
                <template v-slot:append>
                    <v-badge
                    color="info"
                    content="6"
                    inline
                    ></v-badge>
                </template>
                </v-list-item>
                <v-list-item
                    prepend-icon="mdi-account-eye"
                    title="Live Watchers"
                >
                <template v-slot:append>
                    <v-badge
                    color="error"
                    content="12"
                    inline
                    ></v-badge>
                </template>
                </v-list-item>
            </v-list>
            <v-snackbar
                v-model="snackbarFeed"
            >
                a person left
            </v-snackbar>
        </col>
        </v-row>
        </v-sheet>
    </v-container>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            meetingNameCreation: '',
            meetingName: '',
            streamKey: '',
            streamUrl: '',
            streamStatus: '',
            rules: [
                v => !!v || 'Name is required',
                v => (v && v.length >= 5) || 'Name very short',
                v => (v && v.length <= 25) || 'Name very long',
            ],
            loading: false,
            snackbarMeet: false,
            snackbarMeetStatus: 'success',
            snackbarMeetMessage: 'created successfully',
            playedMeetingKey: '',
            snackbarFeed: false,

        };
    },
    methods: {
        createMeeting() {
            this.loading = true; 
            const token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.e30.AsK6EJG3nbHVjR-iHvmKMfRP7Ug7RyaZQ6MaDoqy6Go';
            const apiUrl = 'https://ams.pm.tts.live:5443/DevTest3/rest/v2/broadcasts/create';

            // Send the API request to create a stream
            axios
                .post(
                apiUrl,
                { 
                    name: this.meetingNameCreation 
                },
                {
                    headers: {
                        'Content-Type': 'application/json',
                        Authorization: token,
                    },
                }
                )
                .then((response) => {
                    // Store the meeting information in the database
                    this.storeMeeting(response.data)
                    .then(() => {
                        // Display the meeting information
                        this.meetingName = response.data.name;
                        this.streamStatus = response.data.status;
                        this.streamUrl = response.data.rtmpURL;
                        this.snackbarMeet = true;
                    })
                    .catch((error) => {
                        console.error('Error storing meeting in database:', error);
                    });
                })
                .catch((error) => {
                    console.error('Error creating meeting:', error);
                    this.snackbarMeetStatus = 'error';
                    this.snackbarMeetMessage = 'Error creating meeting';
                    this.snackbarMeet = true;
                })
                .finally(() => {
                    this.loading = false; 
                });
        },
        storeMeeting(meetingData) {
            return new Promise((resolve, reject) => {
                axios
                .post('/meetings', meetingData)
                .then((response) => {
                    console.log('Meeting stored in database:', response.data);
                    resolve(response.data);
                })
                .catch((error) => {
                    console.error('Error storing meeting in database:', error);
                    reject(error);
                });
            });
        },
        // Copy the stream URL to the clipboard
        copyToClipBoard(text) {
            navigator.clipboard.writeText(text);
        },
        
    }
};
</script>

<style scoped>

</style>