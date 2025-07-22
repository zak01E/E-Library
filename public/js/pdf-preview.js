/**
 * PDF Preview with restrictions
 * Limits viewing to first few pages and disables download/print
 */

class PDFPreview {
    constructor(container, pdfUrl, options = {}) {
        this.container = container;
        this.pdfUrl = pdfUrl;
        this.options = {
            maxPages: options.maxPages || 3,
            scale: options.scale || 1.2,
            showWatermark: options.showWatermark !== false,
            ...options
        };
        
        this.pdfDoc = null;
        this.currentPage = 1;
        this.totalPages = 0;
        this.isLoading = false;
        
        this.init();
    }
    
    async init() {
        try {
            // Load PDF.js
            if (typeof pdfjsLib === 'undefined') {
                await this.loadPDFJS();
            }
            
            this.createViewer();
            await this.loadPDF();
        } catch (error) {
            console.error('Error initializing PDF preview:', error);
            this.showError('Impossible de charger l\'aperçu PDF');
        }
    }
    
    async loadPDFJS() {
        return new Promise((resolve, reject) => {
            const script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js';
            script.onload = () => {
                pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
                resolve();
            };
            script.onerror = reject;
            document.head.appendChild(script);
        });
    }
    
    createViewer() {
        this.container.innerHTML = `
            <div class="pdf-preview-container h-full flex flex-col">
                <div class="pdf-controls bg-gray-100 p-3 border-b flex justify-between items-center flex-shrink-0">
                    <div class="flex items-center space-x-2">
                        <button id="prevPage" class="px-3 py-2 bg-white hover:bg-gray-50 border border-gray-300 rounded text-sm font-medium text-gray-700 transition-colors" disabled>
                            <i class="fas fa-chevron-left mr-1"></i>Précédent
                        </button>
                        <span id="pageInfo" class="text-sm text-gray-600 px-2">Page 1 sur 1</span>
                        <button id="nextPage" class="px-3 py-2 bg-white hover:bg-gray-50 border border-gray-300 rounded text-sm font-medium text-gray-700 transition-colors" disabled>
                            Suivant<i class="fas fa-chevron-right ml-1"></i>
                        </button>
                    </div>
                    <div class="text-xs text-gray-500 bg-gray-200 px-2 py-1 rounded">
                        <i class="fas fa-eye mr-1"></i>Aperçu limité
                    </div>
                </div>
                <div class="pdf-canvas-container relative bg-gray-50 overflow-auto flex-1" style="min-height: 400px;">
                    <div id="loadingIndicator" class="absolute inset-0 flex items-center justify-center z-10">
                        <div class="text-center">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-emerald-600 mx-auto mb-2"></div>
                            <p class="text-sm text-gray-600">Chargement de l'aperçu...</p>
                        </div>
                    </div>
                    <div class="p-4">
                        <canvas id="pdfCanvas" class="mx-auto shadow-lg block" style="display: none; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        `;

        this.setupControls();
    }
    
    setupControls() {
        const prevBtn = this.container.querySelector('#prevPage');
        const nextBtn = this.container.querySelector('#nextPage');
        
        prevBtn.addEventListener('click', () => this.previousPage());
        nextBtn.addEventListener('click', () => this.nextPage());
    }
    
    async loadPDF() {
        this.isLoading = true;
        
        try {
            const loadingTask = pdfjsLib.getDocument(this.pdfUrl);
            this.pdfDoc = await loadingTask.promise;
            this.totalPages = Math.min(this.pdfDoc.numPages, this.options.maxPages);
            
            await this.renderPage(1);
            this.updateControls();
            
            // Hide loading indicator
            const loadingIndicator = this.container.querySelector('#loadingIndicator');
            const canvas = this.container.querySelector('#pdfCanvas');
            loadingIndicator.style.display = 'none';
            canvas.style.display = 'block';
            
        } catch (error) {
            console.error('Error loading PDF:', error);
            this.showError('Erreur lors du chargement du PDF');
        } finally {
            this.isLoading = false;
        }
    }
    
    async renderPage(pageNum) {
        if (!this.pdfDoc || pageNum < 1 || pageNum > this.totalPages) {
            return;
        }

        try {
            const page = await this.pdfDoc.getPage(pageNum);
            const canvas = this.container.querySelector('#pdfCanvas');
            const context = canvas.getContext('2d');

            // Calculate scale to fit container width while maintaining aspect ratio
            const containerWidth = this.container.querySelector('.pdf-canvas-container').clientWidth - 32; // Account for padding
            const viewport = page.getViewport({ scale: 1.0 });
            const scale = Math.min(this.options.scale, containerWidth / viewport.width);

            const scaledViewport = page.getViewport({ scale: scale });

            // Set canvas dimensions
            canvas.height = scaledViewport.height;
            canvas.width = scaledViewport.width;

            // Set CSS dimensions for responsive display
            canvas.style.width = '100%';
            canvas.style.height = 'auto';

            const renderContext = {
                canvasContext: context,
                viewport: scaledViewport
            };

            await page.render(renderContext).promise;

            // Add watermark if enabled
            if (this.options.showWatermark) {
                this.addWatermark(context, canvas.width, canvas.height);
            }

            this.currentPage = pageNum;

        } catch (error) {
            console.error('Error rendering page:', error);
            this.showError('Erreur lors du rendu de la page');
        }
    }
    
    addWatermark(context, width, height) {
        context.save();
        context.globalAlpha = 0.1;
        context.font = '24px Arial';
        context.fillStyle = '#000000';
        context.textAlign = 'center';
        context.translate(width / 2, height / 2);
        context.rotate(-Math.PI / 4);
        context.fillText('APERÇU LIMITÉ', 0, 0);
        context.restore();
    }
    
    updateControls() {
        const prevBtn = this.container.querySelector('#prevPage');
        const nextBtn = this.container.querySelector('#nextPage');
        const pageInfo = this.container.querySelector('#pageInfo');

        prevBtn.disabled = this.currentPage <= 1;
        nextBtn.disabled = this.currentPage >= this.totalPages;

        pageInfo.textContent = `Page ${this.currentPage} sur ${this.totalPages}`;

        // Update button styles
        if (prevBtn.disabled) {
            prevBtn.className = 'px-3 py-2 bg-gray-100 border border-gray-200 rounded text-sm font-medium text-gray-400 cursor-not-allowed';
        } else {
            prevBtn.className = 'px-3 py-2 bg-white hover:bg-gray-50 border border-gray-300 rounded text-sm font-medium text-gray-700 transition-colors';
        }

        if (nextBtn.disabled) {
            nextBtn.className = 'px-3 py-2 bg-gray-100 border border-gray-200 rounded text-sm font-medium text-gray-400 cursor-not-allowed';
        } else {
            nextBtn.className = 'px-3 py-2 bg-white hover:bg-gray-50 border border-gray-300 rounded text-sm font-medium text-gray-700 transition-colors';
        }
    }
    
    async previousPage() {
        if (this.currentPage > 1 && !this.isLoading) {
            await this.renderPage(this.currentPage - 1);
            this.updateControls();
        }
    }
    
    async nextPage() {
        if (this.currentPage < this.totalPages && !this.isLoading) {
            await this.renderPage(this.currentPage + 1);
            this.updateControls();
        }
    }
    
    showError(message) {
        this.container.innerHTML = `
            <div class="flex items-center justify-center h-64 bg-gray-50">
                <div class="text-center text-gray-500">
                    <i class="fas fa-exclamation-triangle text-4xl mb-4 text-red-400"></i>
                    <p class="text-lg font-medium mb-2">Erreur</p>
                    <p class="text-sm">${message}</p>
                </div>
            </div>
        `;
    }
    
    destroy() {
        if (this.pdfDoc) {
            this.pdfDoc.destroy();
        }
        this.container.innerHTML = '';
    }
}

// Export for use in other scripts
window.PDFPreview = PDFPreview;
