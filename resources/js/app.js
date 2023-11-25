import './bootstrap';

import {createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import App from './components/App.vue';
import {useQuizStore} from './store.js';
import { createPinia } from 'pinia'

// Import your Vue components
import JoinQuizLayout from './components/quiz/layout/join-quiz-layout.vue';
import QuizPageLayout from './components/quiz/layout/quiz-page-layout.vue';
import QuizSummaryLayout from './components/quiz/layout/quiz-summary-layout.vue';

import JoinQuizJoinedParticipants from './components/quiz/join-quiz-joined-participants.vue';
import JoinQuizUsername from './components/quiz/join-quiz-username.vue';
import QuizHeaderWithProgressBar from './components/quiz/quiz-header-with-progress-bar.vue';
import QuizHeader from './components/quiz/quiz-header.vue';
import QuizLoading from './components/quiz/quiz-loading.vue';

import QuizQuestionText from './components/quiz/quizComponent/quiz-question-text.vue';
import QuizTypeMCQ from './components/quiz/quizComponent/quiz-type-mcq.vue';
import QuizTypeText from './components/quiz/quizComponent/quiz-type-text.vue';
import QuizTypeTrueFalse from './components/quiz/quizComponent/quiz-type-truefalse.vue';

import QuizExplaination from './components/quiz/postAnswerAction/quiz-explaination.vue';
import QuizLeaderboard from './components/quiz/postAnswerAction/quiz-leaderboard.vue';
import ForwardBackwardBtn from './components/quiz/postAnswerAction/forward-backward-btn.vue';

import QuizClosure from './components/quiz/quiz-closure.vue';
// import QuizSummary from './components/quiz/quiz-summary.vue';
import QuizSummaryBlock1 from './components/quiz/quiz-summary-block1.vue';
import QuizSummaryBlock2 from './components/quiz/quiz-summary-block2.vue';
import QuizSummaryReviewQuestion from './components/quiz/quiz-summary-review-question.vue';

const routes = [
  { path: '/join-quiz-layout', component: JoinQuizLayout },
  { path: '/quiz-page-layout', component: QuizPageLayout, name: 'quiz-page' },
  { path: '/quiz-summary-layout', component: QuizSummaryLayout },

  { path: '/join-quiz-joined-participants', component: JoinQuizJoinedParticipants },
  { path: '/join-quiz-username', component: JoinQuizUsername },
  { path: '/quiz-header', component: QuizHeader },
  { path: '/quiz-loading', component: QuizLoading },

  { path: '/quiz-header-with-progress-bar', component: QuizHeaderWithProgressBar },
  { path: '/quiz-question-text', component: QuizQuestionText },
  { path: '/quiz-type-mcq', component: QuizTypeMCQ },
  { path: '/quiz-type-text', component: QuizTypeText },
  { path: '/quiz-type-truefalse', component: QuizTypeTrueFalse },

  { path: '/quiz-explaination', component: QuizExplaination },
  { path: '/quiz-leaderboard', component: QuizLeaderboard},
  { path: '/forward-backward-btn', component: ForwardBackwardBtn },

  { path: '/quiz-closure', component: QuizClosure },
  // { path: '/quiz-summary', component: QuizSummary },
  { path: '/quiz-summary-block1', component: QuizSummaryBlock1 },
  { path: '/quiz-summary-block2', component: QuizSummaryBlock2 },
  { path: '/quiz-summary-review-question', component: QuizSummaryReviewQuestion },
  // {
  //   path: '/quiz-summary/:userId/:sessionId/:quizId',
  //   name: 'quiz-summary',
  //   component: QuizSummary,
  //   props: true,
  // },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

// const quizStore = useQuizStore();

// createApp(App).use(router).use(quizStore).mount('#app');
// createApp(App).use(router);

const app = createApp(App);
app.use(router);
app.use(createPinia());
// app.config.globalProperties.$store = useQuizStore(); 
const store = useQuizStore();
app.use(store)
app.mount('#app');
// createApp(App).use(router).use(createPinia()).mount('#app');