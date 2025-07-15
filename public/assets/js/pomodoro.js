document.addEventListener('DOMContentLoaded', function() {
  // Elementos
  const modes       = document.querySelectorAll('.mode-btn');
  const display     = document.getElementById('timer-display');
  const startBtn    = document.getElementById('start-btn');
  const pauseBtn    = document.getElementById('pause-btn');
  const resetBtn    = document.getElementById('reset-btn');
  const applyBtn    = document.getElementById('apply-settings-btn');
  const workInput   = document.getElementById('work-duration');
  const shortInput  = document.getElementById('short-break-duration');
  const longInput   = document.getElementById('long-break-duration');

  // Carga ajustes
  let stored = JSON.parse(localStorage.getItem('pomodoroSettings')) || {};
  const defaultSettings = {
    work:       stored.workMin       || 25,
    shortBreak: stored.shortMin      || 5,
    longBreak:  stored.longMin       || 15
  };
  workInput.value  = defaultSettings.work;
  shortInput.value = defaultSettings.shortBreak;
  longInput.value  = defaultSettings.longBreak;

  // Estados
  let mode      = 'work';
  let cycleCount = 0;        // Contador de pomodoros completos
  let durations = {
    work:       defaultSettings.work * 60,
    shortBreak: defaultSettings.shortBreak * 60,
    longBreak:  defaultSettings.longBreak * 60
  };
  let remaining  = durations[mode];
  let intervalId = null;

  // Helpers
  function updateDisplay(time) {
    const m = String(Math.floor(time/60)).padStart(2,'0');
    const s = String(time%60).padStart(2,'0');
    display.textContent = `${m}:${s}`;
  }
  function notify(title, body) {
    if ('Notification' in window && Notification.permission === 'granted') {
      new Notification(title, { body });
    } else {
      alert(body);
    }
  }
  function switchMode(newMode) {
    modes.forEach(btn => btn.classList.toggle('active', btn.dataset.mode === newMode));
    mode      = newMode;
    remaining = durations[mode];
    updateDisplay(remaining);
  }

  // Lógica de transición de modos
  function nextCycle() {
    if (mode === 'work') {
      cycleCount++;
      // Cada 4 pomodoros largos, toca descanso largo
      if (cycleCount % 4 === 0) {
        switchMode('longBreak');
      } else {
        switchMode('shortBreak');
      }
    } else {
      // De descanso vuelves a work
      switchMode('work');
    }
  }

  // Temporizador
  function startTimer() {
    startBtn.disabled = true;
    pauseBtn.disabled = false;
    intervalId = setInterval(() => {
      remaining--;
      if (remaining < 0) {
        clearInterval(intervalId);
        // Notificación
        if (mode === 'work') {
          notify('Pomodoro terminado', '¡Hora de un descanso!');
        } else {
          notify('Descanso terminado', '¡Hora de volver al trabajo!');
        }
        // Avanzar al siguiente modo y auto-start (opcional)
        nextCycle();
        startTimer();
      } else {
        updateDisplay(remaining);
      }
    }, 1000);
  }
  function pauseTimer() {
    clearInterval(intervalId);
    startBtn.disabled = false;
    pauseBtn.disabled = true;
  }
  function resetTimer() {
    clearInterval(intervalId);
    remaining = durations[mode];
    updateDisplay(remaining);
    startBtn.disabled = false;
    pauseBtn.disabled = true;
  }

  // Events
  modes.forEach(btn => btn.addEventListener('click', () => {
    pauseTimer();
    cycleCount = 0;      // reset ciclo si cambias manualmente
    switchMode(btn.dataset.mode);
  }));
  startBtn.addEventListener('click', startTimer);
  pauseBtn.addEventListener('click', pauseTimer);
  resetBtn.addEventListener('click', resetTimer);
  applyBtn.addEventListener('click', () => {
    const w = parseInt(workInput.value, 10);
    const s = parseInt(shortInput.value, 10);
    const l = parseInt(longInput.value, 10);
    durations.work       = w * 60;
    durations.shortBreak = s * 60;
    durations.longBreak  = l * 60;
    localStorage.setItem('pomodoroSettings', JSON.stringify({ workMin:w, shortMin:s, longMin:l }));
    switchMode(mode);
  });

  // Init
  if ('Notification' in window && Notification.permission === 'default') {
    Notification.requestPermission();
  }
  updateDisplay(remaining);
});
