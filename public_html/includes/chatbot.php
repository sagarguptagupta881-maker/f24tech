<!-- Floating Chatbot -->
<div id="chatbot-container" class="fixed bottom-6 right-6 z-50">
    <!-- Chat Button -->
    <button id="chat-toggle" class="bg-blue-600 hover:bg-blue-700 text-white rounded-full p-4 shadow-lg transition-all duration-300 hover:scale-110">
        <svg id="chat-icon" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
        </svg>
        <svg id="close-icon" class="h-6 w-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>

    <!-- Chat Window -->
    <div id="chat-window" class="hidden absolute bottom-16 right-0 w-80 h-96 bg-white rounded-lg shadow-2xl border border-gray-200 flex flex-col">
        <!-- Chat Header -->
        <div class="bg-blue-600 text-white p-4 rounded-t-lg">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold">F24Tech Support</h4>
                    <p class="text-xs opacity-90">We're here to help!</p>
                </div>
            </div>
        </div>

        <!-- Chat Messages -->
        <div id="chat-messages" class="flex-1 p-4 overflow-y-auto space-y-3">
            <div class="flex items-start">
                <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mr-2 flex-shrink-0">
                    <svg class="h-3 w-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div class="bg-gray-100 rounded-lg p-3 max-w-xs">
                    <p class="text-sm">Hi! 👋 Welcome to F24Tech. How can I help you today?</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="p-3 border-t border-gray-200">
            <div class="grid grid-cols-2 gap-2 mb-3">
                <button onclick="sendQuickMessage('I need a quote')" class="text-xs bg-gray-100 hover:bg-gray-200 p-2 rounded transition-colors">
                    Get Quote
                </button>
                <button onclick="sendQuickMessage('Tell me about your services')" class="text-xs bg-gray-100 hover:bg-gray-200 p-2 rounded transition-colors">
                    Our Services
                </button>
                <button onclick="sendQuickMessage('I want to start a project')" class="text-xs bg-gray-100 hover:bg-gray-200 p-2 rounded transition-colors">
                    Start Project
                </button>
                <button onclick="sendQuickMessage('Contact information')" class="text-xs bg-gray-100 hover:bg-gray-200 p-2 rounded transition-colors">
                    Contact Info
                </button>
            </div>
        </div>

        <!-- Chat Input -->
        <div class="p-3 border-t border-gray-200">
            <div class="flex items-center space-x-2">
                <input 
                    type="text" 
                    id="chat-input" 
                    placeholder="Type your message..." 
                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    onkeypress="handleChatKeyPress(event)"
                />
                <button onclick="sendMessage()" class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-lg transition-colors">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Chatbot functionality
let chatOpen = false;

document.getElementById('chat-toggle').addEventListener('click', function() {
    const chatWindow = document.getElementById('chat-window');
    const chatIcon = document.getElementById('chat-icon');
    const closeIcon = document.getElementById('close-icon');
    
    if (chatOpen) {
        chatWindow.classList.add('hidden');
        chatIcon.classList.remove('hidden');
        closeIcon.classList.add('hidden');
        chatOpen = false;
    } else {
        chatWindow.classList.remove('hidden');
        chatIcon.classList.add('hidden');
        closeIcon.classList.remove('hidden');
        chatOpen = true;
        document.getElementById('chat-input').focus();
    }
});

function sendMessage() {
    const input = document.getElementById('chat-input');
    const message = input.value.trim();
    
    if (message) {
        addUserMessage(message);
        input.value = '';
        
        // Simulate bot response
        setTimeout(() => {
            const response = getBotResponse(message);
            addBotMessage(response);
        }, 1000);
    }
}

function sendQuickMessage(message) {
    addUserMessage(message);
    
    setTimeout(() => {
        const response = getBotResponse(message);
        addBotMessage(response);
    }, 1000);
}

function addUserMessage(message) {
    const messagesContainer = document.getElementById('chat-messages');
    const messageDiv = document.createElement('div');
    messageDiv.className = 'flex justify-end';
    messageDiv.innerHTML = `
        <div class="bg-blue-600 text-white rounded-lg p-3 max-w-xs">
            <p class="text-sm">${message}</p>
        </div>
    `;
    messagesContainer.appendChild(messageDiv);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

function addBotMessage(message) {
    const messagesContainer = document.getElementById('chat-messages');
    const messageDiv = document.createElement('div');
    messageDiv.className = 'flex items-start';
    messageDiv.innerHTML = `
        <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mr-2 flex-shrink-0">
            <svg class="h-3 w-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
        </div>
        <div class="bg-gray-100 rounded-lg p-3 max-w-xs">
            <p class="text-sm">${message}</p>
        </div>
    `;
    messagesContainer.appendChild(messageDiv);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

function getBotResponse(message) {
    const lowerMessage = message.toLowerCase();
    
    if (lowerMessage.includes('quote') || lowerMessage.includes('price') || lowerMessage.includes('cost')) {
        return `I'd be happy to help you get a quote! Please visit our <a href="?page=contact" class="text-blue-600 underline">contact page</a> or email us at <a href="mailto:sales@f24tech.com" class="text-blue-600 underline">sales@f24tech.com</a> with your project details.`;
    }
    
    if (lowerMessage.includes('service') || lowerMessage.includes('what do you do')) {
        return `We offer comprehensive software development services including:<br>
        • Custom Software Development<br>
        • Mobile App Development<br>
        • Cloud Solutions<br>
        • Data Analytics<br>
        • Cybersecurity<br>
        • UI/UX Design<br><br>
        Visit our <a href="?page=services" class="text-blue-600 underline">services page</a> for more details!`;
    }
    
    if (lowerMessage.includes('contact') || lowerMessage.includes('phone') || lowerMessage.includes('email')) {
        return `You can reach us at:<br>
        📧 Email: <a href="mailto:sales@f24tech.com" class="text-blue-600 underline">sales@f24tech.com</a><br>
        📞 Phone: <a href="tel:+918950773419" class="text-blue-600 underline">+91 8950773419</a><br>
        📍 Address: Plot No. 44, Sector 44, Gurgaon, Haryana, 122003, INDIA<br><br>
        We're available Mon-Fri, 9am-6pm IST.`;
    }
    
    if (lowerMessage.includes('project') || lowerMessage.includes('start')) {
        return `Great! Let's start your project. Please <a href="?page=contact" class="text-blue-600 underline">fill out our contact form</a> with your requirements, or email us directly at <a href="mailto:sales@f24tech.com" class="text-blue-600 underline">sales@f24tech.com</a>. We'll get back to you within 24 hours!`;
    }
    
    if (lowerMessage.includes('portfolio') || lowerMessage.includes('work') || lowerMessage.includes('examples')) {
        return `Check out our <a href="?page=portfolio" class="text-blue-600 underline">portfolio</a> to see examples of our work across various industries including healthcare, fintech, e-commerce, and more!`;
    }
    
    if (lowerMessage.includes('hello') || lowerMessage.includes('hi') || lowerMessage.includes('hey')) {
        return `Hello! 👋 Welcome to F24Tech. I'm here to help you with any questions about our software development services. How can I assist you today?`;
    }
    
    if (lowerMessage.includes('thank') || lowerMessage.includes('thanks')) {
        return `You're welcome! 😊 Is there anything else I can help you with? Feel free to reach out anytime!`;
    }
    
    // Default response
    return `Thanks for your message! For specific inquiries, please contact us at <a href="mailto:sales@f24tech.com" class="text-blue-600 underline">sales@f24tech.com</a> or call <a href="tel:+918950773419" class="text-blue-600 underline">+91 8950773419</a>. Our team will be happy to help you!`;
}

function handleChatKeyPress(event) {
    if (event.key === 'Enter') {
        sendMessage();
    }
}

// Auto-open chatbot after 10 seconds (optional)
setTimeout(() => {
    if (!chatOpen) {
        const button = document.getElementById('chat-toggle');
        button.classList.add('animate-bounce');
        setTimeout(() => {
            button.classList.remove('animate-bounce');
        }, 2000);
    }
}, 10000);
</script>

<style>
#chatbot-container {
    font-family: 'Inter', sans-serif;
}

#chat-messages::-webkit-scrollbar {
    width: 4px;
}

#chat-messages::-webkit-scrollbar-track {
    background: #f1f1f1;
}

#chat-messages::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 2px;
}

#chat-messages::-webkit-scrollbar-thumb:hover {
    background: #a1a1a1;
}

@media (max-width: 640px) {
    #chat-window {
        width: 300px;
        height: 400px;
        right: -10px;
    }
}
</style>