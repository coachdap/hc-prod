(window.__googlesitekit_webpackJsonp=window.__googlesitekit_webpackJsonp||[]).push([[13],{2:function(t,r){t.exports=googlesitekit.i18n},24:function(t,r,e){"use strict";e.d(r,"a",(function(){return n})),e.d(r,"b",(function(){return a}));var n="_googlesitekitDataLayer",a="data-googlesitekit-gtag"},30:function(t,r,e){"use strict";e.d(r,"a",(function(){return n}));var n=function(t){return t instanceof Date&&!isNaN(t)}},31:function(t,r,e){"use strict";(function(t){e.d(r,"b",(function(){return b})),e.d(r,"d",(function(){return h})),e.d(r,"a",(function(){return y})),e.d(r,"c",(function(){return m}));var n=e(3),a=e.n(n),o=e(10),i=e.n(o);e(23);function c(t,r){var e="undefined"!=typeof Symbol&&t[Symbol.iterator]||t["@@iterator"];if(!e){if(Array.isArray(t)||(e=function(t,r){if(!t)return;if("string"==typeof t)return u(t,r);var e=Object.prototype.toString.call(t).slice(8,-1);"Object"===e&&t.constructor&&(e=t.constructor.name);if("Map"===e||"Set"===e)return Array.from(t);if("Arguments"===e||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(e))return u(t,r)}(t))||r&&t&&"number"==typeof t.length){e&&(t=e);var n=0,a=function(){};return{s:a,n:function(){return n>=t.length?{done:!0}:{done:!1,value:t[n++]}},e:function(t){throw t},f:a}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var o,i=!0,c=!1;return{s:function(){e=e.call(t)},n:function(){var t=e.next();return i=t.done,t},e:function(t){c=!0,o=t},f:function(){try{i||null==e.return||e.return()}finally{if(c)throw o}}}}function u(t,r){(null==r||r>t.length)&&(r=t.length);for(var e=0,n=new Array(r);e<r;e++)n[e]=t[e];return n}var s,l="googlesitekit_".concat("1.41.0","_"),f=["sessionStorage","localStorage"],d=[].concat(f),p=function(){var r=i()(a.a.mark((function r(e){var n,o;return a.a.wrap((function(r){for(;;)switch(r.prev=r.next){case 0:if(n=t[e]){r.next=3;break}return r.abrupt("return",!1);case 3:return r.prev=3,o="__storage_test__",n.setItem(o,o),n.removeItem(o),r.abrupt("return",!0);case 10:return r.prev=10,r.t0=r.catch(3),r.abrupt("return",r.t0 instanceof DOMException&&(22===r.t0.code||1014===r.t0.code||"QuotaExceededError"===r.t0.name||"NS_ERROR_DOM_QUOTA_REACHED"===r.t0.name)&&0!==n.length);case 13:case"end":return r.stop()}}),r,null,[[3,10]])})));return function(t){return r.apply(this,arguments)}}();function v(){return g.apply(this,arguments)}function g(){return(g=i()(a.a.mark((function r(){var e,n,o;return a.a.wrap((function(r){for(;;)switch(r.prev=r.next){case 0:if(void 0===s){r.next=2;break}return r.abrupt("return",s);case 2:e=c(d),r.prev=3,e.s();case 5:if((n=e.n()).done){r.next=15;break}if(o=n.value,!s){r.next=9;break}return r.abrupt("continue",13);case 9:return r.next=11,p(o);case 11:if(!r.sent){r.next=13;break}s=t[o];case 13:r.next=5;break;case 15:r.next=20;break;case 17:r.prev=17,r.t0=r.catch(3),e.e(r.t0);case 20:return r.prev=20,e.f(),r.finish(20);case 23:return void 0===s&&(s=null),r.abrupt("return",s);case 25:case"end":return r.stop()}}),r,null,[[3,17,20,23]])})))).apply(this,arguments)}var b=function(){var t=i()(a.a.mark((function t(r){var e,n,o,i,c,u,s;return a.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,v();case 2:if(!(e=t.sent)){t.next=10;break}if(!(n=e.getItem("".concat(l).concat(r)))){t.next=10;break}if(o=JSON.parse(n),i=o.timestamp,c=o.ttl,u=o.value,s=o.isError,!i||c&&!(Math.round(Date.now()/1e3)-i<c)){t.next=10;break}return t.abrupt("return",{cacheHit:!0,value:u,isError:s});case 10:return t.abrupt("return",{cacheHit:!1,value:void 0});case 11:case"end":return t.stop()}}),t)})));return function(r){return t.apply(this,arguments)}}(),h=function(){var r=i()(a.a.mark((function r(e,n){var o,i,c,u,s,f,d,p,g=arguments;return a.a.wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return o=g.length>2&&void 0!==g[2]?g[2]:{},i=o.ttl,c=void 0===i?3600:i,u=o.timestamp,s=void 0===u?Math.round(Date.now()/1e3):u,f=o.isError,d=void 0!==f&&f,r.next=3,v();case 3:if(!(p=r.sent)){r.next=14;break}return r.prev=5,p.setItem("".concat(l).concat(e),JSON.stringify({timestamp:s,ttl:c,value:n,isError:d})),r.abrupt("return",!0);case 10:return r.prev=10,r.t0=r.catch(5),t.console.warn("Encountered an unexpected storage error:",r.t0),r.abrupt("return",!1);case 14:return r.abrupt("return",!1);case 15:case"end":return r.stop()}}),r,null,[[5,10]])})));return function(t,e){return r.apply(this,arguments)}}(),y=function(){var r=i()(a.a.mark((function r(e){var n;return a.a.wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return r.next=2,v();case 2:if(!(n=r.sent)){r.next=13;break}return r.prev=4,n.removeItem("".concat(l).concat(e)),r.abrupt("return",!0);case 9:return r.prev=9,r.t0=r.catch(4),t.console.warn("Encountered an unexpected storage error:",r.t0),r.abrupt("return",!1);case 13:return r.abrupt("return",!1);case 14:case"end":return r.stop()}}),r,null,[[4,9]])})));return function(t){return r.apply(this,arguments)}}(),m=function(){var r=i()(a.a.mark((function r(){var e,n,o,i;return a.a.wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return r.next=2,v();case 2:if(!(e=r.sent)){r.next=14;break}for(r.prev=4,n=[],o=0;o<e.length;o++)0===(i=e.key(o)).indexOf(l)&&n.push(i.substring(l.length));return r.abrupt("return",n);case 10:return r.prev=10,r.t0=r.catch(4),t.console.warn("Encountered an unexpected storage error:",r.t0),r.abrupt("return",[]);case 14:return r.abrupt("return",[]);case 15:case"end":return r.stop()}}),r,null,[[4,10]])})));return function(){return r.apply(this,arguments)}}()}).call(this,e(18))},32:function(t,r,e){"use strict";(function(t){e.d(r,"a",(function(){return p})),e.d(r,"b",(function(){return d}));var n=e(74),a=t._googlesitekitBaseData||{},o=a.isFirstAdmin,i=a.trackingAllowed,c={isFirstAdmin:o,trackingEnabled:a.trackingEnabled,trackingID:a.trackingID,referenceSiteURL:a.referenceSiteURL,userIDHash:a.userIDHash},u=Object(n.a)(c),s=u.enableTracking,l=u.disableTracking,f=u.isTrackingEnabled,d=u.trackEvent;function p(t){t?s():l()}!0===i&&p(f())}).call(this,e(18))},33:function(t,r,e){"use strict";(function(t){var n,a;e.d(r,"a",(function(){return o})),e.d(r,"b",(function(){return i}));var o=new Set((null===(n=t)||void 0===n||null===(a=n._googlesitekitBaseData)||void 0===a?void 0:a.enabledFeatures)||[]),i=function(t){var r=arguments.length>1&&void 0!==arguments[1]?arguments[1]:o;return r instanceof Set&&r.has(t)}}).call(this,e(18))},37:function(t,r,e){"use strict";e.d(r,"a",(function(){return a}));var n=e(30),a=function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"",r="string"==typeof t;if(!r)return!1;var e=t.split("-");return 3===e.length&&Object(n.a)(new Date(t))}},42:function(t,r,e){"use strict";e.d(r,"a",(function(){return a}));var n=e(24);function a(t){return function(){t[n.a]=t[n.a]||[],t[n.a].push(arguments)}}},46:function(t,r,e){"use strict";e.d(r,"a",(function(){return a}));var n=e(1),a=function(t){return function(r){return function FilteredComponent(e){return Object(n.createElement)(n.Fragment,{},"",Object(n.createElement)(r,e),t)}}}},47:function(t,r,e){"use strict";e.d(r,"a",(function(){return g})),e.d(r,"b",(function(){return b}));var n=e(6),a=e.n(n),o=e(26),i=e.n(o),c=e(7),u=e.n(c),s=e(65),l=e.n(s),f=e(9);function d(t,r){var e=Object.keys(t);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(t);r&&(n=n.filter((function(r){return Object.getOwnPropertyDescriptor(t,r).enumerable}))),e.push.apply(e,n)}return e}function p(t){for(var r=1;r<arguments.length;r++){var e=null!=arguments[r]?arguments[r]:{};r%2?d(Object(e),!0).forEach((function(r){a()(t,r,e[r])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(e)):d(Object(e)).forEach((function(r){Object.defineProperty(t,r,Object.getOwnPropertyDescriptor(e,r))}))}return t}function v(t,r){if(r&&Array.isArray(r)){var e=r.map((function(t){return"object"===i()(t)?Object(f.s)(t):t}));return"".concat(t,"::").concat(l()(JSON.stringify(e)))}return t}var g={receiveError:function(t,r,e){return u()(t,"error is required."),r&&u()(e&&Array.isArray(e),"args is required (and must be an array) when baseName is specified."),{type:"RECEIVE_ERROR",payload:{error:t,baseName:r,args:e}}},clearError:function(t,r){return t&&u()(r&&Array.isArray(r),"args is required (and must be an array) when baseName is specified."),{type:"CLEAR_ERROR",payload:{baseName:t,args:r}}},clearErrors:function(t){return{type:"CLEAR_ERRORS",payload:{baseName:t}}}};function b(){var t={getErrorForSelector:function(r,e){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:[];return u()(e,"selectorName is required."),t.getError(r,e,n)},getErrorForAction:function(r,e){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:[];return u()(e,"actionName is required."),t.getError(r,e,n)},getError:function(t,r,e){var n=t.error,a=t.errors;return r||e?(u()(r,"baseName is required."),a[v(r,e)]):n},getErrors:function(t){var r=new Set(Object.values(t.errors));return void 0!==t.error&&r.add(t.error),Array.from(r)},hasErrors:function(r){return t.getErrors(r).length>0}};return{initialState:{errors:{},error:void 0},actions:g,controls:{},reducer:function(t,r){var e=r.type,n=r.payload;switch(e){case"RECEIVE_ERROR":var o=n.baseName,i=n.args,c=n.error;return p(p({},t),{},o?{errors:p(p({},t.errors||{}),{},a()({},v(o,i),c))}:{error:c});case"CLEAR_ERROR":var u=n.baseName,s=n.args,l=p({},t);if(u){var f=v(u,s);l.errors=p({},t.errors||{}),delete l.errors[f]}else l.error=void 0;return l;case"CLEAR_ERRORS":var d=n.baseName,g=p({},t);if(d)for(var b in g.errors=p({},t.errors||{}),g.errors)(b===d||b.startsWith("".concat(d,"::")))&&delete g.errors[b];else g.errors={},g.error=void 0;return g;default:return t}},resolvers:{},selectors:t}}},48:function(t,r,e){"use strict";e.d(r,"a",(function(){return a})),e.d(r,"b",(function(){return n})),e.d(r,"e",(function(){return u})),e.d(r,"f",(function(){return p})),e.d(r,"g",(function(){return v})),e.d(r,"h",(function(){return f.a})),e.d(r,"d",(function(){return g})),e.d(r,"c",(function(){return h})),e.d(r,"i",(function(){return d}));var n="Invalid dateString parameter, it must be a string.",a='Invalid date range, it must be a string with the format "last-x-days".',o=e(7),i=e.n(o),c=e(30),u=function(t){var r=new Date(t);i()(Object(c.a)(r),"Date param must construct to a valid date instance or be a valid date instance itself.");var e="".concat(r.getMonth()+1),n="".concat(r.getDate());return[r.getFullYear(),e.length<2?"0".concat(e):e,n.length<2?"0".concat(n):n].join("-")},s=e(12),l=e.n(s),f=e(37),d=function(t){i()(Object(f.a)(t),n);var r=t.split("-"),e=l()(r,3),a=e[0],o=e[1],c=e[2];return new Date(a,o-1,c)},p=function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"",r=arguments.length>1?arguments[1]:void 0,e=d(t);return e.setDate(e.getDate()-r),u(e)},v=function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"",r=t.split("-");return 3===r.length&&"last"===r[0]&&!Number.isNaN(r[1])&&!Number.isNaN(parseFloat(r[1]))&&"days"===r[2]};function g(t){var r=t.match(/last-(\d+)-days/);if(r&&r[1])return parseInt(r[1],10);throw new Error("Unrecognized date range slug.")}var b=e(2);function h(){var t=function(t){return Object(b.sprintf)(
/* translators: %s: number of days */
Object(b._n)("Last %s day","Last %s days",t,"google-site-kit"),t)};return{"last-7-days":{slug:"last-7-days",label:t(7),days:7},"last-14-days":{slug:"last-14-days",label:t(14),days:14},"last-28-days":{slug:"last-28-days",label:t(28),days:28},"last-90-days":{slug:"last-90-days",label:t(90),days:90}}}},5:function(t,r){t.exports=googlesitekit.data},52:function(t,r,e){"use strict";e.d(r,"a",(function(){return i})),e.d(r,"b",(function(){return c}));var n=e(26),a=e.n(n),o=e(77),i=function(t){var r=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};return{__html:o.a.sanitize(t,r)}};function c(t){var r,e="object"===a()(t)?t.toString():t;return null==e||null===(r=e.replace)||void 0===r?void 0:r.call(e,/\/+$/,"")}},53:function(t,r,e){"use strict";(function(t){var n=e(0),a=e.n(n),o=e(8),i=e.n(o);function ChangeArrow(r){var e=r.direction,n=r.invertColor,a=r.width,o=r.height;return t.createElement("svg",{className:i()("googlesitekit-change-arrow","googlesitekit-change-arrow--".concat(e),{"googlesitekit-change-arrow--inverted-color":n}),width:a,height:o,viewBox:"0 0 10 10",fill:"none",xmlns:"http://www.w3.org/2000/svg"},t.createElement("path",{d:"M5.625 10L5.625 2.375L9.125 5.875L10 5L5 -1.76555e-07L-2.7055e-07 5L0.875 5.875L4.375 2.375L4.375 10L5.625 10Z",fill:"currentColor"}))}ChangeArrow.propTypes={direction:a.a.string,invertColor:a.a.bool,width:a.a.number,height:a.a.number},ChangeArrow.defaultProps={direction:"up",invertColor:!1,width:9,height:9},r.a=ChangeArrow}).call(this,e(1))},58:function(t,r,e){"use strict";e.d(r,"a",(function(){return n}));var n="core/ui"},61:function(t,r,e){"use strict";function n(t){try{return new URL(t).pathname}catch(t){}return null}function a(t,r){try{return new URL(r,t).href}catch(t){}return("string"==typeof t?t:"")+("string"==typeof r?r:"")}function o(t){return"string"!=typeof t?t:t.replace(/^https?:\/\/(www\.)?/i,"").replace(/\/$/,"")}e.d(r,"b",(function(){return n})),e.d(r,"a",(function(){return a})),e.d(r,"c",(function(){return o}))},63:function(t,r,e){"use strict";(function(t){e.d(r,"c",(function(){return w})),e.d(r,"d",(function(){return E})),e.d(r,"b",(function(){return S})),e.d(r,"a",(function(){return k}));var n=e(12),a=e.n(n),o=e(26),i=e.n(o),c=e(6),u=e.n(c),s=e(16),l=e.n(s),f=e(22),d=e(54),p=e.n(d),v=e(2);function g(t,r){var e=Object.keys(t);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(t);r&&(n=n.filter((function(r){return Object.getOwnPropertyDescriptor(t,r).enumerable}))),e.push.apply(e,n)}return e}function b(t){for(var r=1;r<arguments.length;r++){var e=null!=arguments[r]?arguments[r]:{};r%2?g(Object(e),!0).forEach((function(r){u()(t,r,e[r])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(e)):g(Object(e)).forEach((function(r){Object.defineProperty(t,r,Object.getOwnPropertyDescriptor(e,r))}))}return t}var h=function(t){var r=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},e=y(t,r),n=e.formatUnit,a=e.formatDecimal;try{return n()}catch(t){return a()}},y=function(t){var r=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};t=parseInt(t,10),Number.isNaN(t)&&(t=0);var e=Math.floor(t/60/60),n=Math.floor(t/60%60),a=Math.floor(t%60);return{hours:e,minutes:n,seconds:a,formatUnit:function(){var o=r.unitDisplay,i=b(b({unitDisplay:void 0===o?"short":o},l()(r,["unitDisplay"])),{},{style:"unit"});return 0===t?E(a,b(b({},i),{},{unit:"second"})):Object(v.sprintf)(
/* translators: 1: formatted seconds, 2: formatted minutes, 3: formatted hours */
Object(v._x)("%3$s %2$s %1$s","duration of time: hh mm ss","google-site-kit"),a?E(a,b(b({},i),{},{unit:"second"})):"",n?E(n,b(b({},i),{},{unit:"minute"})):"",e?E(e,b(b({},i),{},{unit:"hour"})):"").trim()},formatDecimal:function(){var r=Object(v.sprintf)(// translators: %s number of seconds with "s" as the abbreviated unit.
Object(v.__)("%ds","google-site-kit"),a);if(0===t)return r;var o=Object(v.sprintf)(// translators: %s number of minutes with "m" as the abbreviated unit.
Object(v.__)("%dm","google-site-kit"),n),i=Object(v.sprintf)(// translators: %s number of hours with "h" as the abbreviated unit.
Object(v.__)("%dh","google-site-kit"),e);return Object(v.sprintf)(
/* translators: 1: formatted seconds, 2: formatted minutes, 3: formatted hours */
Object(v._x)("%3$s %2$s %1$s","duration of time: hh mm ss","google-site-kit"),a?r:"",n?o:"",e?i:"").trim()}}},m=function(t){return 1e6<=t?Math.round(t/1e5)/10:1e4<=t?Math.round(t/1e3):1e3<=t?Math.round(t/100)/10:t},O=function(t){var r={minimumFractionDigits:1,maximumFractionDigits:1};return 1e6<=t?Object(v.sprintf)(// translators: %s: an abbreviated number in millions.
Object(v.__)("%sM","google-site-kit"),E(m(t),t%10==0?{}:r)):1e4<=t?Object(v.sprintf)(// translators: %s: an abbreviated number in thousands.
Object(v.__)("%sK","google-site-kit"),E(m(t))):1e3<=t?Object(v.sprintf)(// translators: %s: an abbreviated number in thousands.
Object(v.__)("%sK","google-site-kit"),E(m(t),t%10==0?{}:r)):E(t,{signDisplay:"never",maximumFractionDigits:1})},w=function(t){var r=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};t=Object(f.isFinite)(t)?t:Number(t),Object(f.isFinite)(t)||(console.warn("Invalid number",t,i()(t)),t=0);var e={};if("%"===r)e={style:"percent",maximumFractionDigits:2};else{if("s"===r)return h(t,{unitDisplay:"narrow"});r&&"string"==typeof r?e={style:"currency",currency:r}:Object(f.isPlainObject)(r)&&(e=b({},r))}var n=e,a=n.style,o=void 0===a?"metric":a;return"metric"===o?O(t):"duration"===o?h(t,r):E(t,e)},j=p()(console.warn),E=function(t){var r=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},e=r.locale,n=void 0===e?k():e,o=l()(r,["locale"]);try{return new Intl.NumberFormat(n,o).format(t)}catch(r){j("Site Kit numberFormat error: Intl.NumberFormat( ".concat(JSON.stringify(n),", ").concat(JSON.stringify(o)," ).format( ").concat(i()(t)," )"),r.message)}for(var c={currencyDisplay:"narrow",currencySign:"accounting",style:"unit"},u=["signDisplay","compactDisplay"],s={},f=0,d=Object.entries(o);f<d.length;f++){var p=a()(d[f],2),v=p[0],g=p[1];c[v]&&g===c[v]||(u.includes(v)||(s[v]=g))}try{return new Intl.NumberFormat(n,s).format(t)}catch(r){return new Intl.NumberFormat(n).format(t)}},S=function(t){var r=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},e=r.locale,n=void 0===e?k():e,a=r.style,o=void 0===a?"long":a,i=r.type,c=void 0===i?"conjunction":i;if(Intl.ListFormat){var u=new Intl.ListFormat(n,{style:o,type:c});return u.format(t)}
/* translators: used between list items, there is a space after the comma. */var s=Object(v.__)(", ","google-site-kit");return t.join(s)},k=function(){var r=arguments.length>0&&void 0!==arguments[0]?arguments[0]:t,e=Object(f.get)(r,["_googlesitekitLegacyData","locale"]);if(e){var n=e.match(/^(\w{2})?(_)?(\w{2})/);if(n&&n[0])return n[0].replace(/_/g,"-")}return r.navigator.language}}).call(this,e(18))},67:function(t,r,e){"use strict";(function(t){e.d(r,"a",(function(){return u})),e.d(r,"b",(function(){return s})),e.d(r,"c",(function(){return f}));var n=e(12),a=e.n(n),o=e(2);function i(t,r){var e="undefined"!=typeof Symbol&&t[Symbol.iterator]||t["@@iterator"];if(!e){if(Array.isArray(t)||(e=function(t,r){if(!t)return;if("string"==typeof t)return c(t,r);var e=Object.prototype.toString.call(t).slice(8,-1);"Object"===e&&t.constructor&&(e=t.constructor.name);if("Map"===e||"Set"===e)return Array.from(t);if("Arguments"===e||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(e))return c(t,r)}(t))||r&&t&&"number"==typeof t.length){e&&(t=e);var n=0,a=function(){};return{s:a,n:function(){return n>=t.length?{done:!0}:{done:!1,value:t[n++]}},e:function(t){throw t},f:a}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var o,i=!0,u=!1;return{s:function(){e=e.call(t)},n:function(){var t=e.next();return i=t.done,t},e:function(t){u=!0,o=t},f:function(){try{i||null==e.return||e.return()}finally{if(u)throw o}}}}function c(t,r){(null==r||r>t.length)&&(r=t.length);for(var e=0,n=new Array(r);e<r;e++)n[e]=t[e];return n}var u=function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:0,r=null,e=null,n=document.querySelector("#toplevel_page_googlesitekit-dashboard .googlesitekit-notifications-counter"),a=document.querySelector("#wp-admin-bar-google-site-kit .googlesitekit-notifications-counter");if(n&&a)return!1;if(r=document.querySelector("#toplevel_page_googlesitekit-dashboard .wp-menu-name"),e=document.querySelector("#wp-admin-bar-google-site-kit .ab-item"),null===r&&null===e)return!1;var i=document.createElement("span");i.setAttribute("class","googlesitekit-notifications-counter update-plugins count-".concat(t));var c=document.createElement("span");c.setAttribute("class","plugin-count"),c.setAttribute("aria-hidden","true"),c.textContent=t;var u=document.createElement("span");return u.setAttribute("class","screen-reader-text"),u.textContent=Object(o.sprintf)(
/* translators: %d is the number of notifications */
Object(o._n)("%d notification","%d notifications",t,"google-site-kit"),t),i.appendChild(c),i.appendChild(u),r&&null===n&&r.appendChild(i),e&&null===a&&e.appendChild(i),i},s=function(){t.localStorage&&t.localStorage.clear(),t.sessionStorage&&t.sessionStorage.clear()},l=function(t){for(var r=location.search.substr(1).split("&"),e={},n=0;n<r.length;n++)e[r[n].split("=")[0]]=decodeURIComponent(r[n].split("=")[1]);return t?e.hasOwnProperty(t)?decodeURIComponent(e[t].replace(/\+/g," ")):"":e},f=function(t){var r=arguments.length>1&&void 0!==arguments[1]?arguments[1]:location,e=new URL(r.href);if(t)return e.searchParams&&e.searchParams.get?e.searchParams.get(t):l(t);var n,o={},c=i(e.searchParams.entries());try{for(c.s();!(n=c.n()).done;){var u=a()(n.value,2),s=u[0],f=u[1];o[s]=f}}catch(t){c.e(t)}finally{c.f()}return o}}).call(this,e(18))},72:function(t,r,e){"use strict";(function(t){e(38),e(39)}).call(this,e(18))},73:function(t,r,e){"use strict";(function(t){e.d(r,"a",(function(){return o})),e.d(r,"b",(function(){return i}));var n=e(180),a=e(53),o=function(r){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};if(Number.isNaN(Number(r)))return"";var o=e.invertColor,i=void 0!==o&&o;return Object(n.a)(t.createElement(a.a,{direction:r>0?"up":"down",invertColor:i}))},i=function(t){var r,e,n,a,o,i,c,u,s,l,f,d,p,v,g;if(void 0!==t)return 1===(null==t||null===(r=t[0])||void 0===r||null===(e=r.data)||void 0===e||null===(n=e.rows)||void 0===n?void 0:n.length)||(null==t||null===(a=t[0])||void 0===a||null===(o=a.data)||void 0===o||null===(i=o.rows)||void 0===i||null===(c=i[0])||void 0===c||null===(u=c.metrics)||void 0===u||null===(s=u[0])||void 0===s||null===(l=s.values)||void 0===l?void 0:l[0])===(null==t||null===(f=t[0])||void 0===f||null===(d=f.data)||void 0===d||null===(p=d.totals)||void 0===p||null===(v=p[0])||void 0===v||null===(g=v.values)||void 0===g?void 0:g[0])}}).call(this,e(1))},74:function(t,r,e){"use strict";(function(t){e.d(r,"a",(function(){return l}));var n=e(6),a=e.n(n),o=e(75),i=e(76);function c(t,r){var e=Object.keys(t);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(t);r&&(n=n.filter((function(r){return Object.getOwnPropertyDescriptor(t,r).enumerable}))),e.push.apply(e,n)}return e}function u(t){for(var r=1;r<arguments.length;r++){var e=null!=arguments[r]?arguments[r]:{};r%2?c(Object(e),!0).forEach((function(r){a()(t,r,e[r])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(e)):c(Object(e)).forEach((function(r){Object.defineProperty(t,r,Object.getOwnPropertyDescriptor(e,r))}))}return t}var s={isFirstAdmin:!1,trackingEnabled:!1,trackingID:"",referenceSiteURL:"",userIDHash:""};function l(r){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:t,n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:t,a=u(u({},s),r);return a.referenceSiteURL&&(a.referenceSiteURL=a.referenceSiteURL.toString().replace(/\/+$/,"")),{enableTracking:Object(o.a)(a,e),disableTracking:function(){a.trackingEnabled=!1},isTrackingEnabled:function(){return!!a.trackingEnabled},trackEvent:Object(i.a)(a,e,n)}}}).call(this,e(18))},75:function(t,r,e){"use strict";(function(t){e.d(r,"a",(function(){return o}));var n=e(42),a=e(24);function o(r,e){var o=Object(n.a)(e);return function(){r.trackingEnabled=!0;var e=t.document;if(!e.querySelector("script[".concat(a.b,"]"))){var n=e.createElement("script");n.setAttribute(a.b,""),n.async=!0,n.src="https://www.googletagmanager.com/gtag/js?id=".concat(r.trackingID,"&l=").concat(a.a),e.head.appendChild(n),o("js",new Date),o("config",r.trackingID)}}}}).call(this,e(18))},76:function(t,r,e){"use strict";(function(t){e.d(r,"a",(function(){return p}));var n=e(3),a=e.n(n),o=e(6),i=e.n(o),c=e(10),u=e.n(c),s=e(42),l=e(33);function f(t,r){var e=Object.keys(t);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(t);r&&(n=n.filter((function(r){return Object.getOwnPropertyDescriptor(t,r).enumerable}))),e.push.apply(e,n)}return e}function d(t){for(var r=1;r<arguments.length;r++){var e=null!=arguments[r]?arguments[r]:{};r%2?f(Object(e),!0).forEach((function(r){i()(t,r,e[r])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(e)):f(Object(e)).forEach((function(r){Object.defineProperty(t,r,Object.getOwnPropertyDescriptor(e,r))}))}return t}function p(r,e,n){var o=Object(s.a)(e);return function(){var e=u()(a.a.mark((function e(i,c,u,s){var f,p,v,g,b,h,y,m;return a.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if(v=r.isFirstAdmin,g=r.referenceSiteURL,b=r.trackingEnabled,h=r.trackingID,y=r.userIDHash,!(null===(f=n._gaUserPrefs)||void 0===f||null===(p=f.ioo)||void 0===p?void 0:p.call(f))){e.next=3;break}return e.abrupt("return");case 3:if(b){e.next=5;break}return e.abrupt("return");case 5:return m={send_to:h,event_category:i,event_label:u,value:s,dimension1:g,dimension2:v?"true":"false",dimension3:y,dimension4:"1.41.0",dimension5:Array.from(l.a).join(", ")},e.abrupt("return",new Promise((function(r){var e=setTimeout((function(){t.console.warn('Tracking event "'.concat(c,'" (category "').concat(i,'") took too long to fire.')),r()}),1e3);o("event",c,d(d({},m),{},{event_callback:function(){clearTimeout(e),r()}}))})));case 7:case"end":return e.stop()}}),e)})));return function(t,r,n,a){return e.apply(this,arguments)}}()}}).call(this,e(18))},77:function(t,r,e){"use strict";(function(t){e.d(r,"a",(function(){return a}));var n=e(100),a=e.n(n)()(t)}).call(this,e(18))},83:function(t,r,e){"use strict";e.d(r,"a",(function(){return g})),e.d(r,"c",(function(){return h})),e.d(r,"b",(function(){return y}));var n=e(16),a=e.n(n),o=e(6),i=e.n(o),c=e(3),u=e.n(c),s=e(7),l=e.n(s),f=e(5),d=e.n(f),p=e(31),v=d.a.createRegistryControl,g=function(t){var r;l()(t,"storeName is required to create a snapshot store.");var e={},n={deleteSnapshot:u.a.mark((function t(){var r;return u.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,{payload:{},type:"DELETE_SNAPSHOT"};case 2:return r=t.sent,t.abrupt("return",r);case 4:case"end":return t.stop()}}),t)})),restoreSnapshot:u.a.mark((function t(){var r,e,n,a,o,i,c=arguments;return u.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return r=c.length>0&&void 0!==c[0]?c[0]:{},e=r.clearAfterRestore,n=void 0===e||e,t.next=4,{payload:{},type:"RESTORE_SNAPSHOT"};case 4:if(a=t.sent,o=a.cacheHit,i=a.value,!o){t.next=13;break}return t.next=10,{payload:{snapshot:i},type:"SET_STATE_FROM_SNAPSHOT"};case 10:if(!n){t.next=13;break}return t.next=13,{payload:{},type:"DELETE_SNAPSHOT"};case 13:return t.abrupt("return",o);case 14:case"end":return t.stop()}}),t)})),createSnapshot:u.a.mark((function t(){var r;return u.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,{payload:{},type:"CREATE_SNAPSHOT"};case 2:return r=t.sent,t.abrupt("return",r);case 4:case"end":return t.stop()}}),t)}))},o=(r={},i()(r,"DELETE_SNAPSHOT",(function(){return Object(p.a)("datastore::cache::".concat(t))})),i()(r,"CREATE_SNAPSHOT",v((function(r){return function(){return Object(p.d)("datastore::cache::".concat(t),r.stores[t].store.getState())}}))),i()(r,"RESTORE_SNAPSHOT",(function(){return Object(p.b)("datastore::cache::".concat(t),3600)})),r);return{initialState:e,actions:n,controls:o,reducer:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:e,r=arguments.length>1?arguments[1]:void 0,n=r.type,o=r.payload;switch(n){case"SET_STATE_FROM_SNAPSHOT":var i=o.snapshot,c=(i.error,a()(i,["error"]));return c;default:return t}}}},b=function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:d.a;return Object.values(t.stores).filter((function(t){return Object.keys(t.getActions()).includes("restoreSnapshot")}))},h=function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:d.a;return Promise.all(b(t).map((function(t){return t.getActions().createSnapshot()})))},y=function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:d.a;return Promise.all(b(t).map((function(t){return t.getActions().restoreSnapshot()})))}},9:function(t,r,e){"use strict";e.d(r,"t",(function(){return c.b})),e.d(r,"q",(function(){return u.a})),e.d(r,"u",(function(){return u.b})),e.d(r,"s",(function(){return p})),e.d(r,"b",(function(){return v.b})),e.d(r,"h",(function(){return v.c})),e.d(r,"o",(function(){return g.c})),e.d(r,"p",(function(){return g.d})),e.d(r,"l",(function(){return g.b})),e.d(r,"g",(function(){return g.a})),e.d(r,"m",(function(){return m})),e.d(r,"c",(function(){return O})),e.d(r,"r",(function(){return w.i})),e.d(r,"e",(function(){return j.a})),e.d(r,"k",(function(){return j.b})),e.d(r,"j",(function(){return E.b})),e.d(r,"f",(function(){return E.a})),e.d(r,"n",(function(){return E.c})),e.d(r,"i",(function(){return S})),e.d(r,"a",(function(){return k})),e.d(r,"v",(function(){return _})),e.d(r,"d",(function(){return D}));var n=e(99),a=e.n(n),o=e(97),i=e.n(o),c=e(32),u=e(52),s=e(26),l=e.n(s),f=e(65),d=e.n(f),p=function(t){return d()(JSON.stringify(function t(r){var e={};return Object.keys(r).sort().forEach((function(n){var a=r[n];a&&"object"===l()(a)&&!Array.isArray(a)&&(a=t(a)),e[n]=a})),e}(t)))};var v=e(67),g=(e(72),e(63));e(46);function b(t){return t.replace(/\[([^\]]+)\]\((https?:\/\/[^\/]+\.\w+\/?.*?)\)/gi,'<a href="$2" target="_blank" rel="noopener noreferrer">$1</a>')}function h(t){return"<p>".concat(t.replace(/\n{2,}/g,"</p><p>"),"</p>")}function y(t){return t.replace(/\n/gi,"<br>")}function m(t){for(var r=t,e=0,n=[b,h,y];e<n.length;e++){r=(0,n[e])(r)}return r}var O=function(t){return t=parseFloat(t),isNaN(t)||0===t?[0,0,0,0]:[Math.floor(t/60/60),Math.floor(t/60%60),Math.floor(t%60),Math.floor(1e3*t)-1e3*Math.floor(t)]},w=e(48),j=e(73),E=e(61),S=function(t){switch(t){case"minute":return 60;case"hour":return 3600;case"day":return 86400;case"week":return 604800;case"month":return 2592e3;case"year":return 31536e3}},k=function(t,r){if("0"===t||0===t||isNaN(t))return null;var e=(r-t)/t;return isNaN(e)||!a()(e)?null:e},_=function(t){try{return JSON.parse(t)&&!!t}catch(t){return!1}},D=function(t){if(!t)return"";var r=t.replace(/&#(\d+);/g,(function(t,r){return String.fromCharCode(r)})).replace(/(\\)/g,"");return i()(r)}},995:function(t,r,e){"use strict";e.r(r);var n=e(5),a=e.n(n),o=e(47),i=e(83),c=e(6),u=e.n(c),s=e(7),l=e.n(s),f=e(49),d=e.n(f);function p(t,r){var e=Object.keys(t);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(t);r&&(n=n.filter((function(r){return Object.getOwnPropertyDescriptor(t,r).enumerable}))),e.push.apply(e,n)}return e}function v(t){for(var r=1;r<arguments.length;r++){var e=null!=arguments[r]?arguments[r]:{};r%2?p(Object(e),!0).forEach((function(r){u()(t,r,e[r])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(e)):p(Object(e)).forEach((function(r){Object.defineProperty(t,r,Object.getOwnPropertyDescriptor(e,r))}))}return t}var g={initialState:{},actions:{setValues:function(t){return l()(d()(t),"values must be an object."),{payload:{values:t},type:"SET_VALUES"}},setValue:function(t,r){return l()(t,"key is required."),{payload:{key:t,value:r},type:"SET_VALUE"}}},controls:{},reducer:function(t,r){var e=r.type,n=r.payload;switch(e){case"SET_VALUES":var a=n.values;return v(v({},t),a);case"SET_VALUE":var o=n.key,i=n.value;return v(v({},t),{},u()({},o,i));default:return t}},resolvers:{},selectors:{getValue:function(t,r){return t[r]}}},b=e(58),h=a.a.combineStores(a.a.commonStore,g,Object(i.a)(b.a),Object(o.b)());h.initialState,h.actions,h.controls,h.reducer,h.resolvers,h.selectors;a.a.registerStore(b.a,h)}},[[995,1,0]]]);