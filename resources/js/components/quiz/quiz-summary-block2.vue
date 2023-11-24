<template>
            <div class="summary-color-block">
                <div class="summary-container-block" style="background: #76C893;">
                    <p class="">Correct</p>
                    <p id="quiz-correct">{{numOfCorrect}}</p>
                </div>
                <div class="summary-container-block" style="background: #D05252;">
                    <p class="">Incorrect</p>
                    <p id="quiz-incorrect">{{numOfIncorrect}}</p>
                </div>

                <div class="summary-container-block" style="background: #168AAD;">
                    <p class="">Avg Time</p>
                    <p id="quiz-avg-time">{{avgTime}}</p>
                    <span>s</span>
                </div>
            </div>
</template>


<script>
export default {
  props: {
    numOfCorrect: {
      type: Number,
      required: true
    },
    numOfIncorrect: {
      type: Number,
      required: true
    },
    avgTime: {
      type: Number,
      required: true
    }
  }
};
</script>

<style>
.summary-container-block {
            background: yellowgreen;
            color: white;
            width: 100px;
            padding: 10px;
            margin: 10px;

        }

        .summary-container-block p:first-child {
            text-align: left;
            font-size: 18px;
            font-weight: 300;
            margin: 0;
        }

        .summary-container-block p:nth-child(2) {
            text-align: center;
            font-size: 48px;
            font-weight: 500;
            margin: 0;
            display: inline-block;
        }

        .summary-container-block span {
            font-size: 20px;
        }

</style>