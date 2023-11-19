<template>
  <div>
    <quiz-header></quiz-header>
    <join-quiz-username></join-quiz-username>
    <joinQuizJoinedParticipants></joinQuizJoinedParticipants>
  </div>
</template>

<script>
import QuizHeader from '../quiz-header.vue';
import JoinQuizUsername from '../join-quiz-username.vue';
import joinQuizJoinedParticipants from '../join-quiz-joined-participants.vue';

export default {
  components: {
    QuizHeader,
    JoinQuizUsername,
    joinQuizJoinedParticipants
  }
}
</script>