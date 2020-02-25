var bufferShim = require('buffer-shims');
bufferShim.from('foo');
bufferShim.alloc(9, 'cafeface', 'hex');
var tt = bufferShim.allocUnsafe(15);
bufferShim.allocUnsafeSlow(21);
var buffer = bufferShim.alloc(8);

console.log(buffer);
