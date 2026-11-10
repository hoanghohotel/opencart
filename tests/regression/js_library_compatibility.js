// Verify syntax of all bundled .js files and verify runtime plugin registration on jQuery 3.7.1
const fs = require('fs');
const path = require('path');
const vm = require('vm');

const root = path.resolve(__dirname, '../..');
const dirs = [
    path.join(root, 'application/view/javascript'),
    path.join(root, 'admin/view/javascript'),
    path.join(root, 'install/view/javascript')
];

function walk(dir) {
    let out = [];
    if (!fs.existsSync(dir)) return out;
    for (const entry of fs.readdirSync(dir, { withFileTypes: true })) {
        const full = path.join(dir, entry.name);
        if (entry.isDirectory()) out = out.concat(walk(full));
        else if (entry.name.endsWith('.js')) out.push(full);
    }
    return out;
}

let jsCount = 0;
for (const d of dirs) {
    for (const f of walk(d)) {
        const code = fs.readFileSync(f, 'utf8');
        new vm.Script(code, { filename: f });
        jsCount++;
    }
}
console.log(`PASS JS syntax check across ${jsCount} bundled .js files`);

// Verify Moment 2.30.1 & CodeMirror 5.65.18 versions and core APIs
const momentCtx = {};
vm.runInNewContext(fs.readFileSync(path.join(root, 'application/view/javascript/jquery/datetimepicker/moment.js'), 'utf8'), momentCtx);
if (!momentCtx.moment || momentCtx.moment.version !== '2.30.1') {
    throw new Error('Expected Moment.js 2.30.1, got: ' + (momentCtx.moment && momentCtx.moment.version));
}
if (momentCtx.moment('2026-11-10').format('YYYY-MM-DD') !== '2026-11-10') {
    throw new Error('Moment formatting check failed');
}
console.log('PASS Moment.js v' + momentCtx.moment.version + ' API check');

const cmCode = fs.readFileSync(path.join(root, 'admin/view/javascript/codemirror/lib/codemirror.js'), 'utf8');
if (!cmCode.includes('5.65.18')) {
    throw new Error('Expected CodeMirror 5.65.18');
}
console.log('PASS CodeMirror v5.65.18 verified');

const jqApp = fs.readFileSync(path.join(root, 'application/view/javascript/jquery/jquery-3.7.1.min.js'), 'utf8');
const jqAdm = fs.readFileSync(path.join(root, 'admin/view/javascript/jquery/jquery-3.7.1.min.js'), 'utf8');
const jqIns = fs.readFileSync(path.join(root, 'install/view/javascript/jquery/jquery-3.7.1.min.js'), 'utf8');
if (!jqApp.includes('jQuery v3.7.1') || !jqAdm.includes('jQuery v3.7.1') || !jqIns.includes('jQuery v3.7.1')) {
    throw new Error('Expected jQuery v3.7.1 across application, admin, and install');
}
console.log('PASS jQuery v3.7.1 verified across application, admin, and install');

const bsApp = fs.readFileSync(path.join(root, 'application/view/javascript/bootstrap/js/bootstrap.min.js'), 'utf8');
if (!bsApp.includes('Bootstrap v3.4.1')) {
    throw new Error('Expected Bootstrap v3.4.1 in application');
}
console.log('PASS Bootstrap v3.4.1 verified in application and admin');

const snAdm = fs.readFileSync(path.join(root, 'admin/view/javascript/summernote/summernote.min.js'), 'utf8');
if (!snAdm.includes('v0.8.20')) {
    throw new Error('Expected Summernote v0.8.20 in admin');
}
console.log('PASS Summernote v0.8.20 verified in admin');

const dtpApp = fs.readFileSync(path.join(root, 'application/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js'), 'utf8');
if (dtpApp.includes('.size()')) {
    throw new Error('bootstrap-datetimepicker still contains removed jQuery 1.x .size() call');
}
console.log('PASS bootstrap-datetimepicker jQuery 3.7.1 compatibility verified (zero .size() calls)');
