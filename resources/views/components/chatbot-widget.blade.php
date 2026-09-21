{{-- Chatbot d'assistance — voir App\Services\ChatbotService pour la logique de réponse --}}
<div id="chatbot-widget" class="fixed bottom-5 right-5 z-50">
    <button id="chatbot-toggle" type="button"
            class="w-14 h-14 rounded-full bg-green-700 text-white shadow-lg flex items-center justify-center hover:bg-green-800">
        <svg id="chatbot-icon-open" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8-1.06 0-2.076-.163-3.017-.463L3 21l1.395-3.72C3.512 15.888 3 14.482 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
        </svg>
        <svg id="chatbot-icon-close" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>

    <div id="chatbot-panel" class="hidden absolute bottom-16 right-0 w-80 max-w-[90vw] bg-white border border-gray-200 rounded-lg shadow-xl flex flex-col overflow-hidden">
        <div class="bg-green-700 text-white px-4 py-3">
            <p class="font-medium text-sm">Assistant E-Mairie Batchenga</p>
            <p class="text-xs text-green-100">Posez votre question</p>
        </div>

        <div id="chatbot-messages" class="flex-1 px-3 py-3 space-y-2 overflow-y-auto text-sm" style="height: 320px;">
            <div class="bg-gray-100 text-gray-700 rounded-lg rounded-bl-none px-3 py-2 max-w-[85%]">
                Bonjour ! Je peux vous renseigner sur les services, les rendez-vous, le suivi de vos demandes ou l'état civil. Que souhaitez-vous savoir ?
            </div>
        </div>

        <form id="chatbot-form" class="border-t border-gray-100 flex">
            <input id="chatbot-input" type="text" placeholder="Votre question..." autocomplete="off"
                   class="flex-1 px-3 py-2 text-sm focus:outline-none">
            <button type="submit" class="bg-green-700 text-white px-4 text-sm hover:bg-green-800">Envoyer</button>
        </form>
    </div>
</div>

<script>
(function () {
    const toggleBtn = document.getElementById('chatbot-toggle');
    const panel = document.getElementById('chatbot-panel');
    const iconOpen = document.getElementById('chatbot-icon-open');
    const iconClose = document.getElementById('chatbot-icon-close');
    const messages = document.getElementById('chatbot-messages');
    const form = document.getElementById('chatbot-form');
    const input = document.getElementById('chatbot-input');

    toggleBtn.addEventListener('click', function () {
        panel.classList.toggle('hidden');
        iconOpen.classList.toggle('hidden');
        iconClose.classList.toggle('hidden');
        if (!panel.classList.contains('hidden')) {
            input.focus();
        }
    });

    function ajouterMessage(texte, auteur) {
        const bulle = document.createElement('div');
        if (auteur === 'utilisateur') {
            bulle.className = 'bg-green-700 text-white rounded-lg rounded-br-none px-3 py-2 max-w-[85%] ml-auto';
        } else {
            bulle.className = 'bg-gray-100 text-gray-700 rounded-lg rounded-bl-none px-3 py-2 max-w-[85%]';
        }
        bulle.textContent = texte;
        messages.appendChild(bulle);
        messages.scrollTop = messages.scrollHeight;
    }

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        const texte = input.value.trim();
        if (!texte) return;

        ajouterMessage(texte, 'utilisateur');
        input.value = '';

        try {
            const response = await fetch('{{ route('chatbot.repondre') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ message: texte }),
            });
            const data = await response.json();
            ajouterMessage(data.reponse ?? "Désolé, une erreur est survenue.", 'bot');
        } catch (err) {
            ajouterMessage("Désolé, une erreur est survenue. Réessayez plus tard.", 'bot');
        }
    });
})();
</script>
