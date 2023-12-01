
import {createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import App from './components/App.vue';
import {useQuizStore} from './store.js';
import { createPinia } from 'pinia'

// Import your Vue components
import JoinQuizLayout from './components/quiz/layout/join-quiz-layout.vue';
import QuizPageLayout from './components/quiz/layout/quiz-page-layout.vue';

import JoinQuizJoinedParticipants from './components/quiz/join-quiz-joined-participants.vue';
import QuizHeaderWithProgressBar from './components/quiz/quiz-header-with-progress-bar.vue';
import QuizHeader from './components/quiz/quiz-header.vue';
import QuizLoading from './components/quiz/quiz-loading.vue';

import QuizQuestionText from './components/quiz/quizComponent/quiz-question-text.vue';
import QuizTypeMCQ from './components/quiz/quizComponent/quiz-type-mcq.vue';
import QuizTypeText from './components/quiz/quizComponent/quiz-type-text.vue';
import QuizTypeTrueFalse from './components/quiz/quizComponent/quiz-type-truefalse.vue';

import QuizExplaination from './components/quiz/postAnswerAction/quiz-explaination.vue';
import QuizLeaderboard from './components/quiz/postAnswerAction/quiz-leaderboard.vue';

import QuizClosure from './components/quiz/quiz-closure.vue';

const routes = [
  { path: '/join-quiz-layout', component: JoinQuizLayout },
  { path: '/join-quiz', component: JoinQuizLayout },
  { path: '/quiz/quiz-page-layout', component: QuizPageLayout },

  // { path: '/join-quiz', component: JoinQuizLayout, name: 'join-quiz', props: (route) => ({ code: route.query.code }) },

  { path: '/quiz/join-quiz-joined-participants', component: JoinQuizJoinedParticipants },
  { path: '/quiz/quiz-header', component: QuizHeader },
  { path: '/quiz/quiz-loading', component: QuizLoading },

  { path: '/quiz/quiz-header-with-progress-bar', component: QuizHeaderWithProgressBar },
  { path: '/quiz/quiz-question-text', component: QuizQuestionText },
  { path: '/quiz/quiz-type-mcq', component: QuizTypeMCQ },
  { path: '/quiz/quiz-type-text', component: QuizTypeText },
  { path: '/quiz/quiz-type-truefalse', component: QuizTypeTrueFalse },

  { path: '/quiz/quiz-explaination', component: QuizExplaination },
  { path: '/quiz/quiz-leaderboard', component: QuizLeaderboard},

  { path: '/quiz/quiz-closure', component: QuizClosure },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

const app = createApp(App);
const pinia = createPinia();


// Hook into the store's actions to save state in localStorage
pinia.use(({ store }) => {
  store.$onAction((mutation) => {
    localStorage.setItem('piniaState', JSON.stringify(store.$state));
  });
});

// On application startup, retrieve the state from localStorage (if exists)
const localStorageState = localStorage.getItem('piniaState');
if (localStorageState) {
  pinia.state.value = JSON.parse(localStorageState);
}

app.use(router);
app.use(pinia);

const store = useQuizStore();
app.use(store)

app.mount('#app');

