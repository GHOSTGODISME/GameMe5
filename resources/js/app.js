import './bootstrap';

import {createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import App from './components/App.vue';

// Import your Vue components
import index from './components/quiz/index.vue';
import joinQuizJoinedParticipants from './components/quiz/join-quiz-joined-participants.vue';
import joinQuizUsername from './components/quiz/join-quiz-username.vue';
import quizClosure from './components/quiz/quiz-closure.vue';
import quizHeaderWithProgressBar from './components/quiz/quiz-header-with-progress-bar.vue';
import quizHeader from './components/quiz/quiz-header.vue';
import quizLeaderboard from './components/quiz/quiz-leaderboard.vue';
import quizLoading from './components/quiz/quiz-loading.vue';
import quizPage from './components/quiz/quiz-page.vue';
import quizQuestionText from './components/quiz/quiz-question-text.vue';
import quizSummary from './components/quiz/quiz-summary.vue';
import quizTypeMCQ from './components/quiz/quiz-type-mcq.vue';
import quizTypeText from './components/quiz/quiz-type-text.vue';
import quizTypeTrueFalse from './components/quiz/quiz-type-truefalse.vue';

import QuizLayout from './components/quiz/layout/join-quiz-layout.vue';

const routes = [
  {
    path: '/',
    component: index,
    name: 'index'
  },
  {
    path: '/join-quiz/joined-participants',
    component: joinQuizJoinedParticipants,
    name: 'join-quiz-joined-participants'
  },
  {
    path: '/join-quiz/username',
    component: joinQuizUsername,
    name: 'join-quiz-username'
  },
  {
    path: '/quiz-closure',
    component: quizClosure,
    name: 'quiz-closure'
  },
  {
    path: '/quiz-header-with-progress-bar',
    component: quizHeaderWithProgressBar,
    name: 'quiz-header-with-progress-bar'
  },
  {
    path: '/quiz-header',
    component: quizHeader,
    name: 'quiz-header'
  },
  {
    path: '/quiz-leaderboard',
    component: quizLeaderboard,
    name: 'quiz-leaderboard'
  },
  {
    path: '/quiz-loading',
    component: quizLoading,
    name: 'quiz-loading'
  },
  {
    path: '/quiz-page',
    component: quizPage,
    name: 'quiz-page'
  },
  {
    path: '/quiz-question-text',
    component: quizQuestionText,
    name: 'quiz-question-text'
  },
  {
    path: '/quiz-summary',
    component: quizSummary,
    name: 'quiz-summary'
  },
  {
    path: '/quiz-type-mcq',
    component: quizTypeMCQ,
    name: 'quiz-type-mcq'
  },
  {
    path: '/quiz-type-text',
    component: quizTypeText,
    name: 'quiz-type-text'
  },
  {
    path: '/quiz-type-truefalse',
    component: quizTypeTrueFalse,
    name: 'quiz-type-truefalse'
  },
  {
    path: '/multiple-components',
    component: QuizLayout,
    name: 'multiple-components'
  },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});


createApp(App).use(router).mount('#app');