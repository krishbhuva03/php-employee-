#!/usr/bin/env bash
# Start PHP built-in server for this project and record its PID
set -euo pipefail
PROJECT_ROOT="$(cd "$(dirname "$0")" && pwd)"
HOST=localhost
PORT=8000
LOGFILE="$PROJECT_ROOT/.php-server.log"
PIDFILE="$PROJECT_ROOT/.php-server.pid"

if [ -f "$PIDFILE" ] && kill -0 "$(cat "$PIDFILE")" 2>/dev/null; then
  echo "Server already running (PID=$(cat "$PIDFILE"))"
  exit 0
fi

echo "Starting PHP dev server at http://$HOST:$PORT"
cd "$PROJECT_ROOT"
/opt/homebrew/opt/php/bin/php -S "$HOST:$PORT" -t . > "$LOGFILE" 2>&1 &
echo $! > "$PIDFILE"
echo "Started (PID=$(cat "$PIDFILE")), logs: $LOGFILE"
