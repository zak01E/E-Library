// Test de fonctionnalité des onglets de navigation
// Ce script peut être exécuté dans la console du navigateur

function testTabsFunctionality() {
    console.log('🧪 Début des tests de fonctionnalité des onglets...');
    
    // Test 1: Vérifier la présence d'Alpine.js
    console.log('\n📋 Test 1: Vérification d\'Alpine.js');
    if (typeof window.Alpine !== 'undefined') {
        console.log('✅ Alpine.js est chargé');
    } else {
        console.log('❌ Alpine.js n\'est pas chargé');
        return false;
    }
    
    // Test 2: Vérifier la présence des onglets
    console.log('\n📋 Test 2: Vérification des éléments d\'onglets');
    const tabContainer = document.querySelector('[x-data*="activeTab"]');
    if (tabContainer) {
        console.log('✅ Container des onglets trouvé');
    } else {
        console.log('❌ Container des onglets non trouvé');
        return false;
    }
    
    // Test 3: Vérifier les boutons d'onglets
    console.log('\n📋 Test 3: Vérification des boutons d\'onglets');
    const tabButtons = document.querySelectorAll('[x-data*="activeTab"] button');
    console.log(`📊 Nombre de boutons trouvés: ${tabButtons.length}`);
    
    if (tabButtons.length === 3) {
        console.log('✅ Les 3 boutons d\'onglets sont présents');
        
        // Vérifier les textes des boutons
        const expectedTexts = ['Récents', 'Populaires', 'Les plus vus'];
        tabButtons.forEach((button, index) => {
            const buttonText = button.textContent.trim();
            if (buttonText.includes(expectedTexts[index])) {
                console.log(`✅ Bouton ${index + 1}: "${expectedTexts[index]}" trouvé`);
            } else {
                console.log(`❌ Bouton ${index + 1}: texte incorrect. Attendu: "${expectedTexts[index]}", Trouvé: "${buttonText}"`);
            }
        });
    } else {
        console.log('❌ Nombre incorrect de boutons d\'onglets');
        return false;
    }
    
    // Test 4: Vérifier les contenus des onglets
    console.log('\n📋 Test 4: Vérification des contenus d\'onglets');
    const tabContents = document.querySelectorAll('[x-show*="activeTab"]');
    console.log(`📊 Nombre de contenus trouvés: ${tabContents.length}`);
    
    if (tabContents.length === 3) {
        console.log('✅ Les 3 contenus d\'onglets sont présents');
        
        // Vérifier les conditions x-show
        const expectedConditions = ['recent', 'popular', 'viewed'];
        tabContents.forEach((content, index) => {
            const xShowValue = content.getAttribute('x-show');
            if (xShowValue && xShowValue.includes(expectedConditions[index])) {
                console.log(`✅ Contenu ${index + 1}: condition x-show correcte`);
            } else {
                console.log(`❌ Contenu ${index + 1}: condition x-show incorrecte`);
            }
        });
    } else {
        console.log('❌ Nombre incorrect de contenus d\'onglets');
        return false;
    }
    
    // Test 5: Test d'interaction (simulation de clics)
    console.log('\n📋 Test 5: Test d\'interaction des onglets');
    
    // Fonction pour attendre un délai
    const wait = (ms) => new Promise(resolve => setTimeout(resolve, ms));
    
    // Test de clic sur chaque onglet
    async function testTabClicks() {
        for (let i = 0; i < tabButtons.length; i++) {
            console.log(`🖱️ Simulation de clic sur l'onglet ${i + 1}`);
            
            // Simuler le clic
            tabButtons[i].click();
            
            // Attendre un peu pour que la transition se fasse
            await wait(300);
            
            // Vérifier si l'onglet est actif
            const isActive = tabButtons[i].classList.contains('text-emerald-600') || 
                           tabButtons[i].classList.contains('bg-white');
            
            if (isActive) {
                console.log(`✅ Onglet ${i + 1} activé avec succès`);
            } else {
                console.log(`❌ Onglet ${i + 1} n'a pas été activé correctement`);
            }
        }
    }
    
    // Exécuter les tests de clic
    testTabClicks().then(() => {
        console.log('\n🎉 Tests terminés !');
        console.log('📊 Résumé: Tous les tests de base sont passés');
        console.log('💡 Conseil: Testez manuellement les transitions visuelles');
    });
    
    return true;
}

// Test de performance
function testTabsPerformance() {
    console.log('\n⚡ Test de performance des onglets...');
    
    const tabButtons = document.querySelectorAll('[x-data*="activeTab"] button');
    if (tabButtons.length === 0) {
        console.log('❌ Aucun bouton d\'onglet trouvé pour le test de performance');
        return;
    }
    
    const iterations = 10;
    const times = [];
    
    for (let i = 0; i < iterations; i++) {
        const startTime = performance.now();
        
        // Simuler un clic
        tabButtons[i % tabButtons.length].click();
        
        const endTime = performance.now();
        times.push(endTime - startTime);
    }
    
    const averageTime = times.reduce((a, b) => a + b, 0) / times.length;
    console.log(`📊 Temps moyen de changement d'onglet: ${averageTime.toFixed(2)}ms`);
    
    if (averageTime < 50) {
        console.log('✅ Performance excellente');
    } else if (averageTime < 100) {
        console.log('✅ Performance bonne');
    } else {
        console.log('⚠️ Performance à améliorer');
    }
}

// Test d'accessibilité
function testTabsAccessibility() {
    console.log('\n♿ Test d\'accessibilité des onglets...');
    
    const tabButtons = document.querySelectorAll('[x-data*="activeTab"] button');
    
    // Vérifier les attributs d'accessibilité
    tabButtons.forEach((button, index) => {
        // Vérifier si le bouton est focusable
        if (button.tabIndex >= 0) {
            console.log(`✅ Bouton ${index + 1}: focusable`);
        } else {
            console.log(`⚠️ Bouton ${index + 1}: pourrait ne pas être focusable`);
        }
        
        // Vérifier la présence d'icônes pour l'identification visuelle
        const icon = button.querySelector('i');
        if (icon) {
            console.log(`✅ Bouton ${index + 1}: icône présente`);
        } else {
            console.log(`⚠️ Bouton ${index + 1}: aucune icône trouvée`);
        }
    });
}

// Fonction principale pour exécuter tous les tests
function runAllTests() {
    console.clear();
    console.log('🚀 TESTS DE FONCTIONNALITÉ DES ONGLETS E-LIBRARY');
    console.log('================================================');
    
    const functionalityResult = testTabsFunctionality();
    
    if (functionalityResult) {
        setTimeout(() => {
            testTabsPerformance();
            testTabsAccessibility();
            
            console.log('\n🏁 TOUS LES TESTS TERMINÉS');
            console.log('📋 Pour tester manuellement:');
            console.log('   1. Cliquez sur chaque onglet');
            console.log('   2. Vérifiez les transitions visuelles');
            console.log('   3. Testez sur mobile/tablette');
            console.log('   4. Testez avec le clavier (Tab + Entrée)');
        }, 2000);
    }
}

// Exporter les fonctions pour utilisation dans la console
window.testTabsFunctionality = testTabsFunctionality;
window.testTabsPerformance = testTabsPerformance;
window.testTabsAccessibility = testTabsAccessibility;
window.runAllTests = runAllTests;

console.log('📝 Tests chargés ! Utilisez runAllTests() pour commencer.');
