const AlertManager = {
    alertTypes: {
        'success': { class: 'alert-success', icon: 'check-circle-fill' },
        'error': { class: 'alert-danger', icon: 'exclamation-triangle-fill' },
        'warning': { class: 'alert-warning', icon: 'exclamation-circle-fill' },
        'info': { class: 'alert-info', icon: 'info-circle-fill' }
    },

    show: function(type, message, duration = 5000) {
        const alertSettings = this.alertTypes[type] || this.alertTypes['info'];
        const alertHtml = `
            <div class="alert ${alertSettings.class} alert-dismissible fade show d-flex align-items-center position-fixed top-0 start-0 end-0 mt-4 mt-md-5 mx-2 mx-md-auto" role="alert" style="z-index: 9999; max-width: 100%;">
                <div class="container-fluid px-0">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="${type}:">
                                <use xlink:href="#${alertSettings.icon}" />
                            </svg>
                        </div>
                        <div class="col">
                            <strong>${type.charAt(0).toUpperCase() + type.slice(1)}:</strong> ${message}
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
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

// Tambahkan SVG icons ke dalam body
document.body.insertAdjacentHTML('beforeend', `
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
        </symbol>
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </symbol>
        <symbol id="exclamation-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
        </symbol>
        <symbol id="info-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
        </symbol>
    </svg>
`);

// Tambahkan CSS untuk mobile
const style = document.createElement('style');
style.textContent = `
    @media (max-width: 767.98px) {
        .alert {
            left: 0 !important;
            right: 0 !important;
            transform: none !important;
            width: 100% !important;
            max-width: none !important;
            border-radius: 0 !important;
        }
    }
`;
document.head.appendChild(style);