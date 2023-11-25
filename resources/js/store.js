import { defineStore } from 'pinia';
import { createPinia } from 'pinia';

export const useQuizStore = defineStore('quiz', {
  state: () => ({
    currentQuestionIndex: 0,
    questions: [],
    userResponses: {},
    correctness: {},
    
    questionTimes: {},
    questionPoints: {},
    navigationHistory: [],
    // questionPoints: 0,
    

    userRank: null,
    totalPoints: 0,

    quizTitle: '',
    quizState: 'notStarted',
    quizTimer: 0,
    quizTotalQuestion: 0,

    sessionCode: '',
    username: '',

    userId: 0,
    sessionId:0,
    quizId: 0,

    quizAccuracy: 0, 
    correctAnswersCount: 0, 
    incorrectAnswersCount: 0, 
    averageTime:0,
  }),
  actions: {
    setCurrentQuestionIndex(index) {
      this.currentQuestionIndex = index;
    },
    setQuestions(questions) {
      this.questions = questions;
    },
    storeQuizResponse(questionId, response) {
      this.userResponses = {
        ...this.userResponses,
        [questionId]: response,
      };
    },
    storeCorrectness(questionId, isCorrect) {
      this.correctness = {
        ...this.correctness,
        [questionId]: isCorrect,
      };
      if(isCorrect){
        this.incrementCorrectAnswersCount();
      }else{
        this.incrementIncorrectAnswersCount();
      }
    },
    storeQuestionTime(questionId, timeTaken) {
      this.questionTimes = {
        ...this.questionTimes,
        [questionId]: timeTaken,
      };
    },
    storeQuestionPoints(questionId) {
      const question = this.questions.find(question => question.id === questionId);
      this.questionPoints = {
        ...this.questionPoints,
        [questionId]: question.points,
      };
      this.setTotalQuizPoints(this.totalPoints + question.points);
    },
    setQuizState(newState) {
      this.quizState = newState;
    },
    setQuizTimer(timer) {
      this.quizTimer = timer;
    },
    setQuizTitle(title) {
      this.quizTitle = title;
    },
    setUsername(username) {
      this.username = username;
    },
    setSessionCode(sessionCode) {
      this.sessionCode = sessionCode;
    },
    setTotalQuizPoints(totalPoints) {
      this.totalQuizPoints = totalPoints;
    },
    setQuestionPoints(state, { questionId, points }) {
      this.questionPoints[questionId] = points;
    },
    setUserRank(rank) {
      this.userRank = rank;
    },
    addToNavigationHistory(questionId) {
      state.navigationHistory.push(questionId);
    },
    removeFromNavigationHistory() {
      state.navigationHistory.pop();
    },
    setQuizQuestions(questions) {
      this.quizQuestions = questions;
    },
    incrementCorrectAnswersCount() {
          this.correctAnswersCount++;
        },
        incrementIncorrectAnswersCount() {
          this.incorrectAnswersCount++;
        },
    setQuestionTime(state, { questionId, timeTaken }) {
      this.questionTimes[questionId] = timeTaken;
      console.log(questionTimes);
    },
    recordQuestionTime({ setQuestionTime }, { questionId, timeTaken }) {
      setQuestionTime({ questionId, timeTaken });
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
    navigateToNextQuestion() {
      const nextQuestionId = this.questions[this.currentQuestionIndex + 1]?.id;
      if (nextQuestionId) {
        this.navigateForward(nextQuestionId);
      } else {
        this.setQuizState('finished');
        // Additional logic when the quiz is finished
      }
    },
    navigateToPreviousQuestion() {
      const prevQuestionId = this.navigationHistory[this.navigationHistory.length - 1];
      if (prevQuestionId) {
        this.navigateBackward(prevQuestionId);
      }
    },
    updateUserRank(leaderboard) {
      const userIndex = leaderboard.findIndex((player) => player.id === this.userId);
      if (userIndex !== -1) {
        const userRank = userIndex + 1;
        this.userRank = userRank;
      } else {
        this.userRank = null;
      }
    },
    // async fetchQuizDetails(code) {
    //   try {
    //     const response = await fetch(`/quiz/details/${code}`);
    //     const details = await response.json();
    //     this.setQuizTitle(details.title);
    //     console.log("this.userTitle " + this.userTitle);
    //   } catch (error) {
    //     console.error('Failed to fetch quiz details:', error);
    //   }
    // },
    async fetchQuizDetails() {
      try {
        const response = await fetch(`/quiz/details/${this.sessionCode}`);
        const details = await response.json();
    
        console.log('Fetched details:', details);
    
        if (details && details.quiz.title) {
          this.setQuizTitle(details.quiz.title); // Update quizTitle using setQuizTitle action
          this.quizId = details.quiz.id;
          this.sessionId = details.session_id;
          console.log("this.sessionId " + this.sessionId);
          console.log('Updated quizTitle:', this.quizTitle);
        } else {
          console.error('Quiz details or title is empty.');
        }
      } catch (error) {
        console.error('Failed to fetch quiz details:', error);
      }
    },
    
    async fetchQuizQuestions() {
      try {
        const response = await fetch(`/quiz/questions/${this.quizId}`);
        const questions = await response.json();
        this.setQuestions(questions);
        this.quizTotalQuestion = questions.length;
        console.log('Fetched questions:', this.questions);
            } catch (error) {
              console.error('Failed to fetch questions:', error);
                  }
    },
    calculateQuizAccuracy() {
      const totalQuestions = Object.keys(this.correctness).length;
      if (totalQuestions === 0) {
        this.quizAccuracy = 0;
        return;
      }

      const correctAnswers = Object.values(this.correctness).filter(isCorrect => isCorrect).length;
      this.correctAnswersCount = correctAnswers;
      this.incorrectAnswersCount = totalQuestions - correctAnswers;

      this.quizAccuracy = (correctAnswers / totalQuestions) * 100;
    },

    calculateAverageTime() {
      const totalQuestions = Object.keys(this.questionTimes).length;
      if (totalQuestions === 0) {
        this.averageTime = 0;
        return;
      }

      const totalTime = Object.values(this.questionTimes).reduce((acc, time) => acc + time, 0);
      this.totalQuestionTime = totalTime;
      this.averageTime = totalTime / totalQuestions;
    },
    startQuiz() {
      this.setQuizState('started');
      this.setQuizTimer(0);
      this.fetchQuizDetails(123);
    },
    async storeIndividualResponse(payload) {
      try {
        const response = await fetch('/api/store-individual-response', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(payload),
        });

        if (!response.ok) {
          throw new Error('Failed to store individual response');
        }

        const responseData = await response.json();
        // Handle successful response from the backend if needed
        console.log('Response from backend:', responseData);
      } catch (error) {
        console.error('Error storing individual response:', error);
        // Handle error
      }
    },
    setRandomUserId() {
      // Generate a random user ID between 1 and 1000 (for example)
      const randomUserId = Math.floor(Math.random() * 1000) + 1;
      this.userId = randomUserId;
    },
    
  },
  getters: {
    getQuizAccuracy() {
      this.calculateQuizAccuracy();
      return this.quizAccuracy.toFixed(1); // Display accuracy up to 2 decimals
    },

    getAverageTime() {
      this.calculateAverageTime();
      return this.averageTime.toFixed(1); // Display average time up to 2 decimals
    },  },

    getQuizTitle() {
      return this.quizTitle;
    },
});


// {
// title: 'Question title',
// type: 0, // Use 0, 1, 2 to represent MCQ, True/False, TextInput
// options: ['Option A', 'Option B', 'Option C', 'Option D'], // Array of options for MCQ or True/False
// correctAnswer: ['Option A', 'Option C'], // Array to store correct answers (useful for multiple correct answers)
// explanation: 'Answer explanation', // Nullable
// singleAnswerFlag: true, // Nullable, used for TextInput type to indicate single answer
// points: 10, // Points allocated to the question
// duration: 30, // Duration in seconds for answering the question
// }


// answer_explanation: "[]"
// ​​correct_ans: Array [ "True" ]
// ​​​created_at: "2023-11-21T15:22:56.000000Z"
// ​​​duration: 10
// ​​​id: 1
// ​​​index: "0"
// ​​​options: Array [ "True", "False" ]
// ​​​points: 15
// ​​​quiz_id: 1
// ​​​single_ans_flag: 1
// ​​​title: "Ut nobis voluptatem suscipit deleniti debitis facere."
// ​​​type: "1"
// ​​​updated_at: "2023-11-21T15:53:15.000000Z"