// Image optimization utilities
export const optimizeImage = (src, options = {}) => {
    const {
        width = 'auto',
        quality = 80,
        format = 'webp',
        loading = 'lazy'
    } = options;

    const img = new Image();
    img.src = src;
    img.loading = loading;
    img.decoding = 'async';

    // Add width if specified
    if (width !== 'auto') {
        img.width = width;
    }

    // Add loading animation class
    img.classList.add('image-loading');

    // Handle loading states
    img.onload = () => {
        img.classList.remove('image-loading');
        img.classList.add('image-loaded');
    };

    return img;
};

// Convert image to WebP format
export const convertToWebP = async (file) => {
    return new Promise((resolve) => {
        const reader = new FileReader();
        reader.onload = (e) => {
            const img = new Image();
            img.onload = () => {
                const canvas = document.createElement('canvas');
                canvas.width = img.width;
                canvas.height = img.height;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0);
                canvas.toBlob((blob) => {
                    resolve(blob);
                }, 'image/webp', 0.8);
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    });
};

// Preload critical images
export const preloadCriticalImages = (urls) => {
    urls.forEach(url => {
        const link = document.createElement('link');
        link.rel = 'preload';
        link.as = 'image';
        link.href = url;
        document.head.appendChild(link);
    });
}; 