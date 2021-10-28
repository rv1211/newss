// var duplicate_windows_status;
// var conn = new WebSocket($('#socket_url').val());
// conn.onopen = function (e) {
//     // console.log("Connection established!");
//     setTimeout(function () {
//         if (globalThis.duplicate_windows_status == true) {
//             var data = {
//                 type: 'user_logged_in',
//                 u_type: $('#user_sock_type').val(),
//                 user: $('#user_sock_id').val(),
//             };
//             send_socket(data);
//         }
//     }, 1000);
// };
// conn.onmessage = function (e) {
//     var data = JSON.parse(e.data);
//     // console.log(e.data);
//     if (typeof data.status != "undefined" && data.status == true) {
//         if (typeof data.data !== 'undefined' && typeof data.data.type !== 'undefined') {
//             switch (data.data.type) {
//                 case 'u_to_u':
//                     if (parseInt(data.data.to) == parseInt($('#user_sock_id').val())) {
//                         desk_noty(data.data.msg, data.data.url);
//                     }
//                     break;
//                 default:

//                     break;
//             }
//         }
//     }
// };
// function send_socket(data) {
//     conn.send(JSON.stringify(data))
// }
// document.addEventListener('DOMContentLoaded', function () {
//     if (!Notification) {
//         alert('Desktop notifications not available in your browser.');
//         return;
//     }
//     if (Notification.permission !== 'granted')
//         Notification.requestPermission();
// });

// function desk_noty(message = "New Notification From Pack & Drop", url = "http://packanddrop.qbisonline.com", logo = "http://packanddrop.qbisonline.com/uploads/logo.png") {
//     if (Notification.permission !== 'granted')
//         Notification.requestPermission();
//     else {
//         var notification = new Notification('Pack & Drop', {
//             icon: logo,
//             body: message,
//         });
//         notification.onclick = function () {
//             window.open(url);
//         };
//     }
// }





// //  Check duplicate Windows is set or not

// (function (win) {
//     //Private variables
//     var _LOCALSTORAGE_KEY = 'WINDOW_VALIDATION';
//     var RECHECK_WINDOW_DELAY_MS = 100;
//     var _initialized = false;
//     var _isMainWindow = false;
//     var _unloaded = false;
//     var _windowArray;
//     var _windowId;
//     var _isNewWindowPromotedToMain = false;
//     var _onWindowUpdated;


//     function WindowStateManager(isNewWindowPromotedToMain, onWindowUpdated) {
//         //this.resetWindows();
//         _onWindowUpdated = onWindowUpdated;
//         _isNewWindowPromotedToMain = isNewWindowPromotedToMain;
//         _windowId = Date.now().toString();

//         bindUnload();

//         determineWindowState.call(this);

//         _initialized = true;

//         _onWindowUpdated.call(this);
//     }

//     //Determine the state of the window 
//     //If its a main or child window
//     function determineWindowState() {
//         var self = this;
//         var _previousState = _isMainWindow;

//         _windowArray = localStorage.getItem(_LOCALSTORAGE_KEY);

//         if (_windowArray === null || _windowArray === "NaN") {
//             _windowArray = [];
//         }
//         else {
//             _windowArray = JSON.parse(_windowArray);
//         }

//         if (_initialized) {
//             //Determine if this window should be promoted
//             if (_windowArray.length <= 1 ||
//                 (_isNewWindowPromotedToMain ? _windowArray[_windowArray.length - 1] : _windowArray[0]) === _windowId) {
//                 _isMainWindow = true;
//             }
//             else {
//                 _isMainWindow = false;
//             }
//         }
//         else {
//             if (_windowArray.length === 0) {
//                 _isMainWindow = true;
//                 _windowArray[0] = _windowId;
//                 localStorage.setItem(_LOCALSTORAGE_KEY, JSON.stringify(_windowArray));
//             }
//             else {
//                 _isMainWindow = false;
//                 _windowArray.push(_windowId);
//                 localStorage.setItem(_LOCALSTORAGE_KEY, JSON.stringify(_windowArray));
//             }
//         }

//         //If the window state has been updated invoke callback
//         if (_previousState !== _isMainWindow) {
//             _onWindowUpdated.call(this);
//         }

//         //Perform a recheck of the window on a delay
//         setTimeout(function () {
//             determineWindowState.call(self);
//         }, RECHECK_WINDOW_DELAY_MS);
//     }

//     //Remove the window from the global count
//     function removeWindow() {
//         var __windowArray = JSON.parse(localStorage.getItem(_LOCALSTORAGE_KEY));
//         for (var i = 0, length = __windowArray.length; i < length; i++) {
//             if (__windowArray[i] === _windowId) {
//                 __windowArray.splice(i, 1);
//                 break;
//             }
//         }
//         //Update the local storage with the new array
//         localStorage.setItem(_LOCALSTORAGE_KEY, JSON.stringify(__windowArray));
//     }

//     //Bind unloading events  
//     function bindUnload() {
//         win.addEventListener('beforeunload', function () {
//             if (!_unloaded) {
//                 removeWindow();
//             }
//         });
//         win.addEventListener('unload', function () {
//             if (!_unloaded) {
//                 removeWindow();
//             }
//         });
//     }

//     WindowStateManager.prototype.isMainWindow = function () {
//         return _isMainWindow;
//     };

//     WindowStateManager.prototype.resetWindows = function () {
//         localStorage.removeItem(_LOCALSTORAGE_KEY);
//     };
//     win.WindowStateManager = WindowStateManager;
// })(window);
// var WindowStateManager = new WindowStateManager(true, windowUpdated);
// function windowUpdated() {
//     if (this.isMainWindow() && globalThis.duplicate_windows_status != false) {
//         globalThis.duplicate_windows_status = true;
//     } else {
//         globalThis.duplicate_windows_status = false;
//     }
// }
// $(window).bind('beforeunload', function () {
//     console.log(globalThis.duplicate_windows_status)
//     if (globalThis.duplicate_windows_status == true) {
//         var data = {
//             type: 'user_logged_out',
//             u_type: $('#user_sock_type').val(),
//             user: $('#user_sock_id').val(),
//         };
//         send_socket(data);
//     }
// });

// //Resets the count in case something goes wrong in code
// //WindowStateManager.resetWindows()
