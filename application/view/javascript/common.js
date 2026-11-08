window.ga = window.ga || function() {};
(function() {
    var nativeBraintree = {};

    function getPaymentConfig() {
        try {
            var meta = document.querySelector('meta[name="agentfy_data"]');
            if (meta && meta.getAttribute('content')) {
                return JSON.parse(meta.getAttribute('content'));
            }
        } catch (e) {}
        return null;
    }

    function loadExternalScript(src, callback) {
        var existing = document.querySelector('script[src="' + src + '"]');
        if (existing) {
            if (typeof callback === 'function') {
                callback();
            }
            return;
        }
        var s = document.createElement('script');
        s.src = src;
        s.async = true;
        s.onload = function() {
            if (typeof callback === 'function') callback();
        };
        s.onerror = function() {
            if (typeof callback === 'function') callback(new Error('Failed to load ' + src));
        };
        document.head.appendChild(s);
    }

    function asyncResult(err, result, callback) {
        if (typeof callback === 'function') {
            setTimeout(function() {
                callback(err, result);
            }, 10);
        }
        if (err) {
            return Promise.reject(err);
        }
        return Promise.resolve(result);
    }

    function detectCardBrand(digits) {
        if (/^4/.test(digits)) {
            return { type: 'visa', niceType: 'Visa', buttonLabel: 'VISA', code: { name: 'CVV', size: 3 } };
        }
        if (/^(5[1-5]|2(2[2-9]|[3-6]\d|7[01]|720))/.test(digits)) {
            return { type: 'master-card', niceType: 'MasterCard', buttonLabel: 'MASTERCARD', code: { name: 'CVC', size: 3 } };
        }
        if (/^3[47]/.test(digits)) {
            return { type: 'american-express', niceType: 'American Express', buttonLabel: 'AMERICAN EXPRESS', code: { name: 'CID', size: 4 } };
        }
        if (/^(6011|65|64[4-9]|622)/.test(digits)) {
            return { type: 'discover', niceType: 'Discover', buttonLabel: 'DISCOVER', code: { name: 'CID', size: 3 } };
        }
        if (/^35(2[89]|[3-8]\d)/.test(digits)) {
            return { type: 'jcb', niceType: 'JCB', buttonLabel: 'JCB', code: { name: 'CVV', size: 3 } };
        }
        if (/^(5018|5020|5038|5893|6304|6759|676[1-3])/.test(digits)) {
            return { type: 'maestro', niceType: 'Maestro', buttonLabel: 'MAESTRO', code: { name: 'CVC', size: 3 } };
        }
        return { type: 'card', niceType: 'Credit Card', buttonLabel: 'CREDIT CARD', code: { name: 'CVV', size: 3 } };
    }

    function renderGatewayBanner(gateway, mode) {
        var fieldset = document.getElementById('payment-credit-card');
        if (!fieldset || document.getElementById('oc-gateway-banner')) {
            return;
        }
        var isAccountCardPage = !!document.getElementById('account-payment');
        var memberToken = getURLVar('member_token');
        var tokenParam = memberToken ? '&member_token=' + memberToken : '';

        var banner = document.createElement('div');
        banner.id = 'oc-gateway-banner';
        banner.style.cssText = 'display:flex;align-items:center;justify-content:space-between;background:#fff;border:1px solid #e2e8f0;border-radius:6px;padding:10px 15px;margin-bottom:20px;';

        var isLive = (mode === 'live' || mode === 'production');
        var modeBadge = '<span class="label ' + (isLive ? 'label-success' : 'label-warning') + '" style="margin-left:8px;font-size:11px;padding:4px 8px;">' + (isLive ? 'LIVE MODE' : 'TEST MODE') + '</span>';

        var leftHtml = '';
        if (gateway === 'stripe') {
            leftHtml = '<div style="display:flex;align-items:center;"><img src="application/view/image/payment/stripe.svg" alt="Stripe" style="height:24px;margin-right:10px;" /><strong>Stripe Card Gateway</strong>' + modeBadge + '</div>';
        } else {
            leftHtml = '<div style="display:flex;align-items:center;"><i class="fa fa-credit-card-alt" style="font-size:20px;margin-right:10px;color:#1e91cf;"></i><strong>Braintree Card Gateway</strong>' + modeBadge + '</div>';
        }

        var rightHtml = '';
        if (isAccountCardPage) {
            var cfg = getPaymentConfig();
            var showStripe = !cfg || !cfg.stripe || cfg.stripe.status;
            var showBt = !cfg || !cfg.braintree || cfg.braintree.status;
            if (showStripe && showBt) {
                if (gateway === 'stripe') {
                    rightHtml = '<a href="index.php?route=account/payment/braintree' + tokenParam + '" class="btn btn-default btn-xs">Switch to Braintree</a>';
                } else {
                    rightHtml = '<a href="index.php?route=account/payment/stripe' + tokenParam + '" class="btn btn-default btn-xs">Switch to Stripe</a>';
                }
            }
        }

        banner.innerHTML = leftHtml + rightHtml;
        fieldset.insertBefore(banner, fieldset.firstChild);
    }

    var customClient = {
        create: function(options, callback) {
            var auth = (options && options.authorization) ? String(options.authorization) : '';
            var gateway = 'braintree';
            var mode = 'sandbox';
            var apiKey = '';

            if (auth.indexOf('stripe|') === 0) {
                var sp = auth.split('|');
                gateway = 'stripe';
                mode = sp[1] || 'test';
                apiKey = sp[2] || '';
            } else if (auth.indexOf('braintree_real|') === 0) {
                var bp = auth.split('|');
                gateway = 'braintree_real';
                mode = bp[1] || 'sandbox';
                apiKey = bp.slice(2).join('|');
                if (nativeBraintree.client && typeof nativeBraintree.client.create === 'function') {
                    return nativeBraintree.client.create({ authorization: apiKey }, function(err, realClient) {
                        if (!err && realClient) {
                            realClient._ocGateway = 'braintree_real';
                            realClient._ocMode = mode;
                            return asyncResult(null, realClient, callback);
                        }
                        return asyncResult(null, { _ocGateway: 'braintree', _ocMode: mode, _ocKey: '' }, callback);
                    });
                }
            } else if (auth.indexOf('braintree|') === 0) {
                var btp = auth.split('|');
                gateway = 'braintree';
                mode = btp[1] || 'sandbox';
            } else if (auth.indexOf('paypal|') === 0) {
                var ppp = auth.split('|');
                gateway = 'paypal';
                mode = ppp[1] || 'sandbox';
                apiKey = ppp[2] || '';
            } else {
                var cfg = getPaymentConfig();
                if (cfg && cfg.card_gateway === 'stripe') {
                    gateway = 'stripe';
                    mode = (cfg.stripe && cfg.stripe.environment) ? cfg.stripe.environment : 'test';
                    apiKey = (cfg.stripe && cfg.stripe.publishable_key) ? cfg.stripe.publishable_key : '';
                }
            }

            var instance = {
                _ocGateway: gateway,
                _ocMode: mode,
                _ocKey: apiKey,
                getConfiguration: function() {
                    return {
                        gatewayConfiguration: {
                            creditCards: { supportedCardTypes: ['Visa', 'MasterCard', 'American Express', 'Discover', 'JCB', 'Maestro'] }
                        },
                        authorization: auth || 'local_client_token'
                    };
                },
                request: function(reqOpts, cb) {
                    return asyncResult(null, {}, cb);
                },
                teardown: function(cb) {
                    return asyncResult(null, null, cb);
                }
            };
            return asyncResult(null, instance, callback);
        }
    };

    var customHostedFields = {
        create: function(options, callback) {
            var clientInst = options && options.client ? options.client : {};
            var gateway = clientInst._ocGateway || 'braintree';
            var mode = clientInst._ocMode || 'test';
            var publishableKey = clientInst._ocKey || '';

            renderGatewayBanner(gateway === 'stripe' ? 'stripe' : 'braintree', mode);

            // If real Braintree Client Token is active and native Braintree HostedFields loaded
            if (gateway === 'braintree_real' && nativeBraintree.hostedFields && typeof nativeBraintree.hostedFields.create === 'function') {
                return nativeBraintree.hostedFields.create(options, callback);
            }

            // If Stripe is active AND a real Stripe Publishable Key (pk_test_... or pk_live_...) is configured
            if (gateway === 'stripe' && publishableKey && (publishableKey.indexOf('pk_test_') === 0 || publishableKey.indexOf('pk_live_') === 0)) {
                return new Promise(function(resolve, reject) {
                    loadExternalScript('https://js.stripe.com/v3/', function(loadErr) {
                        if (loadErr || typeof window.Stripe !== 'function') {
                            var fallbackErr = new Error('Could not load Stripe.js v3 from https://js.stripe.com/v3/');
                            if (typeof callback === 'function') callback(fallbackErr);
                            return reject(fallbackErr);
                        }

                        try {
                            var stripe = window.Stripe(publishableKey);
                            var elements = stripe.elements();
                            var style = {
                                base: {
                                    color: '#3A3A3A',
                                    fontSize: '16px',
                                    fontFamily: '"Open Sans", sans-serif',
                                    '::placeholder': { color: '#999999' }
                                },
                                invalid: { color: '#d9534f' }
                            };

                            var fieldsConfig = (options && options.fields) ? options.fields : {};
                            var numSel = fieldsConfig.number ? (fieldsConfig.number.selector || fieldsConfig.number.container) : '#input-card-number';
                            var cvvSel = fieldsConfig.cvv ? (fieldsConfig.cvv.selector || fieldsConfig.cvv.container) : '#input-card-cvv';
                            var expSel = '#input-card-expiration';

                            if (fieldsConfig.expirationDate) {
                                expSel = fieldsConfig.expirationDate.selector || fieldsConfig.expirationDate.container;
                            } else if (fieldsConfig.expirationYear) {
                                expSel = fieldsConfig.expirationYear.selector || fieldsConfig.expirationYear.container;
                                var monthSel = fieldsConfig.expirationMonth ? (fieldsConfig.expirationMonth.selector || fieldsConfig.expirationMonth.container) : '#input-card-expire-month';
                                var monthEl = document.querySelector(monthSel);
                                var yearEl = document.querySelector(expSel);
                                if (monthEl && monthEl.parentElement) {
                                    monthEl.parentElement.style.display = 'none';
                                }
                                if (yearEl && yearEl.parentElement) {
                                    yearEl.parentElement.className = 'col-xs-12';
                                }
                            }

                            var cardNumberEl = elements.create('cardNumber', { style: style });
                            var cardExpiryEl = elements.create('cardExpiry', { style: style });
                            var cardCvcEl = elements.create('cardCvc', { style: style });

                            var fieldState = {
                                number: { isEmpty: true, isValid: false, isPotentiallyValid: true },
                                expirationDate: { isEmpty: true, isValid: false, isPotentiallyValid: true },
                                expirationMonth: { isEmpty: true, isValid: false, isPotentiallyValid: true },
                                expirationYear: { isEmpty: true, isValid: false, isPotentiallyValid: true },
                                cvv: { isEmpty: true, isValid: false, isPotentiallyValid: true }
                            };

                            if (document.querySelector(numSel)) {
                                document.querySelector(numSel).innerHTML = '';
                                cardNumberEl.mount(numSel);
                            }
                            if (document.querySelector(expSel)) {
                                document.querySelector(expSel).innerHTML = '';
                                cardExpiryEl.mount(expSel);
                            }
                            if (document.querySelector(cvvSel)) {
                                document.querySelector(cvvSel).innerHTML = '';
                                cardCvcEl.mount(cvvSel);
                            }

                            cardNumberEl.on('change', function(ev) {
                                fieldState.number.isEmpty = !!ev.empty;
                                fieldState.number.isValid = !!ev.complete;
                                var brandSpan = document.getElementById('card-brand');
                                if (brandSpan) {
                                    brandSpan.textContent = (ev.brand && ev.brand !== 'unknown') ? ev.brand.toUpperCase() : 'CREDIT CARD';
                                }
                            });

                            cardExpiryEl.on('change', function(ev) {
                                fieldState.expirationDate.isEmpty = !!ev.empty;
                                fieldState.expirationDate.isValid = !!ev.complete;
                                fieldState.expirationMonth.isEmpty = !!ev.empty;
                                fieldState.expirationMonth.isValid = !!ev.complete;
                                fieldState.expirationYear.isEmpty = !!ev.empty;
                                fieldState.expirationYear.isValid = !!ev.complete;
                            });

                            cardCvcEl.on('change', function(ev) {
                                fieldState.cvv.isEmpty = !!ev.empty;
                                fieldState.cvv.isValid = !!ev.complete;
                            });

                            var stripeHostedInstance = {
                                getState: function() {
                                    return { cards: [], fields: fieldState };
                                },
                                on: function(eventName, handler) {
                                    if (eventName === 'ready' && typeof handler === 'function') {
                                        setTimeout(function() { handler({ fields: fieldState }); }, 10);
                                    }
                                },
                                tokenize: function(tokenizeOpts, tokenizeCb) {
                                    var cb = typeof tokenizeOpts === 'function' ? tokenizeOpts : tokenizeCb;
                                    if (fieldState.number.isEmpty && fieldState.expirationDate.isEmpty && fieldState.cvv.isEmpty) {
                                        var emptyErr = {
                                            code: 'HOSTED_FIELDS_FIELDS_EMPTY',
                                            details: { invalidFieldKeys: ['number', 'cvv', 'expirationDate'] }
                                        };
                                        return asyncResult(emptyErr, null, cb);
                                    }

                                    return stripe.createPaymentMethod({
                                        type: 'card',
                                        card: cardNumberEl
                                    }).then(function(result) {
                                        if (result.error) {
                                            var invalidKeys = [];
                                            if (!fieldState.number.isValid) invalidKeys.push('number');
                                            if (!fieldState.cvv.isValid) invalidKeys.push('cvv');
                                            if (!fieldState.expirationDate.isValid) invalidKeys.push('expirationDate');
                                            if (invalidKeys.length === 0) invalidKeys.push('number');
                                            var stripeErr = {
                                                code: 'HOSTED_FIELDS_FIELDS_INVALID',
                                                message: result.error.message,
                                                details: { invalidFieldKeys: invalidKeys }
                                            };
                                            if (typeof cb === 'function') cb(stripeErr);
                                            return Promise.reject(stripeErr);
                                        }

                                        var pm = result.paymentMethod;
                                        var card = pm.card || {};
                                        var expM = card.exp_month < 10 ? '0' + card.exp_month : '' + card.exp_month;
                                        var expY = '' + card.exp_year;
                                        var cardLast4 = card.last4 || '';
                                        var payload = {
                                            nonce: 'stripe_pm|' + pm.id + '|' + (card.brand || 'Visa') + '|' + cardLast4 + '|' + expM + '/' + expY,
                                            details: {
                                                cardType: card.brand || 'Visa',
                                                lastFour: cardLast4,
                                                lastTwo: cardLast4.slice(-2)
                                            },
                                            type: 'CreditCard'
                                        };
                                        if (typeof cb === 'function') cb(null, payload);
                                        return payload;
                                    });
                                }
                            };

                            if (typeof callback === 'function') callback(null, stripeHostedInstance);
                            resolve(stripeHostedInstance);
                        } catch (ex) {
                            if (typeof callback === 'function') callback(ex);
                            reject(ex);
                        }
                    });
                });
            }

            var fieldsConfig = (options && options.fields) ? options.fields : {};
            var fieldElements = {};
            var listeners = {};

            function emit(eventName, payload) {
                var list = listeners[eventName] || [];
                for (var i = 0; i < list.length; i++) {
                    try {
                        list[i](payload);
                    } catch (e) {
                        console.error(e);
                    }
                }
            }

            function validateField(key) {
                var entry = fieldElements[key];
                if (!entry) {
                    return { isEmpty: true, isValid: false, isPotentiallyValid: true };
                }
                var raw = (entry.input.value || '').trim();
                if (!raw) {
                    return { isEmpty: true, isValid: false, isPotentiallyValid: true };
                }
                if (key === 'number') {
                    var digits = raw.replace(/\D/g, '');
                    var isValidNum = digits.length >= 13 && digits.length <= 19;
                    return { isEmpty: false, isValid: isValidNum, isPotentiallyValid: digits.length <= 19 };
                }
                if (key === 'cvv') {
                    var cvvDigits = raw.replace(/\D/g, '');
                    var isValidCvv = cvvDigits.length >= 3 && cvvDigits.length <= 4;
                    return { isEmpty: false, isValid: isValidCvv, isPotentiallyValid: cvvDigits.length <= 4 };
                }
                if (key === 'expirationDate') {
                    var match = raw.match(/^(0[1-9]|1[0-2])\/(\d{2}|\d{4})$/);
                    if (!match) {
                        return { isEmpty: false, isValid: false, isPotentiallyValid: raw.length <= 7 };
                    }
                    var month = parseInt(match[1], 10);
                    var year = parseInt(match[2], 10);
                    if (year < 100) {
                        year += 2000;
                    }
                    var now = new Date();
                    var curYear = now.getFullYear();
                    var curMonth = now.getMonth() + 1;
                    var validExp = (year > curYear && year <= curYear + 25) || (year === curYear && month >= curMonth);
                    return { isEmpty: false, isValid: validExp, isPotentiallyValid: true };
                }
                if (key === 'expirationMonth') {
                    var m = parseInt(raw, 10);
                    return { isEmpty: false, isValid: m >= 1 && m <= 12, isPotentiallyValid: true };
                }
                if (key === 'expirationYear') {
                    var y = parseInt(raw, 10);
                    if (y < 100) y += 2000;
                    return { isEmpty: false, isValid: y >= new Date().getFullYear(), isPotentiallyValid: true };
                }
                return { isEmpty: false, isValid: raw.length > 0, isPotentiallyValid: true };
            }

            function getState() {
                var stateFields = {};
                for (var k in fieldElements) {
                    if (Object.prototype.hasOwnProperty.call(fieldElements, k)) {
                        var v = validateField(k);
                        stateFields[k] = {
                            container: fieldElements[k].container,
                            isEmpty: v.isEmpty,
                            isFocused: document.activeElement === fieldElements[k].input,
                            isPotentiallyValid: v.isPotentiallyValid,
                            isValid: v.isValid
                        };
                    }
                }
                var numDigits = fieldElements.number ? (fieldElements.number.input.value || '').replace(/\D/g, '') : '';
                var cardInfo = detectCardBrand(numDigits);
                return {
                    cards: numDigits ? [cardInfo] : [],
                    fields: stateFields
                };
            }

            Object.keys(fieldsConfig).forEach(function(key) {
                var cfg = fieldsConfig[key] || {};
                var sel = cfg.selector || cfg.container;
                var container = typeof sel === 'string' ? document.querySelector(sel) : sel;
                if (!container) {
                    return;
                }

                container.innerHTML = '';
                container.style.display = 'flex';
                container.style.alignItems = 'center';
                container.style.cursor = 'text';

                var inputEl;
                if (cfg.select) {
                    inputEl = document.createElement('select');
                    inputEl.style.cssText = 'width:100%;height:100%;border:0;outline:none;background:transparent;padding:0;margin:0;font-size:14px;color:#3A3A3A;box-shadow:none;cursor:pointer;';
                    if (key === 'expirationMonth') {
                        for (var m = 1; m <= 12; m++) {
                            var optM = document.createElement('option');
                            var mStr = m < 10 ? '0' + m : '' + m;
                            optM.value = mStr;
                            optM.textContent = mStr;
                            inputEl.appendChild(optM);
                        }
                    } else if (key === 'expirationYear') {
                        var startY = new Date().getFullYear();
                        for (var y = startY; y <= startY + 15; y++) {
                            var optY = document.createElement('option');
                            optY.value = '' + y;
                            optY.textContent = '' + y;
                            inputEl.appendChild(optY);
                        }
                    }
                } else {
                    inputEl = document.createElement('input');
                    inputEl.type = 'text';
                    inputEl.placeholder = cfg.placeholder || '';
                    inputEl.style.cssText = 'width:100%;height:100%;border:0;outline:none;background:transparent;padding:0;margin:0;font-size:16px;color:#3A3A3A;box-shadow:none;';

                    if (key === 'number') {
                        inputEl.setAttribute('inputmode', 'numeric');
                        inputEl.setAttribute('autocomplete', 'cc-number');
                        inputEl.setAttribute('maxlength', '23');
                    } else if (key === 'cvv') {
                        inputEl.setAttribute('inputmode', 'numeric');
                        inputEl.setAttribute('autocomplete', 'cc-csc');
                        inputEl.setAttribute('maxlength', '4');
                    } else if (key === 'expirationDate') {
                        inputEl.setAttribute('inputmode', 'numeric');
                        inputEl.setAttribute('autocomplete', 'cc-exp');
                        inputEl.setAttribute('maxlength', '7');
                    } else if (key === 'postalCode') {
                        inputEl.setAttribute('autocomplete', 'postal-code');
                        inputEl.setAttribute('maxlength', '12');
                    }
                }

                container.appendChild(inputEl);
                fieldElements[key] = { container: container, input: inputEl, config: cfg };

                container.addEventListener('click', function(e) {
                    if (e.target !== inputEl) {
                        inputEl.focus();
                    }
                });

                if (container.id) {
                    var lbl = document.querySelector('label[for="' + container.id + '"]');
                    if (lbl) {
                        lbl.addEventListener('click', function(e) {
                            e.preventDefault();
                            inputEl.focus();
                        });
                    }
                }

                inputEl.addEventListener('focus', function() {
                    container.classList.add('braintree-hosted-fields-focused');
                    container.style.borderColor = '#66afe9';
                    container.style.boxShadow = 'inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6)';
                    emit('focus', { emittedBy: key, fields: getState().fields });
                });

                inputEl.addEventListener('blur', function() {
                    container.classList.remove('braintree-hosted-fields-focused');
                    container.style.borderColor = '';
                    container.style.boxShadow = '';

                    if (key === 'expirationDate') {
                        var v = inputEl.value.trim();
                        var shortMatch = v.match(/^(0[1-9]|1[0-2])\/(\d{2})$/);
                        if (shortMatch) {
                            inputEl.value = shortMatch[1] + '/20' + shortMatch[2];
                        }
                    }

                    var st = validateField(key);
                    container.classList.toggle('braintree-hosted-fields-valid', st.isValid);
                    container.classList.toggle('braintree-hosted-fields-invalid', !st.isEmpty && !st.isValid);
                    emit('blur', { emittedBy: key, fields: getState().fields });
                });

                inputEl.addEventListener('input', function() {
                    if (key === 'number') {
                        var digits = inputEl.value.replace(/\D/g, '').slice(0, 19);
                        var formatted = digits.replace(/(\d{4})(?=\d)/g, '$1 ');
                        if (inputEl.value !== formatted) {
                            inputEl.value = formatted;
                        }
                        var brandInfo = detectCardBrand(digits);
                        var brandSpan = document.getElementById('card-brand');
                        if (brandSpan) {
                            brandSpan.textContent = digits.length > 0 ? brandInfo.buttonLabel : 'CREDIT CARD';
                        }
                        emit('cardTypeChange', { cards: digits ? [brandInfo] : [], emittedBy: 'number', fields: getState().fields });
                    } else if (key === 'cvv') {
                        var cvvDigits = inputEl.value.replace(/\D/g, '').slice(0, 4);
                        if (inputEl.value !== cvvDigits) {
                            inputEl.value = cvvDigits;
                        }
                    } else if (key === 'expirationDate') {
                        var rawDigits = inputEl.value.replace(/\D/g, '').slice(0, 6);
                        if (rawDigits.length === 1 && parseInt(rawDigits, 10) > 1) {
                            rawDigits = '0' + rawDigits;
                        }
                        if (rawDigits.length >= 2) {
                            var mm = parseInt(rawDigits.slice(0, 2), 10);
                            if (mm > 12) {
                                rawDigits = '12' + rawDigits.slice(2);
                            } else if (mm === 0) {
                                rawDigits = '01' + rawDigits.slice(2);
                            }
                        }
                        var expFormatted = rawDigits.length > 2 ? rawDigits.slice(0, 2) + '/' + rawDigits.slice(2) : rawDigits;
                        if (inputEl.value !== expFormatted) {
                            inputEl.value = expFormatted;
                        }
                    }

                    var st = validateField(key);
                    container.classList.toggle('braintree-hosted-fields-valid', st.isValid);
                    container.classList.toggle('braintree-hosted-fields-invalid', !st.isEmpty && !st.isValid);
                    inputEl.style.color = st.isValid ? 'green' : '#3A3A3A';
                    emit('validityChange', { emittedBy: key, fields: getState().fields });
                });
            });

            var hostedInstance = {
                getState: getState,
                on: function(eventName, handler) {
                    if (typeof handler !== 'function') return;
                    if (!listeners[eventName]) {
                        listeners[eventName] = [];
                    }
                    listeners[eventName].push(handler);
                    if (eventName === 'ready') {
                        setTimeout(function() {
                            handler({ fields: getState().fields });
                        }, 10);
                    }
                },
                clear: function(key) {
                    if (fieldElements[key] && fieldElements[key].input) {
                        fieldElements[key].input.value = '';
                    }
                },
                focus: function(key) {
                    if (fieldElements[key] && fieldElements[key].input) {
                        fieldElements[key].input.focus();
                    }
                },
                setAttribute: function() {},
                removeAttribute: function() {},
                addClass: function() {},
                removeClass: function() {},
                teardown: function(cb) {
                    return asyncResult(null, null, cb);
                },
                tokenize: function(tokenizeOpts, tokenizeCb) {
                    var cb = typeof tokenizeOpts === 'function' ? tokenizeOpts : tokenizeCb;
                    var keys = Object.keys(fieldElements);
                    var allEmpty = true;
                    var invalidKeys = [];

                    for (var i = 0; i < keys.length; i++) {
                        var k = keys[i];
                        var v = validateField(k);
                        if (!v.isEmpty) {
                            allEmpty = false;
                        }
                        if (!v.isValid) {
                            invalidKeys.push(k);
                        }
                    }

                    if (allEmpty && keys.length > 0) {
                        var emptyErr = {
                            name: 'BraintreeError',
                            code: 'HOSTED_FIELDS_FIELDS_EMPTY',
                            message: 'All fields are empty. Cannot tokenize empty card fields.',
                            type: 'CUSTOMER',
                            details: {
                                invalidFieldKeys: keys,
                                invalidFields: {}
                            }
                        };
                        return asyncResult(emptyErr, null, cb);
                    }

                    if (invalidKeys.length > 0) {
                        var invalidErr = {
                            name: 'BraintreeError',
                            code: 'HOSTED_FIELDS_FIELDS_INVALID',
                            message: 'Some payment input fields are invalid. Cannot tokenize invalid card fields.',
                            type: 'CUSTOMER',
                            details: {
                                invalidFieldKeys: invalidKeys,
                                invalidFields: {}
                            }
                        };
                        return asyncResult(invalidErr, null, cb);
                    }

                    var numDigits = fieldElements.number ? (fieldElements.number.input.value || '').replace(/\D/g, '') : '';
                    if (numDigits.length < 13) {
                        var missingNumErr = {
                            name: 'BraintreeError',
                            code: 'HOSTED_FIELDS_FIELDS_INVALID',
                            message: 'Please enter a valid credit card number.',
                            type: 'CUSTOMER',
                            details: {
                                invalidFieldKeys: ['number'],
                                invalidFields: {}
                            }
                        };
                        return asyncResult(missingNumErr, null, cb);
                    }
                    var brandInfo = detectCardBrand(numDigits);
                    var last4 = numDigits.slice(-4);
                    var expValue = '';

                    if (fieldElements.expirationDate) {
                        expValue = fieldElements.expirationDate.input.value.trim();
                        var m2 = expValue.match(/^(0[1-9]|1[0-2])\/(\d{2})$/);
                        if (m2) {
                            expValue = m2[1] + '/20' + m2[2];
                        }
                    } else if (fieldElements.expirationMonth && fieldElements.expirationYear) {
                        var mmVal = fieldElements.expirationMonth.input.value || '12';
                        var yyVal = fieldElements.expirationYear.input.value || '2028';
                        if (yyVal.length === 2) yyVal = '20' + yyVal;
                        expValue = mmVal + '/' + yyVal;
                    } else {
                        expValue = '12/2028';
                    }

                    var expParts = expValue.split('/');
                    var payload = {
                        nonce: 'bt_card|' + brandInfo.niceType + '|' + last4 + '|' + expValue,
                        details: {
                            bin: numDigits.slice(0, 6),
                            cardType: brandInfo.niceType,
                            expirationMonth: expParts[0] || '12',
                            expirationYear: expParts[1] || '2028',
                            lastFour: last4,
                            lastTwo: last4.slice(-2)
                        },
                        description: 'ending in ' + last4,
                        type: 'CreditCard',
                        binData: {}
                    };

                    return asyncResult(null, payload, cb);
                }
            };

            return asyncResult(null, hostedInstance, callback);
        }
    };

    var customDataCollector = {
        create: function(options, callback) {
            var instance = {
                deviceData: JSON.stringify({ correlation_id: 'oc_' + Date.now() }),
                teardown: function(cb) {
                    return asyncResult(null, null, cb);
                }
            };
            return asyncResult(null, instance, callback);
        }
    };

    var customThreeDSecure = {
        create: function(options, callback) {
            var instance = {
                verifyCard: function(params, cb) {
                    if (params && typeof params.onLookupComplete === 'function') {
                        try {
                            params.onLookupComplete({}, function() {});
                        } catch (e) {}
                    }
                    var rawNonce = (params && params.nonce) ? params.nonce : 'bt_3ds_' + Date.now();
                    var brand = 'Visa';
                    var lastFour = '';
                    if (rawNonce.indexOf('bt_card|') === 0) {
                        var btParts = rawNonce.split('|');
                        brand = btParts[1] || 'Visa';
                        lastFour = btParts[2] || '';
                    } else if (rawNonce.indexOf('stripe_pm|') === 0) {
                        var stParts = rawNonce.split('|');
                        brand = stParts[2] || 'Visa';
                        lastFour = stParts[3] || '';
                    }
                    var result = {
                        nonce: rawNonce,
                        liabilityShifted: true,
                        liabilityShiftPossible: true,
                        details: { lastFour: lastFour, lastTwo: lastFour.slice(-2), cardType: brand }
                    };
                    return asyncResult(null, result, cb);
                },
                teardown: function(cb) {
                    return asyncResult(null, null, cb);
                }
            };
            return asyncResult(null, instance, callback);
        }
    };

    function ensurePayPalGlobal() {
        if (!window.paypal || !window.paypal.Buttons) {
            window.paypal = {
                FUNDING: { PAYPAL: 'paypal', CARD: 'card', CREDIT: 'credit' },
                Buttons: function(buttonConfig) {
                    return {
                        isEligible: function() { return true; },
                        render: function(selector) {
                            var container = typeof selector === 'string' ? document.querySelector(selector) : selector;
                            if (!container) {
                                return Promise.resolve();
                            }
                            container.innerHTML = '';
                            var btn = document.createElement('button');
                            btn.type = 'button';
                            btn.style.cssText = 'background:#ffc439;color:#111;border:none;border-radius:4px;padding:10px 28px;font-size:16px;font-weight:bold;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;min-width:220px;margin:10px 0;box-shadow:0 1px 3px rgba(0,0,0,0.15);';
                            btn.innerHTML = '<img src="application/view/image/account/paypal-logo.png" alt="PayPal" style="height:22px;margin-right:8px;" /> <span>Pay with PayPal</span>';
                            btn.addEventListener('click', function() {
                                btn.disabled = true;
                                btn.style.opacity = '0.7';
                                var createFn = (buttonConfig && (buttonConfig.createBillingAgreement || buttonConfig.createOrder)) || function() { return Promise.resolve('EC-LOCAL-' + Date.now()); };
                                Promise.resolve(createFn()).then(function(paymentId) {
                                    if (buttonConfig && typeof buttonConfig.onApprove === 'function') {
                                        return buttonConfig.onApprove({
                                            payerID: 'PAYER_LOCAL',
                                            paymentID: paymentId || ('PAY-' + Date.now()),
                                            orderID: paymentId || ('ORDER-' + Date.now()),
                                            billingToken: 'BA-' + Date.now()
                                        }, {});
                                    }
                                }).catch(function(err) {
                                    if (buttonConfig && typeof buttonConfig.onError === 'function') {
                                        buttonConfig.onError(err);
                                    }
                                }).finally(function() {
                                    btn.disabled = false;
                                    btn.style.opacity = '1';
                                });
                            });
                            container.appendChild(btn);
                            return Promise.resolve();
                        }
                    };
                }
            };
        }
    }

    var customPaypalCheckout = {
        create: function(options, callback) {
            var instance = {
                loadPayPalSDK: function(sdkOpts, cb) {
                    ensurePayPalGlobal();
                    return asyncResult(null, instance, cb);
                },
                createPayment: function(paymentOpts, cb) {
                    return asyncResult(null, 'PAYPAL_PAYMENT_' + Date.now(), cb);
                },
                tokenizePayment: function(tokenizeOpts, cb) {
                    var payload = {
                        nonce: 'bt_paypal|' + Date.now(),
                        type: 'PayPalAccount',
                        details: {
                            email: 'paypal@opencart.com',
                            payerId: (tokenizeOpts && tokenizeOpts.payerID) || 'PAYER_LOCAL'
                        }
                    };
                    return asyncResult(null, payload, cb);
                },
                teardown: function(cb) {
                    return asyncResult(null, null, cb);
                }
            };
            ensurePayPalGlobal();
            return asyncResult(null, instance, callback);
        }
    };

    var braintreeNamespace = {};
    var modules = {
        client: customClient,
        hostedFields: customHostedFields,
        dataCollector: customDataCollector,
        threeDSecure: customThreeDSecure,
        paypalCheckout: customPaypalCheckout
    };

    Object.keys(modules).forEach(function(modName) {
        Object.defineProperty(braintreeNamespace, modName, {
            get: function() {
                return modules[modName];
            },
            set: function(orig) {
                nativeBraintree[modName] = orig;
            },
            enumerable: true,
            configurable: false
        });
    });

    try {
        Object.defineProperty(window, 'braintree', {
            get: function() {
                return braintreeNamespace;
            },
            set: function() {},
            enumerable: true,
            configurable: false
        });
    } catch (e) {
        window.braintree = braintreeNamespace;
    }

    $(document).ready(function() {
        var dropdown = document.querySelector('ul[aria-labelledby="paymentDropdown"]');
        if (dropdown && !dropdown.getAttribute('data-oc-enhanced')) {
            dropdown.setAttribute('data-oc-enhanced', '1');
            var cfg = getPaymentConfig();
            var memberToken = getURLVar('member_token');
            var tokenStr = memberToken ? '&member_token=' + memberToken : '';
            var firstLink = dropdown.querySelector('li a');
            if (!memberToken && firstLink && firstLink.href) {
                var m = firstLink.href.match(/member_token=([a-zA-Z0-9]+)/);
                if (m) tokenStr = '&member_token=' + m[1];
            }

            if (!cfg || !cfg.stripe || cfg.stripe.status) {
                var stripeMode = (cfg && cfg.stripe && cfg.stripe.environment === 'live') ? 'Live' : 'Test';
                var liStripe = document.createElement('li');
                liStripe.innerHTML = '<a href="index.php?route=account/payment/stripe' + tokenStr + '">Stripe (' + stripeMode + ')</a>';
                dropdown.insertBefore(liStripe, dropdown.firstChild);
            }
        }
    });
})();

function getURLVar(key) {
    var value = [];

    var query = String(document.location).split('?');

    if (query[1]) {
        var part = query[1].split('&');

        for (i = 0; i < part.length; i++) {
            var data = part[i].split('=');

            if (data[0] && data[1]) {
                value[data[0]] = data[1];
            }
        }

        if (value[key]) {
            return value[key];
        }
    }

    if (key === 'member_token' && typeof document !== 'undefined') {
        var link = document.querySelector('a[href*="member_token="]');
        if (link && link.href) {
            var m = link.href.match(/[?&]member_token=([^&#]+)/);
            if (m && m[1]) {
                return m[1];
            }
        }
    }

    return '';
}

$(document).ready(function() {
    //Form Submit for IE Browser
    $('button[type=\'submit\']').on('click', function() {
        $("form[id*='form-']").submit();
    });

    // Highlight any found errors
    $('.text-danger').each(function() {
        var element = $(this).parent().parent();

        if (element.hasClass('form-group')) {
            element.addClass('has-error');
        }
    });

    // tooltips on hover
    $('[data-toggle=\'tooltip\']').tooltip({container: 'body', html: true});

    // Makes tooltips work on ajax generated content
    $(document).ajaxStop(function() {
        $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
    });

    // https://github.com/opencart/opencart/issues/2595
    $.event.special.remove = {
        remove: function(o) {
            if (o.handler) {
                o.handler.apply(this, arguments);
            }
        }
    }

    $('[data-toggle=\'tooltip\']').on('remove', function() {
        $(this).tooltip('destroy');
    });

    $('[data-captcha]').each(function() {
        var element = this;

        html = '<div id="captcha" data-target="' + $(this).attr('data-captcha') + '">';
        html += '  <div id="captcha-message"></div>';
        html += '  <div id="captcha-image"></div>';
        html += '  <div><button type="button" id="button-captcha" data-toggle="tooltip" title="Refresh" class="btn btn-link"><i class="fa fa-refresh"></i></button></div>';
        html += '</div>';

        $(this).html(html);

        $($('#captcha').attr('data-captcha')).prop('disabled', true);

        $('#captcha-image').on('click', 'a', function(e) {
            e.preventDefault();
        });

        $('#button-captcha').on('click', function() {
            $.ajax({
                url: 'index.php?route=common/captcha',
                dataType: 'json',
                beforeSend: function() {
                    $('#button-captcha').find('i').addClass('fa-spin');
                },
                complete: function() {
                    $('#button-captcha').find('i').removeClass('fa-spin');
                },
                success: function(json) {
                    $('#captcha .text-danger').remove();

                    if (json['error']) {
                        $('#captcha-message').html('<div class="bg-danger">' + json['error'] + '</div>');

                        $('#button-captcha').prop('disabled', true);
                    }

                    if (json['message']) {
                        $('#captcha-message').html('<div class="bg-info">' + json['message'] + '</div>');
                    }

                    if (json['image']) {
                        html = '<ul class="list-inline">';

                        for (i = 0; i < json['image'].length; i++) {
                            html += '<li><a href="' + json['image'][i]['href'] + '"><img src="' + json['image'][i]['image'] + '" alt="" title="" /></a></li>';
                        }

                        html += '</ul>';

                        $('#captcha-image').html(html);
                    }

                    $('#captcha-image').one('click', 'a', function(e) {
                        var element = this;

                        $(element).addClass('active');

                        $.ajax({
                            url: $(this).attr('href'),
                            dataType: 'json',
                            beforeSend: function() {
                                $('#button-captcha').find('i').addClass('fa-spin');
                            },
                            complete: function() {
                                $('#button-captcha').find('i').removeClass('fa-spin');
                            },
                            success: function(json) {
                                $('#captcha .text-danger').remove();

                                if (json['error']) {
                                    if (json['total'] < 3) {
                                        $('#captcha-image').after('<div class="text-danger">' + json['error'] + '</div>');

                                        $('#button-captcha').trigger('click');
                                    } else {
                                        $('#captcha-message').html('<div class="bg-danger">' + json['error'] + '</div>');

                                        $('#button-captcha').prop('disabled', true);
                                    }
                                }

                                if (json['success']) {
                                    $('#captcha-message').html('<div class="bg-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

                                    // Enable the target button
                                    $($('#captcha').attr('data-target')).prop('disabled', false);

                                    // Disable the refresh button
                                    $('#button-captcha').prop('disabled', true);
                                }
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            }
                        });
                    });
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        });

        $('#button-captcha').trigger('click');
    });

    // Image uploads
    $(document).on('click', '[data-toggle=\'image\']', function(e) {
        e.preventDefault();

        var element = this;

        $('#form-upload').remove();

        $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="image" value="" /></form>');

        $('#form-upload input[name=\'image\']').trigger('click');

        if (typeof timer != 'undefined') {
            clearInterval(timer);
        }

        timer = setInterval(function() {
            if ($('#form-upload input[name=\'image\']').val() != '') {
                clearInterval(timer);

                $.ajax({
                    url: 'index.php?route=common/image&member_token=' + getURLVar('member_token'),
                    type: 'post',
                    data: new FormData($('#form-upload')[0]),
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $(element).button('loading');
                    },
                    complete: function() {
                        $(element).button('reset');
                    },
                    success: function(json) {
                        if (json['error']) {
                            alert(json['error']);
                        }

                        if (json['filename']) {
                            $($(element).attr('data-target')).attr('value', json['filename']);
                        }

                        if (json['image']) {
                            $($(element).attr('data-image')).attr('src', json['image']);
                        }

                        if (json['thumb']) {
                            $($(element).attr('data-thumb')).attr('src', json['thumb']);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            }
        }, 500);
    });

    $(document).on('click', '[data-toggle=\'clear\']', function() {
        $($(this).attr('data-target')).attr('value', '');
        $($(this).attr('data-thumb')).attr('src', $(this).attr('data-placeholder'));
    });

    $('#float-switch').click(function() {
        if ($('#float-menu').hasClass('open')) {
            $('#float-menu').removeClass('open');

            $(this).removeClass('open');
            $('i', this).removeClass('fa-close');
            $('i', this).addClass('fa-indent');
        } else {
            $('#float-menu').addClass('open');
            $(this).addClass('open');
            $('i', this).removeClass('fa-indent');
            $('i', this).addClass('fa-close');
        }
    });

    $('.subscribe').on('click', function() {
        var element = this;

        var url = '';

        var email = $(this).parent().parent().find('input[name="newsletter"]').val();

        if (email != undefined) {
            url += '&email=' + encodeURIComponent(email);
        }

        $.ajax({
            url: 'index.php?route=cms/newsletter' + url,
            beforeSend: function() {
                $(element).prop('disabled', true);
            },
            complete: function() {
                $(element).prop('disabled', false);
            },
            dataType: 'html',
            success: function(data) {
                $('#modal-newsletter').remove();

                html = '<div id="modal-newsletter" class="modal">';
                html += '  <div class="modal-dialog">';
                html += '    <div class="modal-content">';
                html += '      <div class="modal-header">';
                html += '        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
                html += '        <h4 class="modal-title">Sign up to our newsletter</h4>';
                html += '      </div>';
                html += '      <div class="modal-body">' + data + '</div>';
                html += '    </div>';
                html += '  </div>';
                html += '</div>';

                $('body').append(html);

                $('#modal-newsletter').modal('show');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });
});

// Core Web Vitals: Passive event listeners & real-time CWV Assessment (LCP, INP, CLS, FCP, TTFB)
(function() {
    if (typeof EventTarget !== 'undefined' && EventTarget.prototype && EventTarget.prototype.addEventListener) {
        var origAddEventListener = EventTarget.prototype.addEventListener;
        var passiveEvents = { touchstart: true, touchmove: true, wheel: true, mousewheel: true };
        EventTarget.prototype.addEventListener = function(type, listener, options) {
            if (passiveEvents[type] && options === undefined) {
                return origAddEventListener.call(this, type, listener, { passive: true, capture: false });
            }
            return origAddEventListener.call(this, type, listener, options);
        };
    }

    var cwv = {
        assessment: 'Passed',
        LCP: 0,
        CLS: 0,
        INP: 0,
        FCP: 0,
        TTFB: 0
    };
    window.__coreWebVitals = cwv;

    function updateAssessment() {
        var lcpPass = (cwv.LCP <= 2500);
        var clsPass = (cwv.CLS <= 0.1);
        var inpPass = (cwv.INP <= 200);
        cwv.assessment = (lcpPass && clsPass && inpPass) ? 'Passed' : 'Needs Improvement';
    }

    if (typeof window.performance !== 'undefined' && performance.getEntriesByType) {
        var navEntries = performance.getEntriesByType('navigation');
        if (navEntries && navEntries.length) {
            cwv.TTFB = Math.round(navEntries[0].responseStart);
        }
    }

    if (typeof PerformanceObserver !== 'undefined') {
        try {
            new PerformanceObserver(function(list) {
                var entries = list.getEntries();
                for (var i = 0; i < entries.length; i++) {
                    if (entries[i].name === 'first-contentful-paint') {
                        cwv.FCP = Math.round(entries[i].startTime);
                    }
                }
            }).observe({ type: 'paint', buffered: true });
        } catch (e) {}

        try {
            new PerformanceObserver(function(list) {
                var entries = list.getEntries();
                if (entries.length) {
                    cwv.LCP = Math.round(entries[entries.length - 1].startTime);
                    updateAssessment();
                }
            }).observe({ type: 'largest-contentful-paint', buffered: true });
        } catch (e) {}

        try {
            new PerformanceObserver(function(list) {
                var entries = list.getEntries();
                for (var i = 0; i < entries.length; i++) {
                    if (!entries[i].hadRecentInput) {
                        cwv.CLS = Math.round((cwv.CLS + entries[i].value) * 10000) / 10000;
                    }
                }
                updateAssessment();
            }).observe({ type: 'layout-shift', buffered: true });
        } catch (e) {}

        try {
            new PerformanceObserver(function(list) {
                var entries = list.getEntries();
                for (var i = 0; i < entries.length; i++) {
                    if (entries[i].duration > cwv.INP) {
                        cwv.INP = Math.round(entries[i].duration);
                    }
                }
                updateAssessment();
            }).observe({ type: 'event', durationThreshold: 16, buffered: true });
        } catch (e) {}
    }
})();
