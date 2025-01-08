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
- **UI Component Framework:** Vuetify
- **Database:** MySQL
- **Real-Time Streaming:** Antmedia


## Architecture Overview

The application follows a modern web development architecture, combining **Laravel** for backend logic (serves as the API layer) and **Vue.js** for frontend logic and interactivity (serves as the user interface layer). 
Below is a detailed breakdown of the architecture and how data fetching and API interactions are handled, including integration with the Antmedia Server API:

### Integration Vue.js with Laravel

Vue.js is integrated with Laravel using the method of [Embedded Vue Components in Blade Files](https://vueschool.io/articles/vuejs-tutorials/the-ultimate-guide-for-using-vue-js-with-laravel/).

> With Vue.js components embedded within Blade files, Laravel serves as the core application.
> This strategy preserves Laravel's solid architectural foundation while incorporating dynamic Vue.js components,
> resulting in a more engaging user experience without sacrificing the familiarity of traditional Laravel multi-page and server-side development.


### Antmedia API

- **Integration with Antmedia Server API:** The application integrates with the Antmedia Server API to manage live streams and fetch stream-related data.
  Both Laravel and Vue.js interact with the Antmedia Server API, each serving a specific purpose: Vue.js handles creating and playing live meetings, while Laravel manages editing and deleting meetings.
  
- **API Data Fetching:** The application uses periodic fetching (polling) to retrieve updates such as viewer counts, live feed updates and updated meetings data. Below are the scenarios where polling is used:
  - **On First Access of the App:** When the application is first accessed, polling is used to synchronize data in local DB with Antmedia Server.
  - **During a Played Meeting:** Polling occurs every 10 seconds to fetch updates.
  - **When a Meeting Name is Updated:** Polling is triggered to synchronize the updated meeting data with local DB.

 > This approach was chosen instead of WebSockets for simplicity.
                        

### JWT Usage

To simplify Antmedia API Fetching, and as user authentication was not a requirement in this test, a static JWT is used for all requests. 
> [!IMPORTANT]  
> The JWT Token is generated with this *Secret Key* : **5R9Pw4sgcCbNYDpseVEtNp93xtRb0Vtb**


## Testing 

The application includes two Unit Tests for now to ensure the correctness of two helper methods: *formatDuration* and *formatStartTime*. These tests are written using PHPUnit.


## Future Improvements

- Add user authentication and authorization for secure meeting management.
- Implement WebSockets for real-time updates to enhance user experience.
- Implement dynamic JWT management, including short-lived access tokens and refresh tokens, for enhanced security and scalability.
- Add more meetings management features.
- Expand Tests by adding  Features, Integration and Automated tests.

  
## License

Any work or source code produced as part of this project is the sole property of شركة التحول التقني (Tech Trans).
