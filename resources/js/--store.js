import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default store = new Vuex.Store({
  state: {
    currentQuestionIndex: 0,
    questions: [],
    userResponses: {}, // Object to store user responses { questionId: response }
    correctness: {}, // Object to store whether responses are correct { questionId: boolean }
    userRank: null, // Store the user's rank
    questionTimes: {}, // Object to store time taken for each question { questionId: timeTaken }
    navigationHistory: [], // Array to store the user's navigation history
    points: {},
    totalPoints = 0,

    quizState: 'notStarted', // 'notStarted', 'ongoing', 'completed', etc.
    quizTimer: 0, // Timer or countdown for the quiz
    quizQuestions: [],
  },
  mutations: {
    setCurrentQuestionIndex(state, index) {
      state.currentQuestionIndex = index;
    },
    setQuestions(state, questions) {
      state.questions = questions;
    },
    setUserResponse(state, { questionId, response }) {
      Vue.set(state.userResponses, questionId, response);
    },
    setQuizState(state, newState) {
      state.quizState = newState;
    },
    setQuizTimer(state, timer) {
      state.quizTimer = timer;
    },
    setUserResponse(state, { questionId, response }) {
        Vue.set(state.userResponses, questionId, response);
      },
    setCorrectness(state, { questionId, isCorrect }) {
        Vue.set(state.correctness, questionId, isCorrect);
    },
    setQuestionPoints(state, { questionId, points }) {
      Vue.set(state.questionPoints, questionId, points);
    },
    setTotalQuizPoints(state, totalPoints) {
        state.totalQuizPoints = totalPoints;
      },

      setUserRank(state, rank) {
        state.userRank = rank;
      },
      setQuestionTime(state, { questionId, timeTaken }) {
        Vue.set(state.questionTimes, questionId, timeTaken);
      },
      addToNavigationHistory(state, questionId) {
        state.navigationHistory.push(questionId);
      },
      removeFromNavigationHistory(state) {
        state.navigationHistory.pop();
      },
      addQuizQuestion(state, question) {
        state.quizQuestions.push(question);
      },
  },
  actions: {
    // Actions for fetching questions, submitting responses, handling quiz flow, etc.
    addQuizQuestion({ commit }, question) {
        commit('addQuizQuestion', question);
        // You might have additional logic here such as API calls or validation before adding the question to the state
      },
    evaluateResponse({ state, commit }, { questionId, response }) {
        const correctAnswer = state.questions.find(question => question.id === questionId).correctAnswer;
        const isCorrect =false;

            // Check correctness based on question type
    switch (question.type) {
      case 0: // MCQ
          const correctAnswers = question.correctAnswer;
          isCorrect = correctAnswers.every(answer => response.includes(answer));
          break;
      case 1: // True/False
          isCorrect = response === question.correctAnswer[0]; // Assuming only one correct answer
          break;
      case 2: // TextInput
          isCorrect = response.toLowerCase() === question.correctAnswer[0].toLowerCase(); // Case-insensitive comparison
          break;
      default:
          break;
  }
  
        commit('setUserResponse', { questionId, response });
        commit('setCorrectness', { questionId, isCorrect });
      },

      calculateAndSetPoints({ state, commit }, { questionId, userResponse }) {
        const question = state.questions.find(question => question.id === questionId);
  
        let points = 0; // Calculate points based on correctness, question difficulty, etc.
        if (state.correctness[questionId]) {
            points = question.points; // Points fetched from the question object
        }
  
        commit('setQuestionPoints', { questionId, points });
        commit('setTotalQuizPoints', state.quizQuestions.reduce((acc, q) => acc + state.questionPoints[q.id], 0));
        // Additionally, you might want to update the points in the database here
        // Example: Use an API call to update the points in the database for this specific question
        // axios.put(`/api/questions/${questionId}/points`, { points });
      },
      calculateAndSetRank({ state, commit }, userScore) {
        // You might retrieve scores of other participants or a predefined threshold to calculate the user's rank
        const otherParticipantScores = [/* Array of scores of other participants */];
        otherParticipantScores.push(userScore);
  
        otherParticipantScores.sort((a, b) => b - a); // Sort scores in descending order
  
        const userRank = otherParticipantScores.indexOf(userScore) + 1; // Find the user's rank
  
        commit('setUserRank', userRank);
      },
      recordQuestionTime({ commit }, { questionId, timeTaken }) {
        commit('setQuestionTime', { questionId, timeTaken });
      },
      navigateForward({ commit, state }, questionId) {
        commit('addToNavigationHistory', state.currentQuestionIndex);
        commit('setCurrentQuestionIndex', questionId);
      },
      navigateBackward({ commit, state }) {
        commit('removeFromNavigationHistory');
        const previousQuestionId = state.navigationHistory.pop();
        commit('setCurrentQuestionIndex', previousQuestionId);
      },
  
  
  },
  getters: {
    // Getters for accessing state variables or derived data
  },
});


// {
//     title: 'Question title',
//     type: 0, // Use 0, 1, 2 to represent MCQ, True/False, TextInput
//     options: ['Option A', 'Option B', 'Option C', 'Option D'], // Array of options for MCQ or True/False
//     correctAnswer: ['Option A', 'Option C'], // Array to store correct answers (useful for multiple correct answers)
//     explanation: 'Answer explanation', // Nullable
//     singleAnswerFlag: true, // Nullable, used for TextInput type to indicate single answer
//     points: 10, // Points allocated to the question
//     duration: 30, // Duration in seconds for answering the question
//   }
  