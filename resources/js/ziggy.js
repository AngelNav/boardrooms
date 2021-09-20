const Ziggy = {"url":"http:\/\/boardrooms.test","port":null,"defaults":{},"routes":{"login":{"uri":"login","methods":["GET","HEAD"]},"logout":{"uri":"logout","methods":["POST"]},"register":{"uri":"register","methods":["GET","HEAD"]},"password.request":{"uri":"password\/reset","methods":["GET","HEAD"]},"password.email":{"uri":"password\/email","methods":["POST"]},"password.reset":{"uri":"password\/reset\/{token}","methods":["GET","HEAD"]},"password.update":{"uri":"password\/reset","methods":["POST"]},"password.confirm":{"uri":"password\/confirm","methods":["GET","HEAD"]},"home":{"uri":"home","methods":["GET","HEAD"]},"boardrooms.index":{"uri":"boardrooms","methods":["GET","HEAD"]},"boardrooms.store":{"uri":"boardrooms","methods":["POST"]},"boardrooms.show":{"uri":"boardrooms\/{boardroom}","methods":["GET","HEAD"],"bindings":{"boardroom":"id"}},"boardrooms.update":{"uri":"boardrooms\/{boardroom}","methods":["PUT","PATCH"],"bindings":{"boardroom":"id"}},"boardrooms.destroy":{"uri":"boardrooms\/{boardroom}","methods":["DELETE"],"bindings":{"boardroom":"id"}}}};

if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}

export { Ziggy };
