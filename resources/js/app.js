import './bootstrap';

// Lazy load Splide
const initSplide = async () => {
    const { default: Splide } = await import('@splidejs/splide');
    await import('@splidejs/splide/css');

    // Initialize Splide only when needed
    document.addEventListener('DOMContentLoaded', () => {
        const splideElements = document.querySelectorAll('.splide');
        if (splideElements.length > 0) {
            splideElements.forEach(element => {
                new Splide(element).mount();
            });
        }
    });
};

// Initialize components only when they're in viewport
const initComponents = () => {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                if (entry.target.classList.contains('splide')) {
                    initSplide();
                }
                observer.unobserve(entry.target);
            }
        });
    });

    document.querySelectorAll('.splide').forEach(element => {
        observer.observe(element);
    });
};

// Initialize components when DOM is ready
document.addEventListener('DOMContentLoaded', initComponents);