<template>
    <div class="closure-container-bg">
        <div class="closure-container">
            
            <img src="/img/logo_header.png" alt="img"/>

            <p class="closure-title">Congratulation!</p>

            <p class="closure-description">You have completed the quiz !!!</p>

            <p class="text-white ">Press ‘Continue’ button to view your summary.</p>

            <button class="btn button-style btn-dark " @click="continueClicked">Continue</button>
        </div>
    </div>
</template>

<script>
export default {
  methods: {
    continueClicked() {
      this.$router.push('/quiz-summary');

    }
    
  }
};
</script>

<style>
.closure-container-bg{
    background-image: url('/img/quiz-closure-awards.png');
    background-attachment: fixed;
    background-repeat: no-repeat;
    background-size:cover;
    background-position: center;
    background-size: 500px;
    width: 100%;
    height: 100%;
    display: grid;
    place-items: center;
}

.closure-container {
    display: flex;
    flex-wrap: nowrap;
    align-items: center;
    flex-direction: column;
   text-align: center;
   width: 80%;
   margin: auto;
}

.closure-title {
    color: white;
    text-shadow: 8px 8px 4px rgba(0, 0, 0, 0.25);
    /* font-size: 58px; */
    font-size: 8vw;
    font-weight: bold;
}

.closure-description {
    color: white;
    font-weight: 300;
    /* font-size: 32px; */
    font-size: 4vw;
    margin-bottom: 50px;
}
</style>
