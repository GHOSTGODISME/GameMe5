<template>
  <div id="loading-body" v-if="showText">
    <transition name="scale">
      <p :key="countdown" class="countdown-text">{{ countdown }}</p>
    </transition>
  </div>
</template>
  
<script>
import { useQuizStore } from '../../../store.js';

export default {
  data() {
    return {
      showText: true,
      countdownArray: [3, 2, 1, 'Start'], // Array to hold countdown values
      currentIndex: 0, // Index of the current countdown value
      countdown: '', // Current countdown value to be displayed
    };
  },
  mounted() {
    this.startCountdown();
  },
  created() {
    const store = useQuizStore(); // Create store instance
    store.fetchQuizQuestions().then(() => {
      console.log(store.questions);
    });
  },
  methods: {
    async startCountdown() {
      const interval = setInterval(() => {
        if (this.currentIndex < this.countdownArray.length) {
          this.countdown = this.countdownArray[this.currentIndex];
          this.currentIndex++;
        } else {
          this.showText = false; 
          clearInterval(interval);
          console.log('Countdown Finished'); 
          console.log('Redirecting to Quiz Page'); 
      this.$router.push('/quiz-page-layout'); 

        }
      }, 1500); // Change the interval to 1000ms for a one-second countdown
    },
  },
};
</script>
  
  
<style scoped>
#loading-body {
  display: flex;
  justify-content: center;
  align-items: center;
  /* font-size: 200px; */
  font-size: 16vw;
  font-weight: bold;
  color: white;
  text-align: center;
  /* transition: background-color 1s ease; */
  animation: changeBackgroundColor 3s infinite;
  /* Duration can be adjusted */

  width: 100%;
  height: 100%;
}

/* Animation for scaleing text */
.scale-enter-active {
  animation: scale 1s ease;
}

@keyframes scale {
  0% {
    transform: scale(2);
  }

  100% {
    transform: scale(1);
  }
}


@keyframes changeBackgroundColor {
  0% {
    background-color: #01BCFF;
  }

  33% {
    background-color: #019FFF;
  }

  66% {
    background-color: #0179FF;
  }

  100% {
    background-color: #01BCFF;
  }
}
</style>
  