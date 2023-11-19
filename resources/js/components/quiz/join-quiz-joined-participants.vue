<template>
    <div class="joined-participants-container">
      <p class="joined-participants-text">
        Joined Participants <i class="fa-solid fa-person"></i
        ><i class="fa-solid fa-person-dress"></i>
      </p>
  
      <div class="joined-participants-people-container">
        <span v-for="(participant, index) in participants" :key="index" class="joined-participants-people">
          {{ participant }}
        </span>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        participants: [] // Initially an empty array to hold received names
      };
    },
    mounted() {
      // Perform an HTTP request to fetch participants from the server
      this.fetchParticipants();
    },
    updated() {
    // Apply fade-in effect when participants are added
    this.applyFadeInAnimation();
  },
    methods: {
      fetchParticipants() {
        // Example: Assuming you're using Axios for HTTP requests
        // Replace the URL with your server endpoint to fetch participants
        // axios.get('/api/participants')
        //   .then(response => {
        //     this.participants = response.data;
        //   })
        //   .catch(error => {
        //     console.error('Error fetching participants:', error);
        //   });
  
        // Simulated data for demonstration purposes
        // Replace this with your actual HTTP request logic
        setTimeout(() => {
          this.participants = ['Ghostgod', 'husky', 'Ghostgod', 'husky']; // Simulated received names
        }, 1000); // Simulating a delay of 1 second
      },
      applyFadeInAnimation() {
      // Delay the animation to ensure it triggers after data updates
      setTimeout(() => {
        const participants = this.$el.querySelectorAll('.joined-participants-people-container span');
        participants.forEach((participant, index) => {
          participant.style.animation = `fadeInAnimation 0.5s ease ${index * 0.1}s forwards`;
        });
      }, 100);
    }
    }
  };
  </script>
  
  <style>
/* CSS animation definition */
@keyframes fadeInAnimation {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Additional CSS for styling */
.joined-participants-people-container span {
  display: inline-block;
  margin-right: 10px;
  opacity: 0; /* Initially hidden */
}
</style>