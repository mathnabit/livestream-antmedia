<template>
    <v-container class="mt-6">
      <v-row class="justify-center">
        <v-col cols="3">
          <v-card 
            shaped hover
            class="stat-card pa-2"
            @mouseover="hover.meetings = true"
            @mouseleave="hover.meetings = false"
          >
            <template v-slot:prepend>
                <v-badge
                    bordered
                    color="green darken-2"
                    :content="totalMeetings"
                >
                    <v-icon
                        large
                        color="green darken-2"
                    >
                        mdi-view-stream-outline
                    </v-icon>
                </v-badge>
            </template>
            <template v-slot:append>
                <v-chip
                    color="green darken-2"
                    label
                    outlined
                >
                    Meetings
                </v-chip>
            </template>
          </v-card>
        </v-col>
        <v-col cols="3">
          <v-card 
            shaped hover
            class="stat-card pa-2"
            @mouseover="hover.watchers = true"
            @mouseleave="hover.watchers = false"
          >
            <template v-slot:prepend>
              <v-badge
                bordered
                color="blue darken-2"
                :content="totalWatchers"
              >
                <v-icon
                  large
                  color="blue darken-2"
                >
                  mdi-account-eye-outline
                </v-icon>
              </v-badge>
            </template>
            <template v-slot:append>
              <v-chip
                color="blue darken-2"
                label
                outlined
              >
                Watchers
              </v-chip>
            </template>
          </v-card>
        </v-col>
        <v-col cols="3">
          <v-card 
            shaped hover
            class="stat-card pa-2"
            @mouseover="hover.minutes = true"
            @mouseleave="hover.minutes = false"
          >
            <template v-slot:prepend>
              <v-badge
                bordered
                color="purple darken-2"
                :content="Math.round(totalMinutes)"
                
              >
                <v-icon
                  large
                  color="purple darken-2"
                >
                  mdi-clock-outline
                </v-icon>
              </v-badge>
            </template>
            <template v-slot:append>
              <v-chip
                color="purple darken-2"
                label
                outlined
              >
                Minutes
              </v-chip>
            </template>
          </v-card>
        </v-col>
      </v-row>
    <!-- Copy Status Snackbar -->
    <v-snackbar
        v-model="snackbarSync"
        color="primary"
    >
        {{ snackbarSyncMessage }}
    </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            // statistics data
            totalMeetings: 0,
            totalWatchers: 0,
            totalMinutes: 0,
            // snackbar sync
            snackbarSync: false,
            snackbarSyncMessage: 'Meetings synchronized successfully',
            // styling data
            hover: {
                meetings: false,
                watchers: false,
                minutes: false,
            },
        };
    },
    mounted() {
        this.asyncMeetingData();
        this.getStatistics();
    },
    methods: {
        // asynchonise meeting data from the antmedia server
        asyncMeetingData(){
            axios.post('/meetings/sync/antmedia')
                .then(response => {
                    this.snackbarSync = true;;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        // fetch statistics data
        getStatistics() {
            axios.get('/meetings/statistics')
                .then(response => {
                    this.totalMeetings = response.data.totalMeetings;
                    this.totalWatchers = response.data.totalWatchers;
                    this.totalMinutes = response.data.totalMinutes;
                })
                .catch(error => {
                    console.log(error);
                });
        },
    }
};
</script>

<style scoped>
.stat-card {
  transition: all 0.3s ease;
  border-radius: 12px;
  background: linear-gradient(145deg, #ffffff, #f0f0f0);
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.stat-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

</style>