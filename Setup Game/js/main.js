document.addEventListener('DOMContentLoaded', () => {
    // Theme toggle functionality
    const themeToggle = document.querySelector('.theme-toggle');
    themeToggle.addEventListener('click', () => {
        document.body.classList.toggle('light-theme');
        const icon = themeToggle.querySelector('i');
        icon.classList.toggle('fa-moon');
        icon.classList.toggle('fa-sun');
    });

    // Part selection functionality
    const addPartButtons = document.querySelectorAll('.add-part');
    addPartButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            const partItem = e.target.closest('.part-item');
            const partType = partItem.dataset.part;
            showPartSelectionModal(partType);
        });
    });

    // Save build functionality
    const saveBuildButton = document.querySelector('.save-build');
    saveBuildButton.addEventListener('click', saveBuild);
});

// Part selection modal
function showPartSelectionModal(partType) {
    // Create modal
    const modal = document.createElement('div');
    modal.className = 'part-selection-modal';
    modal.innerHTML = `
        <div class="modal-content">
            <div class="modal-header">
                <h2>Select ${partType.toUpperCase()}</h2>
                <button class="close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="search-bar">
                    <input type="text" placeholder="Search ${partType}...">
                </div>
                <div class="parts-list">
                    <!-- Parts will be loaded here -->
                </div>
            </div>
        </div>
    `;

    document.body.appendChild(modal);

    // Close modal functionality
    // const closeButton = modal.querySelector('.close-modal');
    // closeButton.addEventListener('click', () => {
    //     modal.remove();
    // });

    // Close on outside click and button clicks
    modal.addEventListener('click', (e) => {
        if (e.target === modal || e.target.classList.contains('close-modal')) {
            modal.remove();
        }
    });

    // Load parts (simulated data for now)
    loadParts(partType);
}

// Load parts data
function loadParts(partType) {
    // This would typically be an API call
    const partsList = document.querySelector('.parts-list');
    const sampleParts = getSampleParts(partType);
    
    partsList.innerHTML = sampleParts.map(part => `
        <div class="part-option" data-price="${part.price}">
            <div class="part-info">
                <h3>${part.name}</h3>
                <p>${part.description}</p>
            </div>
            <div class="part-price">$${part.price}</div>
            <button class="select-part">Select</button>
        </div>
    `).join('');

    // Add selection functionality
    const selectButtons = partsList.querySelectorAll('.select-part');
    selectButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            const partOption = e.target.closest('.part-option');
            selectPart(partType, partOption);
        });
    });
}

// Sample parts data
function getSampleParts(partType) {
    const parts = {
        cpu: [
            { name: 'Intel Core i9-13900K', description: '24 cores, 32 threads', price: 549.99 },
            { name: 'AMD Ryzen 9 7950X', description: '16 cores, 32 threads', price: 699.99 },
            { name: 'Intel Core i7-13700K', description: '16 cores, 24 threads', price: 399.99 }
        ],
        motherboard: [
            { name: 'ASUS ROG STRIX Z790-E', description: 'ATX, DDR5', price: 449.99 },
            { name: 'MSI MPG B650', description: 'ATX, DDR5', price: 249.99 },
            { name: 'Gigabyte B760M', description: 'Micro ATX, DDR4', price: 129.99 }
        ],
        // Add more part types as needed
    };

    return parts[partType] || [];
}

// Select a part
function selectPart(partType, partOption) {
    const partItem = document.querySelector(`.part-item[data-part="${partType}"]`);
    const partInfo = partOption.querySelector('.part-info');
    const partName = partInfo.querySelector('h3').textContent;
    const partPrice = partOption.dataset.price;

    // Update the part item
    partItem.innerHTML = `
        <i class="fas fa-${getPartIcon(partType)}"></i>
        <span>${partName}</span>
        <button class="remove-part">Remove</button>
    `;
    partItem.dataset.price = partPrice;

    // Add remove functionality
    const removeButton = partItem.querySelector('.remove-part');
    removeButton.addEventListener('click', () => {
        resetPartItem(partType);
    });

    // Update total price
    updateTotalPrice();

    // Close the modal
    document.querySelector('.part-selection-modal').remove();
}

// Reset part item to default state
function resetPartItem(partType) {
    const partItem = document.querySelector(`.part-item[data-part="${partType}"]`);
    partItem.innerHTML = `
        <i class="fas fa-${getPartIcon(partType)}"></i>
        <span>${partType.charAt(0).toUpperCase() + partType.slice(1)}</span>
        <button class="add-part">+ Add</button>
    `;
    delete partItem.dataset.price;

    // Reattach add button functionality
    const addButton = partItem.querySelector('.add-part');
    addButton.addEventListener('click', (e) => {
        showPartSelectionModal(partType);
    });

    // Update total price
    updateTotalPrice();
}

// Get icon for part type
function getPartIcon(partType) {
    const icons = {
        cpu: 'microchip',
        motherboard: 'server',
        gpu: 'desktop',
        ram: 'memory',
        storage: 'hdd',
        psu: 'plug',
        case: 'desktop'
    };
    return icons[partType] || 'question';
}

// Update total price
function updateTotalPrice() {
    const selectedParts = document.querySelectorAll('.part-item:not(:has(.add-part))');
    let total = 0;

    selectedParts.forEach(part => {
        const price = parseFloat(part.dataset.price) || 0;
        total += price;
    });

    document.querySelector('.price').textContent = `$${total.toFixed(2)}`;
}

// Save build
function saveBuild() {
    const selectedParts = document.querySelectorAll('.part-item:not(:has(.add-part))');
    const build = {};

    selectedParts.forEach(part => {
        const partType = part.dataset.part;
        const partName = part.querySelector('span').textContent;
        build[partType] = partName;
    });

    // Here you would typically send this to a server
    console.log('Saving build:', build);
    alert('Build saved successfully!');
} 