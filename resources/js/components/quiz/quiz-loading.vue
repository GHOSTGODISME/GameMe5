<template>
  <div id="loading-body" v-if="showText">
    <transition name="scale">
      <p :key="countdown" class="countdown-text">{{ countdown }}</p>
    </transition>
  </div>
</template>

<script>
import { useQuizStore } from '../../store.js';

export default {
  data() {
    return {
      showText: true,
      countdownArray: [3, 2, 1, 'Start'],
      currentIndex: 0,
      countdown: '',
    };
  },
  mounted() {
    this.startCountdown();
  },
  created() {
    this.fetchQuizSettings();
    this.fetchQuizQuestions();
  },
  methods: {
    async fetchQuizSettings(){
      const store = useQuizStore();
      await store.fetchSessionSettings();
    },
    async fetchQuizQuestions() {
      const store = useQuizStore();
      await store.fetchQuizQuestions();
      console.log(store.questions);
    },
    startCountdown() {
      const interval = setInterval(() => {
        if (this.currentIndex < this.countdownArray.length) {
          this.countdown = this.countdownArray[this.currentIndex];
          this.currentIndex++;
        } else {
          this.finishCountdown();
          clearInterval(interval);
        }
      }, 1500); 
    },
    finishCountdown() {
      this.showText = false;
      console.log('Countdown Finished');
      console.log('Redirecting to Quiz Page');
      this.$router.push('/quiz/quiz-page-layout');
    },
  },
};
</script>

<style scoped>
#loading-body {
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 16vw;
  font-weight: bold;
  color: white;
  text-align: center;
  animation: changeBackgroundColor 3s infinite;
  width: 100%;
  height: 100%;
}

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
