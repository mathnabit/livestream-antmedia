<template>
   <v-container>
        <v-row align="center" justify="center">
            <v-col cols="5">
                <v-sheet class="mx-auto" >
                    <v-form @submit.prevent="createMeeting">
                        <v-text-field
                            v-model="meetingNameCreation"
                            :rules="rules"
                            label="Enter Meeting Name"
                            variant="outlined"
                            density="compact"
                            prepend-icon="mdi-pencil-box"
                        ></v-text-field>
                        <div class="d-flex justify-center">
                            <v-btn 
                                class="mt-2" 
                                type="submit" 
                                color="indigo" 
                                :loading="loading">
                                Create Meeting
                            </v-btn>
                        </div>
                    </v-form>
                </v-sheet>
                <v-snackbar
                    v-model="snackbar"
                    timeout="3000"
                    :color="snackbarStatus == 'success' ? 'success' : 'red-darken-2'"
                >
                    {{ snackbarMessage }}
                </v-snackbar>
            </v-col>
            <v-col cols="7">
                <v-sheet class="d-flex flex-wrap">
                    <v-text-field
                        label="Meeting Name"
                        v-model="meetingName"
                        prepend-icon="mdi-view-stream"
                        variant="outlined"
                        density="compact"
                        class="flex-1-0"
                        readonly
                    ></v-text-field>
                    <v-text-field
                        label="Status"
                        v-model="streamStatus"
                        prepend-icon="mdi-information-box"
                        variant="outlined"
                        density="compact"
                        class="ml-2"
                        readonly
                    ></v-text-field>
                    <v-text-field
                        label="Stream URL"
                        v-model="streamUrl"
                        prepend-icon="mdi-link-box"
                        variant="outlined"
                        density="compact"
                        class="flex-1-1-100"
                        readonly
                    ></v-text-field>
                </v-sheet>
            </v-col>
        </v-row>
        <v-divider></v-divider> <br>
        <v-row justify="center">
            <v-card title="Stream Video">
                <!-- <iframe width="600" height="400" 
                    src="https://ams.pm.tts.live:5443/DevTest3/play.html?id=eOM1hwNzbQCLXJ4C1767757099718617" 
                    frameborder="0" 
                    allowfullscreen>
                </iframe> -->
            </v-card>
        </v-row>
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
            snackbar: false,
            snackbarStatus: 'success',
            snackbarMessage: 'created successfully'

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
                        this.snackbar = true;
                    })
                    .catch((error) => {
                        console.error('Error storing meeting in database:', error);
                    });
                })
                .catch((error) => {
                    console.error('Error creating meeting:', error);
                    this.snackbarStatus = 'error';
                    this.snackbarMessage = 'Error creating meeting';
                    this.snackbar = true;
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
    }
};
</script>

<style scoped>

</style>