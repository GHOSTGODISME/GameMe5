<template>
                <div class="summary-container-row">
                <span>Rank</span>
                <span id="quiz-rank">{{rank}}/{{numOfParticipants}}</span>
            </div>
            <div class="summary-container-row">
                <span>Score</span>
                <span id="quiz-score">{{score}}</span>
            </div>
            <div class="summary-container-row">
                <span>Accuracy</span>
                <span id="quiz-accuracy">{{accuracy}}%</span>
            </div>
</template>


<script>
export default {
  props: {
    rank: {
      type: Number,
      required: true
    },
    numOfParticipants: {
      type: Number,
      required: true
    },
    score: {
      type: Number,
      required: true
    },
    accuracy: {
      type: Number,
      required: true
    }
  }
};
</script>

<style>
        .summary-container-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 30px;
            margin-bottom: 30px;
            font-size: 18px;
            color: white;
            background: #0195FF;
        }
</style>