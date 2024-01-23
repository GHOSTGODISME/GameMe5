// Import required modules using ES6 syntax
import express from 'express';
import http from 'http';
import { Server } from 'socket.io';
import cors from 'cors';

const app = express();
const server = http.createServer(app);
const port = process.env.PORT || 3000;
const io = new Server(server, {
  cors: { origin: "*" }
});

// Use CORS middleware
app.use(cors());

// to store session's data in object
const SESSION_EXPIRY_TIME = 3 * 60 * 60 * 1000; // 3 hours
const INTERVAL_CHECK_TIME = 5 * 60 * 1000; // every 5 minutes

const sessions = new Map();
const interactiveSessions = new Map();
const sessionStartTimes = new Map();
const interactiveSessionStartTimes = new Map();

function initializeSessionData(sessionCode) {
  sessions.set(sessionCode, {
    participants: [],
    leaderboard: [],
    totalParticipants: 0,
    sessionStatus: 'waiting',
    startTime: Date.now(),
  });
  sessionStartTimes.set(sessionCode, Date.now());
}

function initializeInteractiveSessionData(sessionCode) {
  interactiveSessions.set(sessionCode, {
    participants: [],
    messages: [],
    votes: {},
    sessionStatus: '',
    startTime: Date.now(),
  });
  interactiveSessionStartTimes.set(sessionCode, Date.now());
}

function initializePollVotes(sessionCode, pollId, options) {
  const interactiveSession = interactiveSessions.get(sessionCode);

  interactiveSession.votes[pollId] = {};
  options.forEach((option) => {
    interactiveSession.votes[pollId][option.toLowerCase()] = 0;
  });
}

function voteForPollOption(sessionCode, pollId, optionSelected) {
  const interactiveSession = interactiveSessions.get(sessionCode);

  if (interactiveSession && interactiveSession.votes[pollId]) {
    if (interactiveSession.votes[pollId][optionSelected.toLowerCase()] !== undefined) {

      interactiveSession.votes[pollId][optionSelected]++;
      io.to(sessionCode).emit('pollVoteReceived', {
        pollId,
        optionSelected,
        votes: interactiveSession.votes[pollId],
      });
    }

  }
}


function updateSessionStatus(status, sessionCode) {
  sessions.get(sessionCode).sessionStatus = status;
  io.to(sessionCode).emit('session status', sessions.get(sessionCode).sessionStatus);
}

function addLeaderboardEntry(participant, sessionCode) {
  sessions.get(sessionCode).leaderboard[participant.id] = {
    id: participant.id,
    username: participant.username,
    score: 0,
  };
}

function updateLeaderboardEntry(userId, newScore, sessionCode) {
  const leaderboard = sessions.get(sessionCode).leaderboard;
  if (leaderboard[userId]) {
    leaderboard[userId].score = newScore;
    const sortedLeaderboard = Object.values(leaderboard).sort((a, b) => b.score - a.score);
    io.to(sessionCode).emit('update leaderboard', sortedLeaderboard);
  }
}

// Function to initialize the leaderboard with participants
function initializeLeaderboard(sessionCode) {
  const participants = sessions.get(sessionCode).participants;
  const leaderboard = sessions.get(sessionCode).leaderboard;

  if (Object.keys(leaderboard).length === 0) {
    participants.forEach((participant) => {
      if (!leaderboard[participant.id]) {
        leaderboard[participant.id] = {
          id: participant.id,
          username: participant.username,
          score: 0,
        };
      }
    });
  }
  // io.to(sessionCode).emit('update leaderboard', Object.values(leaderboard));
}

app.get('/', (req, res) => {
  res.send('<h1>Hello world</h1>');
});

io.on('connection', (socket) => {
  handleJoinEvents(socket);
  handleScoreUpdates(socket);
  handleSessionEvents(socket);
  handleQuizEvents(socket);
  handleLeaderboardEvents(socket);
  handleDisconnect(socket);
  handleUserResponse(socket);

  handleSession(socket);
  handleInteractiveSession(socket)
});

function handleSession(socket) {
  socket.on('createSession', (sessionCode) => {
    initializeSessionData(sessionCode);
    initializeConnection(sessionCode);
    io.to(socket.id).emit('session created');
    console.log('session created');
  });

  socket.on('joinSession', (sessionCode) => {
    if (sessions.get(sessionCode)) {
      console.log('joinSession');

      const leaderboard = sessions.get(sessionCode).leaderboard;
      const participants = sessions.get(sessionCode).participants;

      console.log(`Participant ${socket.id} joined session ${sessionCode}`)

      socket.join(sessionCode); // Participant joins the room with session code
      socket.to(sessionCode).emit("get leaderboard");
      io.to(sessionCode).emit('initial leaderboard', Object.values(leaderboard));
      io.to(sessionCode).emit('initial participants', participants);
    }
  });

  socket.on('rejoinRoom', (sessionCode) => {
    if (sessions.get(sessionCode)) {
      socket.join(sessionCode);
    }
  });

  socket.on('exitRoom', (sessionCode) => {
    if (sessions.get(sessionCode)) {
      socket.leave(sessionCode);
    }
  })
}

function handleInteractiveSession(socket) {
  socket.on('createInteractiveSession', (data) => {
    const { sessionCode, id, username } = data;

    if (!interactiveSessions.get(sessionCode)) {
      initializeInteractiveSessionData(sessionCode);
    }
    const participants = interactiveSessions.get(sessionCode).participants;
    const existingUser = participants.find((participant) => participant.id === id);

    if (!existingUser) {
      participants.push({ id, username });
    }

    socket.join(sessionCode);
    broadcastAllIS(sessionCode)
  })

  socket.on('sendChatMessage', (data) => {
    const { sessionCode, id, username, message } = data;
    if (interactiveSessions.get(sessionCode)) {
      const messages = interactiveSessions.get(sessionCode).messages;
      const msg = buildMsg(id, username, message);
      messages.push(msg);

      io.to(sessionCode).emit('chatMessageReceived', msg);
    }
  });

  socket.on('createPoll', (data) => {
    const { pollId, sessionCode, pollTitle, options } = data;
    if (interactiveSessions.get(sessionCode)) {
      io.to(sessionCode).emit('newPollCreated', { pollId, pollTitle, options });
      initializePollVotes(sessionCode, pollId, options);
    }
  });

  socket.on('voteForPoll', (data) => {
    const { sessionCode, pollId, optionSelected, userId } = data;
    if (interactiveSessions.get(sessionCode)) {
      voteForPollOption(sessionCode, pollId, optionSelected);
    }
  });

  socket.on('saveChatMessage', (sessionCode) => {
    if (interactiveSessions.get(sessionCode)) {
      const messages = interactiveSessions.get(sessionCode).messages;
      io.to(sessionCode).emit('returnChatMessageSave', messages);
    }
  })

  socket.on('exportChatMessage', (sessionCode) => {
    if (interactiveSessions.get(sessionCode)) {
      const messages = interactiveSessions.get(sessionCode).messages;
      io.to(sessionCode).emit('returnChatMessage', messages);
    }
  })

  socket.on('leaveInteractiveSession', (data) => {
    const { sessionCode, id } = data;
    if (interactiveSessions.get(sessionCode)) {
      const participants = interactiveSessions.get(sessionCode).participants;
      interactiveSessions.get(sessionCode).participants =
        participants.filter((participant) => participant.id !== id);

      broadcastAllIS(sessionCode);
    }
  });
}

function buildMsg(id, username, message) {
  return {
    id,
    username,
    message,
    time: new Intl.DateTimeFormat('default', {
      day: 'numeric',
      month: 'numeric',
      year: 'numeric',
      hour: 'numeric',
      minute: 'numeric',
      second: 'numeric'
    }).format(new Date())
  }
}

function initializeConnection(sessionCode) {
  const participants = sessions.get(sessionCode).participants;
  const leaderboard = sessions.get(sessionCode).leaderboard;
  const sessionStatus = sessions.get(sessionCode).sessionStatus;

  io.to(sessionCode).emit('initial participants', participants);
  io.to(sessionCode).emit('initial leaderboard', Object.values(leaderboard));
  io.to(sessionCode).emit('session status', sessionStatus);
}

function broadcastAllIS(sessionCode) {
  const participants = interactiveSessions.get(sessionCode).participants;
  io.to(sessionCode).emit('is-participants-length', participants.length);
}

function handleJoinEvents(socket) {
  socket.on('checkUser', (data) => {
    const { sessionCode, id } = data;

    if (sessions.get(sessionCode)) {
      const participants = sessions.get(sessionCode).participants;
      const existingUser = participants.find((participant) => participant.id === id);

      io.to(sessionCode).emit('same participants', existingUser);
    }
  });


  socket.on('getSessionParticipants', (sessionCode) => {

    socket.join(sessionCode);

    console.log("getSessionParticipants ", sessionCode);
    const participants = sessions.get(sessionCode).participants;

    console.log(`participants ${participants}`);
    if(participants){
      io.to(sessionCode).emit('initial participants', participants);
    }
    else{
      console.error("Empty participants")
    }

  });


  socket.on('join', (data) => {
    const { sessionCode, id, username } = data;
    console.log("join ", data);

    if (sessions.get(sessionCode)) {
      const participants = sessions.get(sessionCode).participants;
      const leaderboard = sessions.get(sessionCode).leaderboard;

      socket.join(sessionCode);

      const existingUser = participants.find((participant) => participant.id === id);

      if (!existingUser) {
        participants.push({ id, username });
        addLeaderboardEntry({ id, username }, sessionCode);

        io.to(sessionCode).emit('participant joined', { id, username });
        io.to(sessionCode).emit('update leaderboard', Object.values(leaderboard));
        io.to(sessionCode).emit('initial participants', participants);
      } else {
        io.to(sessionCode).emit('same participants');
      }
    }
  });

  socket.on('endInteractiveSession', (sessionCode) => {
    if (interactiveSessions.get(sessionCode)) {

      io.to(sessionCode).emit('interactiveSessionEnded');
      interactiveSessions.delete(sessionCode);
    }
  });

  socket.on('joinInteractiveSession', (data) => {
    const { sessionCode, id, username } = data;
    if (interactiveSessions.get(sessionCode)) {
      const participants = interactiveSessions.get(sessionCode).participants;

      socket.join(sessionCode);

      const existingUser = participants.find((participant) => participant.id === id);

      if (!existingUser) {
        participants.push({ id, username });
      }

      broadcastAllIS(sessionCode);
    }
  });
}

function handleSessionEvents(socket) {
  socket.on('startSession', (sessionCode) => {
    if (sessions.get(sessionCode)) {
      updateSessionStatus('running', sessionCode);
      initializeLeaderboard(sessionCode);
      const sessionStatus = sessions.get(sessionCode).sessionStatus;
      io.to(sessionCode).emit('session status', sessionStatus);

    }
  });

  socket.on('endSession', (sessionCode) => {
    if (sessions.get(sessionCode)) {
      sessions.delete(sessionCode);
    }
  });

  socket.on('get status', (sessionCode) => {
    if (sessions.get(sessionCode)) {
      const sessionStatus = sessions.get(sessionCode).sessionStatus;
      io.to(sessionCode).emit('session status', sessionStatus);
    }
  });
}

function handleScoreUpdates(socket) {
  socket.on('update score', (data) => {
    const { sessionCode, userId, newScore } = data;

    if (sessions.get(sessionCode)) {
      updateLeaderboardEntry(userId, newScore, sessionCode);
    }
  });
}

function handleQuizEvents(socket) {
  socket.on('startQuiz', (sessionCode) => {
    if (sessions.get(sessionCode)) {
      io.to(sessionCode).emit('quizStartSignal');
    }
  });
}

function handleUserResponse(socket) {
  socket.on('userData', (data) => {
    const { sessionCode, userData } = data;
    if (sessions.get(sessionCode)) {
      io.to(sessionCode).emit('updateResponse', userData);
    }
  });
}

function handleLeaderboardEvents(socket) {
  socket.on('get leaderboard', (sessionCode) => {
    if (sessions.get(sessionCode)) {
      const leaderboard = sessions.get(sessionCode).leaderboard;
      io.to(sessionCode).emit('update leaderboard', Object.values(leaderboard));
    }
  });
}

function handleDisconnect(socket) {
  socket.on('disconnect', () => {
    sessions.forEach((sessionData, sessionCode) => {
      const participants = sessionData.participants;
      sessionData.participants = participants.filter((participant) => participant.id !== socket.id);
      const leaderboard = sessionData.leaderboard;

      delete leaderboard[socket.id]; // Remove the participant from the leaderboard
      io.to(sessionCode).emit('participant left', socket.id);
      io.to(sessionCode).emit('update leaderboard', Object.values(leaderboard));
    });

    interactiveSessions.forEach((interactiveSessionData, sessionCode) => {
      const participants = interactiveSessionData.participants;
      interactiveSessionData.participants = participants.filter((participant) => participant.id !== socket.id);
      io.to(sessionCode).emit('participant left', socket.id);
      broadcastAllIS(sessionCode);
    });
  });
}

/// to clear those session exceed 3 hours to prevent overloaded
function clearExpiredSessions() {
  const currentTime = Date.now();

  // for quiz session
  for (const [sessionCode, sessionStartTime] of sessionStartTimes.entries()) {
    if (currentTime - sessionStartTime > SESSION_EXPIRY_TIME) {
      console.log(`Session ${sessionCode} has expired and will be cleared.`);
      sessions.delete(sessionCode);
      sessionStartTimes.delete(sessionCode);
    }
  }

  // for interactive session
  for (const [sessionCode, interactiveSessionStartTime] of interactiveSessionStartTimes.entries()) {
    if (currentTime - interactiveSessionStartTime > SESSION_EXPIRY_TIME) {
      console.log(`Interactive Session ${sessionCode} has expired and will be cleared.`);
      interactiveSessions.delete(sessionCode);
      interactiveSessionStartTimes.delete(sessionCode);
    }
  }


}

setInterval(clearExpiredSessions, INTERVAL_CHECK_TIME);

server.listen(port, () => {
  console.log(`Server is running on port ${port}`);
});
