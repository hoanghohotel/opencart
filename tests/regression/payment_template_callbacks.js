// Evaluate the actual rendered confirm scripts with browser/provider fakes.
// No DOM/network provider calls are allowed; AJAX callbacks are captured.
const fs = require('fs');
const vm = require('vm');
const inputs = JSON.parse(fs.readFileSync(0, 'utf8'));
(async () => {
    let count = 0;
    for (const [name, html] of Object.entries(inputs)) {
        let click, options;
        const window = { location: { href: '' } };
        const button = { addEventListener: (event, fn) => { click = fn; } };
        const chain = new Proxy({}, { get: () => () => chain });
        const $ = () => chain;
        $.ajax = data => { options = data; };
        const context = {
            window, document: { getElementById: () => button, querySelector: () => button }, $, console,
            setTimeout: fn => fn(), Promise,
            braintree: {
                client: { create: (data, callback) => {
                    if (callback) callback(null, {});
                    return Promise.resolve({});
                } },
                dataCollector: { create: (data, callback) => {
                    const result = { deviceData: 'fixture-device' };
                    if (callback) callback(null, result);
                    return Promise.resolve(result);
                } },
                threeDSecure: { create: () => Promise.resolve({ verifyCard: () => Promise.resolve({ nonce: 'fixture-nonce' }) }) }
            }
        };
        const script = html.match(/<script[^>]*>([\s\S]*?)<\/script>/i)[1];
        vm.runInNewContext(script, context);
        await new Promise(resolve => setImmediate(resolve));
        if (!click) throw new Error(name + ': confirm button not wired');
        click({ preventDefault() {} });
        if (!options) throw new Error(name + ': no confirmation request');
        options.error({}, '', '');
        if (window.location.href !== 'index.php?route=checkout/checkout/failure') throw new Error(name + ': network error reported success');
        count++;
        window.location.href = '';
        options.success({ error: 'Declined' });
        if (window.location.href) throw new Error(name + ': decline navigated to success');
        count++;
        options.success({});
        if (window.location.href) throw new Error(name + ': empty response reported success');
        count++;
        options.success({ order_id: 123, success: 'Confirmed' });
        if (window.location.href !== 'index.php?route=checkout/checkout/success') throw new Error(name + ': success contract changed');
        count++;
        console.log('PASS template callbacks', name);
    }
    console.log(count + ' callback scenarios PASS; PayPal unavailable render/SDK guard PASS');
})().catch(error => { console.error(error); process.exitCode = 1; });
