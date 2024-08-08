const LoadingIndicator = {
    show: function(element) {
        if (element) {
            element.classList.remove('d-none');
        }
    },
    hide: function(element) {
        if (element) {
            element.classList.add('d-none');
        }
    },
    toggleButton: function(button, disable = true) {
        if (button) {
            button.disabled = disable;
        }
    }
};