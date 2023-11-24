<template>
    <div id="quiz-title-container" class="">
      {{ title }}
    </div>
  </template>
  
  <script>
  export default {
    props: {
      title: {
        type: String,
        required: true,
      },
    },
  };
  </script>
  