<template>
  <div class="joined-participants-container">
    <p class="joined-participants-text">
      Joined Participants <i class="fa-solid fa-person"></i><i class="fa-solid fa-person-dress"></i>
      ({{ participants.length }})
    </p>

    <transition-group name="fade">
      <span v-for="(participant, index) in participants" :key="index" class="joined-participants-people">
        {{ participant }}
      </span>
    </transition-group>
  </div>
</template>

<script>
export default {
  props: {
    participants: Array,
  },
};
</script>

<style>
/* CSS for fade animation */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease-in-out;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>
