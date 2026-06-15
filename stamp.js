// Writes build-info.js with current branch + version + timestamp.
// Run automatically via .git/hooks/pre-commit — no build system needed.
const { execSync } = require('child_process');
const fs = require('fs');

const branch = (() => {
  try { return execSync('git rev-parse --abbrev-ref HEAD', { encoding: 'utf8' }).trim(); }
  catch { return 'unknown'; }
})();

const version = (() => {
  try { return fs.readFileSync('version.txt', 'utf8').trim(); }
  catch { return ''; }
})();

const now = new Date();
const buildTime = now.toLocaleString('en-US', {
  month: 'short', day: 'numeric', year: 'numeric',
  hour: 'numeric', minute: '2-digit', hour12: true
});

const info = { branch, version, time: buildTime };
fs.writeFileSync('build-info.js', `window.__BUILD__=${JSON.stringify(info)};\n`);
console.log('[stamp] build-info.js written:', info);
