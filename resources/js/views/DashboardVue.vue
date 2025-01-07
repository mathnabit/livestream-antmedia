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
                    content="100"
                >
                    <v-icon
                        large
                        color="green darken-2"
                    >
                        mdi-toolbox-outline
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
                content="200"
              >
                <v-icon
                  large
                  color="blue darken-2"
                >
                  mdi-shape-outline
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
            @mouseover="hover.hours = true"
            @mouseleave="hover.hours = false"
          >
            <template v-slot:prepend>
              <v-badge
                bordered
                color="purple darken-2"
                content="85"
                
              >
                <v-icon
                  large
                  color="purple darken-2"
                >
                  mdi-gesture-tap-button
                </v-icon>
              </v-badge>
            </template>
            <template v-slot:append>
              <v-chip
                color="purple darken-2"
                label
                outlined
              >
                Hours
              </v-chip>
            </template>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            hover: {
                meetings: false,
                watchers: false,
                hours: false,
            },
        };
    },
    methods: {
        
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