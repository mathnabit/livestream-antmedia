# LiveStream Antmedia

A livestream mini App with Antmedia integration


## General Description

### Description

This project is a live meeting application built using Laravel (backend) and Vue.js (frontend).
It allows users to create meetings and playing real-time video streaming with real-time viewer counters.

### Demo

[A small Demo for the App](https://drive.google.com/file/d/1hKfJKvb8hMSax56eyC8cylFDYEnR6G4a/view?usp=sharing)


## Features of the App

### Features

- **Create a Meeting:** Users can create a new meeting by entering a meeting name. The system generates a unique meeting key and link.
- **Live Video Streaming:** Each meeting includes a live video stream (audio and video) powered by Antmedia.
- **Live Feed:** A real-time feed displays notifications when users join or leave the meeting (without displaying names).
- **Real-Time Viewer Counter:** Shows the number of users currently watching the live stream as well as the total of watchers.
- **Meeting Statistics:** Users can view some statistics of meetings.
- **Edit Meeting Name or Delete Meeting:** Users can edit the name of an existing meeting as well as delete a meeting.

### Use Case Diagram

This Use Case Diagrams illustrates the main interactions between users (actors) and the system.

![use case diagram](https://github.com/user-attachments/assets/c2acbfba-f679-4d07-b87c-48b343fdffc7)

### Sequence Diagrams

This Sequences Diagram illustrate the flow of events when a user creates a new meeting / play a meeting / edit meeting name / delete meeting.
They showing the interactions between the Client, the Backend, the Database and the Antmedia API.

![create_play_stream sequence diagram](https://github.com/user-attachments/assets/765c3d7b-d116-4a6a-a52e-12568368f8a1)

![edit_delete_stream sequence diagram](https://github.com/user-attachments/assets/30a63ccf-7632-4888-a817-b905928fee68)

> For simplicity, diagrams didn't include all details.

## Database Design

For now, the database is very simple and contains one table.

![db design](https://github.com/user-attachments/assets/4cc4b885-2fd8-46ab-997b-87d59c047989)


## Technology Stack

- **Backend:** Laravel (PHP framework)
- **Frontend:** Vue.js (JavaScript framework)
- **Database:** MySQL
- **Real-Time Streaming:** Antmedia


## Architecture Overview

### Using Vue.js with Laravel

Vue.js in integrated with Laravel using the method of [Embedded Vue Components in Blade Files](https://vueschool.io/articles/vuejs-tutorials/the-ultimate-guide-for-using-vue-js-with-laravel/).

> With Vue.js components embedded within Blade files, Laravel serves as the core application.
> This strategy preserves Laravel's solid architectural foundation while incorporating dynamic Vue.js components,
> resulting in a more engaging user experience without sacrificing the familiarity of traditional Laravel multi-page and server-side development.


### API Data Fetching



### JWT Usage



## Testing 



## Future Improvements



## License

Any work or source code produced as part of this project, including but not limited to modifications, enhancements, or derivative works,
is the sole property of شركة التحول التقني (Tech Trans).
