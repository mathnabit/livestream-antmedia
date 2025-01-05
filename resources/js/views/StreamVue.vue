<template>
   <v-container>
        <v-row align="center" justify="center">
            <v-col cols="5">
                <v-sheet class="mx-auto" >
                    <v-form @submit.prevent>
                    <v-text-field
                        v-model="streamName"
                        :rules="rules"
                        label="Enter Stream Name"
                        variant="outlined"
                        density="compact"
                        prepend-icon="mdi-pencil-box"
                    ></v-text-field>
                    <div class="d-flex justify-center">
                        <v-btn class="mt-2" type="submit" color="indigo" >Submit</v-btn>
                    </div>
                    </v-form>
                </v-sheet>
            </v-col>
            <v-col cols="7">
                <v-sheet class="d-flex flex-wrap">
                    <v-text-field
                        label="Stream Name"
                        prepend-icon="mdi-view-stream"
                        variant="outlined"
                        density="compact"
                        class="flex-1-0"
                        disabled
                    ></v-text-field>
                    <v-text-field
                        label="Status"
                        prepend-icon="mdi-information-box"
                        variant="outlined"
                        density="compact"
                        class="ml-2"
                        disabled
                    ></v-text-field>
                    <v-text-field
                        label="Stream URL"
                        prepend-icon="mdi-link-box"
                        variant="outlined"
                        density="compact"
                        class="flex-1-1-100"
                        disabled
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
export default {
    data() {
        return {
            streamName: '',
            rules: [
                value => {
                if (value) return true
                return 'You must enter name of stream.'
                },
            ],
        };
    },
    methods: {
        
    }
};
</script>

<style scoped>

</style>