#!/usr/bin/env bash
# Stop PHP built-in server started by start.sh
set -euo pipefail
PROJECT_ROOT="$(cd "$(dirname "$0")" && pwd)"
PIDFILE="$PROJECT_ROOT/.php-server.pid"
LOGFILE="$PROJECT_ROOT/.php-server.log"

if [ ! -f "$PIDFILE" ]; then
  echo "PID file not found. Is the server running?"
  exit 1
fi

PID=$(cat "$PIDFILE")
if kill -0 "$PID" 2>/dev/null; then
  echo "Stopping server (PID=$PID)"
  kill "$PID"
  sleep 0.3
  if kill -0 "$PID" 2>/dev/null; then
    echo "PID still alive, sending SIGKILL"
    kill -9 "$PID" || true
  fi
  rm -f "$PIDFILE"
  echo "Stopped. Logs: $LOGFILE"
  exit 0
else
  echo "Process $PID not running. Cleaning PID file."
  rm -f "$PIDFILE"
  exit 1
fi
