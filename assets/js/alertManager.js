const AlertManager = {
    show: function(type, message, duration = 5000) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-4 mt-md-5" role="alert" style="z-index: 9999;">
                <strong>${type.charAt(0).toUpperCase() + type.slice(1)}:</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;

        // Tambahkan alert ke dalam container
        const alertContainer = document.getElementById('alert-container');
        if (!alertContainer) {
            console.error('Alert container not found');
            return;
        }
        alertContainer.innerHTML = alertHtml;

        // Hilangkan alert setelah durasi tertentu
        setTimeout(() => {
            const alertElement = alertContainer.querySelector('.alert');
            if (alertElement) {
                alertElement.classList.remove('show');
                setTimeout(() => alertElement.remove(), 150);
            }
        }, duration);
    },

    success: function(message, duration) {
        this.show('success', message, duration);
    },

    error: function(message, duration) {
        this.show('error', message, duration);
    },

    warning: function(message, duration) {
        this.show('warning', message, duration);
    },

    info: function(message, duration) {
        this.show('info', message, duration);
    }
};