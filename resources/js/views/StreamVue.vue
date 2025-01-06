<template>
   <v-container>
        <v-sheet class="pt-4 px-4 mx-auto" :elevation="1" rounded>
            <v-row align="center" justify="center" class="mb-2">
                <v-col cols="5">
                    <v-form @submit.prevent="createMeeting" v-model="isFormCreateValid">
                        <v-text-field
                            v-model="createdMeetName"
                            :rules="meetNameRules"
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
                                :disabled="!isFormCreateValid"
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
                        v-model="createdMeetUrl"
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
                            @click="copyToClipBoard(createdMeetUrl)"
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
                <v-form v-model="isFormPlayValid">
                    <v-text-field
                        v-model="playedMeetKey"
                        label="Enter Meeting Key"
                        :rules="meetKeyRules"
                        variant="outlined"
                        density="compact"
                        prepend-icon="mdi-identifier"
                    ></v-text-field>
                </v-form>
            </v-col>
            <v-col cols="4">
                <v-btn 
                    color="indigo" 
                    prepend-icon="mdi-play"
                    @click="playStream"
                    :disabled="!isFormPlayValid"
                >
                    Play Meeting
                </v-btn>
            </v-col>
        </v-row>
        <v-row justify="center">
        <col cols="8">   
            <v-card title="Stream Video" width="700" height="400" justify="center">
                <iframe 
                    width="700" height="350" 
                    :src="'https://ams.pm.tts.live:5443/DevTest3/play.html?id=' + playedMeetKey" 
                    frameborder="0" allowfullscreen
                    v-if="playedMeetStatus === 'broadcasting'"
                >
                </iframe>
                <v-empty-state
                    image="https://cdn.vuetifyjs.com/docs/images/components/v-empty-state/connection.svg"
                    text="When a stream is played, it will be displayed here"
                    title="Stream Video Unavailable"
                    v-if="playedMeetStatus !== 'broadcasting'"
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
                    :subtitle="playedMeetName"
                ></v-list-item>
                <v-list-item
                    prepend-icon="mdi-information-box"
                    title="Meeting Status" 
                    :subtitle="playedMeetStatus"
                ></v-list-item>
                <v-list-item
                    prepend-icon="mdi-database-eye"
                    title="All Watchers"
                >
                <template v-slot:append>
                    <v-badge
                    color="info"
                    :content="totalWatchers"
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
                    :content="liveWatchers"
                    inline
                    ></v-badge>
                </template>
                </v-list-item>
            </v-list>
            <v-snackbar
                v-model="snackbarFeed"
                color="info"
            >
                {{ snackbarFeedMessage }}
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
            // Meeting creation data
            createdMeetName: '',
            createdMeetKey: '',
            createdMeetUrl: '',
            meetNameRules: [
                v => !!v || 'Meeting Name is required',
                v => (v && v.length >= 5) || 'Name very short',
                v => (v && v.length <= 25) || 'Name very long',
            ],
            isFormCreateValid: false,
            loading: false,
            snackbarMeet: false,
            snackbarMeetStatus: 'success',
            snackbarMeetMessage: 'meeting created successfully',
            // Meeting playing data
            meetKeyRules: [
                v => !!v || 'Meeting Key is required',
                v => (v && v.length >= 5) || 'Not a valid key',
            ],
            isFormPlayValid: false,
            playedMeetName: '__',
            playedMeetUrl: '',
            playedMeetKey: '',
            playedMeetStatus: '__',
            // Meeting Feed data
            totalWatchers: 0,
            liveWatchers: 0,
            snackbarFeed: false,
            snackbarFeedMessage: '',

        };
    },
    methods: {
        createMeeting() {
            this.loading = true; 
            const token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.e30.AsK6EJG3nbHVjR-iHvmKMfRP7Ug7RyaZQ6MaDoqy6Go';
            const createApiUrl = 'https://ams.pm.tts.live:5443/DevTest3/rest/v2/broadcasts/create';

            // Send the API request to create a stream
            axios
                .post(
                    createApiUrl,
                    { 
                        name: this.createdMeetName 
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
                        this.createdMeetName = response.data.name;
                        this.createdMeetUrl = response.data.rtmpURL;
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
                    resolve(response.data);
                })
                .catch((error) => {
                    reject(error);
                });
            });
        },
        // Copy the stream URL to the clipboard
        copyToClipBoard(text) {
            navigator.clipboard.writeText(text);
        },

        // Check the status and statistics of the stream
        checkStatusAndStatistics() {
            const token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.e30.AsK6EJG3nbHVjR-iHvmKMfRP7Ug7RyaZQ6MaDoqy6Go';
            const statusApiUrl = `https://ams.pm.tts.live:5443/DevTest3/rest/v2/broadcasts/${this.playedMeetKey}`;
            const statisticsApiUrl = `https://ams.pm.tts.live:5443/DevTest3/rest/v2/broadcasts/${this.playedMeetKey}/broadcast-statistics`;
            return Promise.all([
                axios.get(statusApiUrl, {
                    headers: {
                        Authorization: token,
                    },
                }),
                axios.get(statisticsApiUrl, {
                    headers: {
                        Authorization: token,
                    },
                }),
            ])
            .then(([statusResponse, statisticsResponse]) => {
                    // Update the stream status
                    this.playedMeetName = statusResponse.data.name;
                    this.playedMeetStatus = statusResponse.data.status;

                    // clear the interval if the stream is no longer active
                    if (this.playedMeetStatus !== 'broadcasting') {
                        clearInterval(this.streamCheckInterval);
                        this.streamCheckInterval = null;
                        console.log('Stream is not active. Interval cleared.');
                    }
                    // Update the stream statistics 
                    
                    // Calculate the current live watchers count
                    let countLiveWatchers = 
                        Math.max(0, statisticsResponse.data.totalRTMPWatchersCount) +
                        Math.max(0, statisticsResponse.data.totalHLSWatchersCount) +
                        Math.max(0, statisticsResponse.data.totalWebRTCWatchersCount) +
                        Math.max(0, statisticsResponse.data.totalDASHWatchersCount);
                    // Calculate the difference between the updated and previous watchers count
                    let watchersDifference = countLiveWatchers - this.liveWatchers;
                    this.liveWatchers = countLiveWatchers;
                    // Update the total watchers count and trigger snackbar feed
                    if (watchersDifference > 0) {
                        // New viewers joined
                        this.totalWatchers += watchersDifference;
                        this.snackbarFeed = true;
                        this.snackbarFeedMessage = `${watchersDifference} new ${watchersDifference === 1 ? 'viewer' : 'viewers'} joined`;
                    } else if (watchersDifference < 0) {
                        // Viewers left the stream
                        this.snackbarFeed = true;
                        this.snackbarFeedMessage = `${Math.abs(watchersDifference)} ${Math.abs(watchersDifference) === 1 ? 'viewer' : 'viewers'} left`;
                    }
                    // Update the meeting total watchers in the database
                    //if (this.playedMeetStatus == 'broadcasting') {
                        this.updateMeeting(statusResponse)
                            .then(() => {
                                console.log('meeting updated successfuly');
                            })
                            .catch((error) => {
                                console.error('Error updating meeting : ', error);
                            });
                    //}
                    return this.playedMeetStatus;
                })
                .catch((error) => {
                    console.error('Error checking stream status or statistics:', error);
                    this.snackbarFeed = true;
                    this.snackbarFeedMessage = 'Meeting Not Found';
                    return 'inactive';
                });
        },
        // Update meeting total watchers in database
        updateMeeting(meetingData) {
            return new Promise((resolve, reject) => {
                console.log('Updating meeting... ', meetingData);
                axios
                .post(`/meetings/${this.playedMeetKey}`, 
                    { 
                        status: meetingData.data.status,
                        startTime: meetingData.data.startTime,
                        duration: meetingData.data.duration,
                        totalWatchers: this.totalWatchers 
                    }
                )
                .then((response) => {
                    resolve(response.data);
                })
                .catch((error) => {
                    reject(error);
                });
            });

        },
        // Play the stream
        playStream() {
            console.log('Starting playStream...');
            // initialize the total and live watchers count
            this.totalWatchers = 0;
            this.liveWatchers = 0;
            // Clear any existing interval
            if (this.streamCheckInterval) {
                clearInterval(this.streamCheckInterval);
                this.streamCheckInterval = null;
            }
            // Call the first check immediately
            this.checkStatusAndStatistics()
            .then((streamStatus) => {
                // Start the interval only if the stream is active
                if (streamStatus === 'broadcasting') {
                    console.log('Stream is live: ' + streamStatus);
                    this.streamCheckInterval = setInterval(this.checkStatusAndStatistics, 10000);
                } else if (this.playedMeetStatus == 'created' || this.playedMeetStatus == 'finished') {
                        // Stream is not Live
                        console.log('Stream is not Live');
                        this.snackbarFeed = true;
                        this.snackbarFeedMessage = 'Meeting is not Live';
                }
            })
            .catch((error) => {
                console.error('Error in playStream:', error);
            });
        },
        // Clear the interval when the component is destroyed
        beforeUnmount() {
            if (this.streamCheckInterval) {
            clearInterval(this.streamCheckInterval);
            this.streamCheckInterval = null;
            }
        },
  },
    
};
</script>

<style scoped>

</style>