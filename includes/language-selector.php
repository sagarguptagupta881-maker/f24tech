<!-- Language Selector -->
<div class="language-selector">
    <select id="language-selector" onchange="translatePage(this.value)" class="text-sm">
        <option value="en">🇺🇸 English</option>
        <option value="es">🇪🇸 Español</option>
        <option value="fr">🇫🇷 Français</option>
        <option value="de">🇩🇪 Deutsch</option>
        <option value="hi">🇮🇳 हिंदी</option>
        <option value="zh">🇨🇳 中文</option>
        <option value="ja">🇯🇵 日本語</option>
        <option value="ar">🇸🇦 العربية</option>
        <option value="pt">🇧🇷 Português</option>
        <option value="ru">🇷🇺 Русский</option>
    </select>
</div>

<script>
// Google Translate Integration
function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage: 'en',
        includedLanguages: 'en,es,fr,de,hi,zh,ja,ar,pt,ru',
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
        autoDisplay: false
    }, 'google_translate_element');
}

function translatePage(language) {
    if (language === 'en') {
        // Reset to original language
        location.reload();
        return;
    }
    
    // Use Google Translate API
    const googleTranslateCombo = document.querySelector('.goog-te-combo');
    if (googleTranslateCombo) {
        googleTranslateCombo.value = language;
        googleTranslateCombo.dispatchEvent(new Event('change'));
    } else {
        // Fallback: Load Google Translate
        loadGoogleTranslate(language);
    }
    
    // Store language preference
    localStorage.setItem('preferred_language', language);
    
    // Track language change
    if (window.analytics) {
        window.analytics.trackInteraction('language_change', 'language_selector', language);
    }
}

function loadGoogleTranslate(targetLanguage) {
    // Create hidden Google Translate element
    if (!document.getElementById('google_translate_element')) {
        const translateDiv = document.createElement('div');
        translateDiv.id = 'google_translate_element';
        translateDiv.style.display = 'none';
        document.body.appendChild(translateDiv);
        
        // Load Google Translate script
        const script = document.createElement('script');
        script.src = 'https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
        document.head.appendChild(script);
    }
}

// Auto-translate based on browser language or stored preference
document.addEventListener('DOMContentLoaded', function() {
    const storedLanguage = localStorage.getItem('preferred_language');
    const browserLanguage = navigator.language.split('-')[0];
    const selector = document.getElementById('language-selector');
    
    if (storedLanguage && storedLanguage !== 'en') {
        selector.value = storedLanguage;
        setTimeout(() => translatePage(storedLanguage), 1000);
    } else if (browserLanguage !== 'en' && selector.querySelector(`option[value="${browserLanguage}"]`)) {
        selector.value = browserLanguage;
        setTimeout(() => translatePage(browserLanguage), 1000);
    }
});

// Hide Google Translate bar
document.addEventListener('DOMContentLoaded', function() {
    const style = document.createElement('style');
    style.textContent = `
        .goog-te-banner-frame { display: none !important; }
        .goog-te-menu-value { display: none !important; }
        .goog-te-gadget { display: none !important; }
        body { top: 0 !important; }
        #google_translate_element { display: none !important; }
    `;
    document.head.appendChild(style);
});
</script>

<!-- Hidden Google Translate Element -->
<div id="google_translate_element" style="display: none;"></div>