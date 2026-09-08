(function() {
    const path = window.location.pathname;
    if (path.includes('.php') || path.includes('/app/') || path.includes('/main/')) {
        window.history.replaceState(null, '', '/');
    }
})();